<?php

namespace Happy\ThreadMan;

class Spam 
{

    public function detect($body)
    {
        //Detect invalid keywords.
        $this->detectInvalidKeywords($body);

        return false;
    }

    public function detectInvalidKeywords($body)
    {
        $invalidKeywords = [
            'yahoo customer'
        ];

        foreach ($invalidKeywords as $keyword) {
            // Check spam
            if (stripos($body, $keyword) !== false){
                throw (new Exception('Your reply contains spam.'));
            }
        }
    }
}