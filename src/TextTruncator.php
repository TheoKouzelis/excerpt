<?php namespace Kouz;

class TextTruncator
{
    protected $ending = "";
    protected $limit = 0;

    protected function isLimitLessThanCharCount($text)
    {
        return ($this->limit > 0 && $this->limit < strlen($text));
    }
    protected function isLimitLessThanWordCount($text)
    {
        return ($this->limit > 0 && $this->limit < str_word_count($text));
    }

    protected function isWholeNumber($number)
    {
        return (is_numeric($number) && floor($number) == $number);
    }

    public function limitChars($text)
    {
        $this->validateText($text);
        $text = $this->sanitizeText($text);

        if ($this->isLimitLessThanCharCount($text)) {
            return trim(substr($text, 0, $this->limit)) . $this->ending;
        } else {
            return $text;
        }
    }

    public function limitWords($text)
    {
        $this->validateText($text);
        $text = $this->sanitizeText($text);

        if ($this->isLimitLessThanWordCount($text)) {
            $words = explode(" ", $text);
            return implode(" ", array_splice($words, 0, $this->limit)) . $this->ending;
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

    protected function sanitizeText($text)
    {
        $text = trim($text);
        $text = preg_replace('/\s+/', ' ', $text);

        return $text;
    }

    protected function validateText($text)
    {
        if (!is_string($text)) {
            throw new \InvalidArgumentException("Text must be a string");
        }
    }
}
