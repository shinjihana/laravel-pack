<?php

namespace Happy\ThreadMan\Inspections;

use Exception;

class InvalidKeywords
{
    protected $keywords = [
        'yahoo customer'
    ];
    public function detect($body)
    {

        foreach ($this->keywords as $keyword) {
            // Check spam
            if (stripos($body, $keyword) !== false){
                throw new Exception('Your reply contains spam.');
            }
        }
    }
}