<?php 

namespace ABC\Domain;
 
use Abcsoft\DIC\Interfaces\LocatorInterface; 
 
use ABC\Domain\Ports\{
    CommandInterface,    
    ServiceInterface    
};

/** 
 * Шина команд 
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2018
 * @license http://www.wtfpl.net/ 
 */ 
class CommandBus
{
    protected $commandLocator;
    protected $serviceLocator;
    protected $namespace;
    protected $group;
    protected $dto;    

    /**    
    *
    * @param string $group
    */ 
    public function setConfig(array $config)
    {
        $this->namespace = $config['command_bus']['namespace'];
        return $this;
    }    
    
    /**    
    *
    * @param string $group
    */ 
    public function setCommandLocator(LocatorInterface $commandLocator)
    {
        $this->commandLocator = $commandLocator;
        return $this;
    }
    
    /**    
    *
    * @param string $group
    */ 
    public function setServiceLocator(LocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }
   
    /**    
    *
    * @param string $group
    */ 
    public function setDTO($dto)
    {
        $this->dto = $dto;
        return $this;
    }
    
    /**    
    *
    * @param object $command
    *
    * @return array|object  
    */
    public function execute($command)
    {
        $result = $this->process($command);     
        return $this->dto->make($result);
    }
    
    /**    
    *
    * @param object $command
    *
    * @return array  
    */
    public function asArray($command)
    {
        return $this->process($command);
    }
    
    /**    
    * Экзекутор
    *
    * @param object|string $command
    *
    * @return object  
    */
    protected function process($command)
    {  
        if(is_string($command)){
            $command = $this->commandLocator->get(CommandInterface::class, $command);
        }
        
        $className = get_class($command);
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $commandName = basename($className);
        $rawName = substr($commandName, 0, -7);
        $type  = ('Read' === substr($rawName, -4)) ? 'Reader' : 'Writer';
        $serviceName = preg_replace('~(.+?)Read|Write$~', '$1', $rawName) . $type;
        $serviceClassName = $this->namespace .'\\'. $serviceName;
     
        if(!empty($this->serviceLocator)){
            $service = $this->serviceLocator->get(ServiceInterface::class, $serviceName);
        } elseif(class_exists($serviceClassName)) {
            $service =  new $serviceClassName;
        }
        
        return $service->process($command);
    }
}
