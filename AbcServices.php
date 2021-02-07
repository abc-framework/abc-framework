<?php 

namespace ABC;

  
/** 
 * Класс AbcServices 
 * Перечень сервисов и их структура
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2015
 * @license http://www.wtfpl.net/ 
 */   

class AbcServices 
{
    /**
    * Сервисы
    */
    
    const ASSERTS       = 'Asserts';
    const BB_DECODER    = 'BbDecoder';
    const CONTAINER     = 'Container'; 
    const PIPE          = 'Pipe';
    const STORAGE       = 'Storage';  
    const VALUE_OBJECT  = 'ValueObject';
    const DOMAIN        = 'Domain';
    const COMMANDBUS    = 'Commandbus';
    const DTO           = 'DTO';
    const PARAMS        = 'Params';
    const INFLECTOR     = 'Inflector';
    const MAILER        = 'Mailer';    
    const PAGINATOR     = 'Paginator'; 
    const DB_COMMAND    = 'DbCommand'; 
    const MIGRATIONS    = 'Migrations';
    const MYSQLI        = 'Mysqli';    
    const PDO           = 'Pdo';
    const SQL_DEBUG     = 'SqlDebug';
    const TEMPLATE      = 'Tpl';
    const TPL_NATIVE    = 'TplNative';
    const URI_MANAGER   = 'UriManager';
    const VALIDATOR     = 'Validator';


    
    
    /**
    * Поддиректории сервисов
    */
    protected $subDir = [
        self::CONTAINER     => 'Collection',
        self::PIPE          => 'Collection',        
        self::STORAGE       => 'Collection',
        self::VALUE_OBJECT  => 'Collection',
        self::COMMANDBUS    => 'Domain',
        self::DTO           => 'Domain',
        self::DB_COMMAND    => 'Sql',
        self::MIGRATIONS    => 'Sql',
        self::MYSQLI        => 'Sql',
        self::PDO           => 'Sql',
        self::SQL_DEBUG     => 'Sql',
        self::TEMPLATE      => 'Tpl',
        self::TPL_NATIVE    => 'Tpl',
    ];
    
    /**
    * Система
    */
    const ROUTER  = 'Router';    
}
