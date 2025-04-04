<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return
     */
    public function index()
    {
        return view('users.index',[
            'users' => User::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): \Illuminate\Http\JsonResponse
    {
        $user->delete();
        Session::flash('status',__('shop.user.delete.success'));
        return response()->json([
            'status' => 'success'
        ]);
    }
}
