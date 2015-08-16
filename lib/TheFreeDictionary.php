<?php
namespace Vantt;


use Symfony\Component\DomCrawler\Crawler;

class TheFreeDictionary extends AbstractCrawler
{
    /**
     * @return string
     */
    public function getHTML()
    {
        $url  = 'http://www.thefreedictionary.com/'.$this->getWord();
        return file_get_contents($url);
    }

    /**
     * @param $html
     * @return string
     */
    public function parseHTML($html)
    {
        $crawler = new Crawler($html);
        return trim($crawler->filter('#Definition section')->first()->text());
    }

}