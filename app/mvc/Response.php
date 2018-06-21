<?php
class Response{
    protected $_content;
    protected $_statusCode = 200;
    protected $_headers = [];
    const HTTP = 'HTTP/2';

    /**
     * @param string|null $content
     */
    public function setContent(?string $content){
        $this->_content = $content;
    }

    /**
     * @param int $statusCode
     *
     */
    public function setStatusCode(int $statusCode){
        $this->_statusCode = $statusCode;
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
        header(self::HTTP . $this->_statusCode);
        foreach($this->_headers as $name => $value){
            header($name . ': ' . $value);
        }
        print $this->_content;
    }
}