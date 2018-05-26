<?php
class Session{
    protected static $_session_flag = false;
    protected static $_generated_flag = false;

    /**
     * Session constructor.
     */
    public function __construct(){
        if(!self::$_session_flag){
            session_start();
            self::$_session_flag = true;
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set(string $key, $value){
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @param null $par
     * @return null
     */
    public function get(string $key, $par=null){
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
        return $par;
    }

    /**
     * 現在のセッションIDを新しく生成したものと置き換える。
     * @param bool $del
     */
    public function generateSession(bool $del=true){
        if(!self::$_generated_flag){
            session_regenerate_id($del);
            self::$_generated_flag = true;
        }
    }

    /**
     * サインイン/サインアウト状態を設定する
     * @param bool $flag
     */
    public function setAuthenticateStatus(bool $flag){
        $this->set('_authenticated', $flag);
        $this->generateSession();
    }

    /**
     * サインインしているか否かを返す
     * @return bool
     */
    public function isAuthenticated(){
        return $this->get('_authenticated', false);
    }

    /**
     * $_SESSIONを空にする。
     */
    public function clear(){
        $_SESSION = [];
    }

}