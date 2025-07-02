<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePasswordRequest;
use App\Models\Password;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('passwords.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePasswordRequest $request)
    {
        $password = Password::create($request->validated());
        $link = URL::temporarySignedRoute(
            'your.route.name', // Define this route in your web.php
            now()->addMinutes(60), // Link expires in 60 minutes
            ['uuid' => $model->uuid]
        );
        return response()->json(['message' => 'Password created', 'link' => $link], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Password $password)
    {
        return view('passwords.show', compact('password'));
    }
}
