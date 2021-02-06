<?php

namespace ABC\Core\Application;

/** 
 * Класс NotFound
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2017
 * @license http://www.wtfpl.net/
 */   
class NotFound
{
    protected $pipe;
    
    /**
    * Конструктор.
    *
    * @param object $pipe
    */
    public function __construct($pipe = null)
    {
        $this->pipe = $pipe;
    }
    
    /**
    * Заглушка.
    */
    public function add()
    {
        return $this;
    }
    
    /**
    * Генерация 404.
    */
    public function create404()
    {
        $this->pipe->add(function ($request, $response, $arg) {
            $response = $response->withStatus(404);
            $response->write('404 Not Found');
            return $response;
        });
    }    
}
