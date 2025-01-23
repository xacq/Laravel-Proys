<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {    //VALIDO EL DATO QUE SE INGRESA COMO NUMERO TELEFONICO EN EL CONTROLADOR EN LA ACCION DE CREACION
        $validatedData = $request->validate([
            'phone_number' => ['required', 'string', 'max:15', 'regex:/^[0-9]+$/', 'unique:users,phone_number'],
        ]);

        User::create($validatedData);

        return response()->json(['message' => 'Usuario creado satisfactoriamente!'], 201);
    }

    public function update(Request $request, User $user)
    {    //VALIDO EL DATO DE NUMERO TELEFONICO CUANDO SE HACE UNA ACTUALIZACION DEL CAMPO
        $validatedData = $request->validate([
            'phone_number' => ['required', 'string', 'max:15', 'regex:/^[0-9]+$/', 'unique:users,phone_number,' . $user->id],
        ]);

        $user->update($validatedData);

        return response()->json(['message' => 'Usuario actualizado satisfactoriamente!']);
    }
}

abstract class Controller
{
    //
}

