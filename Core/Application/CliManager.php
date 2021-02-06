<?php

namespace ABC\Core\Application;

use ABC\ABC;
use Abcsoft\SQL\Migrations\Migrations;

/** 
 * Класс CliManager
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2015
 * @license http://www.wtfpl.net/
 */   
class CliManager
{
    protected $argc;
    protected $argv;
     
    /**
    * @param object $abc
    */ 
    public function __construct()
    {  
        ini_set('register_argc_argv', true);
    }     
    
    /**
    * Запукает консольный скрипт.
    *
    * @return string
    */        
    public function run()
    {
        $this->argc = $GLOBALS['argc'];
        $this->argv = $GLOBALS['argv'];
        
        if($this->argc <= 1){
            return ABC_CLI_NO_COMMAND;
        }
        
        $rout = explode('/', $this->argv[1]);
        $command = $rout[0] ?? null;
        
        switch($command){
            case 'migrate' :
                return $this->migration();
            
            default :
                return sprintf(ABC_CLI_INVALID_COMMAND, $command);    
            
        }
    } 
 
    /**
    * Выполняет миграцию.
    *
    * @return string
    */        
    protected function migration()
    {
        $migrate = new Migrations(ABC::getConfig());
        $migrate->route($this->argv);
        return $migrate->getReport();
    }
}
