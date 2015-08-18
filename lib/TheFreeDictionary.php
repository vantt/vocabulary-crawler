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
        return $this->client->get($url);
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