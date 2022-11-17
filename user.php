<?php

    session_start();

    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once "configs/utils.php";
    require_once "configs/methods.php";

    require_once "model/User.php";



    if(isMetodo("POST")){

        if(parametrosValidos($_SESSION, ["idUser"])){
            response(400, ["status" => "Negado! Você já está logado!"]);
        }

        if(parametrosValidos($_POST, ["login", "senha"])){
            $login = $_POST["login"];
            $senha = $_POST["senha"];

            $result = User::login($login, $senha);
            if(!$result){
                response(401, ["status" => "Usuário ou senha incorretos!"]);
            }

            $_SESSION["idUser"] = $result;

            response(200, ["status" => "Você está logado!"]);
        }

        if(parametrosValidos($_POST, ["nome", "login", "senha"])){
            $nome = $_POST["nome"];
            $login = $_POST["login"];
            $senha = $_POST["senha"];

            if(!User::isCreated($login)){
                $result = User::create($nome, $login, $senha);
                if($result){
                    response(201, ["status"=> "OK",]);
                }
                response(500, ["status"=> "BAD"]);
            }
            response(400, ["status"=> "BAD"]);
        }
    }

    if(isMetodo("GET")){

        if(parametrosValidos($_GET, ["logout"])){
            session_destroy();
            response(200, ["status" => "Deslogado!"]);
        }

        $users = User::getAll();
        response(200, $users);
    }

    if(isMetodo("PUT")){
        if(parametrosValidos($_PUT, ["id", "nome", "login", "senha"])){
            $nome = $_PUT["nome"];
            $login = $_PUT["login"];
            $senha = $_PUT["senha"];
            $id = $_PUT["id"];

            $result = User::update($id, $nome, $login, $senha);
            if($result){
                response(201, ["status"=> "OK",]);
            }
            response(500, ["status"=> "BAD"]);
        }
        response(400, ["status"=> "BAD"]);
    }

    if(isMetodo("DELETE")){
        if(parametrosValidos($_DELETE, ["login"])){
            $login = $_DELETE["login"];

            $result = User::delete($login);
            if($result){
                response(201, ["status"=> "OK",]);
            }
            response(500, ["status"=> "BAD"]);
        }
        response(400, ["status"=> "BAD"]);
    }
?>