<?php
namespace Vantt;


use Symfony\Component\DomCrawler\Crawler;

class Webster extends AbstractCrawler
{
    /**
     * @return string
     */
    public function getHTML()
    {
        $url  = 'http://www.merriam-webster.com/dictionary/'.$this->getWord();
        return file_get_contents($url);
    }

    /**
     * @param $html
     * @return string
     */
    public function parseHTML($html)
    {
        $crawler = new Crawler($html);
        return trim(trim($crawler->filter('.ld_on_collegiate')->text()), ':');
    }

}