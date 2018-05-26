<?php
class FollowingModel extends ExecuteModel{

    /**
     * フォローする人をされる人のIDをDBに登録
     * @param int $user_id
     * @param int $follow_id
     */
    public function registerFollowUser(int $user_id, int $follow_id){
        $sql = "INSERT INTO following_user VALUES (:user_id, :follow_id)";
        $this->execute($sql, [':user_id' => $user_id, ':follow_id' => $follow_id]);
    }

    /**
     * 指定されたユーザーをフォローしているか
     * @param int $user_id
     * @param int $follow_id
     * @return bool
     */
    public function isFollowingUser(int $user_id, int $follow_id){
        $sql = "SELECT COUNT(user_id) AS count
                FROM following_user 
                WHERE user_id = :user_id AND following_id = :follow_id";
        $dat = $this->getRecord($sql, [':user_id' => $user_id, ':follow_id' => $follow_id]);
        if ($dat['count'] !== '0') {
            return true;
        }
        return false;
    }
}