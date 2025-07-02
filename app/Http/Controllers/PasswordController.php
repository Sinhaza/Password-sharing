<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePasswordRequest;
use App\Models\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

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
        $link = (env('APP_URL').'/password/'. $password->uuid);
        return response()->json(['message' => 'Password created', 'link' => $link], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Password $password)
    {
        $this->incrementVisitCount($password);
        return response()->json($password);
    }

    public function incrementVisitCount(Password $password)
    {
        $password->visit_count += 1;
        $password->save();

        if ($password->visit_count >= $password->visit_limit) {
            $password->delete();
        }
    }
}
