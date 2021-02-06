<?php

namespace ABC\Services\Http\Http;

use ABC\Core\Exception\AbcError;

/** 
 * Класс Request
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2017
 * @license http://www.wtfpl.net/
 */   
class Session
{

    protected static $session = false;
    
    /**
    * Старт сессии
    *
    * @return bool
    */        
    public static function start()
    {
        if(!self::isActive()){
            self::$session = session_start();
        }
        
        return self::$session;
    } 
    
    /**
    * Проверка активности сессии
    *
    * @return void
    */        
    public static function isActive()
    {
        return self::$session;
    }     
    
    /**
    * Установка данных сессии
    *
    * @return void
    */        
    public static function set($key, $value)
    {
        self::start();
        if(!self::isActive()){
            AbcError::runtime(ABC_SESSION_INVALID);
        }
        $_SESSION[$key] = $value;
    }     
    
    /**
    * Получение данных из сессии
    *
    * @return string|array
    */        
    public static function get($key, $default)
    {
        self::start();
     
        if (empty($key)) {
            return $_SESSION ?? [];
        }
        
        return $_SESSION[$key] ?? $default;
    }     
    
    /**
    * Получение данных из сессии
    *
    * @return string|array
    */        
    public static function isset($key)
    {
        return isset($_SESSION[$key]);
    }      
    /**
    * Уничтожение сессии
    *
    * @return void
    */        
    public static function destroy()
    {
        if(self::start()){
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            $_SESSION = [];            
            session_destroy();
            self::$session = false;
        }
    }
}
