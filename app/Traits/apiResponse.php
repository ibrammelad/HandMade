<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

trait apiResponse
{


    protected function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function showAll(Collection $collection, $code = 200, $perPage = 15)
    {
        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }

//        $collection = $this->paginate($collection, $perPage);

        return response()->json($collection, $code);
    }


    protected function showOne(Model $instance, $code = 200)
    {
        return $this->successResponse($instance, $code);
    }


    protected function errorResponse($message, $code)
    {
        return response()->json(['message' => $message, "code" => $code], $code);
    }


///// return message to show after operation
    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }



    protected function paginate(Collection $collection, $perPage)
    {
        $rules = [
            'perPage' => 'integer|min:2|max:50',
        ];
        Validator::validate(request()->all(), $rules);
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        if (request()->has('perPage')) {
            $perPage = request()->perPage;
        }
        $result = $collection->slice(($page - 1) * $perPage, $perPage);
        $paginator = new LengthAwarePaginator($result, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        $paginator->appends(request()->all());

        return $paginator;
    }



}





