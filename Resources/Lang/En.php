<?php

namespace ABC\Resources\Lang;

/** 
 * Класс En
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2015
 * @license http://www.wtfpl.net/ 
 */   
class En
{
    
    public static function set() 
    {
        /**
        * General Constants
        */ 
        define('ABC_NO_SUPPORT_SERVICE',       ': service is not supported in the current configuration ');
        define('ABC_INVALID_ARGUMENT',         ' Invalid argument ');
        define("ABC_PROPERTY_NOT_FOUND",       ' Property %s does not exist ');    
        define('ABC_NO_FUNCTIONAL',            ' is not implemented ');
        define('ABC_NO_CLASS',                 ' class not found ');
        define('ABC_NO_METHOD',                ' method offline in framework ');
        define('ABC_NO_ARRAY',                 ' Parameter must be a valid array');  
        define('ABC_NO_CALLBACK',              ' Parameter must be a valid callback ');
        define('ABC_UNKNOWN_ROUTES',           ' Unknown type of routing data ');
        define('ABC_ERROR_ROUTES_RULE',        ' Error in the routing rules ');
        define('ABC_NO_MODEL',                 ' model is not implemented ');
        
        /**
        * Configure
        */ 
        define('ABC_INVALID_DEBUG_SETTING',    ' Сonfiguration error ');
        define('ABC_INVALID_CONFIGURE_APP',    ' Configuring the application is to be performed array ');
        define('ABC_INVALID_CONFIGURE_SITE',   ' Configuring the site is to be performed array ');
        define('ABC_NO_CONFIGURE',             ' Setting is not specified in the configuration file ');
        define('ABC_INVALID_CONFIGURE',        ' Setup key must be a string ');
        
        /**
        * Middleware
        */ 
        
        define('ABC_INVALID_MIDDLWARE',     'Middleware is not set correctly ');
        define('ABC_MIDDLWARE_NO_PROCESS',  'Middleware <strong>%s</strong> must have a method process() ');

        /**
        * Template 
        */ 
        define('ABC_TPL_DISABLE',              ' the template disabled');
        define('ABC_NO_TEMPLATE',              ' templates file  does not exist');
        define('ABC_INVALID_BLOCK',            ' Block <strong>%s</strong> does not exist or incorrect syntax');
        define('ABC_NO_METHOD_IN_TPL',         ' templating method is not supported');
        define('ABC_MODEL_NO_SAVE',            ' System failure. Updates are not accepted.');
        define('ABC_SELECT_NO_TEMPLATE',       ' Cannot select template if values ​​have already been passed to template.');        

        /**
        * Paginator
        */         
        define('ABC_NO_TOTAL',                 ' limit is not set ');
        
        /**
        * Value Object
        */         
        define('ABC_RECYCLING',                 'Reuse is unacceptable');
        define('ABC_NO_PROPERTY',               'The <strong>$%s</strong> property does not exist. To get the value, use the <strong>$value</strong> property  ');
        define('ABC_NO_STRING',                 'The value is not a string, but is of the type <strong>%s</strong>');
        define('ABC_OBJECT_IS_EMPTY',                 'Object is empty');
        
        /**
        * Inflector
        */ 
        define('ABC_NO_ENGLISH',                 'The argument must be an English noun'); 
        
        /**
        * CLI
        */ 
        define('ABC_CLI_INVALID_COMMAND',        "\nCommand \"%s\" not found.\n");
        define('ABC_CLI_NO_COMMAND',             "\nEnter command.\n");
        
        /**
        * Migrations
        */ 
        define('ABC_MIGRATION_ERROR',               'Unidentified migrations error.');
        define('ABC_MIGRATION_FAILED_TABLE',        'Failed to create migration table.');        
        define('ABC_MIGRATION_SUCCESS',             'Migration %s successfully created.');
        define('ABC_MIGRATION_TABLE_SUCCESS',       'Migration table created successfully.'); 
        define('ABC_MIGRATION_NO_CREATE',           'Failed to create migration: %s');        
        define('ABC_MIGRATION_INVALID_PATH',        'Failed to create migration. Check for directories under path %s');   
        define('ABC_MIGRATION_NO_EXECUTED',         'Failed to execute migration: %s');
        define('ABC_MIGRATION_NO_TABLENAME',        'Table name not specified.');
        define("ABC_MIGRATION_NO_CONFIRM",          "\nConfirmation required. (Требуется подтверждение)\n");        
        define('ABC_MIGRATION_INVALID_COMMAND',     "\nMigration command \"%s\" not recognized.");
        define('ABC_MIGRATION_CLEAR',               'Migration history table cleared.');
        define('ABC_MIGRATION_DELETE',              "Removed of recent migrations from history: %s\n");        
        define('ABC_MIGRATION_NO_CLEAR',            'Failed to clear migration history.');
        define('ABC_MIGRATION_EMPTY',               'New migrations not found.');
        define('ABC_MIGRATION_APPLY_EMPTY',         'Applied migrations not found.');
        define('ABC_MIGRATION_LIST_NEW',            "List of new migrations:\n");
        define('ABC_MIGRATION_APPLY',               "\nApply migrations? Y/N\n");
        define('ABC_MIGRATION_CANCEL',              "\nOperation canceled.");
        define('ABC_MIGRATION_LIST_NEW',            "\nList of new migrations:\n");        
        define('ABC_MIGRATION_LIST_EXECUTE',        "\nSuccessfully completed migrations:\n");
        define('ABC_MIGRATION_LIST_CANCEL',         "\nSuccessfully canceled migrations:\n");        
        define('ABC_MIGRATION_EXECUTE_ERROR',       "\nMigration \"%s\" execution error.\n");
        define('ABC_MIGRATION_ROLLBACK',            "\nRoll back migrations? Y/N\n");
        define('ABC_MIGRATION_HISTORY',             "\nHistory of completed migrations.\n");
        
        /**
        * Params
        */ 
        define("ABC_SESSION_INVALID",               "No active session.");        
        
    }
}
















