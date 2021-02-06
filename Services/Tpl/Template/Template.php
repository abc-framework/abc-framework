<?php 

namespace ABC\Services\Tpl\Template;


use ABC\ABC;

/** 
 * Класс Template 
 * Шаблонизатор
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2015
 * @license http://www.wtfpl.net/ 
 */ 
   
class Template  extends Processor
{  
    protected $functions   = ['createUri', 'createLink', 'activeLink'];

    /**
    * Constructor.
    *
    * @param string $tplDir      Path to templates directory
    */
    public function __construct()
    {
        $this->config = ABC::getConfig(); 
        $this->tplDir = str_replace('\\', ABC_DS, $this->config['template']['dir_template']);
        $this->layout = $this->config['template']['layout'];
        $this->tplExt = $this->config['template']['ext'];
        $this->tplPhp = $this->config['template']['php'];
        $functions = $this->config['template']['functions'];
        $this->functions = array_merge($this->functions, $functions);
    }
} 
