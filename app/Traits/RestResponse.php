<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

use Symfony\Component\HttpFoundation\StreamedResponse;

use Throwable;
use Illuminate\Http\Response;

trait RestResponse
{
   /**
    * success
    *
    * @param  mixed $data
    * @param  mixed $code
    * @return mixed
    */
   public function success($data = [], $code = Response::HTTP_OK): mixed
   {
      return response()->json($data, $code);
   }


    /**
     * @param $data
     * @param $code
     * @return JsonResponse
     */
    public function response($data, $code = Response::HTTP_OK): JsonResponse
    {
      return response()->json(["data" => ($data) ? $data : []], $code);
   }


    /**
     * @param $message
     * @param $code
     * @return JsonResponse
     */
    public function information($message, $code = Response::HTTP_OK): JsonResponse
    {
      return response()->json([
         'timestamps' => date('Y-m-d H:i:s'),
         'path' => request()->path(),
         'detail' => $message,
         'code' => $code
      ], $code);
   }


    /**
     * @param $path
     * @param Throwable $exception
     * @param $message
     * @param $code
     * @return JsonResponse
     */
    public function error($path, Throwable $exception, $message, $code): JsonResponse
    {
       return response()->json([
         'timestamps' => date('Y-m-d H:i:s'),
         'path' => $path,
         'exception' =>  basename(str_replace('\\', '/', get_class($exception))),
         'detail' => $this->checkIsArray($message),
         'code' => $code
      ], $code);
   }


    /**
     * @param $path
     * @param $exception
     * @param $message
     * @param $code
     * @return JsonResponse
     */
    public function error_migration($path, $exception, $message, $code): JsonResponse
    {
/*
      return response()->json([
         'timestamps' => date('Y-m-d H:i:s'),
         'path' => $path,
         'exception' =>  $exception,
         'detail' => $this->checkIsArray($message),
         'code' => $code
      ], $code);
*/
      return response()->json([
         'timestamps' => date('Y-m-d H:i:s'),
         'path' => $path,
         'exception' =>  $exception,
         'detail' => $this->checkIsArray($message),
         'code' => $code
      ], $code);

   }

    /**
     * @param $path
     * @param $name
     * @return StreamedResponse
     */
    public function streamDownload($path, $name): StreamedResponse
    {
      return response()->streamDownload(function () use ($path) {
         echo file_get_contents($path);
      }, $name);
   }


    /**
     * @param $message
     * @return array
     */
    private function checkIsArray($message) : array
    {
      $messageArray = [];
      if (!is_array($message)) {
         $messageArray[] = $message;
         $message = $messageArray;
      }
      return collect($message)->unique()->values()->all();
   }

    /**
     * success
     *
     * @param  string|array $data
     * @param mixed $cookie
     * @param  int $code
     * @return JsonResponse
     */
    public function successCookie ($data = [], $cookie, $code = Response::HTTP_OK) : JsonResponse
    {
        return response()->json($data, $code)->withCookie($cookie);
    }

    /**
     * successStr
     *
     * @param  mixed $data
     * @param  mixed $code
     * @return mixed
     */
    public function successStr ($data = [], $code = Response::HTTP_OK) : mixed
    {
        return response($data, $code)->header('Content-Type', 'application/json');
    }

    /**
     * successStr
     *
     * @param $message
     * @param mixed $code
     * @return mixed
     */
    public function errorStr ($message, $code)  : mixed
    {
        return response($message, $code)->header('Content-Type', 'application/json');
    }

}
