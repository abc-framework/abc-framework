<?php  

namespace ABC\Services\Mailer;

use ABC\ABC;

/** 
 * Mailer (почтовый класс)
 * 
 * NOTE: Requires PHP version 5.5 or later   
 * @author phpforum.su
 * @copyright © 2015
 * @license http://www.wtfpl.net/ 
 */ 
class Mailer   
{   
    protected $n = "\n";
    
    protected $to;       
    protected $from;      
    protected $name;
    protected $subject;      
    protected $message;     
    protected $boundary1;   
    protected $boundary2;       
    protected $html   = false;   
    protected $attach = false;       
    protected $multipart; 
    protected $headers;   
    protected $attachment;         
    protected $errors = [];  
    protected $dummy = 'Your post client does not support specification MIME 1.0    
    For correct display of the letter you should replace the post program.'; 
     
    public function __construct()   
    { 
        if (substr(PHP_OS, 0, 3) == "WIN") {  
            $this->n = "\r\n"; 
        } 
        
        $lang = \ABC::getConfig('mailer')['language'];
        $lang = __NAMESPACE__ .'\Language\\'. $lang;
        $this->mailerErrors = (new $lang)->mailerErrors;
        
        $this->boundary1 = '==' . md5(uniqid()); 
        $this->boundary2 = '==' . md5(uniqid(time())); 
    }

    /** 
    * Метод устаноки языка ошибок
    *    
    * @param array $language
    *    
    * @return void 
    */   
    public function setLanguage($language = [])   
    { 
        if (count($language)) {
            $this->mailerErrors = $language;  
        } 
    }

    /** 
    * Метод устаноки сообщения
    *    
    * @param string $message
    *    
    * @return void 
    */   
    public function setMessage($message = '')   
    { 
        if (!empty($message)) { 
            $this->message = $message; 
            $this->headers = $this->dummy . $this->n . $this->n . '--' . $this->boundary2 . $this->n; 
            $this->headers .= 'Content-type: text/plain; charset="utf-8"' . $this->n; 
            $this->headers .= 'Content-Transfer-Encoding: base64' . $this->n . $this->n; 
            $this->multipart = $this->headers . chunk_split(base64_encode($this->message)) . $this->n; 
        } else { 
            $this->errors[] = $this->mailerErrors['no_text']; 
        }
    }
    
    /** 
    * Метод прикрепления файла  
    *     
    * @param string  $file 
    * @param string $filename 
    *
    * @return void 
    */    
    public function attacheFile($file = '', $filename = '')   
    { 
        if (!empty($file)) {
         
            $this->attach = true; 
         
            if (file_exists($file)) { 
             
                if (empty($filename)) {  
                    $filename = basename($file); 
                } else {  
                    $filename = '=?utf-8?b?'. base64_encode($filename) .'?='. strrchr(basename($file), "."); 
                }  
                
                $this->attachment  = 'Content-type: application/octet-stream; name="'. $filename .'"'. $this->n; 
                $this->attachment .= 'Content-disposition: attachment;  filename="'. $filename .'"'. $this->n; 
                $this->attachment .= 'Content-Transfer-Encoding: base64'. $this->n . $this->n; 
                $this->attachment .= chunk_split(base64_encode(file_get_contents($file))) . $this->n . $this->n; 
            } else { 
                $this->errors[] = $this->mailererrors['no_path']; 
            }
            
        } else { 
            $this->errors[] = $this->mailerErrors['no_file']; 
        } 
    }  
 
    /** 
    * Устанавливает HTML формат сообщения 
    *          
    * @return void 
    */     
    public function setHtml()   
    {   
      
        $this->html = true;   
        $this->multipart  = '';         
     
        if ($this->attach) {   
            $this->multipart  = '--'. $this->boundary1 . $this->n;   
            $this->multipart .= 'Content-type: multipart/alternative; boundary="'. 
            $this->boundary2 .'"'. $this->n.$this->n;                
        }   
      
        $this->multipart .=  $this->headers;    
        $this->multipart .= chunk_split(base64_encode(strip_tags($this->message))) . $this->n;          
        $this->multipart .=  '--'. $this->boundary2 . $this->n;         
        $this->multipart .= 'Content-type: text/html; charset="utf-8"'. $this->n;   
        $this->multipart .= 'Content-Transfer-Encoding: base64'. $this->n. $this->n;   
        $this->multipart .= chunk_split(base64_encode($this->message)) . $this->n; 
        $this->multipart  .= '--'. $this->boundary2 .'--';         
    }  

    /** 
    * Устанавливает адрес "Кому" 
    * 
    * @param string  $to  
    *    
    * @return bool
    */     
    public function createTo($to = false)   
    { 
        if (empty($to)) {  
            $this->errors[] = $this->mailerErrors['no_addresse'];
            return false;
        } elseif (false === filter_var($to, FILTER_VALIDATE_EMAIL)) { 
            $this->errors[] = $this->mailerErrors['not_correct'];
            return false;
        } 
        
        $this->to = $to; 
        return true;
    }   
    
    /** 
    * Устанавливает адрес "От кого" 
    * 
    * @param string  $from 
    *    
    * @return void 
    */     
    public function createFrom($from, $name = null)   
    {
        if (!empty($from)) {     
            $this->from = trim(preg_replace('/[\r\n]+/', ' ', $from));
            $this->name = !empty($name) ? $name : $this->from;
        } else {  
            $this->errors[] = $this->mailerErrors['no_sender'];
        }    
    }  
 
    /** 
    * Устанавливает тему сообщения 
    * 
    * @param string  $subject 
    *    
    * @return bool
    */     
    public function createSubject($subject = false)   
    {   
        if (empty($subject)) {   
            $this->errors[] = $this->mailerErrors['no_theme'];
               return false;
        } 
        
        $this->subject = '=?utf-8?b?'. base64_encode($subject) .'?='; 
        return true;
    }   
     
    /** 
    * Формирует заголовки
    *        
    * @return string 
    */  
    protected function createHeaders()   
    { 
        $host = str_replace('www.', '', $_SERVER['HTTP_HOST']);
        $headers  = 'Date: '. date('D, d M Y h:i:s O') . $this->n;       
        $headers .= 'From: '. $this->from .' <'. $this->from .'>'. $this->n; 
        $headers .= 'Message-ID: <'. md5(uniqid(time())) .'@'. $host .'>'. $this->n;      
        $headers .= 'X-Priority: 3: '. $this->n;   
        $headers .= 'X-Mailer:  ABC_Mailer 1.0 (irbis-team.ru)'. $this->n;      
        $headers .= 'MIME-Version: 1.0' . $this->n;     
         
        if ($this->html && !$this->attach) { 
            $headers .= 'Content-type: multipart/alternative; boundary="'. $this->boundary2 .'"'; 
        } elseif($this->html && $this->attach) { 
            $headers .= 'Content-type: multipart/mixed; boundary="'. $this->boundary1 .'"'; 
            $this->multipart .= $this->n .'--'. $this->boundary1 . $this->n; 
            $this->multipart .= $this->attachment; 
            $this->multipart .= '--'. $this->boundary1 .'--'. $this->n; 
        } elseif($this->attach) { 
            $headers .= 'Content-type: multipart/mixed; boundary="'. $this->boundary2 .'"'; 
            $this->multipart .= '--'. $this->boundary2 . $this->n; 
            $this->multipart .= $this->attachment; 
            $this->multipart .= '--'. $this->boundary1 .'--'. $this->n; 
        } else { 
            $headers .= 'Content-type: multipart/related; boundary="'. $this->boundary2 .'"'; 
            $this->multipart .= '--'. $this->boundary2 .'--'. $this->n; 
        } 
        
        return $headers; 
    }    

    /** 
    * Валидация    
    *   
    * @return mix 
    */       
    protected function checkErrors()   
    {      
        return count($this->errors) ? $this->errors : false;   
    }   

    /** 
    * Отправляет письмо используя PHP функцию  mail()    
    * 
    * @return mix 
    */  
    public function sendMail()   
    {            
        if (false === ($errors = $this->checkErrors())) {      
          
            $headers = $this->createHeaders();   
               
            if (!mail($this->to, $this->subject, $this->multipart, $headers, '-f'. $this->from)) {  
                $errors[] = $this->mailerErrors['no_send'];
            } else { 
                return true;
            }
        }
        
        return $errors;
    }     
} 

