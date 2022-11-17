<?php

    session_start();

    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once "configs/utils.php";
    require_once "configs/methods.php";

    require_once "model/Msg.php";
    require_once "model/User.php";

    if(!parametrosValidos($_SESSION, ["idUser"])){
        response(401, ["status" => "Você não está logado!"]); 
    }

    if(isMetodo("POST")){
        if(parametrosValidos($_POST, ["text"])){
            $text = $_POST["text"];
            $userId = $_SESSION["idUser"];

            if(User::exists($userId)){
                $result = Msg::create($text, $userId);
                if($result){
                    response(201, ["status"=> "OK",]);
                }
                response(500, ["status"=> "BAD"]);
            }
            response(400, ["status"=> "BAD"]);
        }
        response(400, ["status"=> "BAD"]);
    }

    if(isMetodo("GET")){
        $result = MSg::getAll();
        response(200, $result);
    }

    if(isMetodo("DELETE")){
        if(parametrosValidos($_DELETE, ["id"])){
            $id = $_DELETE["id"];

            $result = Msg::delete($id);
            if($result){
                response(201, ["status"=> "OK",]);
            }
            response(500, ["status"=> "BAD"]);
        }
        response(400, ["status"=> "BAD"]);
    }
    response(400, ["status"=> "BAD"]);

?>