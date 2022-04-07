<?php
namespace onm;

use onm\TL1InterfaceResponse;

interface TL1Interface {
	public function login(string $username, string $password): TL1InterfaceResponse;
    public function lstDevice(array ...$args): TL1InterfaceResponse;
	public function lstUnregonu(): TL1InterfaceResponse;
	public function lstOnu(array ...$args): TL1InterfaceResponse;
	public function addOnu(array ...$args): TL1InterfaceResponse;
	public function delOnu(array ...$args): TL1InterfaceResponse;
    public function lstOmddm(array ...$args): TL1InterfaceResponse;
	public function cfgLanportvlan(array ...$args): TL1InterfaceResponse;
	public function cfgLanport(array ...$args): TL1InterfaceResponse;
    public function cfgVeipservice(array ...$args): TL1InterfaceResponse;
    public function cfgWifiservice(array ...$args): TL1InterfaceResponse;
    public function setWanservice(array ...$args): TL1InterfaceResponse;
}