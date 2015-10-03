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
        $options = ['debug' => true];
        $response = $this->client->get($full_url, $options);
        return $response->getBody()->getContents();
    }

    public function post($full_url, array $multi_parts = [], array $headers = [])
    {

        $options = ['debug' => true];

        // Grab the client's handler instance.
        $clientHandler = $this->client->getConfig('handler');

        // Create a middleware that echoes parts of the request.
        $tapMiddleware = Middleware::tap(function ($request) {
            echo $request->getHeader('Content-Type');
            // application/json
            echo $request->getBody();
            // {"foo":"bar"}
        });

        $options['handler'] = $tapMiddleware($clientHandler);

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

        $response = $this->client->post($full_url, $options);

        return $response->getBody()->getContents();
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