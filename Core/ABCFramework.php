<?php

namespace ABC\Core;

use ABC\ABC; 
use ABC\Core\Configurator;
use ABC\Core\Base;
use ABC\Core\Exception\AbcError;
use ABC\Core\Application\AppManager;
use ABC\Core\Application\CallableManager;
use ABC\Core\Application\CliManager;
use ABC\Core\Application\MiddlewareManager;
use ABC\Core\Application\Router;
use ABC\Services\Locator;
use ABC\Services\Collection\Storage\Storage;

/** 
 * Класс Abc
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2017
 * @license http://www.wtfpl.net/ 
 */   
class ABCFramework
{

    protected $storage;
    protected $locator;
    
    /**
    * Конструктор
    * 
    * @param array $appConfig
    * @param array $siteConfig
    */    
    public function __construct($appConfig = [], $siteConfig = [])
    {
        $this->storage = new Storage; 
        $this->storage->add('trace', ['start_time' => microtime(true), 'sql_count' => 0]);
        
        $configurator  = new Configurator($appConfig, $siteConfig);
        $config = $configurator->getConfig();
        $this->storage->addArray($config, 'config');
        
        $this->locator  = new Locator; 
        $this->includeFunction();
    } 
    
    /**
    * Запуск приложения
    *
    * @return void
    */      
    public function startApp()
    {  
        if(defined('ABC_CLI')){
            return new CliManager;
        }
        
        $middleware = $this->getConfig('middleware');
        
        if (!empty($middleware)) {   
            return new MiddlewareManager($middleware['application']);    
        }
        
        $this->addToStorage(ABC::ROUTER, new Router);
        return new AppManager;
    }
    
    /**
    * Запуск приложения
    *
    * @return void
    */      
    public function startAppCli()
    {  
        return new CliManager;
    }    
    
    /**
    * Внешний роутинг
    *
    * @return object
    */     
    public function Router()
    { 
        $this->addToStorage(ABC::PIPE, $this->newService(\ABC::PIPE));    
        return new CallableManager();  
    }

    /**
    * Возвращает системное хранилище
    *
    * @return object
    */     
    public function getStorage()
    { 
        return $this->storage;
    }
    
    /**
    * Добавляет значение в хранилище
    *
    * @param string $name
    * @param mix  $value
    *
    * @return void
    */     
    public function addToStorage($name, $value)
    {  
        return $this->storage->add($name, $value);
    }
    
    /**
    * Достает значения из хранилища
    *
    * @param string $name
    * @param mix  $key
    *
    * @return mix
    */    
    public function getFromStorage($name, $key = null)
    {  
        if (!$this->storage->has($name)) {
            return false;
        }
        
        return $this->storage->get($name, $key);
    }
    
    /**
    * Возвращает массив установленного окружения
    *
    * @return array
    */     
    public function getEnvironment()
    {    
        return $this->storage->get('environment', 'config');
    }
  
    /**
    * Возвращает настройки конфигурации
    *
    * @param string $key
    * @param string $default
    *
    * @return array|string|bool
    */     
    public function getConfig($key = null, $default = null)
    {
        if (empty($key) && null !== $default) {
            return $default;
        } 
     
        if (null === $key) {
            return $this->storage->all('config');
        } 
        
        if (!is_string($key)) {
            AbcError::invalidArgument(ABC_INVALID_CONFIGURE);
            return false;
        } 
        
        if (!$this->storage->has($key, 'config')) {
            AbcError::invalidArgument('<strong>'. $key .'</strong>'. ABC_NO_CONFIGURE);
            return false;
        }
        
        return $this->storage->get($key, 'config');
    } 

    /**
    * Выбирает и запускает сервис
    *
    * @param string $serviceId
    *
    * @return object
    */     
    public function newService($serviceId = null)
    { 
        if (true === $this->setService($serviceId)) {    
            return $this->locator->newService();
        }
    }
 
    /**
    * Выбирает и запускает синглтон сервиса
    *
    * @param string $serviceId
    *
    * @return object
    */     
    public function sharedService($serviceId = null)
    { 
        if (true === $this->setService($serviceId)) {    
            return $this->locator->sharedService($serviceId);
        }
    }
    
    /**
    * Проверка ID сервиса
    *
    * @param string $serviceId
    *
    * @return boll
    */     
    public function getClassService($serviceId)
    {    
        if (empty($serviceId) || !is_string($serviceId)) {
            AbcError::invalidArgument(ABC_INVALID_SERVICE_NAME);
        } 
         
        $this->locator->setService($serviceId);
        return $this->locator->getClassName($serviceId); 
    }
    
    /**
    * Проверка ID сервиса
    *
    * @param string $serviceId
    *
    * @return boll
    */     
    protected function setService($serviceId)
    {    
        if (empty($serviceId) || !is_string($serviceId)) {
            AbcError::invalidArgument(ABC_INVALID_SERVICE_NAME);
        } 
         
        $this->locator->setService($serviceId);
        return true; 
    }
    
    /**
    * Подключает файл функций 
    *
    * @return void
    */     
    protected function includeFunction()
    {
        include_once __DIR__ .'/functions.php';
    } 
}
