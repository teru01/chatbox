<?php
class BlogController extends Controller {
    const ARTICLES = 'articles';
    const MESSAGE = 'message';
    const POST = 'article/post';
    const FOLLOW = 'account/follow';
    const REACTIONTAGMODEL_PREF = 'ReactionTag';
    protected $_authentication = ['index', 'post'];


    /**
     * 配列を利用できる形に変換する
     * In: [["reaction_id" => 1, "count" => 1],["reaction_id" => 3, "count" => 3]]
     * Out: [1 => 1, 2 => 0, 3 => 3, 4 => 0]
     * In: null
     * Out: [1 => 0, 2 => 0, 3 => 0, 4 => 0]
     * @param array $ary
     * @param array $reactions
     * @return array
     */
    public static function formatAry(?array $ary, array $reactions){
        $formatted_ary = [];
        if($ary) {
            foreach ($ary as $content) {
                $formatted_ary[$content["reaction_id"]] = $content["count"];
            }
        }
        for($i=1; $i<=count($reactions); $i++){
            if(!isset($formatted_ary[$i])){
                $formatted_ary[$i] = 0;
            }
        }
        return $formatted_ary;
    }

    /**
     * ユーザー専用ページを発行するアクションメソッド
     * @return string
     */
    public function indexAction():string {
        $user = $this->_session->get(self::USER);
        $posted_dataset = $this
            ->_connect_model
            ->get(self::ARTICLEMODEL_PREF)
            ->fetchAllPostedData($user[self::ID]);

        $reactions = ["like" => 1, "surprise" => 2, "laugh" => 3, "dislike" => 4];
        //$reactions = $this->_connect_model->get("Reaction")->getAllReactions();
        foreach($posted_dataset as $key => $data){
            //$posted_data[$key]["reaction"] = [[reaction_id => 1, COUNT => 2],[..=>..]...]

            $posted_dataset[$key]["reaction"] = $this
                ->_connect_model
                ->get(self::REACTIONTAGMODEL_PREF)
                ->computeAllReaction($data[self::ID]);

            $posted_dataset[$key]["reaction"] = self::formatAry($posted_dataset[$key]["reaction"], $reactions);
        }

        $index_view = $this->render([
            self::USER     => $user,
            self::ARTICLES => $posted_dataset,
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
        }elseif (mb_strlen($message) > 2000){
            $errors[] = '内容は2000文字以内です。';
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


    /**
     * 無効なリアクションはNOT FOUNDでリダイレクトする
     * @param int $reaction_id
     * @throws FileNotFoundException
     */
    private function redirectInvalidReaction(int $reaction_id){
        $is_valid_reaction_id = $this->_connect_model
            ->get('Reaction')
            ->isValidReactionId($reaction_id);
        if(!$is_valid_reaction_id) $this->httpNotFound();
    }

    /**
     * 記事に対するリアクションがすでに登録されていればtrue
     * @param int $article_id
     * @param int $reaction_id
     * @param int $user_id
     * @return bool
     */
    private function isRegistered(int $article_id, int $reaction_id, int $user_id){
        return $this
            ->_connect_model
            ->get(self::REACTIONTAGMODEL_PREF)
            ->isRegistered($article_id, $reaction_id, $user_id);
    }

    /**
     * 記事に対してリアクションの付加・取り消しを行う
     * @param array $par
     * @throws FileNotFoundException
     */
    public function reactAction(array $par) {
        $reaction_id = $par['reaction_id'];

        $this->redirectInvalidReaction($reaction_id);

        $user_data = $this->_session->get(self::USER);

        if($this->isRegistered($par[self::ID], $reaction_id, $user_data[self::ID])){
            $this
                ->_connect_model
                ->get(self::REACTIONTAGMODEL_PREF)
                ->deleteReaction($par[self::ID], $reaction_id, $user_data[self::ID]);
        }else{
            $this
                ->_connect_model
                ->get(self::REACTIONTAGMODEL_PREF)
                ->addReaction($par[self::ID], $reaction_id, $user_data[self::ID]);
        }

        $this->redirect('index');
    }

}