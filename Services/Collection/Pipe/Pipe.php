<?php

namespace ABC\Services\Collection\Pipe;

use ABC\ABC;
use ABC\Services\Collection\Pipe\Adapter;
use ABC\Services\Collection\Pipe\CallableHandler;

/** 
 * Класс Pipe
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author irbis-team.ru
 * @copyright © 2017
 * @license http://www.wtfpl.net/ 
 */  
class Pipe
{
    protected $stack;
    protected $request;
    protected $response;
    
    public function __construct()
    {
        $this->stack = new \SplStack;
    }
    
    /**
    * Задает первоначальный REQUEST.
    *
    * @param object $request
    */
    public function setHttp($request, $response)
    {  
        $this->request  = $request;
        $this->response = $response;
    }
    
    /**
    * Добавляет миддлвар в очередь.
    *
    * @param string|array $stack
    *
    * $return object
    */ 
    public function add($stack)
    {
        foreach (is_array($stack) ? $stack : [$stack] as $middlware) {
            $this->stack->push($middlware);        
        }
     
        return $this;
    }
    
    /**
    * Проверяет стек на пустоту.
    * 
    * $return bool
    */
    public function isEmpty()
    {        
        $stack = clone $this->stack;
        $stack->rewind();
        return !$stack->valid();
    }
    
    /**
    * Запускает очередь.
    *
    * $return object
    */
    public function run()
    {                
        if (empty($this->request)) {
            $http = \ABC::newService(\ABC::PSR7);        
            $this->request  = $request = $http->newRequest();
            $this->response = $response = $http->newResponse();
        }
        
        $this->stack->rewind();         
        $this->stack->unshift(function($request, $response){ return $this->response;}); 
 
        $handler = $this->execute($this->response); 
        return $handler->process([$this->request]);
    }    
    
    /**
    * Рекурсивный обход очереди.
    *
    * @param object $request
    * @param object $response
    *
    * $return object
    */
    protected function execute($response)
    { 
        return new CallableHandler(function ($request) use ($response) {
         
            if ($this->stack->valid()) {
                $middleware = $this->stack->current();
                $this->stack->next();
            } 
            
            if (is_object($middleware) && method_exists($middleware, 'handle')) {
                $this->stack->rewind();
                return $middleware->handle($request);
            }
         
            $middleware = $this->normalize($middleware, $response);  
            return $middleware->process($request, $this->execute($response));
            
        }, 
        $response);
    }      

    /**
    * Приведение к PSR-15.
    *
    * @param mix $middleware
    * @param object $response 
    *
    * $return object
    */
    protected function normalize($middleware, $response = null)
    { 
        if (is_string($middleware) && class_exists($middleware)) {
            $middleware = new $middleware; 
        } 
        
        return new Adapter($middleware, $response);
    } 
}
