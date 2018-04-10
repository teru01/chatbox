<?php
class Response{
    protected $_content;
    protected $_statusCode = 200;
    protected $_statusMsg = 'OK';
    protected $_headers = [];
    const HTTP = 'HTTP/1.1';

    /**
     * @param string|null $content
     */
    public function setContent(?string $content){
        $this->_content = $content;
    }

    /**
     * @param int $statusCode
     * @param string $msg
     */
    public function setStatusCode(int $statusCode, string $msg = ''){
        $this->_statusCode = $statusCode;
        $this->_statusMsg = $msg;
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function setHeader(string $name, string $value){
        $this->_headers[$name] = $value;
    }

    /**
     * コンテンツをヘッダとともに出力する。
     */
    public function send(){
        header(self::HTTP . $this->_statusCode . ' ' . $this->_statusMsg);
        foreach($this->_headers as $name => $value){
            header($name . ': ' . $value);
        }
        print $this->_content;
    }
}