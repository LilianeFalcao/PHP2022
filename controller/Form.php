<?php

class Form
{
  private $message = "";
  public function controller()
  {
    $form = new Template("view/Form.html");
    $this->message = $form->saida();
  }
  public function getMessage()
  {
    return $this->message;
  }
}