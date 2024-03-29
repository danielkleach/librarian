<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ErrorResponsesTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class Handler extends ExceptionHandler
{
    use ErrorResponsesTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        BookLookupFailureException::class,
        BookNotFoundException::class,
        HttpException::class,
        ItemUnavailableException::class,
        ItemAlreadyCheckedInException::class,
        ModelNotFoundException::class,
        UserAlreadyFavoritedException::class,
        UserAlreadyReviewedException::class,
        ValidationException::class,
        VideoLookupFailureException::class,
        VideoNotFoundException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
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
        if ($this->shouldReport($e)) {
            app('sentry')->captureException($e);
        }
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $response = parent::render($request, $e);

        $response = collect([
            AuthenticationException::class => $this->errorUnauthorized(),
            AuthorizationException::class => $this->errorForbidden(),
            BookLookupFailureException::class => $this->errorCustomType("There was a problem connecting to Google Books."),
            BookNotFoundException::class => $this->errorCustomType("No books were found matching this ISBN."),
            Exception::class => $this->errorInternalError(),
            HttpException::class => $this->errorForbidden(),
            InvalidItemTypeException::class => $this->errorCustomType("The item type provided is not valid."),
            ItemAlreadyCheckedInException::class => $this->errorCustomType("This item is already checked in."),
            ItemUnavailableException::class => $this->errorCustomType("This item is not available for checkout."),
            MaintenanceModeException::class => $this->errorServiceUnavailable(),
            ModelNotFoundException::class => $this->errorNotFound(),
            NotFoundHttpException::class => $this->errorNotFound(),
            ServiceUnavailableHttpException::class => $this->errorServiceUnavailable(),
            UserAlreadyFavoritedException::class => $this->errorCustomType("This item is already in your favorites."),
            UserAlreadyReviewedException::class => $this->errorCustomType("You have already left a review for this item."),
            VideoLookupFailureException::class => $this->errorCustomType("There was a problem connecting to TMDB."),
            VideoNotFoundException::class => $this->errorCustomType("No videos were found matching the term(s) given.")
        ])->get(get_class($e), $response);

        return $response;
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function unauthenticated($request, AuthenticationException $e)
    {
        return $this->errorUnauthorized();
    }
}
