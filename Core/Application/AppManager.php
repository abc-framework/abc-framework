<?php

namespace ABC\Core\Application;

use ABC\ABC;
use ABC\Core\Base;
use ABC\Core\Exception\AbcError;
/** 
 * Класс AbcFramework
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2015
 * @license http://www.wtfpl.net/
 */   
class AppManager
{
    protected $request;
    protected $config;    
    protected $settings;
    protected $isMiddleware;
    
    /**
    * @param object $abc
    */ 
    public function __construct($isMiddleware = false)
    {   
        $this->settings = ABC::getConfig('settings');
        $this->isMiddleware = $isMiddleware;
        $this->params = ABC::sharedService(ABC::PARAMS);
    }     
    
    /**
    * Вызывает контроллер  и, если есть, вьюшку.
    *
    * @return void
    */        
    public function run()
    {
        $controllersDir = $this->getControllersDir();
        $nameClass  = $this->getNameClass();
        $controller = $controllersDir .'\\'. $nameClass .'Controller'; 
        $action     = $this->getAction();
     
        if (class_exists($controller)) {
            $objController = new $controller();
            
            if (method_exists($objController, $action)) {
                $viewsDir = $this->getViewsDir();
                $view = $viewsDir .'\\'. $nameClass .'View';
                
                if (class_exists($view)) {
                    $objView = new $view();
                } else {
                    $objView = new Base();  
                }
             
                $objController->view = $objView;
                call_user_func([$objController, $action]);
                
            } else {
                $this->create404($action);
            }
            
        } else {
            $this->create404($controller);
        }
        
        unset($objView);
        unset($objController->view);
        
        
        if(true === $this->isMiddleware){
         
            return ['GET'     => $this->params->get(),
                    'headers' => $this->params->getHeaders(),   
                    'body'    => $this->params->getBody()]; 
        } 
        
        $this->params->send();        
    }
    
    /**
    * Возвращает директорию с пользовательскими контроллерами
    *
    * @return string
    */        
    public function getControllersDir()
    {
        return $this->settings['application'] .'\\'. $this->settings['dir_controllers'];
    } 
    
    /**
    * Возвращает директорию с пользовательскими вьюшками
    *
    * @return string
    */        
    public function getViewsDir()
    {
        return $this->settings['application'] .'\\'. $this->settings['dir_views'];
    }
    
    /**
    * Возвращает имя вызванного контроллера
    *
    * @return string
    */        
    public function getNameClass()
    {   
        $nameClass = $this->params->getController();
        $nameClass = preg_replace('#[^'. ABC_DS .'a-z0-9\_-]#ui', '', $nameClass);
        return mb_convert_case($nameClass, MB_CASE_TITLE);
    }  

    /**
    * Возвращает имя вызванного экшена
    *
    * @return string
    */        
    public function getAction()
    {   
        $action = $this->params->getAction();
        $action = preg_replace('#[^a-z0-9\-_]#ui', '', $action);
        return 'action'. mb_convert_case($action, MB_CASE_TITLE);
    } 
 
    /**
    * Если не найден контроллер или экшен, активирует 
    * базовый контроллер с генерацией 404 заголовка
    *
    * @param string $controller
    *  
    * @return void
    */        
    public function create404($search)
    {   
        $baseController = new Base();
        $baseController->action404($search);
    }

    /**
    * Возвращает системное хранилище
    *
    * @return object
    */     
    public function add()
    { 
        AbcError::logic('Мидлвары отключены');
        return $this;
    }        
}
