<?php
/** @noinspection PhpUnused */
/** @noinspection PhpUndefinedMethodInspection */
/** @noinspection PhpUndefinedClassInspection */

namespace App\Http\Requests;

use Validator;

/**
 * Class PostColler
 * @package App\Http\Requests
 */
class PostCallerService {
    public $class;
    public $method;
    public $requestClass;
    public $data;
    public $requestSending;

    /**
     * PostColler constructor.
     * @param $class
     * @param $method
     * @param $requestClass
     * @param $data
     */
    public function __construct($class, $method, $requestClass, $data) {
        $this->class = $class;
        $this->method = $method;
        $this->requestClass = $requestClass;
        $this->data = $data;

        $this->requestSending = new $this->requestClass();
        $this->requestSending->replace($this->data);
    }

    /**
     * @return mixed
     */
    public function call() {
        $requestObject = new $this->requestClass;
        $requestData = $this->requestClass::createFromBase($this->requestSending);

        $validator = Validator::make($this->data, $requestObject->rules());

        if ($validator->fails()) {
            return false;
        }

        return app($this->class)->{$this->method}($requestData);
    }
}
