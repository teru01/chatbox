<?php
require_once 'MysqlAccessData.php';

class BlogApp extends AppBase{
    protected $_signinAction = ['account', 'signin'];
    /**
     * DBに接続する
     */
    protected function doDbConnection(){
        $this->_connectModel->connect('master', [
            'string'   =>  'mysql:dbname=weblog;host=localhost; charset=utf8',
            'user'     =>  MYSQL_USER,
            'password' =>  MYSQL_PASS,
        ]);
    }

    public function getRootDirectory(){
        return dirname(__FILE__);
    }

    protected function getRouteDefinition(){
        return [
            '/account'
                => ['controller' => 'account',
                    'action'     => 'index'],
            '/account/:action'
                => ['controller' => 'account'],
            '/follow'
                => ['controller' => 'account',
                    'action'     => 'follow'],
            '/'
                => ['controller' => 'blog',
                    'action'     => 'index'],
            '/status/post'
                => ['controller' => 'blog',
                    'action'     => 'post'],
            'user/:user_name'
                => ['controller' => 'blog',
                    'action'     => 'user'],
            'user/:user_name/status/:id'
                => ['controller' => 'blog',
                    'action'     => 'specific'],
        ];
    }


}