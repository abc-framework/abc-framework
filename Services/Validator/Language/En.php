<?php

namespace ABC\Services\Validator\Language;

/** 
 * Класс En
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2015
 * @license http://www.wtfpl.net/ 
 */ 
   
class En 
{ 
    public $descriptions = [
            'EMPTY_FIELD'     => 'The field %s can not be empty',
            'NO_INT'          => 'The value of the field %s must be an integer',
            'NO_FLOAT'        => 'The value of the field %s must be a number or a fraction',
            'INVALID_EMAIL'   => 'The value of the field %s must be a valid E-mail address',
            'INVALID_IP'      => 'The value of the field %s must be a valid IP address',
    ];
}

