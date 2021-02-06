<?php

namespace ABC\Core\Application;
 
/** 
 * Трейт ProcessorTrait
 * 
 * NOTE: Requires PHP version 5.5 or later  
 * @author phpforum.su
 * @copyright © 2017
 * @license http://www.wtfpl.net/ 
 */   
trait ResponseTrait
{

    /**
    * Добавляет миддлвары
    *
    * @param mix $middleware
    *
    * @return object
    */ 
    public function add($middleware)
    { 
        $pipe = \ABC::getFromStorage(\ABC::PIPE);
        $pipe->add($middleware);
        \ABC::addToStorage(\ABC::PIPE, $pipe);
        return $this;
    }
    /**
    * Запуск 
    *
    * @return void
    */     
    public function run()
    {
        $pipe = \ABC::getFromStorage(\ABC::PIPE);
      
        if ($pipe->isEmpty()) {
            (new NotFound($pipe))->create404();
        }
       
        $response = $pipe->run();
        
        if (!empty($response)) { 
            $size = $response->getBody()->getSize();
            
            if (null !== $size) {
                $response = $response->withHeader('Content-Length', (string)$size);  
            }
            
            $this->sendHeaders($response);
            $this->sendBody($response);
        }
    }
    
    /**
    * Отправляет заголовки
    *
    * @param object $response
    */     
    protected function sendHeaders($response)
    { 
        if (!headers_sent()) {
            header(sprintf(
                'HTTP/%s %s %s',
                $response->getProtocolVersion(),
                $response->getStatusCode(),
                $response->getReasonPhrase()
            ));

            foreach ($response->getHeaders() as $name => $values) {
                foreach ($values as $value) {
                    header(sprintf('%s: %s', $name, $value), false);
                }
            }
        }
    }
 
    /**
    * Отправляет ответ в поток
    *
    * @param object $response
    */
    protected function sendBody($response)
    {
        $body = $response->getBody();
        
        if ($body->isSeekable()) {
            $body->rewind();
        }
     
        $chunkSize    = 4096;
        $amountToRead = (int)$response->getHeaderLine('Content-Length'); 
     
        while ($amountToRead > 0 && !$body->eof()) {
            $data = $body->read(min($chunkSize, $amountToRead));
            print($data);
          
            $amountToRead -= mb_strlen($data, 'utf-8');
         
            if (connection_status() != CONNECTION_NORMAL) {
                break;
            }
        }
    }
}
