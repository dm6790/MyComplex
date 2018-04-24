<?php

//namespace MyC\MyComplexException;
namespace MyC;
    /**
     * Created by PhpStorm.
     * User: WKR
     * Date: 02.12.2017
     * Time: 12:58
     */
    class MyComplexException extends \Exception
    {
        function __construct ($message = "", $code = 0, \Throwable $previous = null)
        {
            parent::__construct($message, $code, $previous);
        }
    }
