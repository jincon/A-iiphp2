<?php

namespace TinyLara\TinyRouter;


/**
 * @method static TinyRouter get(string $route, Callable $callback)
 * @method static TinyRouter post(string $route, Callable $callback)
 * @method static TinyRouter put(string $route, Callable $callback)
 * @method static TinyRouter delete(string $route, Callable $callback)
 * @method static TinyRouter options(string $route, Callable $callback)
 * @method static TinyRouter head(string $route, Callable $callback)
 */
class TinyRouter
{

    public static $routes = array();

    public static $methods = array();

    public static $callbacks = array();

    public static $ext = array();

    public static $patterns = array(
        ':any' => '[^/]+',
        ':num' => '[0-9]+',
        ':all' => '.*'
    );

    public static $error_callback;

    /**
     * add filter for your routes
     */
    public static function filter($filter, $result)
    {
        if ($filter()) {
            $result();
        }
    }

    /**
     * Defines a route w/ callback and method
     */
    public static function __callstatic($method, $params)
    {
        $uri = $params[0];
        $callback = $params[1];
        $ext = isset($params[2]) ? $params[2] : "";

        if ($method == 'any') {
            self::pushToArray($uri, 'get', $callback, $ext);
            self::pushToArray($uri, 'post', $callback, $ext);
        } else {
            self::pushToArray($uri, $method, $callback, $ext);
        }
    }

    /**
     * Push route items to class arrays
     *
     */
    public static function pushToArray($uri, $method, $callback, $ext)
    {
        array_push(self::$routes, $uri);
        array_push(self::$methods, strtoupper($method));
        array_push(self::$callbacks, $callback);
        self::$ext[$uri] = $ext;
    }

    /**
     * Defines callback if route is not found
     */
    public static function error($callback)
    {
        self::$error_callback = $callback;
    }

    /**
     * Runs the callback for the given request
     *
     * $after: Processor After. It will process the value returned by Controller.
     * Example: View@process
     *
     */
    public static function dispatch($after = null)
    {
        $uri = self::detect_uri();
        $method = $_SERVER['REQUEST_METHOD'];

        $searches = array_keys(static::$patterns);
        $replaces = array_values(static::$patterns);

        $found_route = false;

        // check if route is defined without regex
        if (in_array($uri, self::$routes)) {
            $route_pos = array_keys(self::$routes, $uri);
            foreach ($route_pos as $route) {
                if (self::$methods[$route] == $method) {
                    $found_route = true;

                    //if route is not an object
                    if (!is_object(self::$callbacks[$route])) {

                        //grab all parts based on a / separator
                        $parts = explode('/', self::$callbacks[$route]);

                        //collect the last index of the array
                        $last = end($parts);

                        //grab the controller name and method call
                        $segments = explode('@', $last);

                        //定义了其他命名空间
                        $_namespace = '';
                        if (isset(self::$ext[$uri]['namespace'])) {
                            $_namespace = self::$ext[$uri]['namespace'] . "\\";
                        }

                        //instanitate controller
                        $t = "\app\controllers\\" . $_namespace . $segments[0];

                        $controller = new $t();

                        //call method
                        $return = $controller->$segments[1]();

                        if ($after) {
                            $after_segments = explode('@', $after);
                            $after_segments[0]::$after_segments[1]($return);
                        }

                    } else {
                        //call closure
                        call_user_func(self::$callbacks[$route]);
                    }
                }
            }
        } else {
            // check if defined with regex
            $pos = 0;
            foreach (self::$routes as $route) {

                if (strpos($route, ':') !== false) {
                    $route = str_replace($searches, $replaces, $route);
                }

                if (preg_match('#^' . $route . '$#', $uri, $matched)) {
                    if (self::$methods[$pos] == $method) {
                        $found_route = true;

                        array_shift($matched); //remove $matched[0] as [1] is the first parameter.


                        if (!is_object(self::$callbacks[$pos])) {

                            //grab all parts based on a / separator
                            $parts = explode('/', self::$callbacks[$pos]);

                            //collect the last index of the array
                            $last = end($parts);

                            //grab the controller name and method call
                            $segments = explode('@', $last);

                            //定义了其他命名空间
                            $_namespace = '';
                            if (isset(self::$ext[$uri]['namespace'])) {
                                $_namespace = self::$ext[$uri]['namespace'] . "\\";
                            }

                            //instanitate controller
                            $t = "\app\controllers\\" . $_namespace . $segments[0];

                            $controller = new $t();

                            //setData
                            $controller->segments = $matched;
                            $controller->setGetData($matched);

                            //call method and pass any extra parameters to the method
                            $return = $controller->$segments[1](implode(",", $matched));

                            if ($after) {
                                $after_segments = explode('@', $after);
                                $after_segments[0]::$after_segments[1]($return);
                            }
                            $controller->get(implode("||||", $matched));  //写入到get中
                        } else {
                            call_user_func_array(self::$callbacks[$pos], $matched);
                        }

                    }
                }
                $pos++;
            }
        }

        // run the error callback if the route was not found
        if ($found_route == false) {
            if (!self::$error_callback) {
                self::$error_callback = function () {
                    header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found");
                    echo '404';
                };
            }
            call_user_func(self::$error_callback);
        }
    }

    // detect true URI, inspired by CodeIgniter 2
    private static function detect_uri()
    {
        $uri = $_SERVER['REQUEST_URI'];
        if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0) {
            $uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
        } elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0) {
            $uri = substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
        }
        if ($uri == '/' || empty($uri)) {
            return '/';
        }
        $uri = parse_url($uri, PHP_URL_PATH);
        return str_replace(array('//', '../'), '/', trim($uri, '/'));
    }
}