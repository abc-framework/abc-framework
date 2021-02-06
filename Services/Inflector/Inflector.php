<?php 

namespace ABC\Services\Inflector;
  
use ABC\ABC;
use ABC\Services\Inflector\Pluraliser\English;
use ABC\Services\Inflector\Translit\Cyr;
use ABC\Core\Exception\AbcError;
 
/** 
 * Inflector 
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2018
 * @license http://www.wtfpl.net/ 
 */   
class Inflector 
{

   const UPCASE_FIRST_LETTER = true;
    /** 
    * Перевод слова во множественную форму
    *    
    * @param string $word
    *    
    * @return string 
    */      
    public function pluralizeEn($word)
    { 
        if (!preg_match('~^[a-z_]+$~is', $word)) { 
            AbcError::invalidArgument(ABC_NO_ENGLISH); 
            return false;
        }
     
        return English::plural($word);
    } 
 
    /** 
    * Перевод ВерблюжьейНотации в нижнюю_змеиную_нотацию.
    *    
    * @param string $word
    *    
    * @return string 
    */      
    public function underscore($word)
    { 
        if (!preg_match('~^[a-z_]+$~is', $word)) { 
            AbcError::invalidArgument(ABC_NO_ENGLISH); 
            return false;
        }
     
        return English::underscore($word); 
    } 
 
    /** 
    * Перевод нижней_змеиной_нотации в ВерблюжьюНотацию
    *    
    * @param string $word
    *    
    * @return string 
    */ 
    public function camelize($word, $downcase_first_letter = self::UPCASE_FIRST_LETTER)
    {
        return English::camelize($word, $word, $downcase_first_letter); 
    }
    /** 
    * Перевод кириллицы в латиницу
    *    
    * @param string $text
    *    
    * @return string 
    */
    public function cyrLat($text) 
    {
        return Cyr::cyrLat($text);        
    } 

    /** 
    * Перевод латиницы в кириллицу
    *    
    * @param string $text
    *    
    * @return string 
    */       
    public function latCyr($text) 
    { 
        return Cyr::latCyr($text); 
    } 
    
    
}
