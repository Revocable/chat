<?php

session_start();

require_once "./config/utils.php";
require_once "./config/verbs.php";
require_once "./config/header.php";
require_once "./model/Mensagem.php";
require_once "./model/Usuario.php";
$usuario = idUsuarioLogado();
if (isMetodo("GET")) {
    try {
        if (parametrosValidos($_GET, ["logout"])) {
            if (!$usuario) {
                throw new Exception("Usuário não está logado", 401);
            }
            session_destroy();
            output(200, ["msg" => "Deslogado com sucesso"]);
        } else {
            $usuario = Usuario::listarUsuarios();
            output(200, $usuario);
        }
    } catch (Exception $e) {
        output($e->getCode(), ["msg" => $e->getMessage()]);
    }


}

if (isMetodo("POST")) {
    try {
        $usuario = idUsuarioLogado();

        if (parametrosValidos($_POST, ["signup", "login", "nome", "senha"])) {
            if (Usuario::existLogin($_POST["login"])) {
                throw new Exception("Este login já existe", 400);
            }

            $res = Usuario::add($_POST["nome"], $_POST["senha"], $_POST["login"]);
            if (!$res) {
                throw new Exception("Erro no cadastro", 500);
            }
            output(200, ["msg" => "Cadastro realizado com sucesso"]);
        }

        if (parametrosValidos($_POST, ["login", "senha"])) {
            if ($usuario) {
                throw new Exception("Você está logado e não pode fazer isso", 400);
            }

            if (!Usuario::existLogin($_POST["login"])) {
                throw new Exception("Este login não existe", 400);
            }

            $res = Usuario::getLogin($_POST["login"], $_POST["senha"]);
            if (!$res) {
                throw new Exception("Login ou senha inválida", 400);
            }
            setIdUsuarioLogado($res["id"]);
            output(200, ["msg" => "Login realizado com sucesso"]);
        }



        throw new Exception("Requisição não reconhecida", 400);
    } catch (Exception $e) {
        output($e->getCode(), ["msg" => $e->getMessage()]);
    }
} else {
    output(405, ["msg" => "Método não permitido"]);
}
