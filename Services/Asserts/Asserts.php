<?php

namespace ABC\Services\Asserts;

use ABC\Core\Exception\AbcError;

/**
* Внутренняя валидация значений
*/
class Asserts
{
    /**
    * True
    */ 
    public function isTrue($value)
    {
        if (true !== $value) {
            AbcError::assert('True expected, '. $this->getType($value) .' given');
        }
        
        return $this;
    }
    
    /**
    * False
    */ 
    public function isFalse($value)
    {
        if (false !== $value) {
            AbcError::assert('False expected, '. $this->getType($value) .' given');
        }
        
        return $this;
    }
    
    /**
    * Булево значение
    */ 
    public function isBoolean($value)
    {
        if (!is_bool($value)) {
            AbcError::assert('Boolean type expected, '. gettype($value) .' given');
        }
        
        return $this;
    }

    /**
    * Целочисленное значение
    */ 
    public function isInteger($value)
    {
        if (!is_integer($value)) {
            AbcError::assert('Integer type expected, '. gettype($value) .' given');
        }
        
        return $this;
    }

    /**
    * Строковое значение
    */ 
    public function isString($value)
    {
        if (!is_string($value)) {
            AbcError::assert('String type expected, '. gettype($value) .' given');
        }
        
        return $this;
    }

    /**
    * Массив
    */ 
    public function isArray($value)
    {
        if (!is_array($value)) {
            AbcError::assert('Array type expected, '. gettype($value) .' given');
        }
        
        return $this;
    }

    /**
    * Объект
    */ 
    public function isObject($value)
    {
        if (!is_object($value)) {
            AbcError::assert('Object type expected, '. gettype($value) .' given');
        }
        
        return $this;
    }
    
    /**
    * Замыкание
    */ 
    public function isCallable($value)
    {
        if (!is_callable($value)) {
            AbcError::assert('Callable type expected, '. gettype($value) .' given');
        }
        
        return $this;
    }

    /**
    * Проверка существования класса
    */ 
    public function classExists($class)
    {
        if(!class_exists($class)) {
            AbcError::assert('Class '. $class .' not found');
        }
        return $this;
    }            
    
    /**
    * Проверка на принадлежность к классу
    */ 
    public function instanceOf($obj, $class, $mess = '')
    {
        $this->isObject($obj);
        $this->classExists($class);
        
        if(!($obj instanceof $class)){
            AbcError::assert($mess ? $mess : 'Object does not belong to class '. get_class($class));
        }
     
        return $this;
    }    
    
    /**
    * Проверка на корректность Email
    */ 
    public function isEmail($value)
    {
        if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
            AbcError::assert('Email is incorrect');
        }
        
        return $this;
    }
    
    /**
    * Непустое значение
    */ 
    public function notEmpty($value)
    {     
        if (empty($value) && $value !== 0) {
            AbcError::assert('This value is empty');
        }
        
        return $this;
    }
    
    /**
    * Наличие в массиве
    */ 
    public function inArray($needle, $haystack)
    {
        if (!in_array($needle, $haystack)) {
            AbcError::assert('Element `'. $needle .'` not found in array');
        }
        
        return $this;
    }    
    
    /**
    * Наличие ключа в массиве
    */ 
    public function keyInArray($key, $haystack)
    {
        if (!isset($haystack[$key])) {
            AbcError::assert('Element with a key `'. $key .'` is not set in the array');
        }
        
        return $this;
    }   

    /**
    * Сравнение количества элементов массивов
    */ 
    public function sameCount($arr1, $arr2)
    {
        if (count($arr1) !== count($arr2)) {
            AbcError::assert('The number of elements is not the same');
        }
        
        return $this;
    }
    
    /**
    * Проверка наличия метода в классе объекта
    */ 
    public function methodExists($object, $method)
    {
        if (!method_exists($object, $method)) {
            $class = is_object($object) ? get_class($object) : $object;
            AbcError::assert('Method '. $class .'::'. $method .' not defined');
        }
        
        return $this;
    }
    
    /**
    * Сообщение об отсутствии свойства
    */ 
    public function protertyNotFound($properties, $name)
    {
        if (!isset($properties[$name])) {
            AbcError::assert('Trying to get property of non-object (::'. $name .')');
        }
        return $this;
    }

    
    /**
    * getType
    */ 
    protected function getType($value)
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        
        return gettype($value);
    }  
}