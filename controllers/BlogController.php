<?php
class BlogController extends Controller {
    const USER = 'user';
    const ID   = 'id';
    const STATUSMODEL_PREF = 'Status';
    const USERMODEL_PREF = 'User';
    const STATUSES = 'statuses';
    const TOKEN = '_token';
    const MESSAGE = 'message';
    const POST = 'status/post';
    const FOLLOW = 'account/follow';
    protected $_authentication = ['index', 'post'];

    /**
     * ユーザー専用ページを発行するアクションメソッド
     * @return string
     */
    public function indexAction() {
        $user = $this->_session->get(self::USER);
        $user_data = $this->_connect_model
                     ->get(self::STATUSMODEL_PREF)
                     ->getUserData($user[self::ID]);

        $index_view = $this->render([
            self::STATUSES => $user_data,
            self::MESSAGE  => '',
            self::TOKEN    => $this->getToken(self::POST)
        ]);
        return $index_view;
    }

    /**
     * フォームから投稿された記事をDBに登録する
     * @return string|void
     * @throws FileNotFoundException
     */
    public function postAction(){
        if(!$this->_request->isPost()){
            $this->httpNotFound();
        }

        $token = $this->_request->getPost(self::TOKEN);
        if(!$this->checkToken(self::POST, $token)){
            return $this->redirect('/');
        }
        $message = $this->_request->getPost(self::MESSAGE);
        $errors = [];

        if(!strlen($message)){
            $errors[] = '投稿記事を入力してください。';
        }elseif (mb_strlen($message) > 200){
            $errors[] = '内容は200文字以内です。';
        }

        if(count($errors) === 0){
            $user = $this->_session->get(self::USER);
            $this->_connect_model->get(self::STATUSMODEL_PREF)->insert($user[self::ID], $message);
            return $this->redirect('/');
        }

        $user = $this->_session->get(self::USER);
        $post_data = $this->_connect_model->get(self::STATUSMODEL_PREF)->getUserData($user[self::ID]);
        return $this->render([
            'errors' => $errors,
            self::MESSAGE => $message,
            self::STATUSES => $post_data,
            self::TOKEN => $this->getToken(self::POST)
        ], 'index');
    }

    /**
     * 特定ユーザーの全ての投稿を発行する
     * @param $par
     * @return string
     * @throws FileNotFoundException
     */
    public function userAction($par){
        $user_data = $this
            ->_connect_model
            ->get(self::USERMODEL_PREF)
            ->getUserRecord($par['user_name']);

        if(!$user_data) {
            $this->httpNotFound();
        }

        $posted_data = $this
            ->_connect_model
            ->get(self::STATUSMODEL_PREF)
            ->getPostedMessage($user_data[self::ID]);

        return $this->render([
            self::USER => $user_data,
            self::STATUSES => $posted_data,
            self::TOKEN => $this->getToken(self::FOLLOW),
        ]);
    }

    /**
     * 特定の1記事を発行する
     * @param $par
     * @return string
     * @throws FileNotFoundException
     */
    public function specificAction($par){
        $posted_data = $this
            ->_connect_model
            ->get(self::STATUSMODEL_PREF)
            ->getSpecificMessage($par[self::ID], $par['user_name']);

        if(!$posted_data) {
            $this->httpNotFound();
        }

        return $this->render(['status' => $posted_data]);
    }


}