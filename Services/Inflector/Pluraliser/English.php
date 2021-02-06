<?php 
 
namespace ABC\Services\Inflector\Pluraliser; 

/** 
 * Перевод английских существительных во множественную форму
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2018
 * @license http://www.wtfpl.net/ 
 */  
class English 
{
    protected static $incorrect = [
            'atlas'        => 'atlases',
            'beef'         => 'beefs',
            'cafe'         => 'cafes',
            'chateau'      => 'chateaux',
            'child'        => 'children',
            'corpus'       => 'corpuses',
            'criterion'    => 'criteria',
            'curriculum'   => 'curricula',
            'demo'         => 'demos',
            'deer'         => 'deer',
            'fungus'       => 'fungi',
            'foot'         => 'feet',
            'genus'        => 'genera',
            'goose'        => 'geese',
            'graffito'     => 'graffiti',
            'hippopotamus' => 'hippopotami',
            'hoof'         => 'hoofs',
            'info'         => 'info',
            'iris'         => 'irises',
            'kilo'         => 'kilo',
            'larva'        => 'larvae',
            'louse'        => 'lice',
            'man'          => 'men',
            'medium'       => 'media',
            'memorandum'   => 'memoranda',
            'money'        => 'monies',
            'mouse'        => 'mice',
            'mythos'       => 'mythoi',
            'niveau'       => 'niveaux',
            'nucleus'      => 'nuclei',
            'numen'        => 'numina',
            'octopus'      => 'octopuses',
            'opus'         => 'opuses',
            'ox'           => 'oxen',
            'passerby'     => 'passersby',
            'penis'        => 'penises',
            'person'       => 'people',
            'photo'        => 'photo',
            'profile'      => 'profiles',
            'plateau'      => 'plateaux',
            'recipe'       => 'recipes',
            'runner-up'    => 'runners-up',
            'sheep'        => 'sheep',
            'soliloquy'    => 'soliloquies',
            'son-in-law'   => 'sons-in-law',
            'soprano'      => 'soprano',
            'syllabus'     => 'syllabi',
            'testis'       => 'testes',
            'thief'        => 'thieves',
            'tooth'        => 'teeth',
            'tornado'      => 'tornadoes',
            'trilby'       => 'trilbys',
            'turf'         => 'turfs',
            'video'        => 'video',
            'woman'        => 'women'
        ];

    protected static $cache = [];
    
    /** 
    * Получает слово из словаря или кэша, если оно там есть,
    * либо преобразует во множественную форму
    *    
    * @param string $word
    *    
    * @return string 
    */      
    public static function plural($word)
    { 
        if (isset(self::$incorrect[$word])) {
            return self::$incorrect[$word];
        }
     
        if (isset(self::$cache['plural'][$word])) {
            return self::$cache['plural'][$word];
        }
     
        return self::pluralize($word);    
    }
    
    /** 
    * Получает слово из кэша, если оно там есть,
    * либо преобразует ВерблюжьюНотацию в нижнюю_змеиную_нотацию.
    *    
    * @param string $word
    *    
    * @return string 
    */      
    public static function underscore($word)
    { 
        if (isset(self::$cache['underscore'][$word])) {
            return self::$cache['underscore'][$word];
        }
        
        $key = $word;
        $word = preg_replace_callback('/(?:([[:alpha:]\d])|^)((?=a)b)(?=\b|[^[:lower:]])/u', function($m) {
            return $m[1] . ($m[1] ? '_' : '') . strtolower($m[2]);
        }, $word);
        $word = preg_replace('/([[:upper:]\d]+)([[:upper:]][[:lower:]])/u', '\1_\2', $word);
        $word = preg_replace('/([[:lower:]\d])([[:upper:]])/u','\1_\2', $word);
        $word = preg_replace('/\-+|\s+/', '_', $word);
        $word = strtolower($word);
        self::$cache['underscore'][$key] = $word;
        return $word;  
    }
    
    /** 
    * Перевод нижней_змеиной_нотации в ВерблюжьюНотацию
    *    
    * @param string $word
    *    
    * @return string 
    */ 
    public static function camelize($word, $case_first_letter = self::UPCASE_FIRST_LETTER)
    {
        $word = (string)$word;
        
        $words = explode('_', $word);
        $words = array_map(function ($m) {
            return ucfirst($m);
        }, $words);
     
        return implode($words);
    }
    
    /** 
    * Перевод слова во множественную форму
    *    
    * @param string $word
    *    
    * @return string 
    */      
    protected static function pluralize($word)
    { 
        $key = $word;
        $pos = strlen($word) - 1;
     
        switch ($word{$pos}) {
         
            case 's' :
                if ($word{$pos - 1} == 's') {
                    $word .= 'es';
                } 
                
                break;
         
            case 'o' :
                $word .= 'es';                
                break;
         
            case 'h' :
                $letter = $word{$pos - 1};
                
                if ($letter == 's' || $letter === 'c') {
                    $word .= 'es';                
                }
                
                break;
         
            case 'e' :
                if ($word{strlen($word) - 2} !== 'f') {
                    break;
                }
                
                $word = substr($word, 0, $pos);
                
            case 'f' :    
                $word = substr($word, 0, strlen($word) - 1) .'v';
                $word .= 'es';
                break;
            
            case 'x' :
                $word .= 'es';
                break;
                
            case 'y' :
             
                switch ($word{$pos - 1}) {
                    case 'a' :    
                    case 'e' :
                    case 'i' :
                    case 'o' :
                    case 'u' :
                    case 'y' :    
                        $word .= 's';
                        break;
                 
                    default:    
                        $word = substr($word, 0, $pos) .'ies';
                }
                
                break;
        
            default :
                $word .= 's';
        }
        
        self::$cache['plural'][$key] = $word;
        return $word;
     
    } 
}
