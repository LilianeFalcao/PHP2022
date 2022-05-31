<?php

class Form
{
  private $message = "";
  private $error = "";

  public function __construct(){
    Transaction::open();
  }
  public function controller()
  {
    $form = new Template("restrict/view/Form.html");
    $form-> set("id", "");
    $form -> set("nome", "");
    $form -> set("email", "");
    $form -> set("telefone", "");
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
      if(empty( $_POST["id"])){
        $contatos->insert("nome,email,telefone", "$nome, $email, $telefone");
      }else{
        $id = $conexao->quote($_POST['id']);
        $contatos->update("nome =  $nome, email = $email, telefone = $telefone", "id=$id" );
      }
    }catch(Exception $e){
      echo $e->getMessage();
    }
    }
  }
  public function editar(){
    if(isset($_GET['id'])){
      try{
        $conexao = Transaction::get();
        $id = $conexao->quote($_GET['id']);
        $contatos = new Crud('contatos');
        $resultado = $contatos->select("*", "id=$id");
        $form = new Template("view/Form.html");
        foreach ($resultado[0] as $cod => $valor) {
          $form->set($cod, $valor);
        }
        $this->message = $form->saida();
      }catch (Exception $e) {
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