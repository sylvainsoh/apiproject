<?php

namespace App\Models;

class Input
{
    /**
     * Content of the input
     * 
     * @var string
     */
    private string $content;

    /**
     * Constructor
     * 
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * 
     * 
     * @param int $number
     * @return Input
     */
    public function eachWordFirstChars(int $number): Input
    {
        $textTab = explode('-', $this->content);
        $newContent = '';
        foreach ($textTab as $str) {
            $newContent .= strtolower(substr($str, 0, $number));
        }
        
        //Update content
        $this->content = $newContent;
        
        return $this;
    }

    /**
     * Count the words of the content
     * 
     * @return int
     */
    public function wordsCount(): int
    {
        return str_word_count($this->content);
    }

    /**
     * Get the last words of the content
     * 
     * @return Input
     */
    public function lastWords(): Input
    {
        $textTab=explode(' ',$this->content);
        
        $this->content = $textTab[count($textTab)-1];
        
        return $this;
    }

    /**
     * Override
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->content;
    }
}
