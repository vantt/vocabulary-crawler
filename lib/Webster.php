<?php
namespace Vantt;


use Exception;
use Symfony\Component\DomCrawler\Crawler;

class Webster extends AbstractCrawler
{
    /**
     * @return string
     */
    public function getHTML()
    {
        $url  = 'http://www.merriam-webster.com/dictionary/'.$this->getWord();
        return $this->client->get($url);
    }

    /**
     * @param $html
     * @return string
     */
    public function parseHTML($html)
    {
        $crawler = new Crawler($html);

        try {
            $item = $crawler->filter('.ld_on_collegiate');

            if ($item->count() == 0) {
                $item = $crawler->filter('.ssens');
            }

            if ($item->count()) {
                return trim(trim($item->text()), ':');
            }
        }
        catch (Exception $e) {
            return '';
        }

        return '';
    }

}