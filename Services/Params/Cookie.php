<?php

namespace ABC\Services\Params;

use ABC\Core\Exception\AbcError;

/** 
 * Класс Request
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2017
 * @license http://www.wtfpl.net/
 */   
class Cookie
{

    protected $name;
    protected $response;
    
    /**
    * 
    */        
    public function __construct($name = NULL, $params = NULL)
    {
        $this->name = $name;    
        $this->params = $params;
    }
    
    /**
    * 
    *
    * @return string|array
    */        
    public function set($arr)
    {
        if(is_string($this->name)){
            $arr = [
                'name'      => $this->name,
                'value'     => $arr[1] ?? '',
                'expires'   => $arr[2] ?? 0,
                'path'      => $arr[3] ?? '',
                'domain'    => $arr[4] ?? '',
                'secure'    => $arr[5] ?? false,
                'httponly'  => $arr[6] ?? true,
            ];
        }
     
        $header = sprintf('%s=%s', $this->name, urlencode($arr['value']));
     
        if ($arr['expires'] !== 0) {
            $header .= sprintf('; expires=%s', gmdate('D, d M Y H:i:s T', (int)$arr['expires']));
        }
     
        if (!empty($arr['path'])) {
            $header .= sprintf('; path=%s', $arr['path']);
        }
     
        if (!empty($arr['domain'])) {
            $header .= sprintf('; domain=%s', $arr['domain']);
        }
     
        if ($arr['secure']) {
            $header .= '; secure';
        }
     
        if ($arr['httponly']) {
            $header .= '; httponly';
        }
     
        $this->params->setHeader('Set-Cookie', $header);
        $_COOKIE[$this->name] = $arr['value'];
    } 
    
    /**
    * 
    *
    * @return string|array
    */        
    public function get($default)
    {
        return $_COOKIE[$this->name] ?? $default;
    }
    
    /**
    * 
    *
    * @return string|array
    */        
    public function isset()
    {
        return isset($_COOKIE[$this->name]);
    } 

    /**
    * 
    *
    * @return void
    */        
    public function unset()
    {
        $params = func_get_args()[0];
     
        if(!$this->isset()){
            return false;
        }        
      
        $params[1] = '';
        $params[2] = 1;
        $this->set($params);        
        unset($_COOKIE[$this->name]);
    } 
}
