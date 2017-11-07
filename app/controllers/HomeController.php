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
namespace app\controllers;
use Aiiphp\View;
use Aiiphp\Controller;
use Illuminate\Database\Capsule\Manager as DB;
use app\models\Test;
use Autoclass\Curl;

class HomeController extends Controller
{

    public function route(){
        exit("route");
    }

    public function home()
    {

//        $demoobj = $this->load('Demo');
//        echo $demoobj->test();exit;

        //echo Curl::get("http://www.jincon.com");

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

        //
        //DB::insert('insert into users (id, name) values (?, ?)', [1, 'Dayle']);
        //$affected = DB::update('update users set votes = 100 where name = ?', ['John']);
        //$deleted = DB::delete('delete from users');
        //Transactions
        /*DB::transaction(function () {
            DB::table('users')->update(['votes' => 1]);
            DB::table('posts')->delete();
        });*/
        //$users = DB::insert('insert into tests (title, content) values (?, ?)', [1, 'Dayle']);
        $users = DB::select('select * from tests where id = ?',[1]);
        //$users = Capsule::table('users')->where('votes', '>', 100)->get();
        //$results = Capsule::select('select * from users where id = ?', array(1));
        //var_dump($users);
        //$user = DB::table('users')->where('name', 'John')->first();
        //echo $user->name;
        // view sample
        $this->view = View::make('home')->with('article',Test::selecttest())
            ->withTitle('Aiiphp2 :-D')
            ->withFuckMe('OK!');

    }

}