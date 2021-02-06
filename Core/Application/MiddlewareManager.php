<?php

namespace ABC\Core\Application;

/** 
 * Класс MiddlewareManager
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2017
 * @license http://www.wtfpl.net/ 
 */   
class MiddlewareManager
{
    use ResponseTrait;
    
    /**
    * Конструктор
    * 
    */    
    public function __construct($application)
    {
        $pipe = \ABC::newService(\ABC::PIPE);
        
        if(true === $application){
         
            \ABC::addToStorage(\ABC::ROUTER, new Router);
            \ABC::addToStorage(\ABC::HTTP, \ABC::newService(\ABC::HTTP));
            $app = (new AppManager(true))->run();
            
            $http = \ABC::newService(\ABC::PSR7);        
            $request  = $http->newRequest();
            $request  = $request->withQueryParams($app['GET']);
            $response = $http->newResponse();
            $pipe->setHttp($request, $response);
            
            $pipe->add(function($request, $response, $next) use ($app){
                foreach($app['headers'] as $name => $value){
                    $response = $response->withHeader($name, $value);            
                }
                $response = $response->write($app['body']);
                $response = $next($request, $response); 
                return $response;
            });
        }
        
        \ABC::addToStorage(\ABC::PIPE, $pipe); 
    } 
}
