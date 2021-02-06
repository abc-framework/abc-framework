<?php
 
namespace ABC;

/** 
 * Класс Abc 
 * Стартует фреймворк
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2015
 * @license http://www.wtfpl.net/ 
 */   
class ABC extends AbcServices 
{
   
    protected static $config;
    protected static $process;     

    /**
    * Старт приложения
    *
    * Принимает аргументaми массивы пользовательских настроек.
    * Список настроек доступен в документации abc-framework.ru/docs/setting
    *
    * @param array $appConfig
    * @param array $siteConfig
    *
    * @return object
    */     
    public static function startApp($appConfig = [], $siteConfig = [])
    { 
        if (empty(self::$process)) {
            self::process($appConfig, $siteConfig);        
        }
        
        return self::$process->startApp();   
    }

    /**
    * Старт приложения bp из командной строки
    *
    * Принимает аргументaми массивы пользовательских настроек.
    * Список настроек доступен в документации abc-framework.ru/docs/setting
    *
    * @param array $appConfig
    * @param array $siteConfig
    *
    * @return object
    */     
    public static function startAppCli($appConfig = [], $siteConfig = [])
    { 
        self::process($appConfig, $siteConfig);
        return self::$process->startAppCli();   
    }
    
    /**
    * Старт роутинга
    *
    * Принимает аргументaми массивы пользовательских настроек.
    * Список настроек доступен в документации abc-framework.ru/docs/setting
    *
    * @param array $appConfig
    * @param array $siteConfig
    *
    * @return object
    */     
    public static function Router($appConfig = [], $siteConfig = [])
    { 
        if (empty(self::$process)) {
            self::process($appConfig, $siteConfig);        
        }
        
        return self::$process->router();   
    }
    
    /**
    * Запуск фреймворка с внешним роутингом
    *
    * @return void
    */     
    public static function run()
    { 
        self::$process->run();  
    }
    
    /**
    * Возвращает настройки окружения
    *
    * @return array
    */     
    public static function getEnvironment()
    {
        return self::$process->getEnvironment();
    } 
    
    /**
    * Возвращает хранилище
    *
    * @return object
    */     
    public static function getStorage()
    {
        return self::$process->getStorage();
    } 
    
    /**
    * Добавляет значение в хранилище
    *
    * @param string $name
    * @param mix  $value
    *
    * @return void
    */     
    public static function addToStorage($name, $value)
    {
        self::$process->addToStorage($name, $value);
    } 

    /**
    * Достает значения из хранилища
    *
    * @param string $name
    * @param mix  $key
    *
    * @return mix
    */ 
    public static function getFromStorage($name, $key = null)
    {
        return self::$process->getFromStorage($name, $key);
    }  
    
    /**
    * Возвращает текущий процесс
    *
    * @return object
    */ 
    public static function getProcess()
    {
        return self::$process;
    } 
   
    /**
    * Инициализирует новый объект сервиса
    *
    * @param string $serviceId
    *
    * @return object
    */ 
    public static function newService($serviceId = null)
    {
        return self::$process->newService($serviceId);
    }

    /**
    * Возвращает объект сервиса (singltone)
    *
    * @param string $serviceId
    *
    * @return object
    */     
    public static function sharedService($serviceId = null)
    {
        return self::$process->sharedService($serviceId);
    }  

    /**
    * Возвращает имя корневого класса сервиса
    *
    * @param string $serviceId
    *
    * @return object
    */     
    public static function getClassService($serviceId = null)
    {
        return self::$process->getClassService($serviceId);
    } 
    
    /**
    * Получает настройку конфигурации
    *
    * @param string $key
    * @param string $default
    *
    * @return string
    */     
    public static function getConfig($key = null, $default = null)
    {
        return self::$process->getConfig($key, $default);
    }
    
    /**
    * Запуск фреймворка
    *
    * Принимает аргументaми массивы пользовательских настроек.
    * Список настроек доступен в документации abc-framework.ru/docs/setting
    *
    * @param array $appConfig
    * @param array $siteConfig
    */     
    protected static function process($appConfig, $siteConfig)
    { 
        self::$config = array_merge($appConfig, $siteConfig);
        self::$process = new \ABC\Core\ABCFramework($appConfig, $siteConfig);
    }
}


