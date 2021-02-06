<?php

namespace ABC\Services\Params;

use ABC\ABC;

/** 
 * Класс Request
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2017
 * @license http://www.wtfpl.net/
 */   
class Params
{
    protected $GET;
    protected $config;
    protected $headers = [];
    protected $body = '';
    
    /**
    * Конструктор
    */ 
    public function __construct()
    {
        $this->config = ABC::getConfig('default_route');
        if (!empty($_SERVER['QUERY_STRING'])) {
            $this->GET = $this->parseQueryString();
        } else { 
            $this->GET = ABC::getFromStorage('GET');
        } 
    } 
    /**
    * Инициализация GET параметров
    *
    * @param string $key
    * @param string $default
    *
    * @return string|array
    */        
    public function get($key = null, $default = null)
    {
        if (empty($key)) {
            return $this->GET ?? [];
        }
        
        return isset($this->GET[$key]) ? $this->GET[$key] : $default;
    } 
    
    /**
    * Инициализация параметров SESSION
    *
    * @param string $key
    * @param string $default
    *
    * @return string
    */        
    public function getSession($key = null, $default = null)
    {
        return Session::get($key, $default);
    }  
    
    /**
    * Проверка наличия параметров SESSION
    *
    * @param string $key
    * @param string $value
    *
    * @return void
    */        
    public function issetSession($key)
    {
        Session::isset($key);
    } 
    
    /**
    * Инициализация параметров COOKIE
    *
    * @param string $key
    * @param string $default
    *
    * @return string
    */        
    public function getCookie($name = null, $default = null)
    {
        return (new Cookie($name))->get($default);
    }
    
    /**
    * Проверяет наличие COOKIE
    *
    * @param string $key
    * @param string $default
    *
    * @return string
    */        
    public function issetCookie($name)
    {
        return (new Cookie($name))->isset();
    }
    
    /**
    * Установка параметров SESSION
    *
    * @param string $key
    * @param string $value
    *
    * @return void
    */        
    public function setSession($key, $value)
    {
        Session::set($key, $value);
    }
 
    /**
    * Проверка наличия параметров SESSION
    *
    * @param string $key
    * @param string $value
    *
    * @return void
    */        
    public function destroySession()
    {
        Session::destroy();
    } 
    
    /**
    * Установка параметров COOKIE
    *
    * @param string $key
    * @param string $default
    *
    * @return string
    */        
    public function setCookie()
    {
        $params = func_get_args();
        (new Cookie($params[0], $this))->set(func_get_args());
    }
    
     /**
    * Удаляет COOKIE
    *
    * @param string $key
    * @param string $default
    *
    * @return string
    */        
    public function unsetCookie()
    {
        $params = func_get_args();
        (new Cookie($params[0], $this))->unset($params);
    }  
  
    /**
    * Возвращает текущий контроллер
    *
    * @return string
    */    
    public function getController()
    {
        $get = $this->GET;
        $controller = empty($get) ?: array_shift($get);
        return $controller ?? $this->config['controller'];
    } 
    
    /**
    * Возвращает текущий экшен
    *
    * @return string
    */    
    public function getAction()
    {    
        $get = $this->GET;
        empty($get) ?: array_shift($get);
        $action = empty($get) ?: array_shift($get);
        return $action ?? $this->config['action'];
    }
    
    /**
    * Возвращает HOST
    *
    * @return string
    */    
    public function getHostName()
    {
        if (isset($_SERVER['HTTP_HOST'])) {
            return $_SERVER['HTTP_HOST'];
        } elseif (isset($_SERVER['SERVER_NAME'])) {
            return $_SERVER['SERVER_NAME'];
        }
        
        return null;
    }

    /**
    * Возвращает PATH
    *
    * @return string
    */    
    public function getPath()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            return parse_url($_SERVER['REQUEST_URI'])['path'];        
        } 
        
        return '/';
    }
    
    /**
    * Возвращает текущий протокол
    *
    * @return string
    */ 
    public function getProtocol()
    {
        return (isset($_SERVER['HTTPS']) && (strcasecmp($_SERVER['HTTPS'], 'on') === 0 || $_SERVER['HTTPS'] == 1)
               || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') === 0) 
                ? 'https' : 'http';
    }
    
    /**
    * Возвращает базовый URL
    *
    * @return string
    */    
    public function getBaseUrl()
    {
        return $this->getProtocol() .'://'. $this->getHostName();
    }
    
    /**
    * Проверяет, отправлен запрос AJAX'ом или нет
    *
    * @return bool
    */  
    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
    
    /**
    * Разбирает в массив QUERY_STRING
    *
    * @return array
    */        
    protected function parseQueryString()
    {
        $queryString = urldecode($_SERVER['QUERY_STRING']);
        mb_parse_str($queryString, $result);
        return $result;
    }

     /**
    * Ответ сервера
    *
    * @return void
    */        
    public function send()
    {
        $this->sendHeaders();
        $this->sendBody();
    }
    
    /**
    * Устанавливает заголовки
    *
    * @param string $name
    * @param string|array $value 
    */     
    public function setHeader($name, $value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }
        
        $this->headers[$name] = $value;
    }
    
     /**
    * Возвращает заголовки
    *
    * @param string $name
    * @param string|array $value 
    */     
    public function getHeaders()
    {
        return $this->headers;
    }   
    /**
    * Устанавливает тело сообщения
    *
    * @param object $response
    */     
    public function setBody($value)
    {
        $this->body .= $value;
    }
    
    /**
    * Устанавливает тело сообщения
    *
    * @param object $response
    */     
    public function getBody()
    {
        return $this->body;
    }
    
    /**
    * Отправляет заголовки
    *
    * @param object $response
    */     
    public function sendHeaders($stop = false)
    { 
        if (!headers_sent()) {
            header('HTTP/1.1 200');
         
            foreach ($this->headers as $name => $values) {
                foreach ($values as $value) {
                    header(sprintf('%s: %s', $name, $value), false);
                }
            }
        }
        
        if(true === $stop){
            exit();
        }
    }

    /**
    * Отправляет заголовки
    *
    * @param object $response
    */     
    protected function sendBody()
    { 
        print($this->body);
    }      
}
