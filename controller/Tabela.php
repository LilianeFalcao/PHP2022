<?php
class Tabela
{
  private $message = "";
  public function controller()
  {
    $this->message = "Estou na Tabela";
  }
  public function getMessage()
  {
    return $this->message;
  }
}