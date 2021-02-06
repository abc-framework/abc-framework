<?php

namespace ABC\Domain\Ports;

use Abcsoft\DIC\Interfaces\LocatorInterface;
use Psr\Http\Message\RequestInterface;

interface CommandInterface extends LocatorInterface
{
    public function __construct(RequestInterface $request);
}