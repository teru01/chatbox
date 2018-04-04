<?php
class ConnectModel{
    protected $_dbConnections = [];
    protected $_modelList = [];
    protected $_connectName;
    const MODEL = 'Model';

    /**
     * @param string $name
     * @param string $connection_strings
     */
    public function connect(string $name, string $connection_strings){
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
     * @param string $model_name
     * @return mixed
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


    public function __destruct(){
        foreach ($this->_modelList as $model){
            unset($model);
        }
        foreach ($this->_dbConnections as $cnt){
            unset($cnt);
        }
    }
}