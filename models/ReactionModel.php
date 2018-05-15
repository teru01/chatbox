<?php
class ReactionModel extends ExecuteModel{

    /**
     * 全てのリアクションを返す
     * ["like" => 1, "surprise" => 2, ...]
     * @return array|null
     */
    public function fetchAllReaction():?array {
        $sql = "SELECT description, id from reaction;";
        return $this->getAllRecord($sql);
    }
}