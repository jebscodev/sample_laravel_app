<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($data, $code = 200) {
        return response()->json($data, $code);
    }

    public function sendError($data, $code = 404) {
        return response()->json($data, $code);
    }

    public function loggedInUser() {
        return auth('api')->user();
    }

    public function getCurDate() {
        date_default_timezone_set(env('APP_TZ'));
        return date("Y-m-d H:i:s");
    }

    public function formatDate($strdate) {
        return $strdate != null ? date("Y-m-d", strtotime($strdate)) : null;
    }

    public function getPercentage($part, $total) {
        return number_format(($part/$total)*100, 2).'%';
    }

    /**
     * Update single column by batch.
     *
     * @param  \App\Model  $model
     * @param  string $field
     * @param  string $value
     * @param  array $ids
     * @param  \App\Model  $collection
     */
    public function batchUpdate($model, $field, $value, $ids) {
        $rows = $model::whereIn('id', $ids)->get();
        $updated_rows = [];

        foreach ($rows as $row) {
            $row->$field = $value;
            $row->save();

            if ($row->wasChanged($field)) {
                $updated_rows[] = $row->id;
            }
        }

        return $model::whereIn('id', $updated_rows)->get();
    }
}
