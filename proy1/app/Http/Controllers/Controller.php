<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'phone_number' => ['required', 'string', 'max:15', 'regex:/^[0-9]+$/', 'unique:users,phone_number'],
        ]);

        User::create($validatedData);

        return response()->json(['message' => 'Usuario creado satisfactoriamente!'], 201);
    }

    public function update(Request $request, User $user)
    {
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

