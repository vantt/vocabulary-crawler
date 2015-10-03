<?php
/**
 * Created by PhpStorm.
 * User: vantt
 * Date: 9/24/2015
 * Time: 8:46 PM
 */
namespace Vantt\Memrise;

interface HttpRequestInterface
{
    /**
     * @param $full_url
     * @return string
     */
    public function get($full_url);

    public function post($full_url, array $multi_parts = [], array $headers = []);
}