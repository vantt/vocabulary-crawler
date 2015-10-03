<?php
namespace Vantt\Memrise;

abstract class CourseInfo
{
    private $course_id;
    private $course_name;
    private $database_id;

    /**
     * CourseInfo constructor.
     * @param $course_id
     * @param $course_name
     * @param $database_id
     */
    public function __construct($course_id, $course_name, $database_id)
    {
        $this->course_id = $course_id;
        $this->course_name = $course_name;
        $this->database_id = $database_id;
    }

    public function getCourseUri() {
        return '/course/'.$this->course_id.'/'.$this->course_name.'/';
    }

    public function getCourseDatabaseUri() {
        return '/course/'.$this->course_id.'/'.$this->course_name.'/edit/database/'.$this->database_id.'/';
    }

    /**
     * @return mixed
     */
    public function getCourseId()
    {
        return $this->course_id;
    }

    /**
     * @return mixed
     */
    public function getCourseName()
    {
        return $this->course_name;
    }

    /**
     * @return mixed
     */
    public function getDatabaseId()
    {
        return $this->database_id;
    }
}