<?php
class BaseRoute {
    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }
    /**
     * Get URI elements.
     * 
     * @return string
     */
    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        return $uri;
    }

    /**
     * Get querystring params.
     * 
     * @return array
     */
    protected function getQueryStringParams()
    {
        return parse_str($_SERVER['QUERY_STRING'], $query);
    }
    /**
     * Get path relative from the str passed in.
     * 
     * @return string
     */
    protected function getPath($str){
        $path = $this->getUriSegments();
        $path = explode('/', $path);
        $val = array_search($str, $path);
        $path = array_splice($path, $val +1);
        if(!count($path)) {
            $path = ['/'];
        }
        $path = join("/", $path);
        if($path[0] != "/"){
            $path = "/" . $path;
        }

        return $path;
    }

    protected function grabHeaders(){
        $headers=array();
        foreach (getallheaders() as $name => $value) {
            $headers[$name] = $value;
        }
        return $headers;
    }

}
?>