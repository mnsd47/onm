<?php
namespace onm;

use onm\TL1Interface;
use onm\TL1InterfaceResponse;

class Fiberhome implements TL1Interface {
    private $TL1Connection;

    public function __construct(TL1Connection $TL1Connection)
    {
        $this->TL1Connection = $TL1Connection;
    }

	public function login(string $username, string $password): TL1InterfaceResponse
    {
        $command = "LOGIN:::{$this->TL1Connection->ctag}::UN={$username},PWD={$password};";

        return $this->response($this->sendCommand($command), $command);
    }

    public function lstDevice(array ...$args): TL1InterfaceResponse
    {
        @list($target, $payload) = $args;

        $target = $target ? $this->arrayToParameters($target) : '';
        $payload = $payload ? $this->arrayToParameters($payload): '';
        
		$command = "LST-DEVICE::{$target}:{$this->TL1Connection->ctag}::{$payload};";
		
        $response = $this->sendCommand($command);

        if($response['status'] == 'success')
        {
            $response['result'] = $this->parseResponse($response["result"], '/(.*) (.*) (.*) (.*)/iu');
        }

        return $this->response($response, $command);
    }

	public function lstUnregonu(array ...$args): TL1InterfaceResponse 
    {
		$command = "LST-UNREGONU:::{$this->TL1Connection->ctag}::;";

        $response = $this->sendCommand($command);
		
        if($response['status'] == 'success')
        {
            $response['result'] = $this->parseResponse($response["result"], '/(\d{1,}\.?\d{1,}\.?\d{1,}\.?\d{1,}) (\d{1,}) (\d{1,}) ([\w\d-]{1,}) (.*) (.*) (.*) (\d\d\d\d-\d\d-\d\d \d\d:\d\d:\d\d) (.*)/iu');
        }
        
        return $this->response($response, $command);
    }
	
	public function lstOnu(array ...$args): TL1InterfaceResponse
    {
        @list($target, $payload) = $args;

        $target = $target ? $this->arrayToParameters($target) : '';
        $payload = $payload? $this->arrayToParameters($payload) : '';

		$command = "LST-ONU::{$target}:{$this->TL1Connection->ctag}::$payload;";

        $response = $this->sendCommand($command);
        
		if($response['status'] == 'success')
        {
            $response['result'] = $this->parseResponse($response["result"], '/(\d{1,}\.?\d{1,}\.?\d{1,}\.?\d{1,}) (\d{1,}-\d{1,}-\d{1,}-\d{1,}) (\d{1,5}) ([\w\d\\-\s,\[\]\.\/&\(\)]{1,}) (--) ([\w\d-]{1,}) (.*) (.*) (.*) (.*) (.*) (.*)/iu');
        }
        
        return $this->response($response, $command);
    }
	
	public function lstOmddm(array ...$args): TL1InterfaceResponse
    {
        @list($target, $payload) = $args;

        $target = $target ? $this->arrayToParameters($target) : '';
        $payload = $payload? $this->arrayToParameters($payload) : '';

		$command = "LST-OMDDM::{$target}:{$this->TL1Connection->ctag}::{$payload};";

        $response = $this->sendCommand($command);
        
        if($response['status'] == 'success')
        {
            $response['result'] = $this->parseResponse($response["result"], '/(.*) (.*) (\w*) (.*) (\w*) (.*) (\w*) (.*) (\w*) (.*) (\w*) (.*) (.*)/iu');
            $response['result'] = $response['result'][0];
        }
        
        return $this->response($response, $command);
    }

	public function addOnu(array ...$args): TL1InterfaceResponse
    {
        @list($target, $payload) = $args;

        $target = $target ? $this->arrayToParameters($target) : '';
        $payload = $payload? $this->arrayToParameters($payload) : '';
        
		$command = "ADD-ONU::{$target}:{$this->TL1Connection->ctag}::{$payload};";

        $response = $this->sendCommand($command);

        return $this->response($response, $command);
    }

	public function delOnu(array ...$args): TL1InterfaceResponse
    {
        @list($target, $payload) = $args;

        $target = $target ? $this->arrayToParameters($target) : '';
        $payload = $payload? $this->arrayToParameters($payload) : '';

		$command = "DEL-ONU::{$target}:{$this->TL1Connection->ctag}::{$payload};";

        $response = $this->sendCommand($command);
        
		return $this->response($response, $command);
    }

	public function cfgLanportvlan(array ...$args): TL1InterfaceResponse
    {
        @list($target, $payload) = $args;

        $target = $target ? $this->arrayToParameters($target) : '';
        $payload = $payload? $this->arrayToParameters($payload) : '';

		$command = "CFG-LANPORTVLAN::{$target}:{$this->TL1Connection->ctag}::{$payload};";

        $response = $this->sendCommand($command);
        
		return $this->response($response, $command);
    }
	
	public function cfgLanport(array ...$args): TL1InterfaceResponse
    {
        @list($target, $payload) = $args;

        $target = $target ? $this->arrayToParameters($target) : '';
        $payload = $payload? $this->arrayToParameters($payload) : '';	

		$command = "CFG-LANPORT::{$target}:{$this->TL1Connection->ctag}::{$payload};";

        $response = $this->sendCommand($command);
        
		return $this->response($response, $command);
    }

    public function cfgVeipservice(array ...$args): TL1InterfaceResponse
    {
        @list($target, $payload) = $args;

        $target = $target ? $this->arrayToParameters($target) : '';
        $payload = $payload? $this->arrayToParameters($payload) : '';

		$command = "CFG-VEIPSERVICE::{$target}:{$this->TL1Connection->ctag}::{$payload};";

        $response = $this->sendCommand($command);
        
		return $this->response($response, $command);
    }

    public function cfgWifiservice(array ...$args): TL1InterfaceResponse
    {
        @list($target, $payload) = $args;

        $target = $target ? $this->arrayToParameters($target) : '';
        $payload = $payload? $this->arrayToParameters($payload) : '';

        $command = "CFG-WIFISERVICE::{$target}:{$this->TL1Connection->ctag}::{$payload};";

        $response = $this->sendCommand($command);
       
		return $this->response($response, $command);
    }

    public function setWanservice(array ...$args): TL1InterfaceResponse
    {
        @list($target, $payload) = $args;

        $target = $target ? $this->arrayToParameters($target) : '';
        $payload = $payload? $this->arrayToParameters($payload) : '';
		
        $command = "SET-WANSERVICE::{$target}:{$this->TL1Connection->ctag}::{$payload};";

        $response = $this->sendCommand($command);
        
		return $this->response($response, $command);
    }

    public function sendCommand(string $command): array 
    {
        $this->TL1Connection->write($command);
		$buffer = '';
		while(($byte = $this->TL1Connection->read(1)) !== false)
		{
			$chkEnd = trim(substr($buffer,strlen($buffer) - 20));
			if($byte == ';' && 
				(preg_match('/ENDESC=(.*)/', $buffer) ||
				$chkEnd == '--------------')
			) {
				if(false) {
					$this->TL1Connection->close();
				}

				$buffer .= $byte;

				break;
			}

			$buffer .= $byte;
		}
	
	 	$response = [];

		foreach(explode("\n",$buffer) as $line => $value)
		{
			if(!empty(trim($value))) $response[] = $value;
		}
	
		// format response message
		$header = trim($response[0]);
		$response_id = explode(" ",trim($response[1]));
		$response_block = trim($response[2]);

		$d = [
			"status" => "success",
			"result" => null,
			"message" => null,
			"error" => null
		];

		if($response_id[3] != "COMPLD") $d["status"] = "failed";
		
		if(strpos($response_block,"EADD=") !== false) $d["error"] = explode("EADD=",$response_block)[1];

		if(strpos($response_block,"EADD=") !== false) $d["message"] = explode("EADD=",$response_block)[1];

		if(strpos($response_block,"total_blocks=") !== false) 
		{
			$total_blocks = explode("total_blocks=",trim($response[2]));
			$total_blocks = isset($total_blocks[1])?$total_blocks[1]:0;
			if($total_blocks > 0) 
			{
				$blocks = explode("--------------------------------------------------------------------------------",$buffer);
				$res = ["fields"=>[], "records"=>[]];
				for($block = 1;$block < count($blocks);$block+=2) 
				{
					$lines = explode("\n",trim($blocks[$block]));
					$res["fields"] = explode(" ",preg_replace("/\s+/"," ",trim($lines[0])));

					for($line = 1;$line<count($lines);$line++) 
					{
						$res["records"][] = preg_replace("/\s/"," ",trim($lines[$line]));
					}
				}
				$d["result"] = $res;
			}
		}
		return $d;
    }
    
    public function parseResponse(array $r, string $regex): array
    {
        $p = [];
		foreach($r["records"] as $iResult => $result) 
		{
			$matches = [];
			$result = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $result); // remover caracteres utf-8
			preg_match($regex,$result,$matches);
			foreach($r["fields"] as $iField => $field) 
			{
				if(count($matches)>0) $p[$iResult][$field] = trim($matches[$iField+1]);
			}
		}
		return array_values($p);
    }

	private function response(array $response, string $command): TL1InterfaceResponse 
    {
        if($response['status'] == 'success') return new TL1InterfaceResponse(true, $response['result'], $command);

        return new TL1InterfaceResponse(false, $response['error'], $command);
    }

    private function arrayToParameters(array $arr): string 
    {
        $parameters = '';
        $index = 0;
        foreach($arr as $key => $value)
        {
            $parameters .= ($index == 0?'':',')."{$key}=$value";
            $index++;
        }

        return $parameters;
    }
}