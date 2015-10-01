<?php
require './vendor/autoload.php';

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Vantt\Memrise\HttpRequest;
use Vantt\Memrise\LoginPage;
use Vantt\Memrise\AnphabePage;

$client = new Client(['cookies' => true, 'track_redirects' => true, 'headers' => ['User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1']]);
//$page = new AnphabePage(new HttpRequest($client));
$page = new LoginPage(new HttpRequest($client));
$html = $page->doLogin();

echo $html;