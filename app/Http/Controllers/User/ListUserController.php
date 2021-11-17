<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UpdateUserPutRequest;
use App\Http\Requests\StoreListUserPostRequest;

class ListUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = User::all();

        $users = User::orderBy("id",'DESC');
        $search="";

        if(request()->has("search")){
            $search = request("search");
            $users = $users->where('name', 'like','%'.$search.'%')
                        ->orWhere('email', 'like','%'.$search.'%');
        }
                        // Concatenamos enlaces
        $users = $users->paginate(20)->appends(request()->except('page'));

        // dd(request()->except('page'));

        // dd($users->links());

        // CReamos el mensaje tipo flash
        request()->session()->flash('success', 'Realizado correctamente');
        // Enviamos al  $page de inertia

        // dd($user);
        return Inertia::render('UserList/Index',[
            'users' => $users,
            'search'=> $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('UserList/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreListUserPostRequest $request)
    {
        User::create($request->all());

        return Redirect::route('userList.index');

        return Inertia::render('UserList/Create',['success'=>'Guardado satisfactorio']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $customers)
    {

        return Inertia::render('UserList/Show', compact('customers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $customers)
    {
        return Inertia::render('UserList/Edit', compact('customers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserPutRequest $request, User $customers)
    {
        // dd($request->validated());
        $customers->updated($request->validated());

        // dd($request->all());

        // dd(request()->file("avatar"));

        //  Verificar si existe
        if(request()->hasFile('avatar')){
            $customers->updateProfilePhoto(request()->file("avatar"));
        }

        return Redirect::route('userList.edit', $customers);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $customers)
    {
        $customers->delete();
        return Redirect::route('userList.index');
    }


    public function deleteAvatar(User $customers){
        $customers->deleteProfilePhoto();

        return redirect()->back()->with("success", "Avatar eliminado");
    }
}


