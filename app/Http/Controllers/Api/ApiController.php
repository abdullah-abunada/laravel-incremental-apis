<?php
/**
 * Created by PhpStorm.
 * User: abdullah
 * Date: 3/1/2016
 * Time: 5:12 PM
 */

namespace App\Http\Controllers\Api;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }


    public function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * @param $data
     * @param array $headers
     * @return \Response
     */
    public function respond($data, $headers = [])
    {
        return response($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param $message
     * @return \Response
     */
    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }

    /**
     * @param Paginator $paginator
     * @param $data
     * @return \Response
     */
    public function respondWithPagination(Paginator $paginator, $data)
    {

        $data = array_merge($data, [
            'pagination' => [
                'total_count' => $paginator->total(),
                'total_pages' => ceil($paginator->total() / $paginator->perPage()),
                'current_page' => $paginator->currentPage(),
                'limit' => $paginator->perPage(),
            ]
        ]);
        return $this->respond($data);
    }
}