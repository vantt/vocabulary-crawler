<?php
namespace Vantt;

use Symfony\Component\DomCrawler\Crawler;

class Google extends AbstractCrawler
{
    /**
     * @return string
     */
    public function getHTML() {
        return file_get_contents('https://www.google.com/search?q=define+'.$this->getWord());
    }

    /**
     * @param $html
     * @return string
     */
    public function parseHTML($html) {
        $crawler = new Crawler($html);
        return trim($crawler->filter('#ires table')->text());
    }
}