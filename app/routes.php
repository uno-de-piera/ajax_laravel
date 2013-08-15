<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
//ruta para mostrar el formulario de registro
//http://ajax_laravel.dev/ajax
Route::get("ajax", function(){
	return View::make("form_ajax");
});

//ruta para procesar peticiones post llegadas del formulario
Route::post("ajax", function(){
	//comprobamos si es una petición ajax
	if(Request::ajax()){
		//validamos el formulario
	    $registerData = array(
	        "username"    =>    Input::get("username"),
	        "email"       =>    Input::get("email"),
	        "password"    =>    Hash::make(Input::get("password"))
	    );
	        
	    $rules = array(
	        'username'     	=> 'required|min:2|max:100',
	        'email'     	=> 'required|email|min:6|max:100|unique:users',
	        'password'     	=> 'required|confirmed|min:6|max:100'
	    );
	        
	    $messages = array(
	        'required'    	=> 'El campo :attribute es obligatorio.',
	        'min'         	=> 'El campo :attribute no puede tener menos de :min carácteres.',
	        'email'     	=> 'El campo :attribute debe ser un email válido.',
	        'max'         	=> 'El campo :attribute no puede tener más de :min carácteres.',
	        'unique'     	=> 'El email ingresado ya está registrado en la base de datos.',
	        'confirmed' 	=> 'Los passwords no coinciden.'
	    );
	        
	    $validation = Validator::make(Input::all(), $rules, $messages);
	    //si la validación falla redirigimos al formulario de registro con los errores   
	    if ($validation->fails())
	    {
	    	//como ha fallado el formulario, devolvemos los datos en formato json
	    	//esta es la forma de hacerlo en laravel, o una de ellas
			return Response::json(array(
			    'success' => false,
			    'errors' => $validation->getMessageBag()->toArray()
			)); 
	        //en otro caso ingresamos al usuario en la tabla usuarios
	    }else{
	        //creamos un nuevo usuario con los datos del formulario
	        $user = new User($registerData);
	        $user->save(); 
	        //si se realiza correctamente la inserción envíamos un mensaje
	        //conforme se ha registrado correctamente
	        if($user)
	        {
	            return Response::json(array(
				    'success' 		=> 	true,
				    'message' 		=> 	"Te has registrado correctamente"
				));
			}
	    }
	}
});

//ruta que devuelve un json con los usuarios de la base de datos
Route::get("content_ajax", function(){
	if(Request::ajax()){
		$users = DB::table('users')->get();
		return Response::json(array(
			'users' => 	$users
		));
	}
});


Route::get('/', function()
{
    return View::make('hello');
});
 
Route::get("upload", function(){
    return View::make("upload");
});
 
Route::post("upload", function(){
    $file = Input::file("photo");
    $dataUpload = array(
        "username"    =>    Input::get("username"),
        "email"        =>    Input::get("email"),
        "password"    =>    Input::get("password"),
        "photo"        =>    $file//campo foto para validar
    );
    
    $rules = array(
        'username'  => 'required|min:2|max:100',
        'email'     => 'required|email|min:6|max:100|unique:users',
        'password'  => 'required|confirmed|min:6|max:100',
        'photo'     => 'required'
    );
        
    $messages = array(
        'required'  => 'El campo :attribute es obligatorio.',
        'min'       => 'El campo :attribute no puede tener menos de :min carácteres.',
        'email'     => 'El campo :attribute debe ser un email válido.',
        'max'       => 'El campo :attribute no puede tener más de :min carácteres.',
        'unique'    => 'El email ingresado ya está registrado en el blog',
        'confirmed' => 'Los passwords no coinciden'
    );

    $validation = Validator::make(Input::all(), $rules, $messages);
         //si la validación falla redirigimos al formulario de registro con los errores
        //y con los campos que nos habia llenado el usuario    
    if ($validation->fails())
    {
        return Redirect::to('upload')->withErrors($validation)->withInput();
    }else{
        $user = new User(array(
            "username"    =>    Input::get("username"),
            "email"        =>    Input::get("email"),
            "password"    =>    Hash::make(Input::get("password")),
            "photo"        =>    Input::file("photo")->getClientOriginalName()//nombre original de la foto
            
        ));
        if($user->save()){
            //guardamos la imagen en public/imgs con el nombre original
            $i = 0;//indice para el while
            //separamos el nombre de la img y la extensión
            $info = explode(".",$file->getClientOriginalName());
            //asignamos de nuevo el nombre de la imagen completo
            $miImg = $file->getClientOriginalName();
            //mientras el archivo exista iteramos y aumentamos i
            while(file_exists('imgs/'. $miImg)){
            	$i++;
            	$miImg = $info[0]."(".$i.")".".".$info[1];          	
            }
            //guardamos la imagen con otro nombre ej foto(1).jpg || foto(2).jpg etc
            $file->move("imgs",$miImg);
            //si ha cambiado el nombre de la foto por el original actualizamos el campo foto de la bd
            if($miImg != $file->getClientOriginalName()){
            	$user->photo = $miImg;
            	$user->save();
            }
            //redirigimos con un mensaje flash
            return Redirect::to('upload')->with(array('confirm' => 'Te has registrado correctamente.'));
        } 
    }
});


