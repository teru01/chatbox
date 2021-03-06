<?php
abstract class Controller{
    protected $_application;
    protected $_controller;
    protected $_action;
    protected $_request;
    protected $_response;
    protected $_session;
    protected $_connect_model;
    protected $_authentication = [];
    const PROTOCOL = 'http://';
    const ACTION = 'Action';
    const ARTICLEMODEL_PREF = 'Article';
    const USERMODEL_PREF = 'User';
    const FollowingModel_PREF = 'Following';
    const USER = 'user';
    const ID   = 'id';
    const TOKEN = '_token';

    public function __construct($application){
        $this->_controller     = strtolower(substr(get_class($this), 0, -10));
        $this->_application    = $application;
        $this->_request        = $application->getRequest();
        $this->_response       = $application->getResponse();
        $this->_session        = $application->getSession();
        $this->_connect_model  = $application->getConnectModel();
    }

    /**
     * アプリケーションのスーパクラスから呼ばれて、アクションメソッドを実行する
     * @param string $action
     * @param array $params
     * @return mixed
     * @throws AuthorizedException
     * @throws FileNotFoundException
     */
    public function dispatch(string $action, $params=[]){
        $this->_action = $action;
        $action_method = $action . self::ACTION;

        if(!method_exists($this, $action_method)){
            $this->httpNotFound();
        }

        if($this->isAuthentication($action) && !$this->_session->isAuthenticated()){
            throw new AuthorizedException();
        }
        $content = $this->$action_method($params);
        return $content;
    }

    /**
     * NOT FOUND例外を処理する
     * @throws FileNotFoundException
     */
    protected function httpNotFound(){
        throw new FileNotFoundException('FILE NOT FOUND' . $this->_controller . '/' . $this->_action);
    }

    /**
     * 呼び出すのに認証が必要なアクションメソッドか否か
     * @param string $action
     * @return bool
     */
    protected function isAuthentication(string $action){
        if($this->_authentication === true
            || (is_array($this->_authentication)
                && in_array($action, $this->_authentication))){
            return true;
        }
        return false;
    }

    /**
     * Viewクラスのrender()を呼び出しコンテンツを返す
     * @param array $param
     * @param string|null $viewFile
     * @param string|null $template
     * @return string
     */
    protected function render($param=[], string $viewFile=null, string $template=null){
        $info = [
            'request'  => $this->_request,
            'base_url' => $this->_request->getBaseUrl(),
            'session'  => $this->_session,
        ];
        $view = new View($this->_application->getViewDirectory(), $info);

        if(is_null($viewFile)){
            $viewFile = $this->_action;
        }

        if(is_null($template)){
            $template = 'template';
        }

        $path = $this->_controller . '/' . $viewFile;
        $contents = $view->render($path, $param, $template);
        return $contents;
    }


    /**
     * 指定されたURLにリダイレクトを行う
     * @param string $url
     */
    protected function redirect(string $url){
        $host = $this->_request->getHostName();
        $base_url = $this->_request->getBaseUrl();
        $url = self::PROTOCOL . $host . $base_url . $url;
        $this->_response->setStatusCode(302);
        $this->_response->setHeader('Location', $url);
    }

    /**
     * アクションメソッドにより呼び出される。トークンを作成してトークンリストに追加し、新たに作成したトークンを返す
     * @param string $form コントローラー名/アクション名
     * @return string $token
     */
    protected function getToken(string $form){
        $key = 'token/' . $form;
        $tokens = $this->_session->get($key, []);
        if(count($tokens) >= 10){
            array_shift($tokens);
        }

        $password = session_id() . $form;
        $token = password_hash($password, PASSWORD_DEFAULT);
        $tokens[] = $token;
        $this->_session->set($key, $tokens);
        return $token;
    }

    /**
     * フォームデータと共に送信されるトークンがトークンリストにあるかチェックする。
     * @param string $form
     * @param string $token
     * @return bool
     */
    protected function checkToken(string $form, string $token){
        $key = 'token/' . $form;
        $tokens = $this->_session->get($key, []);
        if(false !== ($present = array_search($token, $tokens, true))){
            unset($tokens[$present]);
            $this->_session->set($key, $tokens);
            return true;
        }
        return false;
    }
}
