<?php

namespace ABC\Services\Collection\Pipe;

use ABC\Core\Exception\AbcError;

/** 
 * Класс Adapter
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author irbis-team.ru
 * @copyright © 2017
 * @license http://www.wtfpl.net/ 
 */  
class Adapter
{
    protected $middleware;
    protected $response;
    protected $numArgs = null;
    
    /**
    * Конструктор.
    *
    * @param object|closure $middleware
    * @param object $response
    */    
    public function __construct($middleware, $response = null)
    {
        $this->middleware = $middleware;
        $this->response = $response;
        $this->setNumArgs();
    }
    
    /**
    * Установка количества аргументов.
    *
    * $return void
    */
    public function setNumArgs()
    { 
        if ($this->middleware instanceof \Closure 
        || (is_string($this->middleware) && function_exists($this->middleware))) {
            $reflector  = new \ReflectionFunction($this->middleware);
            $this->numArgs = $reflector->getNumberOfParameters();
        } elseif (is_callable($this->middleware)) {
            $reflector  = new \ReflectionObject($this->middleware);
            $this->numArgs = $reflector->getMethod('__invoke')->getNumberOfParameters();    
        } 
    }    
    
    /**
    * Адаптированный process.
    *
    * @param object $request
    * @param object $arg 
    *
    * $return object
    */
    public function process($request, $arg)
    {
        if (method_exists($this->middleware, 'process')) {
            return $this->middleware->process($request, $arg);
        } 
        
        switch ($this->numArgs) {
            case 2 :
                $arguments = [$request, $arg];
                break;  
            case 3 :
                $arguments = [$request, $this->response, $arg];
                break;    
            case is_null($this->numArgs) :
                AbcError::badFunctionCall(ABC_INVALID_MIDDLWARE);
                return false;   
            default :
                $class = get_Class($this->middleware);
                AbcError::invalidArgument(sprintf(ABC_MIDDLEWARE_INVALID_ARG, $class, $class));
                return false;   
        }
        
        return call_user_func_array($this->middleware, $arguments);
    }
}
