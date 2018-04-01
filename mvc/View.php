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
        require $view;
        $content = ob_get_clean();

        if($template){
            $content = $this->render(
                $template,
                array_merge($this->_passValues, ['_content' => $content])
            );
        }
        return $content;
    }

    public function escape(string $string){
        return htmlspecialchars($string, ENT_QUOTES);
    }
}