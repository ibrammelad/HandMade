<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
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
        $transformer = $collection->first()->transformer;

        // must be before transformData as it become non collection
//        $collection = $this->filterData($collection, $transformer);
//        $collection = $this->sortData($collection, $transformer);
        $collection = $this->paginate($collection, $perPage);
//       $collection = $this->transformData($collection, $transformer);
//        $collection = $this->cache($collection);

        return response()->json($collection, $code);
    }


    protected function showOne(Model $instance, $code = 200)
    {
        $transformer = $instance->transformer;

       // $instance = $this->transformData($instance, $transformer);

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


    /// ///// transformation for data for view
//    protected function transformData($data, $transformer)
//    {
//        $transformation = fractal($data, new $transformer);
//        return $transformation->toArray();
//    }


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
    /////////// to remember the data has operation some of time
//    protected function cache($data)
//    {
//        $url = request()->url();
//        $queryParams = request()->query();
//        ksort($queryParams);
//        $queryString = http_build_query($queryParams);
//        $fulUrl = "{$url}?{$queryString}";
//        return Cache::remember($fulUrl , 60 , function () use ($data) {
//            return $data ;
//        });
//    }

    //// search about common data  where x  = y
//    protected function filterData(Collection $collection, $transformer)
//    {
//        foreach (request()->query() as $index => $item)
//            $attribute = $transformer::originalAttribute($index);
//        if (isset($attribute, $item)) {
//            $collection = $collection->where($attribute, $item);
//        }
//
//        return $collection;
//    }

    ///// sort data by .....
//    protected function sortData(Collection $collection, $transformer)
//    {
//        if (request()->has('sort_by')) {
//            $attribute = $transformer::originalAttribute(request()->sort_by);
//            $collection = $collection->sortBy->{$attribute};
//        }
//        return $collection;
//    }



}
