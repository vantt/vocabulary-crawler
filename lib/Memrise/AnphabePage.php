<?php
namespace Vantt\Memrise;

class AnphabePage extends BasePage
{


    /**
     * BasePage constructor.
     * @param HttpRequestInterface $http
     * @param $word
     */
    public function __construct(HttpRequestInterface $http)
    {
        parent::__construct($http);
        $this->base_url = 'http://www.vietnamworks.com';
        $this->sub_url = '/login';
    }

    protected function findTheWordPosition() {

    }

    public function getThingId() {

    }


    public function doLogin()
    {
        return $this->http->post($this->getFullUrl(), array('form[username]' => 'trantoanvan@yahoo.com', 'form[password]' => 'password', 'form[sign_in]' => ''));
    }
}