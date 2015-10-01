<?php
namespace Vantt\Memrise;

class WordSearchPage extends BasePage
{
    private $word_position;

    /**
     * BasePage constructor.
     * @param HttpRequestInterface $http
     * @param $word
     */
    public function __construct(HttpRequestInterface $http, $word)
    {
        parent::__construct($http);
        $this->sub_url = '/course/750913/movers-9/edit/database/786208/?q='.$word;
    }

    protected function findTheWordPosition() {

    }

    public function getThingId() {

    }


    public function doLogin()
    {
        $this->http->post($this->getFullUrl(), array('csrfmiddlewaretoken' => $this->getCsrfToken(), 'username' => 'vantt', 'password' => 'hsmmhkkm'));
    }
}