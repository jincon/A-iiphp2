<?php
/**
 * Created by PhpStorm.
 * User: jincon
 * Date: 2016/12/27
 * Time: 上午9:32
 */

/**

 * Test Model

 */
namespace app\models;

use Illuminate\Database\Capsule\Manager as DB;

class Test extends \Illuminate\Database\Eloquent\Model{

    public $timestamps = false;

    static public function selecttest(){
        return  DB::table('tests')->where('id', '1')->first();
    }


}