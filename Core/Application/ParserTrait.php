<?php

namespace ABC\Core\Application;


use ABC\ABC; 
use ABC\Core\Exception\AbcError;

/** 
 * Трейт RouteParser
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2017
 * @license http://www.wtfpl.net/
 */   
trait ParserTrait
{
    protected $defaultKeys = ['controller', 'action'];   
    protected $routeRules;  
    protected $current;
    protected $route;
    protected $routes = [];
    protected $elements;
    protected $patterns;
    
    
    /**
    * Разбор правил маршрутизации
    *
    * @param array $routeRules
    * @param string $path
    */    
    public function parseRoutes($routeRules, $path)
    {  
        $path = trim($path, '/') .'/';
      
        if ($path == '/') {
            
            if (empty($routeRules['/'])) {
                ABC::addToStorage('GET', $this->defaultRoute);    
                return;
            }
            
            $rules = $this->getRoutes($routeRules['/']);
            ABC::addToStorage('GET', ['controller' => $rules[0], 'action' => $rules[1]]);
            return;
        }
        
        $this->elements = explode('/', $path);
        $GET = [];
        foreach ($routeRules as $rule => $route) {
          
            if ($this->resolve($rule, $path)) {
                $routes = $this->getRoutes($route);
                $GET = $this->generateGet($routes);
                $GET = array_merge($this->route, $GET);    
            }    
        }
        
        ABC::addToStorage('GET', $GET);
        return $GET;
    } 

    /**
    * Распознование подходящего правила
    *
    * @param string $rule
    * @param string $path
    *
    * @return array
    */    
    public function resolve($rule, $path)
    {
        $rule = trim($rule, '/');
        $pattern = '';
        $this->sections = $this->preapareSections($rule);
     
        foreach ($this->sections as $num => $section) {
            if (is_array($section)) {
                $pattern .= '('. $section['value'] .'?)/'; 
            } else {
                 $pattern .= $section .'/';
            }
        }
     
        return (bool)preg_match('~^'. $pattern .'$~', $path);           
    }
    
    /**
    * Формирует GET параметры
    */    
    public function createParameters($path, $routes = null)
    {
        $elements = explode('/', $path);
        $GET = [];
        foreach ($this->sections as $num => $section) {
         
            if (is_array($section)) {
                $GET[$section['name']] = $elements[$num];
            }
        }
        
        if (!empty($routes)) {
            $routes = $this->setRoute($routes);
            $GET = array_merge($routes, $GET);
        }
        
        ABC::addToStorage('GET', $GET);
        return $GET;
    }
    
    /**
    * Подготовка шаблонов для RegExp
    *
    * @param string $rule
    *
    * @return array
    */    
    protected function preapareSections($rule)
    { 
        $rule = explode('/', $rule);
        $this->patterns = [];
        
        foreach ($rule as $num => $section) {
            $section = str_replace(['{', '}'], ['<', '>'], $section);
            
            if (preg_match_all('~<([\w._-]+)?>~', $section, $out)) {
                $this->patterns[] = ['name' => $out[1][0], 'value' => '[^/]+'];
            } elseif (preg_match_all('~<([\w._-]+):?([^>]+)?>~', $section, $out)) {
                $this->patterns[] = ['name' => $out[1][0], 'value' => $out[2][0]]; 
            } else {
                $this->patterns[] = $section;
            }
        }
        
        return $this->patterns;
    } 
    
    /**
    * Генерация массива GET параметров
    *
    * @param string $route
    *
    * @return array
    */    
    protected function generateGet($routes)
    {
        $GET = []; 
     
        foreach ($this->patterns as $num => $pattern) {
            if (is_array($pattern)) {
             
                if (preg_match('~'. $pattern['value'] .'~', $this->elements[$num])) {
                    $GET[$pattern['name']] = $this->elements[$num];
                }
                
            } else {
                $elements = $this->elements;
                $path = array_shift($elements);
                
                if ($path !== $pattern && preg_match('~'. $pattern .'~', $this->elements[$num])) {
                    $GET[$pattern] = $this->elements[$num]; 
                }   
            }
        }
        
        $this->setRoute($routes);
        return $GET;    
    }
   
    /**
    * Разбор правила маршрута
    *
    * @param string $route
    *
    * @return array
    */ 
    protected function getRoutes($route)
    {  
        $routes = explode('/', $route);
        $action = array_pop($routes);
        $controller = implode('\\', $routes);
        return [$controller, $action];
    }
   
    /**
    * Установка маршрутов
    *
    * @param фккфн $routes
    *
    * @return array
    */ 
    protected function setRoute($routes = [])
    {  
        foreach ($routes as $num => $rout) {
         
            if (!empty($this->defaultKeys[$num])) {
                $this->route[$this->defaultKeys[$num]] = $rout;
            } else {
                AbcError::logic(ABC_ERROR_ROUTES_RULE);
                return false;
            }
        }
        
        return $this->route;
    }
}
