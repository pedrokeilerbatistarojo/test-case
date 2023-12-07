<?php

class LoginUseCase
{
    public function login(string $phone, string $password)
    {
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->where('phone', $celular)->first();

        if (!$usuario || !password_verify($contrasena, $usuario['contrasena'])) {
            return null;
        }

        return $usuario;
    }
}