<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class OtpTimeoutException extends Exception
{
    private $timeLeft;

    public function __construct($timeLeft)
    {
        $this->timeLeft = $timeLeft;
        parent::__construct("OTP timeout. Please wait {$timeLeft} seconds.");
    }
    /**
     * Render the exception as an HTTP response.
     */
    public function render($request)
    {

        throw ValidationException::withMessages([
            'timeLeft' => $this->timeLeft
        ]);
    }
}
