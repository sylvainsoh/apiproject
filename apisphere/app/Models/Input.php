<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Input extends Model
{

    private $content;

    public function __construct($content)
    {
        $this->content = $content;
        parent::__construct();
    }

    public function eachWordFirstChars($number)
    {
        $textTab = explode('-', $this->content);
        $output = '';
        foreach ($textTab as $str) {
            $output .= strtolower(substr($str, 0, $number));
        }
        return $output;
    }

    public function wordsCount()
    {
        return str_word_count($this->content);
    }

    public function lastWords()
    {
        $textTab=explode(' ',$this->content);
        return new Input($textTab[count($textTab)-1]);
    }

    public function __toString()
    {
        return $this->content;
    }
}
