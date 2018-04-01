<?php

/**
 * Class Loader
 */
class Loader{
    protected $_directories = [];

    public function regDirectory(string $dir){
        $this->_directories[] = $dir;
    }

    public function register(){
        spl_autoload_register([$this, 'requireClsFile']);
    }

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