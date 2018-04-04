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
    const NOTFOUNDMSG = 'FILE NOT FOUND.';

    /**
     * AppBase constructor.
     * @param bool $dspErr
     */
    public function __construct(bool $dspErr){
        $this->setDisplayErrors($dspErr);
        $this->initialize();
        $this->doDbConnection();
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
     * コントローラー、アクションを決定しコンテンツを取得、レスポンスを返す
     */
    public function run(){
        try{
            $parameters = $this->_router->getRouteParams($this->_request->getPath());
            if ($parameters === false) {
                throw new FileNotFoundException('NO ROUTE TO' . $this->_request->getPath());
            }
            $controller = $parameters["controller"];
            $action = $parameters["action"];
            $this->getContent($controller, $action, $parameters);
        } catch (FileNotFoundException $e){
            $this->dispErrorPage($e);
        } catch (AutherizedException $e){
            list($controller, $action) = $this->_signinAction;
            $this->getContent($controller, $action);
        }
        $this->_response->send();
    }

    /**
     * コントローラーに対するアクションを実行し、responseオブジェクトに格納する
     * @param string $controllerName
     * @param string $action
     * @param array $parameters
     */
    public function getContent(string $controllerName, string $action, $parameters=[]){
        $controllerClass = ucfirst($controllerName) . self::CONTROLLER;
        $controller = $this->getControllerObject($controllerClass);
        if (is_null($controller)){
            throw new FileNotFoundException($controllerClass . 'NOT FOUND');
        }
        $content = $controller->dispatch($action, $parameters);
        $this->_response->setContent($content);
    }

    /**
     * Controllerオブジェクトを取得し返す
     * @param string $controllerClass
     * @return Controller | null
     */
    protected function getControllerObject(string $controllerClass){
        if(!class_exists($controllerClass)){
            $controllerFile = $this->getControllerDirectory() . '/' . $controllerClass . '.php';
            if(!is_readable($controllerFile)){
                return null;
            }else{
                require_once $controllerFile;
                if(!class_exists($controllerClass)){
                    return null;
                }
            }
        }
        $controller = new $controllerClass($this);
        return $controller;
    }


    /**
     * エラーメッセージを表示するページをresponseオブジェクトに格納する
     * @param Exception $e
     */
    protected function dispErrorPage(Exception $e){
        $this->_response->setStatusCode(404, self::NOTFOUNDMSG);
        $errMessage = $this->isDisplayErrors() ? $e->getMessage() : self::NOTFOUNDMSG;
        $errMessage = htmlspecialchars($errMessage, ENT_QUOTES, 'UTF-8');
        $html = "
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8' />
<title>HTTP 404 Error</title>
</head>
<body>
{$errMessage}
</body>
</html>";
        $this->_response->setContent($html);
    }

    /**
     * @return mixed
     */
    abstract protected function getRouteDefinition();

    /**
     *
     */
    protected function doDbConnection(){}

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->_session;
    }

    /**
     * @return ConnectModel
     */
    public function getConnectModel()
    {
        return $this->_connectModel;
    }

    /**
     * @return bool
     */
    public function isDisplayErrors(){
        return $this->_displayErrors;
    }

    public function getViewDirectory(){
        return $this->getRootDirectory() . self::VIEWDIR;
    }

    public function getModelDirectory(){
        return $this->getRootDirectory() . self::MODELSDIR;
    }

    public function getDocDirectory(){
        return $this->getRootDirectory() . self::WEBDIR;
    }

    abstract public function getRootDirectory();

    public function getControllerDirectory(){
        return $this->getRootDirectory() . self::CONTROLLERSDIR;
    }

}
