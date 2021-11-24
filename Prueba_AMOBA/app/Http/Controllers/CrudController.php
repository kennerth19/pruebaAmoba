<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Users;
use App\Models\Profiles;

class CrudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)    {

        $name = $request->get('nombre');

        $user = Users::orderBy('id','DESC')
        ->where("First_name", 'LIKE', "%$name%")
        ->paginate(5);     

        return view('welcome',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required| max:50',
            'apellido' => 'required| max:50',
            'descripcion' => 'required| max:255',
        ]);

        $user = new Users();
        $profile = new Profiles();

        $user->First_name = $request->nombre;
        $user->Last_name = $request->apellido;
        $user->Description = $request->descripcion;

        //genera nombre con extension de la imagen
        $user->img_path = $request->file('img')->store('/public');
        $user->img_path = substr($user->img_path, 6, 50);

        //almacena la imagen en 
        $profile->ima_profile = $user->img_path;

        $profile->User_id = substr($profile->ima_profile, 5, 11);

        $user->save();
        $profile->save();

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Users $user)
    {
        return view('/modificar',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Users::find($id);
        $user->First_name = $request->nombre;
        $user->Last_name = $request->apellido;
        $user->Description = $request->descripcion;

        $user->save();

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=Users::where('id', '=', $id)->first();
        $profile=Profiles::where('id', '=', $id)->first();

        $user->delete();
        $profile->delete();

        return redirect()->route('user.index');
    }
}
