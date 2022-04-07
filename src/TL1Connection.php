<?php
namespace onm;

class TL1Connection {
    public $host;
    public $port;
    public $username;
    private $password;
    public $ctag;

    protected $conn;

    public function __construct(string $host, $port, string $username, string $password, string $ctag)
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->ctag = $ctag;

        $this->open();
    }

    public function open() 
    {
		$this->conn = @fsockopen($this->host, $this->port, $errno, $errstr, 10);

		if(!$this->conn) 
        {
            throw new \Exception(sprintf('Unable to connect to ems %s:%s. check the address is correctly.', $this->host, $this->port), 503);

            return false;
        }

        return true;
    }

    public function write(string $payload)
    {
        return fwrite($this->conn, $payload);
    }

    public function read(int $length)
    {
        return fread($this->conn, $length);
    }

    public function close() 
    {
        fclose($this->conn);
    }
}