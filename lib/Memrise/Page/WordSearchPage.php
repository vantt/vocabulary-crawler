<?php
namespace Vantt\Memrise\Page;

use Vantt\Memrise\CourseInfo;
use Vantt\Memrise\HttpRequestInterface;

class WordSearchPage extends BasePage
{
    private $word_position = NULL;
    private $course;
    private $word;

    /**
     * BasePage constructor.
     * @param HttpRequestInterface $http
     * @param CourseInfo $course
     * @param $word
     */
    public function __construct(HttpRequestInterface $http, CourseInfo $course, $word)
    {
        parent::__construct($http);
        $this->course = $course;
        $this->word = $word;
    }

    public function findTheWordPosition()
    {
        if (NULL === $this->word_position) {
            $this->sub_url = $this->course->getCourseDatabaseUri() . '?q=' . $this->word;

            $crawler = $this->getPageCrawler();
            $css_path = '#p' . $this->course->getDatabaseId() . ' table.pool-things > tbody > tr > td:nth-child(2) div.text';
            $word = $this->word;
            $position = NULL;

            $crawler->filter($css_path)->each(function ($node, $index) use ($word, &$position) {
                if ($word == $node->text()) {
                    $position = $index;

                }
            });

            if (NULL !== $position) {
                $this->word_position = $position;
            }
            else {
                $this->word_position = FALSE;
            }
        }

        return $this->word_position;
    }

    public function getThingId()
    {
        if (NULL === $this->word_position) {
            $this->sub_url = $this->course->getCourseDatabaseUri() . '?q=' . $this->word;

            $crawler = $this->getPageCrawler();

            // find the word position
            $css_path = '#p' . $this->course->getDatabaseId() . ' table.pool-things > tbody > tr';
            $word = $this->word;
            $tr_element = NULL;

            $crawler->filter($css_path)->each(function ($tr, $index) use ($word, &$tr_element) {
                $node = $tr->filter('td:nth-child(2) div.text');

                if ($node->count() && $word == $node->text()) {
                    $tr_element = $tr;
                    return;
                }
            });

            if (NULL !== $tr_element) {
                return $tr_element->attr('data-thing-id');
            }
        }

        return FALSE;
    }
}