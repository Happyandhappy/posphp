<?php

class WebSocketUser {

  public $socket;
  public $id;
  public $userid = "";
  public $username = "";
  public $userkey = "";
  public $ipaddr = "";
  
  public $headers = array();
  public $handshake = false;

  public $handlingPartialPacket = false;
  public $partialBuffer = "";

  public $sendingContinuous = false;
  public $partialMessage = "";
  
  public $hasSentClose = false;

  function __construct($id, $socket) {
    $this->id = $id;
    $this->socket = $socket;
    socket_getsockname($socket, $this->ipaddr);
  }
}