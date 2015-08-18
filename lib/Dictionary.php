<?php
namespace Vantt;

use Symfony\Component\DomCrawler\Crawler;

class Dictionary extends AbstractCrawler
{
    /**
     * @return string
     */
    public function getHTML()
    {
        $url  = 'http://dictionary.reference.com/browse/'.$this->getWord();
        return $this->client->get($url);
    }

    /**
     * @param $html
     * @return string
     */
    public function parseHTML($html)
    {
        $crawler = new Crawler($html);
        return trim($crawler->filter('.def-list')->text());
    }

}