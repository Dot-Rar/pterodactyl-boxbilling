<?php
namespace Box\Mod\Pterodactyl;

class Service {

  protected $di;

  public function setDi($di) {
    $this->$di = $di;
  }
}
