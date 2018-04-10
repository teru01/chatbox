<?php
class BlogController extends Controller {
    const USER = 'user';
    const ID   = 'id';
    const STATUSMODEL_PREF = 'Status';
    const STATUSES = 'statuses';
    const TOKEN = '_token';
    const MESSAGE = 'message';
    const POST = 'status/post';
    const FOLLOW = 'account/follow';

    /**
     * ユーザー専用ページを発行するアクションメソッド
     * @return string
     */
    public function indexAction() {
        $user = $this->_session->get(self::USER);
        $user_data  = $this->_connect_model
                     ->get('Status')
                     ->getUserData($user[self::ID]);

        $index_view = $this->render([
            self::STATUSES => $user_data,
            self::MESSAGE  => '',
            self::TOKEN    => $this->getToken(self::POST)
        ]);
        return $index_view;
    }
}