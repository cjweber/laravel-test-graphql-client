<?php

namespace GraphQLTestClient;

/**
 * Class ResponseData
 *
 * @package GraphQLClient
 */
class ResponseData
{
    /** @var mixed */
    private $data;

    /** @var mixed */
    private $errors;

    /**
     * ResponseData constructor.
     *
     * @param mixed $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * ResponseData constructor with errors.
     *
     * @param mixed $data
     * @param mixed $errors
     * @return self
     */
    public static function withErrors($data, $errors)
    {
        $instance = new self($data);
        $instance->errors = $errors;
        return $instance;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
