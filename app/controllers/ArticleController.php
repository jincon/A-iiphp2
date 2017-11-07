<?php
/**
 * Created by PhpStorm.
 * User: jincon
 * Date: 2017/11/1
 * Time: 下午10:48
 */

namespace app\controllers;
use Aiiphp\View;
use Aiiphp\Controller;
use Illuminate\Database\Capsule\Manager as DB;
//use app\models\Test;

class ArticleController extends Controller
{
    public function show($segments){

        print_r($_POST);

        //$this->segments;
        //var_dump($this->get());

        echo "id:".$segments;
        exit("Article/show");
    }

    public function view($id){
        print_r($_GET);
        echo "id:".$id;
        exit("Article/view");
    }
}