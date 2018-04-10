<?php
class StatusModel extends ExecuteModel {

    /**
     * statusテーブルに投稿情報を追加する
     * @param int $user_id
     * @param string $message
     */
    public function insert(int $user_id, string $message){
        $now = new DateTime();
        $sql = "INSERT INTO status(user_id, message, time_stamp) VALUES(:user_id, :message, :time_stamp)";
        $this->execute($sql, [
            ':user_id'    => $user_id,
            ':message'    => $message,
            ':time_stamp' => $now
        ]);
    }

    public function getUserData(int $user_id){
        $sql = "SELECT st.*, us.user_name
                FROM   status st LEFT JOIN user us ON st.user_id = us.id
                                 LEFT JOIN followingUser f ON f.following_id = st.user_id
                                                           AND f.user_id = :user_id
                WHERE  f.user_id = :user_id OR us.id = :user_id
                ORDER BY st.time_stamp DESC";
        return $this->getAllRecord($sql, [':user_id' => $user_id]);
    }
}