<?php
 
namespace ABC\Services;
 
use ABC\Core\Exception\AbcError;

/** 
 * Класс Locator
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2015
 * @license http://www.wtfpl.net/ 
 */  
class Locator extends \ABC\AbcServices
{

    protected $serviceId;  
    protected $container = []; 
    protected $component;
 
    public function setService($serviceId)
    {  
        $list = (new \ReflectionClass(__CLASS__))->getConstants(); 
     
        if (!in_array($serviceId, $list)) {
            throw new \badFunctionCallException(sprintf(ABC_NOT_FOUND_SERVICE, $serviceId, $serviceId)); 
        } 
        
        $this->serviceId = $serviceId;
        $dir = !empty($this->subDir[$serviceId]) ? $this->subDir[$serviceId] .'\\' : null;
        $this->component = __NAMESPACE__ .'\\'. $dir . $this->serviceId .'\\'. $this->serviceId;         
        return $this;
    }
 
    /**
    * Получает сервис из локатора если он есть
    * или сначала помещает его туда
    *
    * @return object
    */    
    public function newService()
    {  
        return new $this->component;
    }
    
    /**
    * Получает сервис из локатора если он есть
    * или сначала помещает его туда
    * (по принципу Singleton)
    *
    * @return object
    */    
    public function sharedService($serviceId) 
    { 
        if (!isset($this->container[$serviceId])) { 
            $this->container[$serviceId] = new $this->component;
        } 
      
        return $this->container[$serviceId];
    } 
    
    /**
    * Возвращает имя корневого класса сервиса
    *
    * @return object
    */    
    public function getClassName($serviceId) 
    { 
        return $this->component;
    }      
}
