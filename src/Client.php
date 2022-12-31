<?php

namespace MongoDB\AtlasRest;

class Client
{
    /**
     * The prefix url.
     * @var string
     */
    protected $dsn;

    /**
     * @param string $prefixUrl
     * @param string $name
     */
    public function __construct($prefixUrl)
    {
        $this->dsn = $prefixUrl;
    }

    /**
     * @param string $name
     * @return Collection
     */
    public function __get($name)
    {
        return $this->selectDatabase($name);
    }

    /**
     * @param string $name
     * @param array|object $post
     * @return mixed
     */
    public function action($name, $post)
    {
        $name = urlencode($name);
        $hasil = \Illuminate\Support\Facades\Http::acceptJson()->post($this->dsn .
         "/action/$name", $post);
        if (! $hasil->ok())
            switch ($hasil->status()) {
            case 400:
                throw new HttpExcept\BadRequestHttpException;
            case 401:
                throw new HttpExcept\UnauthorizedHttpException;
            case 403:
                throw new HttpExcept\AccessDeniedHttpException;
            case 404:
                throw new HttpExcept\NotFoundHttpException;
            case 405:
                throw new HttpExcept\MethodNotAllowedHttpException;
            case 406:
                throw new HttpExcept\NotAcceptableHttpException;
            case 409:
                throw new HttpExcept\ConflictHttpException;
            case 410:
                throw new HttpExcept\GoneHttpException;
            case 411:
                throw new HttpExcept\LengthRequiredHttpException;
            case 412:
                throw new HttpExcept\PreconditionFailedHttpException;
            case 415:
                throw new HttpExcept\UnsupportedMediaTypeHttpException;
            case 428:
                throw new HttpExcept\PreconditionRequiredHttpException;
            case 429:
                throw new HttpExcept\TooManyRequestsHttpException;
            case 503:
                throw new HttpExcept\ServiceUnavailableHttpException;
            default:
                throw new HttpExcept\HttpException('unknown error', $hasil->status());
            }
        return $hasil;
    }

    /**
     * @param string $name
     * @return Collection
     */
    public function selectCollection($databaseName, $collectionName)
    {
        return $this->selectDatabase($databaseName)->selectCollection($collectionName);
    }

    /**
     * @param string $name
     * @return Collection
     */
    public function selectDatabase($name)
    {
        return new Database($this, $name);
    }
}
