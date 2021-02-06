<?php

namespace ABC\Core\Application;


/** 
 * Класс CallableResolver
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2017
 * @license http://www.wtfpl.net/
 */   
class CallableManager
{
    use ParserTrait, ResponseTrait;
    
    protected $storage;
    protected $pipe;
    protected static $validMethods = [
        'GET'     => true,    
        'POST'    => true,
        'PUT'     => true,
        'DELETE'  => true,
        'CONNECT' => true,
        'HEAD'    => true,
        'OPTIONS' => true,
        'PATCH'   => true,
        'TRACE'   => true,
    ];

    public function __construct()
    {
        $http = \ABC::newService(\ABC::PSR7);
        $this->request  = $http->newRequest();
        $this->response = $http->newResponse();
        $this->pipe  = \ABC::getFromStorage(\ABC::PIPE);
        $this->notFound = new NotFound;
     
        if (isset($_POST['_method']) && isset(self::$validMethods[$_POST['_method']])) {
            $this->request = $this->request->withMethod($_POST['_method']);
        }
        
        $this->method = $this->request->getMethod();
    }     
    
    /**
    * Метод GET
    *
    * @param string $pattern
    * @param callable $callable
    *
    * @return object
    */ 
    public function get($pattern = null, $callable = null)
    {
        if ($this->method !== 'GET') {
            return $this->notFound;
        }
        
        if (!$this->resolver($pattern, $callable)) {  
            return $this->notFound;
        }
        
        return $this;
    }
    
    /**
    * Метод POST
    *
    * @param string $pattern
    * @param callable $callable
    *
    * @return object
    */ 
    public function post($pattern = null, $callable = null)
    {
        if ($this->method !== 'POST') {
            return $this->notFound;
        }
     
        if (!$this->resolver($pattern, $callable)) {  
            return $this->notFound;
        }
        
        return $this;
    }
    
    /**
    * Метод PUT
    *
    * @param string $pattern
    * @param callable $callable
    *
    * @return object
    */ 
    public function put($pattern = null, $callable = null)
    {
        if ($this->method !== 'PUT') {
            return $this->notFound;
        }
        
        if (!$this->resolver($pattern, $callable)) {  
            return $this->notFound;
        }
        
        return $this;
    }
    
    /**
    * Метод DELETE
    *
    * @param string $pattern
    * @param callable $callable
    *
    * @return object
    */ 
    public function delete($pattern = null, $callable = null)
    {
        if ($this->method !== 'DELETE') {
            return $this->notFound;
        }
        
        if (!$this->resolver($pattern, $callable)) {  
            return $this->notFound;
        }
        
        return $this;
    }
    
    /**
    * Любой метод из переданых 
    *
    * @param array|string $methods
    * @param string $pattern
    * @param callable $callable
    *
    * @return object
    */ 
    public function any($methods = [], $pattern = null, $callable = null)
    {
        $methods = is_string($methods) ? [$methods] : $methods;
        
        foreach ($methods as $method) {
            if ($this->method === $method) {
                if ($this->resolver($pattern, $callable)) {  
                    return $this;
                }
            }
        }
        
        return $this->notFound;     
    }
    
    /**
    * Любой метод из валидных
    *
    * @param string $pattern
    * @param callable $callable
    *
    * @return object
    */ 
    public function all($pattern = null, $callable = null)
    {
        if (isset(self::$validMethods[$this->method])) {
            if ($this->resolver($pattern, $callable)) {  
                return $this;
            }
        }
        
        return $this->notFound;
    }

    /**
    * Группа
    *
    * @param mix $middleware
    *
    * @return object
    */ 
    public function group($pattern = null, $callable)
    {
        $path = $this->getPath();
        $pattern .= '/.*';
     
        if (!$this->resolve($pattern, $path)) {
            return $this->notFound;
        }
     
        call_user_func($callable);
        
        if ($this->pipe->isEmpty()) {
            return $this->notFound;
        }
        
        return $this;
    } 
    
    /**
    * Резольвер
    *
    * @param string $pattern
    * @param callable $callable
    *
    * @return object
    */ 
    protected function resolver($pattern = null, $callable = null)
    {
        $path = $this->getPath();
     
        if (!$this->resolve($pattern, $path)) {
            return false;
        }
        
        if (is_string($callable) && false !== strpos($callable, '@')) {
            $this->appManager($path, $callable);
            return false;
        }
        
        $GET = $this->createParameters($path);
        \ABC::addToStorage('GET', $GET);
        $request = $this->request->withAttributes($GET);
        
        $this->pipe->setHttp($request, $this->response);
        $this->pipe->add($callable);
        
        return true;
    } 
    
    /**
    * Управление приложением из внешнего роутера
    *
    * @param string $path
    * @param string $rout
    *
    */ 
    protected function appManager($path, $rout)
    {
        $routes = explode('@', $rout);
        $GET = $this->createParameters($path, $routes);
        (new AppManager)->run();
    }

    /**
    * Текущий путь
    *
    * @return string 
    */ 
    protected function getPath()
    {
        $path = $this->request->getUri()->getPath();
        return trim($path, '/') .'/';
    }
}
