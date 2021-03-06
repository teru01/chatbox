<?php
class UserModel extends ExecuteModel{

    /**
     * ユーザをDBに登録する
     * @param string $user_name
     * @param string $password
     */
    public function insert(string $user_name, string $password){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $now = new DateTime();
        $sql = "INSERT INTO user(user_name, password, time_stamp) VALUES(:user_name, :password, :time_stamp)";
        $this->execute($sql, [
                ':user_name'  => $user_name,
                ':password'   => $password,
                ':time_stamp' => $now->format('Y-m-d H:i:s'),
            ]);
    }

    /**
     * DBからユーザの情報を取得する
     * @param string $user_name
     * @return mixed
     */
    public function getUserRecord(string $user_name){
        $sql = "SELECT * FROM user WHERE user_name = :user_name";
        $userData = $this->getRecord($sql, [':user_name' => $user_name]);
        return $userData;
    }

    /**
     * user_nameが重複していないか否か
     * @param string $user_name
     * @return bool
     */
    public function isOverlapUserName(string $user_name){
        $sql = "SELECT COUNT(id) AS count FROM user WHERE user_name = :user_name";
        $row = $this->getRecord($sql, [':user_name' => $user_name]);
        if($row['count'] === '0'){
            return false;
        }
        return true;
    }

    /**
     * フォローしている人の情報をDBから取得し返す
     * @param int $user_id
     * @return mixed
     */
    public function getFollowingUser(int $user_id){
        $sql = "SELECT    u.*
                FROM      user AS u
                LEFT JOIN following_user AS f ON f.following_id = u.id
                WHERE     f.user_id = :user_id";
        return $this->getAllRecord($sql, [':user_id' => $user_id]);
    }

    /**
     * ユーザーのアイコン画像URLをアップデートする
     * @param int $user_id
     * @param string $img_path
     */
    public function updateUserImage(int $user_id, string $img_path){
        $sql = "UPDATE  user
                SET     user_img = :img_path
                WHERE   id = :user_id";
        $this->execute($sql, [':img_path' => $img_path, ':user_id' => $user_id]);
    }


    /**
     * フォローしてないユーザ情報を取得する
     * @param int $user_id
     * @return mixed
     */
    public function fetchOtherUsers(int $user_id){
        $sql = "SELECT     *
                FROM       user
                WHERE      id != :user_id AND id NOT IN 
                (
                  SELECT    u.id
                  FROM      user AS u
                  LEFT JOIN following_user AS f 
                  ON        u.id = f.following_id
                  WHERE     f.user_id = :user_id
                )
                ";
        return $this->getAllRecord($sql, [':user_id' => $user_id]);
    }
}