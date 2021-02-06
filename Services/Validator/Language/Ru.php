<?php

namespace ABC\Services\Validator\Language;

/** 
 * Класс Ru
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2015
 * @license http://www.wtfpl.net/ 
 */ 
   
class Ru  
{ 
    public $descriptions = [
            'EMPTY_FIELD'     => 'Поле %s не может быть пустым',
            'NO_INT'          => 'Значение поля %s должно быть целочисленным',
            'NO_FLOAT'        => 'Значение поля %s должно быть числом или дробью',
            'INVALID_EMAIL'   => 'Значение поля %s должно быть корректным E-mail адресом',
            'INVALID_IP'      => 'Значение поля %s должно быть корректным IP адресом',
            'NO_LATIN'        => 'В поле %s допустимы только латинские символы, цифры, дефис и подчеркивание',
    ];
}

