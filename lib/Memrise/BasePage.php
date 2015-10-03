<?php
namespace Vantt\Memrise;

use Symfony\Component\DomCrawler\Crawler;


class BasePage
{
    /**
     * @var HttpRequestInterface
     */
    protected $http;

    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * @var string
     */
    protected $base_url = 'http://www.memrise.com';

    /**
     * @var string
     */
    protected $sub_url;

    /**
     * @var string
     */
    protected $html;

    protected $csrf_token;

    /**
     * BasePage constructor.
     * @param $http
     */
    public function __construct(HttpRequestInterface $http)
    {
        $this->http = $http;
    }

    protected function getHtml()
    {
        if (!$this->html) {
            $this->html = $this->http->get($this->getFullUrl());
        }

        return $this->html;
    }

    public function getFullUrl() {
        return $this->base_url . $this->sub_url;
    }

    protected function getPageCrawler($reset = FALSE)
    {
        if (!$this->crawler || $reset) {
            $this->crawler = new Crawler($this->getHtml());
        }

        return $this->crawler;
    }

    public function getCsrfToken()
    {

        if (!$this->csrf_token) {
            $script = $this->getPageCrawler()->filter('body > script')->first()->text();
            $matches = array();
            preg_match('/csrftoken: "([^"]+)"/', $script, $matches);
            $this->csrf_token = $matches[1];
        }

        return $this->csrf_token;
    }
}