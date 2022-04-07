<?php
namespace onm;

class TL1InterfaceResponse {
    public $success;
    public $response;

    public function __construct(bool $success, $response, string $command)
    {
        $this->success = $success;
        $this->command = $command;
        $this->response = $response;
    }

    public function success($closure) 
    {
        if($this->success) $closure($this->response, $this->command);
        return $this->callback();
    }
    
    public function fail($closure) 
    {
        if(!$this->success) $closure($this->response, $this->command);
        return $this->callback();
    }

    public function get() 
    {
        if($this->success) return $this->response;
        return null;
    }
    
    private function callback() 
    {
        return $this;
    }
}