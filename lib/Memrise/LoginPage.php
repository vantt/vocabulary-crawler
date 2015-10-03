<?php
namespace Vantt\Memrise;

class LoginPage extends BasePage
{
    /**
     * BasePage constructor.
     * @param HttpRequestInterface $http
     */
    public function __construct(HttpRequestInterface $http)
    {
        parent::__construct($http);
        $this->base_url = 'https://www.memrise.com';
        $this->sub_url = '/login/';
    }

    public function doLogin()
    {
        $csrf_token = $this->getCsrfToken();
        echo $csrf_token;
        return $this->http->post($this->getFullUrl(), array('csrfmiddlewaretoken' => $csrf_token, 'username' => 'vantt', 'password' => 'hsmmhkkm', 'next' => ''), ['Referer' => $this->getFullUrl()]);
    }
}