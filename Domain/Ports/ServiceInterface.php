<?php

namespace ABC\Domain\Ports;

use ABC\Domain\Ports\CommandInterface;

interface ServiceInterface
{
    /**
     * Основной метод, запускающий процессы формирования модели
     *
     * @param object $command
     *
     * @return $this
     */
    public function process(CommandInterface $command) : array;
    
}