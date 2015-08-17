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
        $item = $crawler->filter('.ld_on_collegiate');

        if ($item->count() == 0) {
            $item = $crawler->filter('.ssens');
        }

        if ($item->count()) {
            return trim(trim($item->text()), ':');
        }

        return '';
    }

}