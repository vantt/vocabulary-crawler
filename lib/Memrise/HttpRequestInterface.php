<?php
/**
 * Created by PhpStorm.
 * User: vantt
 * Date: 9/24/2015
 * Time: 8:46 PM
 */
namespace Vantt\Memrise;

use GuzzleHttp\Psr7\Response;

interface HttpRequestInterface
{
    /**
     * @param $full_url
     * @return $this
     */
    public function get($full_url);

    /**
     * @param $full_url
     * @param array $multi_parts
     * @param array $headers
     * @return Response
     */
    public function post($full_url, array $multi_parts = [], array $headers = []);

    /**
     * @return int
     */
    public function getStatusCode();

    /**
     * @return string
     */
    public function getResponseHTML();
}