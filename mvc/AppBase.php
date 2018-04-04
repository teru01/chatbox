<?php


abstract class AppBase
{
    protected $_request;
    protected $_response;
    protected $_session;
    protected $_connectModel;
    protected $_router;
    protected $_signinAction = array();
    protected $_displayErrors;

    const CONTROLLER = 'Controller';
    const VIEWDIR = '/views';
    const MODELSDIR = '/models';
    const WEBDIR = '/mvc_htdocs';
    const CONTROLLERSDIR = '/controllers';

    public function __construct($dspErr)
    {

    }

    /**
     * 各クラスのインスタンス化
     */
    protected function initialize(){
        $this->_router       = new Router($this->getRouteDefinition());
        $this->_connectModel = new ConnectModel();
        $this->_request      = new Request();
        $this->_response     = new Response();
        $this->_session      = new Session();
    }

    /**
     * エラー表示の有効・無効の設定をする
     * @param bool $dspErr
     */
    protected function setDisplayErrors(bool $dspErr){
        if ($dspErr) {
            $this->_displayErrors = true;
            ini_set('display_errors', 1);
            ini_set('error_reporting', E_ALL);
        } else {
            $this->_displayErrors = false;
            ini_set('display_errors', 0);
        }
    }

    /**
     * @return mixed
     */
    public function isDisplayErrors(){
        return $this->_displayErrors;
    }

    public function run(){
        try{
            $parameters = $this->_router->getRouteParams($this->_request->getPath());

        }
    }


}
