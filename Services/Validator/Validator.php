<?php

namespace ABC\Services\Validator;

/** 
 * Класс Validator  
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2017
 * @license http://www.wtfpl.net/ 
 */   
class Validator  
{ 
    protected $descriptions;
    protected $errors = null;
 
    public function __construct()
    {
        $lang = \ABC::getConfig('validator')['language']; 
        $lang = __NAMESPACE__ .'\Language\\'. $lang;
        $this->descriptions = (new $lang)->descriptions;
    }

    public function __toString()
    {
        return implode("\n", $this->errors);
    }
    
    /**   
    * Устанавливает массив описания ошибок
    *  
    * @param array $descriptions
    *
    * @return void
    */  
    public function setDescriptions(array $descriptions = [])
    {
        $this->descriptions = array_merge($this->descriptions, $descriptions);
    }
    
    /**   
    * Проверка значения на пустоту.  
    *  
    * @param mix $value
    * @param string|array $label
    *
    * @return boolean
    */  
    public function checkEmpty($value, $label = '')
    {
        if ($value !== 0 && empty($value)) {
            $this->generateError($label, 'EMPTY_FIELD');
             return false;
        }  
        
        return true;
    }
    
    /**   
    * Проверка значения на int.  
    *  
    * @param mix $value
    * @param string|array $label
    *
    * @return boolean
    */  
    public function checkInt($value, $label = '')
    {
        if (false === filter_var($value, FILTER_VALIDATE_INT)) {
            $this->generateError($label, 'NO_INT');        
             return false;
        }  
        
        return true;
    }
    
    /**   
    * Проверка значения на float.  
    *  
    * @param mix $value
    * @param string|array $label
    *
    * @return boolean
    */  
    public function checkFloat($value, $label = '')
    {
        if (false === filter_var($value, FILTER_VALIDATE_FLOAT)) {
            $this->generateError($label, 'NO_FLOAT');        
             return false;
        }  
        
        return true;
    }    
    
    /**   
    * Проверка значения на корректный e-mail.
    *  
    * @param mix $value
    * @param string|array $label
    *
    * @return boolean
    */  
    public function checkEmail($value, $label = '')
    {
        if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->generateError($label, 'INVALID_EMAIL');        
             return false;
        }  
        
        return true;
    }
    
    /**   
    * Проверка значения на корректный IP.
    *  
    * @param mix $value
    * @param string|array $label
    *
    * @return boolean
    */  
    public function checkIp($value, $label = '')
    {
        if (false === filter_var($value, FILTER_VALIDATE_IP)) {
            $this->generateError($label, 'INVALID_IP');        
             return false;
        }  
        
        return true;
    }
    
    /**   
    * Проверка значения на латиницу.
    *  
    * @param string $value
    * @param string|array $label
    * @param boolean $full
    *
    * @return boolean
    */  
    public function checkLatin($value, $label = '', $full = false)
    {
         if (!$full && !$this->checkEmpty($value, $label)) {
            return true;
        } elseif ($full && $value !== 0 && empty($value)) {
            return true;
        }
      
        if (!preg_match('~^[a-z0-9_-]+$~is', $value)) {
            $this->generateError($label, 'NO_LATIN');        
             return false;
        }  
        
        return true;
    }
    
    /**   
    * Проверка значения по регулярному выражению.
    *  
    * @param string $value
    * @param string $regExp
    * @param string|array $label
    *
    * @return boolean
    */  
    public function checkByRegExp($value, $regExp, $label = '')
    {
        if (!preg_match('~'. $regExp .'~uis', $value)) {
            $this->generateError($label);        
             return false;
        }  
        
        return true;
    }
    
    /**   
    * Проверка значения функцией filter_var().  
    *  
    * @param string $value
    * @param int $filter
    * @param mix $options
    * @param array $label
    *
    * @return boolean
    */  
    public function filterVar($value, $filter, $options = null, $label = '')
    {
        if (false === filter_var($value, $filter, $options)) {
            $this->generateError($label);        
             return false;
        }  
        
        return true;
    }
    
    /**   
    * Пользовательская валидация.  
    *  
    * @param callable $callable
    * @param array $label
    *
    * @return boolean
    */  
    public function customCheck(callable $callable, $label = '')
    {
        if (true === call_user_func($callable)) {
            return true;
        }  
        
        $this->generateError($label);        
        return false;
    }
    
    /**   
    * Проверка на наличие ошибок.  
    *  
    * @return boolean
    */      
    public function isValid()
    {
        return empty($this->errors);
    } 
    
    /**   
    * Вывод ошибок.  
    *  
    * @return array|null
    */      
    public function getErrors()
    {
        return $this->errors;
    }

    /**   
    * Генерация строки ошибки.  
    *  
    * @param mix $label
    * @param string $key
    *
    * @return void
    */      
    protected function generateError($label, $key = '')
    {
        if (is_array($label) && empty($key)) {
            $descript = $this->descriptions[key($label)];
        } elseif (empty($key)) {
            $descript = null;
        } else {
            $descript = $this->descriptions[$key]; 
        }
        
        $this->setError($label, $descript);
    }    
    
    /**   
    * Установка ошибок.  
    *  
    * @param mix $label
    * @param string $descript
    *
    * @return void
    */      
    protected function setError($label, $descript = '')
    {
        if (is_array($label) && !empty($descript)) {
            $id = key($label);
            $this->errors[$id] = sprintf($descript, $label[$id]);
        } elseif (!empty($descript)) {
            $this->errors[] = sprintf($descript, $label);
        } else {
            $this->errors[] = $label;
        }
    }
}
