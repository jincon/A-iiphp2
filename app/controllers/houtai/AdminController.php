<?php
/**
 * Created by PhpStorm.
 * User: jincon
 * Date: 2016/12/27
 * Time: 上午9:27
 */

/**
 * \HomeController
 */
namespace app\controllers\houtai;
use Aiiphp\View;
use Aiiphp\Controller;

use app\models\Test;

class AdminController extends Controller
{

    public function home()
    {
        print_r($_GET);
        die("11");
//        $data = ['title'=>'你', 'email'=>'1@baiducom','ip'=>'12.12'];
//        $rules = [
//            'title' => 'required|min:3|max:255',
//            'email' => 'required|email',
//            'ip' => 'required|ip',
//        ];
//
//        $validator = new \Jincon\AiiValidator\AiiValidator($data, $rules);
//
//        if ( !$validator->success ) {
//            foreach ($validator->errors as $error) {
//                echo $error.'<br>';
//            }
//        }



        // mail sample
//        Mail::to('foo@bar.io')->from('bar@foo.io')
//            ->title('Foo Bar')
//            ->content('<h1>Hello~~</h1>')
//            ->send();

        // redis sample
//        Redis::set('key','value',3000,'ms');
//        echo Redis::get('key');

        // view sample
        $this->view = View::make('home')->with('article',Test::first())
            ->withTitle('Aiiphp2 :-D')
            ->withFuckMe('OK!');

    }

}