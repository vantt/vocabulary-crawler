<?php
require './vendor/autoload.php';

use GuzzleHttp\Client;
use Vantt\Memrise\HttpRequest;
use Vantt\Memrise\Page\LoginPage;
use Vantt\Memrise\MoverCourse;
use Vantt\Memrise\Page\UploadPage;
use Vantt\Memrise\Page\WordSearchPage;

$client = new Client(['cookies' => true, 'track_redirects' => true, 'headers' => ['User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1']]);
$http = new HttpRequest($client);
$course = new MoverCourse();

$page = new LoginPage($http);
$page->doLogin();


$page = new WordSearchPage($http, $course, 'mammal');
$thing_id = $page->getThingId();
$csrf_token = $page->getCsrfToken();
$referer = $page->getFullUrl();
$page = new UploadPage($http);
$page->upload($csrf_token, $thing_id, 4, '/var/www/public/vocabulary-crawler/pictures/clothes/bag.jpg', $referer);

echo $html;