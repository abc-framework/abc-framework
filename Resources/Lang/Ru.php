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
class Ru
{
    /**
    * Устанавливает языковые константы
    */     
    public static function set() 
    {
        /**
        * Общие константы
        */ 
        define("ABC_NO_SUPPORT_SERVICE",       ": service is not supported in the current configuration <br />\n<span style=\"color:#f98a8a\">(Сервис не поддерживается в текущей конфигурации)</span><br />\n");
        define("ABC_INVALID_ARGUMENT",         "Invalid argument <br />\n<span style=\"color:#f98a8a\">(Недопустимый аргумент)</span><br />\n");
        define("ABC_PROPERTY_NOT_FOUND",       "Property %s does not exist<br />\n<span style=\"color:#f98a8a\">(Свойство %s не существует)</span><br />\n");    
        define("ABC_NO_FUNCTIONAL",            " is not implemented <br />\n<span style=\"color:#f98a8a\">(Этот функционал не реализован)</span><br />\n");
        define("ABC_NO_CLASS",                 " class not found <br />\n<span style=\"color:#f98a8a\">(класс не найден)</span><br />\n");
        define("ABC_NO_METHOD",                " method offline in framework <br />\n<span style=\"color:#f98a8a\">(метод не поддержиается фреймворком)</span><br />\n");
        define("ABC_NO_CALLBACK",              " Parameter must be a valid callback <br />\n<span style=\"color:#f98a8a\">(Аргументом должен быть валидный callback)</span><br />\n"); 
        define("ABC_NO_ARRAY",                 " Parameter must be a valid array <br />\n<span style=\"color:#f98a8a\">(Аргументом должен быть валидный массив)</span><br />\n");        
        define("ABC_UNKNOWN_ROUTES",           " Unknown type of routing data <br />\n<span style=\"color:#f98a8a\">(неизвестный тип маршрутизации)</span><br />\n");
        define("ABC_ERROR_ROUTES_RULE",        " Error in the routing rules <br />\n<span style=\"color:#f98a8a\">(ошибка в правилах роутинга)</span><br />\n");
        define("ABC_NO_MODEL",                 " model is not implemented <br />\n<span style=\"color:#f98a8a\">(модель не реализована)</span><br />\n");  

        /**
        * Ошибки конфигурации
        */ 
        define("ABC_INVALID_DEBUG_SETTING",    " Сonfiguration error<br />\n<span style=\"color:#f98a8a\">(ошибка конфигурации)</span><br />\n");
        define("ABC_INVALID_CONFIGURE_APP",    " Configuring the application is to be performed array <br />\n<span style=\"color:#f98a8a\">(конфигурация приложения должна быть массивом)</span><br />\n");
        define("ABC_INVALID_CONFIGURE_SITE",   " Configuring the site is to be performed array <br />\n<span style=\"color:#f98a8a\">(конфигурация сайта должна быть массивом)</span><br />\n");
        define("ABC_NO_CONFIGURE",             " Setting is not specified in the configuration file <br />\n<span style=\"color:#f98a8a\">(настройка не задана в конфигурационном файле)</span><br />\n");
        define("ABC_INVALID_CONFIGURE",        " Setup key must be a string <br />\n<span style=\"color:#f98a8a\">(ключ настройки должен быть строкой)</span><br />\n");
  

        /**
        * Миддлвары 
        */ 
        
        define("ABC_INVALID_MIDDLWARE",     "Middleware is not set correctly<br />\n<span style=\"color:#f98a8a\">(Мидлвар задан некорректно)</span><br />\n");
        define("ABC_MIDDLWARE_NO_PROCESS",  "Middleware <strong>%s</strong> must have a method process()<br />\n<span style=\"color:#f98a8a\">(Мидлвар <strong>%s</strong> должен иметь метод process())</span><br />\n");
        define("ABC_MIDDLEWARE_INVALID_ARG","Middleware <strong>%s</strong> is not set correctly (invalid number of arguments)<br />\n<span style=\"color:#f98a8a\">(Мидлвар <strong>%s</strong> имеет неверное количество аргументов)</span><br />\n");

        /**
        * Ошибки использования шаблонизатора
        */ 
        define("ABC_TPL_DISABLE",              " the template disabled <br />\n<span style=\"color:#f98a8a\">(шаблонизатор отключен)</span><br />\n");
        define("ABC_NO_TEMPLATE",              " templates file  does not exist <br />\n<span style=\"color:#f98a8a\">(файл шаблона отутствует)</span><br />\n");
        define("ABC_INVALID_BLOCK",            " Block <strong>%s</strong> does not exist or incorrect syntax <br />\n<span style=\"color:#f98a8a\">(Блок <strong>%s</strong> отсутствует, либо имеет некорректный синтаксис)</span><br />\n");
        define("ABC_NO_METHOD_IN_TPL",         " templating method is not supported <br />\n<span style=\"color:#f98a8a\">(метод не поддерживается шаблонизатором)</span><br />\n");
        define("ABC_SELECT_NO_TEMPLATE",         "Cannot select template if values ​​have already been passed to template. <br />\n<span style=\"color:#f98a8a\">(Нельзя выбрать шаблон, если в макет уже переданы значения переменных.)</span><br />\n");
        
        /**
        * Ошибки использования пагинатора
        */         
        define("ABC_NO_TOTAL",                 " limit is not set <br />\n<span style=\"color:#f98a8a\">(лимит не установлен)</span><br />\n");
        
        /**
        * Ошибки использования Value Object
        */         
        define("ABC_RECYCLING",                 "Reuse is unacceptable<br />\n<span style=\"color:#f98a8a\">(Повторное использование недопустимо)</span><br />\n");
        define("ABC_NO_PROPERTY",               "The <strong>$%s</strong> property does not exist. To get the value, use the <strong>\$value</strong> property  <br />\n<span style=\"color:#f98a8a\">(Свойства <strong>$%s</strong> не существует. Для получения значения используйте свойство <strong>\$value</strong>)</span><br />\n");
        define("ABC_NO_STRING",                 "The value is not a string, but is of the type <strong>%s</strong><br />\n<span style=\"color:#f98a8a\">(Значение не является строкой, а имеет тип <strong>%s</strong>)</span><br />\n");
        define("ABC_OBJECT_IS_EMPTY",                 "Object is empty<br />\n<span style=\"color:#f98a8a\">(Объект не заполнен)</span><br />\n");
        
        /**
        * Ошибки использования инфлектора
        */ 
        define("ABC_NO_ENGLISH",                 "The argument must be an English noun <br />\n<span style=\"color:#f98a8a\">(Аргумент должен быть английским существительным)</span><br />\n");

        /**
        * Командная строка
        */ 
        define("ABC_CLI_NO_COMMAND",             "\nEnter command. (Введите команду)\n");
        define("ABC_CLI_INVALID_COMMAND",        "\nCommand \"%s\" not found. (Команда не распознана)\n");
        
        /**
        * Миграции
        */ 
        define("ABC_MIGRATION_ERROR",               "Unidentified migrations error. (Неопознанная ошибка миграции)");
        define("ABC_MIGRATION_FAILED_TABLE",        "Failed to create migration table. (Не удалось создать таблицу миграций)");        
        define("ABC_MIGRATION_SUCCESS",             "Migration %s successfully created. (Миграция успешно создана)");
        define("ABC_MIGRATION_TABLE_SUCCESS",       "Migration table created successfully. (Таблица миграций успешно создана)"); 
        define("ABC_MIGRATION_NO_CREATE",           "Failed to create migration: %s (Не удалось создать миграцию.");         
        define("ABC_MIGRATION_NO_EXECUTED",         "Failed to execute migration: %s (Не удалось исполнить миграцию.)");          
        define("ABC_MIGRATION_NO_TABLENAME",        "Table name not specified. (Не указано имя таблицы.)");
        define("ABC_MIGRATION_NO_CONFIRM",          "\nConfirmation requi#f98a8a. (Требуется подтверждение)\n");
        define("ABC_MIGRATION_INVALID_COMMAND",     "\nMigration command \"%s\" not recognized. (Команда миграции не распознана)"); 
        define("ABC_MIGRATION_CLEAR",               "Migration history table clea#f98a8a. (Таблица истории миграций очищена)");
        define("ABC_MIGRATION_DELETE",              "Removed of recent migrations from history: %s  (Удалено из истории миграций: %s)\n");        
        define("ABC_MIGRATION_NO_CLEAR",            "Failed to clear migration history. (Не удалось очистить историю миграций)");
        define("ABC_MIGRATION_NEW_EMPTY",           "New migrations not found. (Новых миграций не найдено)");
        define("ABC_MIGRATION_APPLY_EMPTY",         "Applied migrations not found. (Выполненных миграций не найдено)");
        define("ABC_MIGRATION_APPLY",               "\nApply migrations? (Применить миграции?) Y/N\n");
        define("ABC_MIGRATION_CANCEL",              "\nOperation canceled. (Операция отменена)");
        define("ABC_MIGRATION_LIST_NEW",            "\nList of new migrations. (Список новых миграций):\n");        
        define("ABC_MIGRATION_LIST_EXECUTE",        "\nSuccessfully completed migrations. (Успешно выполненные миграции):\n");
        define("ABC_MIGRATION_LIST_CANCEL",         "\nSuccessfully canceled migrations. (Успешно отмененные миграции):\n");        
        define("ABC_MIGRATION_EXECUTE_ERROR",       "\nMigration \"%s\" execution error.\n (Ошибка выполнения миграции)\n");
        define("ABC_MIGRATION_ROLLBACK",            "\n\nRoll back migrations? (Откатить миграции?) Y/N\n");
        define("ABC_MIGRATION_NO_ROLLBACK",         "\nFailed to roll back migrations (Не удалось откатить миграции)\n");    
        define("ABC_MIGRATION_HISTORY",             "\nHistory of completed migrations. (История исполненных миграций)\n");
        define("ABC_MIGRATION_INVALID_PATH",        "Failed to create migration. Check for directories under path %s (Не удалось создать миграцию. Проверьте наличие директорий по пути %s)"); 
    

        /**
        * Params
        */ 
        define("ABC_SESSION_INVALID",               "No active session. <br />\n<span style=\"color:#f98a8a\">(Нет активной сессии)</span>");
    
    }
    
}
    
