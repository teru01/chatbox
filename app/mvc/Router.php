<?php
class Router{
    protected $_convertedRoutes;

    /**
     * Router constructor.
     * @param array $routedef
     */
    public function __construct(array $routedef){
        $this->_convertedRoutes = $this->routeConverter($routedef);
    }

    /**
     * ':'が付いているパスの':'以外の文字をサブパターンの名前に設定して返す
     * @param array $routedef
     * @return array
     */
    public function routeConverter(array $routedef){
        $converted = [];
        foreach ($routedef as $url => $par){
            $converts = explode('/', ltrim($url, '/'));
            foreach ($converts as $i => $convert){
                if(0 === strpos($convert, ':')){
                    $bar = substr($convert, 1);
                    $convert = '(?<' . $bar . '>[^/]+)';
                }
                $converts[$i] = $convert;
            }
            $pattern = '/' . implode('/', $converts);
            $converted[$pattern] = $par;
        }
        return $converted;
    }

    /**
     * リクエストされたパスにマッチするルーティング定義のキーに対する値を返す
     * @param string $path
     * @return array|mixed|null
     */
    public function getRouteParams(string $path){
        if('/' !== substr($path, 0, 1)){
            $path = '/' . $path;
        }
        foreach ($this->_convertedRoutes as $pattern => $par) {
            if (preg_match('#^' . $pattern . '$#', $path, $p_match)) {
                $par = array_merge($par, $p_match);
                return $par;
            }
        }
        return null;
    }

}