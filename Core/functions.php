<?php


use ABC\ABC; 
use ABC\Core\Routing\AppManager;
use ABC\Core\PhpBugsnare\Debugger;


    /**
    * Инициализация GET
    *
    * @param array $key
    * @param array $default
    * 
    * @return string
    */
    function GET($key = null, $default = null)
    {
        return ABC::sharedService(ABC::PARAMS)->get($key, $default);
    }
    
    /**
    * Инициализация POST
    *
    * @param array $key
    * @param array $default
    * 
    * @return string
    */
    function POST($key = null, $default = null)
    {
        if (empty($key)) {
            return $_POST ?? [];
        }
        
        return $_POST[$key] ?? $default;
    }
    
    /**
    * Инициализация COOKIE
    *
    * @param array $key
    * @param array $default
    * 
    * @return string
    */
    function COOKIE($key = null, $default = null)
    {
        return ABC::sharedService(ABC::HTTP)->request()->getCookie($key, $default);
    }
    
    /**
    * Обработка переменных для вывода в поток
    *
    * @param array $data
    * 
    * @return mix
    */
    function htmlChars($data)
    {
        if (is_array($data)) {
            $data = array_map('htmlChars', $data);
        } else {
            $data = htmlspecialchars($data);
        }
        
        return $data;
    }
    
    /**
    * Преобразует элементы массива в нижний регистр
    *
    * @param array $data
    * 
    * @return mix
    */
    function arrayStrtolower($data)
    {
        if (is_array($data)) {
            $data = array_map('arrayStrtolower', $data);
        } else {
            $data = mb_strtolower($data);
        }
        
        return $data;
    }
    
    /**
    * Преобразует элементы массива в верхний регистр
    *
    * @param array $data
    * 
    * @return mix
    */
    function arrayStrtoupper($data)
    {
        if (is_array($data)) {
            $data = array_map('arrayStrtoupper', $data);
        } else {
            $data = mb_strtoupper($data);
        }
        
        return $data;
    }

    /**
    * Формирование URL.
    * 
    * @param string $queryString
    * @param bool|array $mode
    *
    * @return string 
    */      
    function createUri($queryString, $mode = false)   
    {  
        return ABC::newService(ABC::URI_MANAGER)->createUri($queryString, $mode);
    }
    
    /**
    * Формирование ссылок.
    * 
    * @param string $queryString
    * @param string $text
    * @param array $param
    *
    * @return string 
    */      
    function createLink($queryString, $text, $param = [])   
    { 
        return ABC::sharedService(ABC::URI_MANAGER)->createLink($queryString, $text, $param);
    } 
    
    /**   
    * Активация ссылок 
    *
    * @param string $returnUrl
    * @param string $css
    *
    * @return string
    */ 
    function activeLink($returnUrl, $css = 'class="active"')
    { 
        return ABC::sharedService(ABC::URI_MANAGER)->activeLink($returnUrl, $css);
    }     
  
    /**
    * Привидение к типу boolean
    *
    * @param mix $var
    *
    * @return void
    */ 
    function isTrue($var)
    { 
        return filter_var($var, FILTER_VALIDATE_BOOLEAN);
    }
    
    /**
    * Генератор уникальной строки
    *
    * @param mix $var
    *
    * @return void
    */ 
    function uniqueId()
    { 
        return md5(microtime(true) . rand(100, 1000));
    }
    
    /**
    * Трассировка скриптов
    * 
    * @param bool $inc
    *
    * @return void
    */ 
    function trace($inc = false)
    {
        dbg(getReport($inc));
    }
    
    /**
    * Итоговый отчет
    *
    * @param bool $inc
    *
    * @return void
    */ 
    function finalReport($inc = false)
    {
        $report = getReport($inc);
        ?><div class="final_report"><pre><?php
        print($report[1]);
        ?></pre></div><?php
        exit();
    }
    
    /**
    * Трассировка скриптов
    *
    * @param bool $inc
    *
    * @return void
    */ 
    function getReport($inc = false)
    {
        $memory = memory_get_usage();
        $unit   = ['b','kb','mb','gb'];
        $i = floor(log($memory, 1024));
        $memory = round($memory / pow(1024, $i), 2);
        $memory .= ' '. $unit[$i];                
        $trace  = ABC::getFromStorage('trace');
        $time   = microtime(true) - $trace['start_time'];
        $time   = round($time, 5);
        $includes = get_included_files();
        
        $listIncludes = [];
        $num = 0;
        foreach ($includes as $file) {
         
            if (isTrue($inc) || false === stripos($file, 'vendor'. ABC_DS .'ABC')) {
                $listIncludes[] = ++$num .'. '. $file; 
            }
        }
        
        $cntFiles = count($listIncludes);
        $listIncludes = implode("\n", $listIncludes);
        
        $report[] = 'ea446918bb69b3';
        $report[] = <<<EOT
<strong>Script execution report</strong>

1. <em>Script execution time</em>: <strong>$time c</strong>
2. <em>Used memory</em>: <strong>$memory</strong>
3. <em>Count of SQL queries</em>: <strong>{$trace['sql_count']}</strong>
4. <em>Count of included files</em>: <strong>$cntFiles</strong>

<strong>Used Files</strong>: 
$listIncludes
EOT;
        return $report;
    } 













    