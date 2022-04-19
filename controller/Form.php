<?php

class Form
{
  private $message = "";

  public function __construct(){
    Transaction::open();
  }
  public function controller()
  {
    $form = new Template("view/Form.html");
    $this->message = $form->saida();
  }
  public function salvar(){
    if(isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['telefone'])){
    try{
      $conexao = Transaction::get();
      $contatos = new Crud('contatos');
      $nome = $conexao->quote($_POST['nome']);
      $email = $conexao->quote($_POST['email']);
      $telefone = $conexao->quote($_POST['telefone']);
      $resultado = $contatos->insert("nome,email,telefone", "$nome, $email, $telefone");
    }catch(Exception $e){
      echo $e->getMessage();
    }
    }
  }
  public function getMessage()
  {
    return $this->message;
  }
  public function __destruct()
  {
    Transaction::close();
  }
}