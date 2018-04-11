<?php
class AccountController extends Controller{
    protected $_authentication = ['index', 'signout'];
    const SIGNUP = 'account/signup';
    const SIGNIN = 'account/signin';
    const FOLLOW = 'account/follow';
    const USER_NAME = 'user_name';
    const PASSWD = 'password';
    const TOKEN = '_token';
    const USERMODEL_PREF = 'User';
    const ACCOUNT_PATH = '/account';


    /**
     * ユーザーアカウント情報を発行するアクションメソッド
     * @return string
     */
    public function indexAction(){
        $user_data = $this->_session->get('user');
        $followingUsers = $this->_connect_model->get(self::USERMODEL_PREF);
        return $this->render(['user' => $user_data,]);
    }

    /**
     * アカウント登録画面を発行するアクションメソッド
     * @return string
     */
    public function signupAction(){
        if($this->_session->isAuthenticated()){
            $this->redirect(self::ACCOUNT_PATH);
        }
        $signup_view = $this->render([
            self::USER_NAME => '',
            self::PASSWD    => '',
            self::TOKEN     => $this->getToken(self::SIGNUP),
        ]);

        return $signup_view;
    }

    /**
     * アカウントの登録を行うアクションメソッド
     * @return string|void
     * @throws FileNotFoundException
     */
    public function registerAction(){

        if(!$this->_request->isPost()){
            $this->httpNotFound();
        }

        if($this->_session->isAuthenticated()){
            $this->redirect(self::ACCOUNT_PATH);
        }

        $token = $this->_request->getPost(self::TOKEN);
        if(!$this->checkToken(self::SIGNUP, $token)){
            return $this->redirect('/' . self::SIGNUP);
        }

        $user_name = $this->_request->getPost(self::USER_NAME);
        $password = $this->_request->getPost(self::PASSWD);
        $errors = [];

        if(!strlen($user_name)){
            $errors[] = 'ユーザーIDが未入力です';
        }elseif (!preg_match('/^\w{3,20}$/', $user_name)){
            $errors[] = 'ユーザーIDは3文字から20文字です';
        }elseif ($this->_connect_model->get(self::USERMODEL_PREF)->isOverlapUserName($user_name)){
            $errors[] = 'ユーザーIDはすでに使われています。';
        }

        if(!strlen($password)){
            $errors[] = 'パスワードが入力されていません';
        }elseif (strlen($password) < 8 || strlen($password) > 30){
            $errors[] = 'パスワードは8文字から30文字までです。';
        }

        if(count($errors) === 0){
            $this->_connect_model->get(self::USERMODEL_PREF)->insert($user_name, $password);
            $this->_session->setAuthenticateStatus(true);
            $user = $this->_connect_model->get(self::USERMODEL_PREF)->getUserRecord($user_name);
            $this->_session->set('user', $user);
            $this->redirect('/');
        }
        return $this->render([
            self::USER_NAME => $user_name,
            self::PASSWD    => $password,
            'errors'        => $errors,
            self::TOKEN     => $this->getToken(self::SIGNUP),
        ], 'signup');

    }

    /**
     * サインイン用の画面を発行する
     * @return string
     */
    public function signinAction(){
        if($this->_session->isAuthenticated()){
            $this->redirect(self::ACCOUNT_PATH);
        }

        return $this->render([
            self::USER_NAME => '',
            self::PASSWD    => '',
            self::TOKEN     => $this->getToken(self::SIGNIN)
        ]);
    }

    /**
     * ログイン画面から送られた認証情報を元にサインイン処理をする
     * @return string|void
     * @throws FileNotFoundException
     */
    public function authenticateAction(){
        if($this->_session->isAuthenticated()){
            $this->redirect(self::ACCOUNT_PATH);
        }

        if(!$this->_request->isPost()){
            $this->httpNotFound();
        }

        $token = $this->_request->getPost(self::TOKEN);
        if(!$this->checkToken(self::SIGNIN, $token)){
            $this->redirect('/' . self::SIGNIN);
        }

        $user_name = $this->_request->getPost(self::USER_NAME);
        $password = $this->_request->getPost(self::PASSWD);

        $errors = [];
        if(!strlen($user_name)){
            $errors[] = 'ユーザ名を入力してください';
        }

        if(!strlen($password)){
            $errors[] = 'パスワードを入力してください';
        }

        if(count($errors) === 0){
            $user_data = $this->_connect_model->get(self::USERMODEL_PREF)->getUserRecord($user_name);
            if($user_data == null
                || password_verify($password, $user_data[self::PASSWD]) === false){
                $errors[] = 'IDまたはパスワードが間違えてます';
            }else{
                $this->_session->setAuthenticateStatus(true);
                $this->_session->set('user', $user_data);
                return $this->redirect('/');
            }
        }

        return $this->render([
            self::USER_NAME => $user_name,
            self::PASSWD => $password,
            'errors' => $errors,
            self::TOKEN => $this->getToken(self::SIGNIN),
        ], 'signin');
    }



}