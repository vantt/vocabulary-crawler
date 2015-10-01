<?php
namespace Vantt;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;

abstract class AbstractCrawler
{
    protected $word;

    protected $client;

    /**
     * Google constructor.
     * @param $word
     */
    public function __construct($word = NULL)
    {
        $this->word = $word;

        $this->client = new Client();
    }

    /**
     * @return mixed
     */
    public function getWord()
    {
        return str_replace(' ', '+', $this->word);
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
        try {
            $response = $this->getHTML();

            if ('200' == $response->getStatusCode()) {
                return str_replace(PHP_EOL, '', trim($this->parseHTML((string)$response->getBody()->getContents())));
            }
        }
        catch (ClientException $e) {

        }

        return '';
    }


    /**
     * @return Response
     */
    abstract public function getHTML();

    /**
     * @param $html
     */
    abstract public function parseHTML($html);
}