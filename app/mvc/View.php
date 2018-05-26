<?php
class View{
    protected $_baseUrl;
    protected $_initialValue;
    /** @var array $_passValue　ページのタイトルを保持する */
    protected $_passValues = [];

    public function __construct(string $baseUrl, $initialValue=[]){
        $this->_baseUrl = $baseUrl;
        $this->_initialValue = $initialValue;
    }

    public function setPageTitle(string $name, string $value){
        $this->_passValues[$name] = $value;
    }

    /**
     * テンプレートを再帰的に読み込んでhtmlの文字列を返す
     * @param string $filename
     * @param array $parameters
     * @param string|null $template
     * @return string
     */
    public function render(string $filename, $parameters=[], string $template=null){
        $view = $this->_baseUrl . '/' . $filename . '.php';
        extract(array_merge($this->_initialValue, $parameters));
        ob_start();
        ob_implicit_flush(0);
        include $view;
        $content = ob_get_clean();

        if($template){
            $content = $this->render(
                $template,
                array_merge($this->_passValues, ['_content' => $content])
            );
        }
        return $content;
    }

    /**
     * インジェクション対策のためエスケープを施す
     * @param null|string $string
     * @return string
     */
    public static function escape(?string $string){
        return htmlspecialchars($string, ENT_QUOTES);
    }
}