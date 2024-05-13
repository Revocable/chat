<?php

require_once __DIR__ . "/../config/Conexao.php";

class Usuario
{
    public static function add($username, $password, $email)
    {
        try {
            $hashSenha = password_hash($password, PASSWORD_BCRYPT);
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("INSERT INTO Users (username, password, email) VALUES (?, ?, ?)");
            $stmt->execute([$username, $hashSenha, $email]);

            return $stmt->rowCount() === 1;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function listarUsuarios()
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->query("SELECT * FROM Users");

            // Retornar diretamente o array de usuários
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public static function existLogin($login)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT COUNT(*) FROM Users WHERE email LIKE ?");
            $stmt->execute([$login]);
            return $stmt->fetchColumn();
        } catch (Exception $e) {
            return null;
        }
    }

    public static function getLogin($login, $senha)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM Users WHERE email LIKE ?");
            $stmt->execute([$login]);

            $usuario = $stmt->fetchAll()[0];

            if (password_verify($senha, $usuario["password"])) {
                return $usuario;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return null;
        }
    }

}
