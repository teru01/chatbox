<?php
abstract class ExecuteModel{
    protected $_pdo;

    /**
     * ExecuteModel constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo){
        $this->setPdo($pdo);
    }


    /**
     * @param PDO $pdo
     */
    public function setPdo(PDO $pdo){
        $this->_pdo = $pdo;
    }


    /**
     * プリペアードステートメントを実行して結果を返す
     * @param string $sql
     * @param array $parameter
     * @return mixed
     */
    public function execute(string $sql, $parameter=[]){
        $stmt = $this->_pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
        $stmt->execute($parameter);
        return $stmt;
    }


    /**
     * クエリの結果を全て返す
     * @param string $sql
     * @param array $parameter
     * @return mixed
     */
    public function getAllRecord(string $sql, $parameter=[]){
        return $this->execute($sql, $parameter)->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * クエリの結果を1つだけ返す
     * @param string $sql
     * @param array $parameter
     * @return mixed
     */
    public function getRecord(string $sql, $parameter=[]){
        return $this->execute($sql, $parameter)->fetch(PDO::FETCH_ASSOC);
    }

}
