<?php namespace Kouz;

class Excerpt
{
    protected $ending = "";
    protected $limit = 0;

    protected function isLimitLessThanTextLength($text)
    {
        return ($this->limit > 0 && $this->limit < strlen($text));
    }

    protected function isWholeNumber($number)
    {
        return (is_numeric($number) && floor($number) == $number); 
    }

    public function limit($text)
    {
        if (!is_string($text)) {
            throw new \InvalidArgumentException("Text must be a string");
        }

        if ($this->isLimitLessThanTextLength($text)) {
            return trim(substr($text, 0, $this->limit)) . $this->ending;
        } else {
            return $text;
        }
    }

    public function setEnding($ending)
    {
        if (!is_string($ending)) {
            throw new \InvalidArgumentException("Ending must be a string");
        }

        $this->ending = $ending;
    }

    public function setLimit($limit)
    {
        if (!$this->isWholeNumber($limit)) {
            throw new \InvalidArgumentException("Limit must be a whole number");
        }

        $this->limit = $limit; 
    }
}
