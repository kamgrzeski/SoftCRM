<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Response
{
    public $successCode = 200;
    public $successCreatedCode = 201;
    public $acceptedCode = 202;
    public $noContent = 204;
    public $preconditionFailed = 412;
    public $unauthorized = 401;
    public $notFound = 404;

    public function jsonResponse(string $message, $content, int $statusCode, $microTime)
    {
        $errorType = $this->formatErrorType($statusCode);
        $responseTime = $this->formatMicroTime($microTime);

        $response = [
            ($errorType) => [
                'message' => $message,
                'data' => $content,
                'responseTime' => $responseTime,
                'statusCode' => $statusCode
            ]];

        if(empty($content)) {
            unset($response[$errorType]['data']);
        }

        return response()->json($response, $statusCode);
    }

    private function formatErrorType($statusCode)
    {
        if(Str::contains($statusCode, [$this->successCode, $this->successCreatedCode, $this->acceptedCode, $this->noContent])) {
            return 'success';
        } elseif(Str::contains($statusCode, [$this->preconditionFailed, $this->unauthorized, $this->notFound])) {
            return 'error';
        } else {
            return 'server error';
        }
    }

    private function formatMicroTime($endTime)
    {
        $microTime = microtime();
        $microTime = explode(' ', $microTime);
        $microTime = $microTime[1] + $microTime[0];
        $totalTime = round(($microTime - $endTime), 3);

        return $totalTime;
    }

    public function mergeTwoResponses(array $one, array $two)
    {
        return array_merge($one, $two);
    }
}
