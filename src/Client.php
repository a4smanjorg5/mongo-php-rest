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
        return \Illuminate\Support\Facades\Http::acceptJson()->post($this->dsn .
         "/action/$name", $post);
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
