<?php

class BlogApp extends AppBase{
    protected $_signinAction = ['account', 'signin'];
    /**
     * DBに接続する
     */
    protected function doDbConnection(){
        $this->_connectModel->connect('master', [
            'string'   =>  'mysql:dbname=chatbox;host='.getenv("DATABASE_HOST").';charset=utf8',
            'user'     =>  getenv("MYSQL_USER"),
            'password' =>  getenv("MYSQL_PASSWORD"),
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
            '/article/post'
                => ['controller' => 'blog',
                    'action'     => 'post'],
            'user/:user_name'
                => ['controller' => 'blog',
                    'action'     => 'user'],
            'user/:user_name/article/:id'
                => ['controller' => 'blog',
                    'action'     => 'specific'],
            'article/:id/:reaction_id'
                => ['controller' => 'blog',
                    'action'     => 'react'],
        ];
    }


}