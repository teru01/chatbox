<?php
class ConnectModel{
    protected $_dbConnections = [];
    protected $_modelList = [];
    protected $_connectName;
    const MODEL = 'Model';

    /**
     * DBに接続する
     * @param string $name
     * @param array $connection_strings
     */
    public function connect(string $name, array $connection_strings){
        try{
            $cnt = new PDO(
                $connection_strings['string'],
                $connection_strings['user'],
                $connection_strings['password']
            );
        }catch (PDOException $e){
            exit("DBConnection failed: {$e->getMessage()}");
        }
        $cnt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->_dbConnections[$name] = $cnt;
        $this->_connectName = $name;
    }

    /**
     * 最新または$nameで渡されたPDOインスタンスを返す
     * @param string|null $name
     * @return mixed
     */
    public function getConnection(string $name=null){
        if(is_null($name)){
            return current($this->_dbConnections);
        }else{
            return $this->_dbConnections[$name];
        }
    }

    /**
     * $_connectNameがセットされて入ればそれでgetConnection()を呼び出す
     * @return mixed
     */
    public function getModelConnection(){
        if(isset($this->_connectName)){
            $name = $this->_connectName;
            $cnt = $this->getConnection($name);
        }else{
            $cnt = $this->getConnection();
        }
        return $cnt;
    }

    /**
     * モデルクラスをインスタンス化して$_modelListにセットしそれを返す
     * @param string $model_name
     * @return PDO
     */
    public function get(string $model_name){
        if(!isset($this->_modelList[$model_name])){
            $mdl_class = $model_name . self::MODEL;
            $cnt = $this->getModelConnection();
            $obj = new $mdl_class($cnt);
            $this->_modelList[$model_name] = $obj;
        }
        return $this->_modelList[$model_name];
    }


    /**
     * ConnectModel destructor.
     */
    public function __destruct(){
        foreach ($this->_modelList as $model){
            unset($model);
        }
        foreach ($this->_dbConnections as $cnt){
            unset($cnt);
        }
    }
}