<?php
class AccountController extends Controller{
    protected $_authentication = ['index', 'signout'];
    const SIGNUP = 'account/signup';
    const SIGNIN = 'account/signin';
    const FOLLOW = 'account/follow';
    const USER_NAME = 'user_name';
    const PASSWD = 'password';
    const ACCOUNT_PATH = '/account';
    const USER_IMG = 'user_img';
    const DEFAULT_USERIMG = 'default_image.jpg';


    /**
     * ユーザーアカウント情報を発行するアクションメソッド
     * @return string
     */
    public function indexAction(){
        $user_data = $this->_session->get(self::USER);
        $errors = $this->_session->get('errors');
        if(!isset($user_data[self::USER_IMG])){
            $user_data[self::USER_IMG] = self::DEFAULT_USERIMG;
        }

        $followingUsers = $this
            ->_connect_model
            ->get(self::USERMODEL_PREF)
            ->getFollowingUser($user_data[self::ID]);

        return $this->render([
            'user'           => $user_data,
            'followingUsers' => $followingUsers,
            'errors'         => $errors
            ]);
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

    /**
     * サインアウト処理を行うアクションメソッド
     */
    public function signoutAction(){
        $this->_session->clear();
        $this->_session->setAuthenticateStatus(false);
        return $this->redirect('/' . self::SIGNIN);
    }

    /**
     * フォローする人とされる人を登録する
     * @throws FileNotFoundException
     */
    public function followAction(){
        if(!$this->_request->isPost()){
            $this->httpNotFound();
        }

        $followed_user_name = $this->_request->getPost('followed_user_name');
        if(!$followed_user_name){
            $this->httpNotFound();
        }

        $token = $this->_request->getPost(self::TOKEN);
        if(!$this->checkToken(self::FOLLOW, $token)){
            return $this->redirect('/user/' . $followed_user_name);
        }

        $flwed_user_data = $this->_connect_model
                                   ->get(self::USERMODEL_PREF)
                                   ->getUserRecord($followed_user_name);
        if(!$flwed_user_data) {
            $this->httpNotFound();
        }

        $flwing_user_data = $this->_session->get(self::USER);
        $followTblConnection = $this->_connect_model->get(self::FollowingModel_PREF);
        if($flwing_user_data[self::ID] !== $flwed_user_data[self::ID]
            && !$followTblConnection->isFollowingUser($flwing_user_data[self::ID], $flwed_user_data[self::ID])){
            $followTblConnection->registerFollowUser($flwing_user_data[self::ID], $flwed_user_data[self::ID]);
        }
        return $this->redirect(self::ACCOUNT_PATH);
    }

    /**
     * ファイルアップロード時のエラーメッセージを格納する
     * @return mixed
     */
    private function setErrMsg(){
        $msg = [
            UPLOAD_ERR_INI_SIZE => 'ファイルサイズが大きすぎます。(php.ini)',
            UPLOAD_ERR_FORM_SIZE => 'ファイルサイズが大きすぎます。(HTML form error)',
            UPLOAD_ERR_PARTIAL => 'ファイルが一部しかアップロードされていません。',
            UPLOAD_ERR_NO_FILE => 'ファイルはアップロードされませんでした。',
            UPLOAD_ERR_NO_TMP_DIR => '一時保存フォルダが存在しません。',
            UPLOAD_ERR_CANT_WRITE => 'ディスクへの書き込みに失敗しました。',
            UPLOAD_ERR_EXTENSION => '拡張モジュールによってアップロードが中断されました。'
        ];
        return $msg[$_FILES['upload']['error']];
    }

    /**
     * ユーザのレコードとセッション情報を更新する
     * @param $user_data
     * @param $img_location
     */
    private function updateUserData($user_data, $img_location){
        $this->_connect_model
            ->get(self::USERMODEL_PREF)
            ->updateUserImage($user_data[self::ID], $img_location);

        $user_data_with_img = $this->_connect_model
            ->get(self::USERMODEL_PREF)
            ->getUserRecord($user_data[self::USER_NAME]);
        $this->_session->set(self::USER, $user_data_with_img);
    }

    /**
     * ユーザーアイコン画像をアップロードする
     */
    public function uploadAction(){
        $allow_types = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF];
        $uploaded_file = $_FILES['upload']['tmp_name'];
        $user_data = $this->_session->get(self::USER);
        $err_msg = '';
        if ($_FILES['upload']['error'] !== UPLOAD_ERR_OK) {
            $err_msg = $this->setErrMsg();

        } elseif (!in_array(exif_imagetype($uploaded_file), $allow_types)) {
            $err_msg = 'jpeg, png, gifのいずれかをアップロードしてください。';

        } else {
            list($width, $height) = getimagesize($uploaded_file);
            $thumb_wid = 100;
            $thumb_hei = 100;
            $thumbnail = imagecreatetruecolor($thumb_wid, $thumb_hei);
            $base_img = imagecreatefromjpeg($uploaded_file);
            imagecopyresampled($thumbnail, $base_img, 0, 0, 0, 0, $thumb_wid, $thumb_hei, $width, $height);
            $img_location_from_docroot = '/images/user_imgs/'.$user_data[self::USER_NAME].$_FILES['upload']['name'];
            $img_dest = $_SERVER['DOCUMENT_ROOT'].$img_location_from_docroot;

            if (imagejpeg($thumbnail, $img_dest, 60)) {
                $this->updateUserData($user_data, $img_location_from_docroot);
            }

            else{
                $err_msg = 'アップロード処理に失敗しました。';
            }
        }

        $this->_session->set('errors', $err_msg ? [$err_msg] : null);

        $this->redirect(self::ACCOUNT_PATH);
    }
}