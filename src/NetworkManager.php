<?php
namespace onm;

use onm\TL1Connection;

class NetworkManager {
    private $interface;

    public function __construct(string $ems, $port, string $username, string $password, string $ctag, string $interface)
    {
        $TL1Connection = new TL1Connection($ems, $port, $username, $password, $ctag);

        $this->interface = new $interface($TL1Connection);

        $this->interface->login($username, $password)->fail(function() {
            throw new \Exception('Login has failed. check the crendentials.', 401);
        });
    }

    public function lstDevice(...$args) {
        return $this->interface->lstDevice(...$args);
    }

    public function lstOnu(...$args) {
        return $this->interface->lstOnu(...$args);
    }

    public function lstUnregonu(...$args) {
        return $this->interface->lstUnregonu(...$args);
    }

    public function addOnu(...$args) {
        return $this->interface->addOnu(...$args);
    }

    public function delOnu(...$args) {
        return $this->interface->delOnu(...$args);
    }

    public function lstOmddm(...$args) {
        return $this->interface->lstOmddm(...$args);
    }

    public function cfgLanportvlan(...$arg) {
        return $this->interface->cfgLanportvlan(...$arg);
    }

    public function cfgLanport(...$args) {
        return $this->interface->cfgLanport(...$args);
    }

    public function cfgVeipservice(...$args) {
        return $this->interface->cfgVeipservice(...$args);
    }

    public function setWanservice(...$args) {
        return $this->interface->setWanservice(...$args);
    }

    public function addPonvlan(...$args) {
        return $this->interface->addPonvlan(...$args);
    }

    public function chgPortlocation(...$args) {
        return $this->interface->chgPortlocation(...$args);
    }
}