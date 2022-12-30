<?php

namespace MongoDB\AtlasRest;

class Database
{
    /**
     * The client instance.
     * @var Client
     */
    protected $connection;

    /**
     * The database name.
     * @var string
     */
    protected $name;

    /**
     * @param Client $connection
     * @param string $name
     */
    public function __construct($connection, $name)
    {
        $this->connection = $connection;
        $this->name = $name;
    }

    /**
     * @param string $name
     * @return Collection
     */
    public function __get($name)
    {
        return $this->selectCollection($name);
    }

    /**
     * @param string $name
     * @param array|object $post
     * @return mixed
     */
    public function action($name, $post)
    {
        $post['database'] = $this->name;
        return $this->connection->action($name, $post);
    }

    /**
     * @param string $name
     * @return Collection
     */
    public function selectCollection($name)
    {
        return new Collection($this, $name);
    }
}
