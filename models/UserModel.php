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
        $stmt = $this->execute($sql, [
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


}