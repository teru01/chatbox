<?php
class AccountController extends Controller{
    protected $_authentication = ['index', 'signout'];
    const SIGNUP = 'account/signup';
    const SIGNIN = 'account/signin';
    const FOLLOW = 'account/follow';

    /**
     * サインアップのアクションメソッド
     * @return string
     */
    public function signupAction(){
        if($this->_session->isAuthenticated()){
            $this->redirect('/account');
        }
        $signup_view = $this->render([
            'user_name' => '',
            'password'  => '',
            '_token'    => $this->getToken(self::SIGNUP),
        ]);
        return $signup_view;
    }

    

}