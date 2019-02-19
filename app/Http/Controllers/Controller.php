<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var bool
     */
    protected $noCompact = false;

    /**
     * Returns JSON Response in a valid JSON API v1 format
     *
     * @link https://jsonapi.org/format/
     * @param array $data
     * @param array $errors
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function json($data = [], $errors = [], $status = 200)
    {
        if ($this->noCompact) {
            return response()
                ->json(array_merge($data, compact('errors', 'status')));
        }

        return response()
            ->json(compact('data', 'errors', 'status'));
    }

}
