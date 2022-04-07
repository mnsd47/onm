<?php 
namespace onm;

use onm\TL1Interface;
use onm\TL1InterfaceResponse;

class Multilaser implements TL1Interface {    
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
        $payload = $payload ? $this->arrayToParameters($payload) : '';
        
		$command = "LST-DEVICE::{$target}:{$this->TL1Connection->ctag}::{$payload};";

        $response = $this->sendCommand($command);

        if($response['status'] == 'success')
        {
            $response['result'] = $this->parseResponse($response["result"], '/(.*) (\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}) (.*) (V\d{1,}\.\d{1,}\.\d{1,}) (.*)/iu');
        }

        return $this->response($response, $command);
    }

	public function lstUnregonu(array ...$args): TL1InterfaceResponse
    {
		@list($target, $payload) = $args;

		$target = $target ? $this->arrayToParameters($target) : '';

		$command = "LST-UNREGONU::{$target}:{$this->TL1Connection->ctag}::;";
			
        $response = $this->sendCommand($command);
        
		if($response['status'] == 'success')
        {
            $response['result'] = $this->parseResponse($response["result"], '/(.*) (.*) (.*) (.*) (\d{1,}-\d{1,}-\d{1,}-\d{1,}) (.*) (\d\d\d\d-\d\d-\d\d \d\d:\d\d:\d\d) (.*)/iu');
        }
        
        return $this->response($response, $command);
    }

	public function lstOnu(array ...$args): TL1InterfaceResponse
    {
		@list($target, $payload) = $args;

        $target = $target ? $this->arrayToParameters($target) : '';

        $payload = $payload ? $this->arrayToParameters($payload) : '';

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
        $payload = $payload ? $this->arrayToParameters($payload) : '';

		$command = "LST-OMDDM::{$target}:{$this->TL1Connection->ctag}::{$payload};";
		
        $response = $this->sendCommand($command);
        
        if($response['status'] == 'success')
        {
            $response['result'] = $this->parseResponse($response["result"], '/(\d+|\-\-) (\-?\d+\.\d+|\-\-) (\w+|\-\-) (\-?\d+\.\d+|\-\-) (\w+|\-\-) (\-?\d+\.\d+|\-\-) (\w+|\-\-) (\-?\d+\.\d+|\-\-) (\w+|\-\-) (\-?\d+\.\d+|\-\-) (\w+|\-\-) (\-?\d+\.\d+|\-\-) (\-?\d+\.\d+|\-\-)/iu');
			$response['result'] = $response['result'][0];
		}
        
        return $this->response($response, $command);
    }
	
	public function addOnu(array ...$args): TL1InterfaceResponse
    {
		@list($target, $payload) = $args;

        $target = $target ? $this->arrayToParameters($target) : '';
        $payload = $payload ? $this->arrayToParameters($payload) : '';

		$command = "ADD-ONU::{$target}:{$this->TL1Connection->ctag}::{$payload};";

        $response = $this->sendCommand($command);

        return $this->response($response, $command);
    }

	public function delOnu(array ...$args): TL1InterfaceResponse
    {
		@list($target, $payload) = $args;

        $target = $target ? $this->arrayToParameters($target) : '';
        $payload = $payload ? $this->arrayToParameters($payload) : '';

		$command = "DEL-ONU::{$target}:{$this->TL1Connection->ctag}::{$payload};";

        $response = $this->sendCommand($command);
		        
		return $this->response($response, $command);
    }

    public function cfgLanportvlan(array ...$args): TL1InterfaceResponse
    {
		@list($target, $payload) = $args;

        $target = $target ? $this->arrayToParameters($target) : '';
        $payload = $payload ? $this->arrayToParameters($payload) : '';

		$command = "CFG-LANPORTVLAN::{$target}:{$this->TL1Connection->ctag}::{$payload};";

        $response = $this->sendCommand($command);
        
		return $this->response($response, $command);
    }
    
	public function cfgLanport(array ...$args): TL1InterfaceResponse
    {
		@list($target, $payload) = $args;

        $target = $target ? $this->arrayToParameters($target) : '';
        $payload = $payload ? $this->arrayToParameters($payload) : '';

		$command = "CFG-LANPORT::{$target}:{$this->TL1Connection->ctag}::{$payload};";

        $response = $this->sendCommand($command);
        
		return $this->response($response, $command);
    }

	public function chgPortlocation(array ...$args): TL1InterfaceResponse
	{
		@list($target, $payload) = $args;

        $target = $target ? $this->arrayToParameters($target) : '';
        $payload = $payload ? $this->arrayToParameters($payload) : '';
		
		$command = "CHG-PORTLOCATING::{$target}:{$this->TL1Connection->ctag}::{$payload};";

        $response = $this->sendCommand($command);
        
		return $this->response($response, $command);
	}

	public function addPonvlan(array ...$args): TL1InterfaceResponse
    {
		@list($target, $payload) = $args;

        $target = $target ? $this->arrayToParameters($target) : '';
        $payload = $payload ? $this->arrayToParameters($payload) : '';

		$command = "ADD-PONVLAN::{$target}:{$this->TL1Connection->ctag}::{$payload};";

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

		// buffer of 1Mb
		while(($buffer .= $this->TL1Connection->read(1048576)) !== false)
		{
			$lines = explode("\n", $buffer);

			if($lines[count($lines) - 1] == ';') break;
		}

		$d = [
			"status" => "success",
			"result" => null,
			"message" => null,
			"error" => null
		];

		$response = [];

		foreach($lines as $line)
		{
			$line = trim($line);

			if(empty($line)) continue;
			
			if($line == '>' || $line == ';') continue; // remove sinais de controle

			$response[] = $line;
		}

		// format response message
		$response_header = trim($response[0]);
		$response_id = explode(' ', trim($response[1]));
		$response_status = trim($response[2]);
		$total_records = isset($response[3]) ? explode('totalrecord=', $response[3])[1] : null;


		if(isset($response_id[3]) && $response_id[3] != 'COMPLD') $d['status'] = 'failed';
		
		if(strpos($response_status, 'ENDESC=') !== false && strpos($response_status, 'ENDESC=No Error') == false) { 
			$d['status'] = 'failed';
			$d['error'] = explode('ENDESC=', $response_status)[1];
		}

		if(strpos($response_status, 'EADD=') !== false) {
			$d['status'] = 'failed';
			$d['message'] = explode('EADD=', $response_status)[1];
		}

        if($d['error'] == 'system operation failed') $d['status'] = 'failed';
		
		if($total_records != null) 
		{
			$records = [];
			
			// remove headers
			$fields = explode(' ',preg_replace("/\s+/", ' ', $response[6]));
			$records = array_slice($response, 7);
	
			$res = [
				'fields' => $fields, 
				'records' => []
			];
			
			foreach($records as $line)
			{
				if(strpos($line, 'M ') === 0 || strpos($line, 'WIN-') === 0) continue; // rmeove tl1 flags

				if(preg_match("/^\-+$/", $line)) continue; // remove end line -------------------

				$res["records"][] = preg_replace("/\s+/", ' ', $line);
			}
			
	
			$d["result"] = $res;
		}

		return $d;
    }
    
    public function parseResponse(array $r, string $regex): array
    {
        $p = [];

		if(is_null($r)) return null;

		foreach($r["records"] as $iResult => $result) 
		{
			$matches = [];
			$result = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $result); // remover caracteres utf-8
			preg_match($regex, $result, $matches);
			//$matches = explode('  ', $result);
			foreach($r["fields"] as $iField => $field) 
			{
				if(count($matches) > 0) {
					$p[$iResult][$field] = trim($matches[$iField+1]);
				}
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