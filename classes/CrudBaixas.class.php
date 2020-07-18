<?php

    require_once "conexao/conexao.php";
    if(session_status() !== PHP_SESSION_ACTIVE) { 
        session_start(); 
    } 
    Class Baixas{
        //select 
        public function selectBaixas(){

            $pdo = conexao();
            $result = array();
            $select = $pdo->query("SELECT * FROM baixas INNER JOIN estoque ON idestoque = estoque_idestoque 
            INNER JOIN componentes ON idcomponentes = componentes_idcomponentes ORDER BY nome");
            $result = $select->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        }
        //pesquisa o nome desejado
        public function pesquisar($name){

            $pdo = conexao();
            $result = array();
            $select = $pdo->query("SELECT * FROM baixas INNER JOIN estoque ON idestoque = estoque_idestoque 
            INNER JOIN componentes ON idcomponentes = componentes_idcomponentes WHERE nome LIKE '".$name."%'");
            $result = $select->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        }
        //select limit
        public function selectBaixasLimit($inicio, $limit){

            $pdo = conexao();
            $result = array();
            $select = $pdo->query("SELECT nome, qtdBaixas, quantidade, motivo, data  FROM baixas INNER JOIN estoque ON 
            idestoque = estoque_idestoque INNER JOIN componentes ON 
            idcomponentes = componentes_idcomponentes ORDER BY nome LIMIT $inicio, $limit");
            $result = $select->fetchAll(PDO::FETCH_ASSOC);
            return $result;
  
        }
        //select por id
        public function selectId($id){

            $pdo = conexao();
            $result = array();
            $select = $pdo->prepare("SELECT * FROM baixas INNER JOIN estoque ON 
            idestoque = estoque_idestoque INNER JOIN componentes ON 
            idcomponentes = componentes_idcomponentes AND idbaixas = :id");
            $select->bindValue('id', $id);
            $select->execute();
            $result = $select->fetch(PDO::FETCH_ASSOC);
            return $result;
  
        }
        public function selectQuantidade($idestoque){

            $pdo = conexao();

            $select = $pdo->query("SELECT quantidade FROM estoque WHERE idestoque = $idestoque");
            $result = $select->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            
        }
        //ataliza a quantidade da tabela estoque
        public function atualizaQuantidade($result, $idestoque){

            $pdo = conexao();

            $update = $pdo->prepare("UPDATE estoque SET quantidade = :quantidade WHERE  idestoque = :idestoque");
            $update->bindValue('quantidade', $result);
            $update->bindValue('idestoque', $idestoque);
            $update->execute();

        }
        //insert
        public function insertBaixas($observacao, $data, $quantidade, $idestoque){

            $pdo = conexao();
            //verificando se o componente ja foi cadastrado    
            $select = $pdo->prepare("SELECT nome FROM estoque INNER JOIN componentes ON idcomponentes = 
            componentes_idcomponentes INNER JOIN baixas ON idestoque = estoque_idestoque 
            WHERE idestoque = :idestoque");
            $select->bindValue('idestoque', $idestoque);
            $select->execute();
  
            if ($select->rowCount() > 0) { // componente já existe no DB
                return false;
            } else { // componente não existe no DB

                //update
                $total = $this-> selectQuantidade($idestoque);

                foreach ($total as $key => $value) {
                    
                    $result = intval($value['quantidade']) - $quantidade;
                    $this->atualizaQuantidade($result, $idestoque);

                }
                
                //insert
                $insert = $pdo->prepare("INSERT INTO baixas(motivo, qtdBaixas, data, estoque_idestoque) 
                VALUES (:observacao, :qtdBaixas, :data, :idestoque)");
                $insert->bindValue('observacao', $observacao);
                $insert->bindValue('qtdBaixas', $quantidade);
                $insert->bindValue('data', $data);
                $insert->bindValue('idestoque', $idestoque);
                $insert->execute();
                
                return true;
            }
        }
        // update
        public function atualiza($observacao, $data, $quantidade, $id_update){

            $pdo = conexao();
            $update = $pdo->prepare("UPDATE baixas INNER JOIN estoque ON idestoque = estoque_idestoque 
            AND idbaixas = :id SET motivo = :observacao, data = :data, quantidade = :quantidade");
            $update->bindValue('id', $id_update);
            $update->bindValue('observacao', $observacao);
            $update->bindValue('data', $data);
            $update->bindValue('quantidade', $quantidade);
            $update->execute();

            return true;

        }
        //delete
        public function deleteBaixas($idBaixas){

            $pdo = conexao();
            $delete = $pdo->prepare("DELETE FROM baixas WHERE idbaixas = :idbaixas");
            $delete->bindValue('idbaixas', $idBaixas);
            $delete->execute();
        }
    }
?>