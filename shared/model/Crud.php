<?php

class Crud{
    private $tabela;
    private $message =  "";
    private $error = false;
    public function __construct($tabela){
        $this->tabela = $tabela;
    }
    public function select($campos = "*", $condicao = null){
        $conexao = Transaction::get();
        if (!$condicao){
            $sql = "SELECT $campos FROM $this->tabela";
        } else {
          $sql = "SELECT $campos FROM $this->tabela WHERE $condicao";
        }
        $resultado = $conexao->query($sql);
        if($resultado->rowCount() > 0){
            while($registros = $resultado->fetch(PDO::FETCH_ASSOC)){
                $lista[] = $registros;
            }
            return $lista;
        }else{
            $this->message = "Nenhum registro encontrado!";
            $this->error = true;
        }
    }
    public function insert ($campos = null, $valores = null){
        try{
            if(!$campos && !$valores){
                $this->message = "Condição não informada!";
                $this->error = true;
            }else{
                $conexao = Transaction::get();
                $sql = "INSERT INTO $this->tabela ($campos) VALUES ($valores)";
                $resultado = $conexao->query($sql);
                if ($resultado->rowCount() > 0) {
                    $this->message = "Inserido com sucesso!";
                    $this->error = false;
                } else {
                    $this->message = "Erro ao inserir!";
                    $this->error = true;
                }
            }
        }catch (Exception $e) {
            $this->message = $e->getMessage();
            $this->error = true;
        }
    }
    
    public function update($valores = NULL, $campos = NULL){
        if(!$valores || !$campos ){
            $this->message = "Condição não informada!";
            $this->error = true;
        }else{
            try{
            $conexao = Transaction::get();
            $sql = "UPDATE $this->tabela SET $valores WHERE $campos";
            $resultado = $conexao->query($sql);
            if($resultado->rowCount() > 0){
                $this->message = "Atualizado com sucesso!";
                $this->error = false;
            }else{
                $this->message = "Erro ao atualizar!";
                $this->error = true;
            }
            }catch(Exception $e){
                $this->message = $e->getMessage();
                $this->error = true;
            }
        }
    }
    public function delete($campos = NULL){
        if(!$campos){
            $this->message = "Condição não informada!";
            $this->error = true;
        }else{
            try{
            $conexao = Transaction::get();
            $sql = "DELETE FROM $this->tabela WHERE $campos";
            $resultado = $conexao->query($sql);
            if ($resultado->rowCount() > 0) {
                $this->message =  "Excluído com sucesso!";
                $this->error = false;
            } else {
                $this->message =  "Erro ao excluir!";
                $this->error = true;
            }
            }catch(Exception $e){
                $this->message = $e->getMessage();
                $this->error = true;
            }
          }
        }

    public function getMessage()
    {
        return $this->message;
    }
    public function getError()
    {
        return $this->error;
    }
}