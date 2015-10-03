<?php
/**
 * Created by PhpStorm.
 * User: vantt
 * Date: 9/24/2015
 * Time: 8:45 PM
 */

namespace Vantt\Memrise;

use GuzzleHttp\Client;
use GuzzleHttp\Middleware;

class HttpRequest implements HttpRequestInterface
{
    /**
     * @var Client
     */
    private $client;

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
     * @return string
     */
    public function get($full_url)
    {
        $response = $this->client->get($full_url, ['debug' => true]);
        return $response->getBody()->getContents();
    }

    public function post($full_url, array $multi_parts = array())
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


        $multi_part_vars = array();
        foreach ($multi_parts as $name => $data) {
            $multi_part_vars[] = array('name' => $name, 'contents' => $data);
        }


        $response = $this->client->post($full_url, array('multipart' => $multi_part_vars, 'debug' => true, 'handler' => $tapMiddleware($clientHandler),'headers' => ['Referer' =>  $full_url]));
        return $response->getBody()->getContents();
    }

    public function post2($full_url, array $form_params = array())
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
    }
}