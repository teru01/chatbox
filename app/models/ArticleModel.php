<?php
class ArticleModel extends ExecuteModel {

    /**
     * articleテーブルに投稿情報を追加する
     * @param int $user_id
     * @param string $message
     */
    public function insert(int $user_id, string $message){
        $now = new DateTime();
        $sql = "INSERT INTO article(user_id, message, time_stamp) VALUES(:user_id, :message, :time_stamp)";
        $this->execute($sql, [
            ':user_id'    => $user_id,
            ':message'    => $message,
            ':time_stamp' => $now->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * 自分とフォローしている人の全ての情報をDBから取得し返す
     * @param int $user_id
     * @return mixed
     */
    public function fetchAllPostedData(int $user_id){
        $sql = "SELECT art.*, us.user_name
                FROM   article AS art
                LEFT JOIN user AS us ON art.user_id = us.id                 
                LEFT JOIN following_user AS f ON f.following_id = art.user_id
                                                  AND f.user_id = :user_id
                WHERE  f.user_id = :user_id OR us.id = :user_id
                ORDER BY art.time_stamp DESC";
        return $this->getAllRecord($sql, [':user_id' => $user_id]);
    }

    /**
     * 渡されたユーザーIDの投稿とユーザ情報をDBから全て取得し返す
     * @param int $user_id
     * @return mixed
     */
    public function fetchPostedMessage(int $user_id){
        $sql = "SELECT art.*, u.user_name
                FROM article art LEFT JOIN user u ON art.user_id = u.id
                WHERE u.id = :user_id
                ORDER BY art.time_stamp DESC";
        return $this->getAllRecord($sql, [':user_id' => $user_id]);
    }

    /**
     * 渡された記事IDとユーザ名に一致する記事をDBから取得し返す
     * @param int $article_id
     * @param string $user_name
     * @return mixed
     */
    public function fetchSpecificMessage(int $article_id, string $user_name){
        $sql = "SELECT art.*, u.user_name
                FROM article art LEFT JOIN user u ON art.user_id = u.id
                WHERE art.id = :article_id AND u.user_name = :user_name";
        return $this->getRecord($sql, [':article_id' => $article_id, ':user_name' => $user_name]);
    }


}