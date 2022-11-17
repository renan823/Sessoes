<?php
    require_once __DIR__."/../configs/BancoDados.php";

    class Msg{
        public static function create($text, $idUser){
            try{
                $conexao = Conexao::getConexao();
                $stmt = $conexao->prepare("insert into msg(texto, data, idUser) values(?, now(), ?)");
                $stmt->execute([$text, $idUser]);
                if($stmt->rowCount()){
                    return true;
                }
                return false;
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public static function getAll(){
            try{
                $conexao = Conexao::getConexao();
                $stmt = $conexao->prepare("select * from msg order by data");
                $stmt->execute();
                return $stmt->fetchAll();
            }
            catch(Exception $e){
                echo $e;
            }
        }

        public static function delete($id){
            try{
                $conexao = Conexao::getConexao();
                $stmt = $conexao->prepare("delete from msg where id=?");
                $stmt->execute([$id]);
                if($stmt->rowCount()){
                    return true;
                }
                return false;
            }
            catch(Exception $e){
                echo $e;
            }
        }
    }
?>