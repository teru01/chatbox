<?php
class Request{

    /**
     * サーバーのホスト名を返す
     * @return string
     */
    public function getHostName(){
        if(!empty($_SERVER['HTTP_HOST'])){
            return $_SERVER['HTTP_HOST'];
        }
        return $_SERVER['SERVER_NAME'];
    }

    /**
     * リクエストされたURLのホスト名以下を返す
     * @return string
     */
    public function getRequestUri(){
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * フロントコントローラーまでのパスを返す
     * @return string
     */
    public function getBaseUrl(){
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $requestUri = $this->getRequestUri();

        if(0 === strpos($requestUri, $scriptName)){
            return $scriptName;
        }else if(0 === strpos($requestUri, dirname($scriptName))){
            return rtrim(dirname($scriptName), '/');
        }
        return '';
    }

    /**
     * フロントコントローラー以降に続くパスを返す。クエリパラメータは取り除く
     * @return string
     */
    public function getPath(){
        $base_url = $this->getBaseUrl();
        $requestUri = $this->getRequestUri();

        if(false !== ($sp = strpos($requestUri, '?'))){
            $requestUri = substr($requestUri, 0, $sp);
        }
        return (string)substr($requestUri, strlen($base_url));
    }

    /**
     * httpメソッドがpostか否か
     * @return bool
     */
    public function isPost(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            return true;
        }else {
            return false;
        }
    }

    /**
     * POSTで送られたデータを取得
     * @param string $name
     * @param null $param
     * @return string|null
     */
    public function getPost(string $name, $param=null){
        if(isset($_POST[$name])){
            return $_POST[$name];
        }else {
            return $param;
        }
    }


    /**
     * GETで送られたデータを取得
     * @param string $name
     * @param null $param
     * @return string|null
     */
    public function getGet(string $name, $param=null){
        if(isset($_GET[$name])){
            return $_GET[$name];
        }else {
            return $param;
        }
    }


}
