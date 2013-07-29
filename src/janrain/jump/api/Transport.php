<?php
namespace janrain\jump\api;

class HttpTransport
{
    protected $ctx;
    protected $resp;

    public function __construct($method)
    {
        $this->ctx = new \ArrayObject();
        $this->ctx['http'] = new \ArrayObject();
    }

    public function __invoke()
    {

    }

    public function addHeader()
    {

    }


    public function getHeaders()
    {

    }
}
