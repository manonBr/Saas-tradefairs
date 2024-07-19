<?php
namespace App\Exceptions;

use Exception;

class WithArgumentException extends Exception
{
    public function __construct($message, $additionnalInfo=false)
    {
        $this->additionnalInfo = $additionnalInfo;

        parent::__construct($message);
    }

    /**
     * Return the value of our beep variable
     * @return bool
     */
    public function getAdditionnalInfo()
    {
        return $this->additionnalInfo;
    }
}