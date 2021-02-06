<?php

namespace ABC\Services\Collection\Pipe;

/** 
 * Класс CallableHandler
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author irbis-team.ru
 * @copyright © 2017
 * @license http://www.wtfpl.net/ 
 */  

class CallableHandler
{
    protected $callable;
    protected $response;
    
    public function __construct(callable $callable, $response)
    {
        $this->callable = $callable;
        $this->response = $response;
    }
    
    /**
    * Выполнение Handler PSR-15.
    *
    * @param object $request
    *
    * @return object
    */    
    public function handle($request)
    {
        return $this->process($request);
    }
    
    /**
    * Выполнение invoke.
    *
    * @return object
    */    
    public function __invoke()
    {     
        return $this->process(func_get_args());
    }
    
    /**
    * Выполнение Middleware PSR-15.
    *
    * @param mix $arguments
    *
    * @return object
    */
    public function process($arguments)
    { 
        $arguments = is_array($arguments) ? $arguments : [$arguments];
        return call_user_func_array($this->callable, $arguments);
    }    
}
