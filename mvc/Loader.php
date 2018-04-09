<?php

/**
 * Class Loader
 */
class Loader{
    protected $_directories = [];

    /**
     * ローダー対象にするディレクトリを指定する
     * @param string $dir
     */
    public function regDirectory(string $dir){
        $this->_directories[] = $dir;
    }

    /**
     * オートロードのコールバックを登録する。
     */
    public function register(){
        spl_autoload_register([$this, 'requireClsFile']);
    }

    /**
     * クラスを読み込むコールバック関数
     * @param string $class
     */
    public function requireClsFile(string $class){
        foreach ($this->_directories as $dir){
            $file = $dir . '/' . $class . '.php';
            if(is_readable($file)){
                require $file;
                return;
            }
        }
    }
}