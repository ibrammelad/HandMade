<?php

namespace App\Exceptions;
 use Illuminate\Auth\Access\AuthorizationException;
 use Illuminate\Auth\AuthenticationException;
 use Illuminate\Database\Eloquent\ModelNotFoundException;
 use Illuminate\Database\QueryException;
 use Illuminate\Session\TokenMismatchException;
 use Illuminate\Validation\ValidationException;
 use SebastianBergmann\Timer\TimeSinceStartOfRequestNotAvailableException;
 use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

 trait  ExceptionsTrait
 {
     public function apiException($exception , $request)
     {
         if ($this->isModel($exception)) {
             return $this->ModelResponse($exception);
         }

         if ($this->isHTTP($exception)) {
             return  $this->HTTPResponse($exception);

         }
         if ($exception instanceof TokenMismatchException)
         {
             return redirect()->back()->withInput($request->input());
         }

         if ($exception instanceof AuthenticationException) {
             return response()->json('UnAuthentication');
         }
         if ($exception instanceof AuthorizationException) {
             return response()->json('UnAuthorization' ,404);
         }

         if ($exception instanceof QueryException) {
             $errorCode = $exception->errorInfo[1];

             if ($errorCode == 1451) {
                 return response()->json('Cannot remove this resource permanently. It is related with any other resource', 409);
             }
         }
         return Parent::render($request , $exception);

     }


     public function isModel($exception)
     {
         return $exception instanceof ModelNotFoundException;
      }

     public function isHTTP($exception)
     {
         return $exception instanceof NotFoundHttpException;
      }

     public function ModelResponse($ex)
     {
         return response()->json(['errors' => 'Model not found'], 404);
      }

     public function HTTPResponse($ex)
     {
        return response()->json(['errors' => 'Route not correct'], 404);
     }



 }
