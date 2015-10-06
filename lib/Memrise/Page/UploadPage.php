<?php
namespace Vantt\Memrise\Page;

use Vantt\Memrise\HttpRequestInterface;

class UploadPage extends BasePage
{
    /**
     * BasePage constructor.
     * @param HttpRequestInterface $http
     */
    public function __construct(HttpRequestInterface $http)
    {
        parent::__construct($http);
        $this->sub_url = '/ajax/thing/cell/upload_file/';
    }

    public function upload($csrf_token, $thing_id, $cell_id, $file_path)
    {
        $status = $this->http->post(
            $this->getFullUrl(),
            array(
                'csrfmiddlewaretoken' => $csrf_token,
                'thing_id' => (string)$thing_id,
                'cell_id' => (string)$cell_id,
                'cell_type' => 'column',
                'f' => ['contents' => fopen($file_path, 'r')] //'filename' => $filename,
            )
            //,['Referer' => $referer]
        )->getStatusCode();

        return (200 == $status);
    }


}