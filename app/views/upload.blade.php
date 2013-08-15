<!DOCTYPE HTML>
<html lang="es-ES">
    <head>
        <meta charset="UTF-8">
        <!--cargamos los css-->
        {{ HTML::style('css/foundation.min.css') }}
        {{ HTML::style('css/normalize.css') }}
        <title>Título</title>
    </head>
    <body>
 
        <div class="row"> 
            <h1 class="subheader">Subir imágenes con laravel 4</h1>
            <!--si el formulario contiene errores de validación-->
            @if($errors->has())
                <div class="alert-box alert">           
                    <!--recorremos los errores en un loop y los mostramos-->
                    @foreach ($errors->all('<p>:message</p>') as $message)
                        {{ $message }}
                    @endforeach
                     
                </div>
            @endif
            
            @if(Session::has('confirm'))
                <div class="alert-box success round">
                    {{ Session::get('confirm') }}
                </div>                    
            @endif
            <div class="form">
              
                {{ Form::open(array('url' => 'upload', 'files' => true)) }}
 
                {{ Form::label('photo', 'Foto') }}
                
                <!--así se crea un campo file en laravel-->
                {{ Form::file('photo') }}
                
                {{ Form::label('email', 'Email') }}
 
                {{ Form::email('email', Input::old('email')) }}
               
                {{ Form::label('username', 'Nick') }}
 
                {{ Form::text('username', Input::old('username')) }}
 
                {{ Form::label('password', 'Password') }}
 
                {{ Form::password('password') }}
 
                 {{ Form::label('password_confirmation', 'Confirm password') }}
 
                {{ Form::password('password_confirmation') }}
                
                <br />
                {{ Form::submit('Regístrarme', array("class" => "button expand round")) }}
 
                {{ Form::close() }}
 
            </div>    
             
        </div>
    </body>
</html>