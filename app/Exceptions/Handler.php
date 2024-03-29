<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Stripe\Error as Stripe;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        if ($e instanceof TokenMismatchException){
            // Used when session times out and user tries to submit still
            return redirect()->back()->withInput()->with('error', 'Your session has expired please login');
        }
        if($e instanceof FileNotFoundException)
        {
            // Content not found flash notification to user to contact support
            flash()->overlay('Content does not exist please contact Tre-Uniti@belle-idee.org');
            return redirect()->back();
        }

        if ($e instanceof Stripe\Card)
        {
            flash()->overlay($e->getMessage() . ' Please click the Update Card button below.');
            return redirect()->back();
        }

        if ($e instanceof Stripe\RateLimit)
        {
            session()->flash('error_msg','It looks like our payment processor was busy. Please try again in a few minutes.');
            return redirect()->back();
        }

        if ($e instanceof Stripe\Api ||
            $e instanceof Stripe\ApiConnection ||
            $e instanceof Stripe\Authentication ||
            $e instanceof Stripe\InvalidRequest ||
            $e instanceof Stripe\Base)
        {
            session()->flash('error_msg',$e->getMessage());
            return redirect()->back();
        }
        return parent::render($request, $e);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }

}
