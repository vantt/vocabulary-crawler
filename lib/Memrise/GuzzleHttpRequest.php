<?php
namespace Vantt\Memrise;

use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;

define('GUZZLE_DEBUG', FALSE);

class GuzzleHttpRequest implements HttpRequestInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var Response
     */
    private $response;

    /**
     * HttpRequest constructor.
     * @param $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param $full_url
     * @return $this
     */
    public function get($full_url)
    {
        $options = ['debug' => GUZZLE_DEBUG];
        $this->response = $this->client->get($full_url, $options);
        return $this;
    }

    public function post($full_url, array $multi_parts = [], array $headers = [])
    {

        $options = ['debug' => GUZZLE_DEBUG];

        // Grab the client's handler instance.
        $clientHandler = $this->client->getConfig('handler');

        // Create a middleware that echoes parts of the request.
        $tapMiddleware = Middleware::tap(function ($request) {
            echo $request->getHeader('Content-Type');
            // application/json
            echo $request->getBody();
            // {"foo":"bar"}
        });

        //$options['handler'] = $tapMiddleware($clientHandler);

        $multi_part_vars = array();
        foreach ($multi_parts as $name => $data) {
            if (is_array($data)) {
                $data['name'] = $name;
            }
            else {
                $data = ['name' => $name, 'contents' => $data];
            }

            $multi_part_vars[] = $data;
        }

        $options['multipart'] = $multi_part_vars;

        //$options['headers'] = ['Referer' =>  $full_url];
        if (!empty($headers)) {
            $options['headers'] = $headers;
        }

        $this->response = $this->client->post($full_url, $options);

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode() {
        return $this->response->getStatusCode();
    }

    /**
     * @return string
     */
    public function getResponseHTML() {
        return $this->response->getBody()->getContents();
    }

    /*public function post2($full_url, array $form_params = array())
    {


        // Grab the client's handler instance.
        $clientHandler = $this->client->getConfig('handler');

        // Create a middleware that echoes parts of the request.
        $tapMiddleware = Middleware::tap(function ($request) {
            echo $request->getHeader('Content-Type');
            // application/json
            echo $request->getBody();
            // {"foo":"bar"}
        });

        $response = $this->client->post($full_url, array('form_params' => $form_params, 'debug' => true, 'handler' => $tapMiddleware($clientHandler), 'headers' => ['Referer' =>  $full_url]));
        return $response->getBody()->getContents();
    }*/
}