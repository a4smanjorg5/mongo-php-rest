<?php

namespace MongoDB\AtlasRest;

class Collection
{
    /**
     * The database instance.
     * @var Database
     */
    protected $db;

    /**
     * The collection name.
     * @var string
     */
    protected $name;

    /**
     * @param Database $connection
     * @param string $name
     */
    public function __construct($database, $name)
    {
        $this->db = $database;
        $this->name = $name;
    }

    /**
     * Finds a single document matching the query.
     * @param array|object $filter
     * @param array $options Optional. An array specifying the desired options
     * @return mixed
     *
     * @throws UnsupportedException if options are used and not supported by the selected server (e.g. collation, readConcern, writeConcern).
     * @throws InvalidArgumentException for errors related to the parsing of parameters or options.
     */
    public function findOne($filter = [], $options = [])
    {
        return $this->aksi(array_merge(array('filter' => $filter), $options), __FUNCTION__);
    }

    /**
     * Finds documents matching the query.
     * @param array|object $filter
     * @param array $options Optional. An array specifying the desired options
     * @return array
     *
     * @throws UnsupportedException if options are used and not supported by the selected server (e.g. collation, readConcern, writeConcern).
     * @throws InvalidArgumentException for errors related to the parsing of parameters or options.
     */
    public function find($filter = [], $options = [])
    {
        return $this->aksi(array_merge(array('filter' => $filter), $options), __FUNCTION__);
    }

    /**
     * Insert one document.
     * @param array|object $document
     * @param array $options Optional. An array specifying the desired options
     * @return object
     *
     * @throws InvalidArgumentException for errors related to the parsing of parameters or options.
     */
    public function insertOne($document, $options = [])
    {
        return $this->aksi(array_merge(array('document' => $document), $options), __FUNCTION__);
    }

    /**
     * Insert multiple documents.
     * @param array $documents
     * @param array $options Optional. An array specifying the desired options
     * @return object
     *
     * @throws InvalidArgumentException for errors related to the parsing of parameters or options.
     */
    public function insertMany($documents, $options = [])
    {
        return $this->aksi(array_merge(array('documents' => $documents), $options), __FUNCTION__);
    }

    /**
     * Update at most one document that matches the filter criteria. If multiple documents match the filter criteria, only the first matching document will be updated.
     * @param array|object $filter
     * @param array|object $update
     * @param array $options Optional. An array specifying the desired options
     * @return object
     *
     * @throws UnsupportedException if options are used and not supported by the selected server (e.g. collation, readConcern, writeConcern).
     * @throws InvalidArgumentException for errors related to the parsing of parameters or options.
     */
    public function updateOne($filter, $update, $options = [])
    {
        return $this->aksi(array_merge(array('filter' => $filter,
         'update' => $update), $options), __FUNCTION__);
    }

    /**
     * Update all documents that match the filter criteria.
     * @param array|object $filter
     * @param array|object $update
     * @param array $options Optional. An array specifying the desired options
     * @return object
     *
     * @throws UnsupportedException if options are used and not supported by the selected server (e.g. collation, readConcern, writeConcern).
     * @throws InvalidArgumentException for errors related to the parsing of parameters or options.
     */
    public function updateMany($filter, $update, $options = [])
    {
        return $this->aksi(array_merge(array('filter' => $filter,
         'update' => $update), $options), __FUNCTION__);
    }

    /**
     * Deletes at most one document that matches the filter criteria. If multiple documents match the filter criteria, only the first matching document will be deleted.
     * @param array|object $filter
     * @param array $options Optional. An array specifying the desired options
     * @return object
     *
     * @throws UnsupportedException if options are used and not supported by the selected server (e.g. collation, readConcern, writeConcern).
     * @throws InvalidArgumentException for errors related to the parsing of parameters or options.
     */
    public function deleteOne($filter, $options = [])
    {
        return $this->aksi(array_merge(array('filter' => $filter), $options), __FUNCTION__);
    }

    /**
     * Deletes all documents that match the filter criteria.
     * @param array|object $filter
     * @param array $options
     * @return object
     *
     * @throws UnsupportedException if options are used and not supported by the selected server (e.g. collation, readConcern, writeConcern).
     * @throws InvalidArgumentException for errors related to the parsing of parameters or options.
     */
    public function deleteMany($filter, $options = [])
    {
        return $this->aksi(array_merge(array('filter' => $filter), $options), __FUNCTION__);
    }

    /**
     * Executes an aggregation framework pipeline operation on the collection.
     * @param array $pipeline Specifies an aggregation pipeline operation.
     * @param array $options Optional. An array specifying the desired options.
     * @return array
     *
     * @throws UnsupportedException if options are used and not supported by the selected server (e.g. collation, readConcern, writeConcern).
     * @throws InvalidArgumentException for errors related to the parsing of parameters or options.
     */
    public function aggregate($pipeline, $options = [])
    {
        return $this->aksi(array_merge(array('pipeline' => $pipeline), $options), __FUNCTION__);
    }

    private function aksi($kueri, $method)
    {
        $kueri['collection'] = $this->name;
        $hasil = $this->db->action($method, $kueri);
        if (! $hasil->ok())
<<<<<<< HEAD
            return $hasil->body();
=======
            throw new \Exception($hasil->body());
>>>>>>> 96b4a92c3b4e00771c9da6d6f477072aec020c65
        $hasil = $hasil->json();
        switch ($method) {
        case 'findOne':
        case 'find':
        case 'aggregate':
            $hasil = array_values((array)$hasil)[0];
            break;
        }
        return $hasil;
    }
}
