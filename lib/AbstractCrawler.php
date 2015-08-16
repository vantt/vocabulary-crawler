<?php
namespace Vantt;

use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractCrawler
{
    protected $word;

    /**
     * Google constructor.
     * @param $word
     */
    public function __construct($word)
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
    public function getDefinition() {
        $html = $this->getHTML();
        return $this->parseHTML($html);
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