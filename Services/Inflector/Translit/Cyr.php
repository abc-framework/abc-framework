<?php 

namespace ABC\Services\Inflector\Translit;

use ABC\ABC;
 
/** 
 * Транслитерация кириллицы в латиницу и наоборот
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2018
 * @license http://www.wtfpl.net/ 
 */  
class Cyr 
{

    protected static $lat = [
                          "YO", "ZH",  "CZ", "CH", "SHH","SH", "Y'",  
                          "E'", "YU",  "YA", "yo", "zh", "cz", "ch",  
                          "sh", "shh", "y'", "e'", "yu", "ya", "A",  
                          "B" , "V" ,  "G",  "D",  "E",  "Z",  "I",  
                          "J",  "K",   "L",  "M",  "N",  "O",  "P",  
                          "R",  "S",   "T",  "U",  "F",  "X",  "''", 
                          "'",  "a",   "b",  "v",  "g",  "d",  "e",  
                          "z",  "i",   "j",  "k",  "l",  "m",  "n",   
                          "o",  "p",   "r",  "s",  "t",  "u",  "f",   
                          "x",  "''",  "'"];
    
    protected static $cyr = [
                          'Ё', 'Ж', 'Ц', 'Ч', 'Щ', 'Ш', 'Ы',  
                          'Э', 'Ю', 'Я', 'ё', 'ж', 'ц', 'ч',  
                          'ш', 'щ', 'ы', 'э', 'ю', 'я', 'А',  
                          'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И',  
                          'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',  
                          'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ъ',  
                          'Ь', 'а', 'б', 'в', 'г', 'д', 'е',  
                          'з', 'и', 'й', 'к', 'л', 'м', 'н',  
                          'о', 'п', 'р', 'с', 'т', 'у', 'ф',  
                          'х', 'ъ', 'ь'];
    
    /** 
    * Перевод кириллицы в латиницу
    *    
    * @param string $text
    *    
    * @return string 
    */
    public static function cyrLat($text) 
    {
        return str_replace(self::lat, self::cyr, $text);         
    }
    
    /** 
    * Перевод латиницы в кириллицу
    *    
    * @param string $text
    *    
    * @return string 
    */     
    public static function latCyr($text) 
    { 
        $translated = str_replace(self::cyr, self::lat, $text);
        $translated = preg_replace('/(?<=[а-яё])Ь/u', 'ь', $translated); 
        return preg_replace('/(?<=[а-яё])Ъ/u', 'ъ', $translated); 
    } 
}
