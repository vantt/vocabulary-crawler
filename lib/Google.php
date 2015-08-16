<?php
namespace Vantt;

use Symfony\Component\DomCrawler\Crawler;

class Google
{
    private $word;

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
    public function getHTML() {
        $url = 'https://www.google.com/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=define%20' . 'carpenter';
        return file_get_contents($url);
    }

    /**
     * @param $html
     */
    public function parseHTML($html) {
        echo 'asdfadsf'; exit;
        var_dump($html);
        $crawler = new Crawler($html);
    }
}