<?php
class ReactionTagModel extends ExecuteModel {
    /**
     * 記事に対するリアクションがすでに登録されていればtrueを返す。
     * @param int $article_id
     * @param int $reaction_id
     * @param int $user_id
     * @return bool
     */
    public function isRegistered(int $article_id, int $reaction_id, int $user_id):bool {
        $sql = "SELECT COUNT(*)
                FROM reaction_tag
                WHERE article_id = :article_id AND reaction_id = :reaction_id AND user_id = :user_id";
        $result = $this->execute($sql, [':article_id' => $article_id, ':reaction_id' => $reaction_id, ':user_id' => $user_id]);
        if($result !== '0'){
            return true;
        }
        return false;
    }

    /**
     * ある記事に対するリアクションの種別と回数を取得する
     * @param int $article_id
     * @return array|null
     */
    public function computeAllReaction(int $article_id) {
        $sql = "SELECT reaction_id, COUNT(*)
                FROM reaction_tag
                WHERE article_id = :article_id
                GROUP BY reaction_id";
        return $this->getAllRecord($sql, [':article_id' => $article_id]);
    }
}