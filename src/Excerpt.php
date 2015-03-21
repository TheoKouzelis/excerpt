<?php namespace Kouz;

class Excerpt
{
    protected $text = "";
    protected $ending = "";

    public function setEnding($ending)
    {
        if (!is_string($ending)) {
            throw new \InvalidArgumentException("Ending must be a string");
        }

        $this->ending = $ending;
    }

    public function setText($text)
    {
        if (!is_string($text)) {
            throw new \InvalidArgumentException("Text must be a string");
        }

        $this->text = $text; 
    }

    protected function isWholeNumber($number)
    {
        return (is_numeric($number) && floor($number) == $number); 
    }

    public function limit($limit = 0)
    {
        if (!$this->isWholeNumber($limit)) {
            throw new \InvalidArgumentException("Limit must be a whole number");
        }

        if ($limit > 0) {
            return substr($this->text, 0, $limit) . $this->ending;
        } else {
            return $this->text;
        }
    }
}
