<?php 

namespace ABC\Services\Collection\ValueObject;

use ABC\Core\Exception\AbcError;

/** 
 * Класс ValueObject
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2018
 * @license http://www.wtfpl.net/ 
 */
   
final class ValueObject 
{ 
    private $value;
    private $validator;
    private $callable;
    private $blank = true;    
    
    /**
    * Запрет клонирования снаружи
    */ 
    private function __clone(){}
    
    /**
    * Ошибка вызова метода
    *
    * @param string $method
    * @param mix $param
    *
    * @return void
    */     
    public function __call($method, $param)
    {
        $method = explode('::', $method);
        AbcError::badMethodCall(array_pop($method) .'() '. ABC_NO_METHOD);
    } 
    
    /**
    * Установка валидатора
    *
    * @param callable $validator
    *
    * @return bool|void
    */
    public function setValidator(callable $validator)
    {
        if (!isset($this->blank)) {
            AbcError::Logic(ABC_RECYCLING);        
            return false;
        }
        
        $this->validator = $validator;
    }
    
    /**
    * Установка произвольных обработчиков
    *
    * @param callable $callable
    *
    * @return bool|void
    */
    public function addHandler(callable $callable)
    {
        if (!isset($this->blank)) {
            AbcError::Logic(ABC_RECYCLING);        
            return false;
        }
        
        $this->callable[] = $callable;
    }
    
    /**
    * Устанавливает значение и возвращает заполненный клон объекта
    *
    * @param mix $value
    *
    * @return object
    */ 
    public function withValue($value)
    {
        if (!isset($this->blank)) {
            AbcError::Logic(ABC_RECYCLING);        
            return false;
        }
        
        if (!$this->isValid($value)) {
            return false;
        }        
     
        $value = $this->processing($value);
     
        if (is_object($value) || is_bool($value)) {
            AbcError::invalidArgument(ABC_INVALID_ARGUMENT);
            return false;
        }
        
        $clone = clone $this;
        $clone->value = $value;    
        unset($clone->blank);
        unset($clone->validator);
        unset($clone->callable);
        return $clone;        
    }

    /**
    * Возвращает строковое значение 
    *
    * @return string
    */ 
    public function __toString()
    {
        if ($this->isEmpty()) {
            return false;
        }
     
        if (!is_string($this->value)) {
            $type = gettype($this->value);
            AbcError::Logic(sprintf(ABC_NO_STRING, $type, $type));
            return false;
        }
        
        return $this->value;
    }
    
    /**
    * Возвращает значение любого валидного типа, как свойство 'value'
    *
    * @return mix
    */ 
    public function __get(string $name)
    {
        if ($this->isEmpty()) {
            return false;
        }
        
        if ('value' === $name) {
            return $this->value;
        }
        
        AbcError::Logic(sprintf(ABC_NO_PROPERTY, $name, $name));
        return false;
    }
    
    /**
    * Возвращает значение любого валидного типа
    *
    * @return mix
    */
    public function getValue()
    {
        if ($this->isEmpty()) {
            return false;
        }
     
        return $this->value;
    }
    
    /**
    * Сравнение Value Objects
    *
    * @return bool
    */
    public function equals($object)
    {
        return $this->value === $object->value;
    }

    /**
    * Валидация
    *
    * @param mix $value
    *
    * @return bool
    */ 
    private function isValid($value)
    {
        if (empty($this->validator)) {
            return true;
        }
        
        return call_user_func($this->validator, $value);
    } 

    /**
    * Внешняя обработка
    *
    * @param mix $value
    *
    * @return mix
    */ 
    private function processing($value)
    {  
        if (empty($this->callable)) {
            return $value;
        }
     
        foreach ($this->callable as $callable) {
            $value = call_user_func($callable, $value);
        }
        
        return $value; 
    }
    
    /**
    * Проверка заполненности 
    *
    * @return bool
    */
    private function isEmpty()
    {
        if (isset($this->blank)) {
            AbcError::Logic(ABC_OBJECT_IS_EMPTY);        
            return true;
        }
     
        return false;
    }    
}
