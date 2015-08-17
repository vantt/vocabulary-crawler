<?php
namespace Vantt;

abstract class AbstractCrawler
{
    protected $word;

    /**
     * Google constructor.
     * @param $word
     */
    public function __construct($word = NULL)
    {
        $this->word = $word;
    }

    /**
     * @return mixed
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * @param mixed $word
     */
    public function setWord($word)
    {
        $this->word = $word;
    }

    /**
     * @return string
     */
    public function getDefinition($word) {
        $this->setWord($word);
        $html = $this->getHTML();
        return str_replace(PHP_EOL, '', trim($this->parseHTML($html)));
    }


    /**
     * @return string
     */
    abstract public function getHTML();

    /**
     * @param $html
     */
    abstract public function parseHTML($html);
}