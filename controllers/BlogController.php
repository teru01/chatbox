<?php
class BlogController extends Controller {
    const ARTICLES = 'articles';
    const MESSAGE = 'message';
    const POST = 'article/post';
    const FOLLOW = 'account/follow';
    const REACTIONTAGMODEL_PREF = 'Reaction_tag';
    protected $_authentication = ['index', 'post'];



    /**
     * ユーザー専用ページを発行するアクションメソッド
     * @return string
     */
    public function indexAction():string {
        $user = $this->_session->get(self::USER);
        $posted_data = $this->_connect_model
                     ->get(self::ARTICLEMODEL_PREF)
                     ->fetchAllPostedData($user[self::ID]);

        foreach($posted_data as &$article){
            $article["reaction"] = $this->_connect_model
                                        ->get(self::REACTIONTAGMODEL_PREF)
                                        ->selectAllReaction($article[self::ID]);
        }
        unset($article);

        $reactions = ["like" => 1, "surprise" => 2, "laugh" => 3, "dislike" => 4];
        
        $index_view = $this->render([
            self::USER     => $user,
            self::ARTICLES => $posted_data,
            self::MESSAGE  => '',
            self::TOKEN    => $this->getToken(self::POST),
            'reactions'    => $reactions,

        ]);
        return $index_view;
    }

    /**
     * フォームから投稿された記事をDBに登録する
     * @return null|string
     * @throws FileNotFoundException
     */
    public function postAction(): ?string {
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
            $this->_connect_model->get(self::ARTICLEMODEL_PREF)->insert($user[self::ID], $message);
            return $this->redirect('/');
        }

        $user = $this->_session->get(self::USER);
        $post_data = $this->_connect_model->get(self::ARTICLEMODEL_PREF)->fetchAllPostedData($user[self::ID]);
        return $this->render([
            'errors' => $errors,
            self::MESSAGE => $message,
            self::ARTICLES => $post_data,
            self::TOKEN => $this->getToken(self::POST)
        ], 'index');
    }

    /**
     * 特定ユーザーの全ての投稿とフォローボタンを発行する
     * @param array $par
     * @return string
     * @throws FileNotFoundException
     */
    public function userAction(array $par):string {
        $user_data = $this
            ->_connect_model
            ->get(self::USERMODEL_PREF)
            ->getUserRecord($par['user_name']);

        if(!$user_data) {
            $this->httpNotFound();
        }

        $posted_data = $this
            ->_connect_model
            ->get(self::ARTICLEMODEL_PREF)
            ->fetchPostedMessage($user_data[self::ID]);

        $following = null;
        if($this->_session->isAuthenticated()){
            $login_user = $this->_session->get(self::USER);
            if($login_user[self::ID] !== $user_data[self::ID]){
                $following = $this
                    ->_connect_model
                    ->get(self::FollowingModel_PREF)
                    ->isFollowingUser($login_user[self::ID], $user_data[self::ID]);
            }
        }

        return $this->render([
            self::USER => $user_data,
            self::ARTICLES => $posted_data,
            'following' => $following,
            self::TOKEN => $this->getToken(self::FOLLOW),
        ]);
    }

    /**
     * 特定の1記事を発行する
     * @param array $par
     * @return string
     * @throws FileNotFoundException
     */
    public function specificAction(array $par):string {
        $posted_data = $this
            ->_connect_model
            ->get(self::ARTICLEMODEL_PREF)
            ->fetchSpecificMessage($par[self::ID], $par['user_name']);

        if(!$posted_data) {
            $this->httpNotFound();
        }

        return $this->render(['article' => $posted_data]);
    }

    public function reactAction($par) {
        if(!$this->_request->isPost()){
            $this->httpNotFound();
        }

        $this->_connect_model
             ->get(self::REACTIONTAGMODEL_PREF)
             ->doReaction($par[self::ID], $par['reaction_id']);

        $this->redirect('index');
    }

}