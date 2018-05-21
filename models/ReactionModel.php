<?php
class ReactionModel extends ExecuteModel{

    /**
     * 全てのリアクションを返す
     * ["like" => 1, "surprise" => 2, ...]
     * @return array|null
     */
    public function fetchAllReaction():?array {
        $sql = "SELECT description, id from reaction";
        return $this->getKeyPair($sql);
    }

    /**
     * 渡されたIDのリアクションが存在するか調べる
     * @param int $reaction_id
     * @return bool
     */
    public function isValidReactionId(int $reaction_id):bool {
        return in_array($reaction_id, $this->fetchAllReaction());
    }

}