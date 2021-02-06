<?php

namespace ABC\Domain;

use ABC\ABC;
use ABC\Core\Exception\AbcError;
use ABC\Services\Assert;

/** 
 *  Data Transfer Object
 */ 
class DTO 
{
    private $properties = []; 
    private $fill = false;

    /**   
    * __isset
    */ 
    public function __isset($name)
    {
        return isset($this->properties[$name]);
    }    
    
    /**
     * __get
     */
    public function __get($name)
    {
        ABC::sharedService(ABC::ASSERTS)->protertyNotFound($this->properties, $name);
        return $this->properties[$name];
    } 

    /**   
    * __clone
    */ 
    protected function __clone()
    {
        $this->fill = true;
    } 
    
    /**
     * __set
     */
    public function __set($name, $value)
    {
        AbcError::Logic('Impossible to change DTO');
    } 
    
    /**   
    * JSON
    *  
    * @return string
    */ 
    public function __toString()
    {
        return json_encode($this);
    }

    /**
     * Return array
     * @return array
     */
    public function __toArray()
    {
        return (array)$this->properties;
    }
    
    /**
     * @param array $data
     */
    public function make($data)
    {
        if ($this->fill) {
            AbcError::Logic('Can not change DTO');
        }
     
        switch (true) {
         
            case empty($data) :
                return clone $this;
         
            case is_object($data) :
                return $this->fill($data);
         
            case is_array($data) :
             
                $models = [];
                foreach ($data as $name => $model) {
                    if (!is_array($model)) {
                        $models = $this->fill($data);
                        break;
                    } else {
                        $models[$name] = $this->fill($model);
                    }
                }
                
                return $models;
            
            default:
                AbcError::Logic('Impossible to make DTO. The argument must be an array');
        }
    }
    
    /**
     * @param array|object $models
     *
     * @return object
     */
    private function fill($models)
    {
        if (!is_object($models) && !is_array($models)) {
            AbcError::invalidArgument('Incorrect data format');
        }
        
        $dto = clone $this;
        foreach ($models as $name => $value) {
            $dto->properties[$name] = $value;
        }
     
        return $dto;    
    } 
}