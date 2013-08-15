<!DOCTYPE HTML>
<html lang="es-ES">
    <head>
        <meta charset="UTF-8">
        <!--cargamos los archivos css y js-->
        {{ HTML::style('css/foundation.min.css') }}
        {{ HTML::style('css/normalize.css') }}
        {{ HTML::script('js/jquery.js') }}
        {{ HTML::script('js/functions.js') }}
        <!--nuestro título podrá ser modificado-->
        <title>Ajax con Laravel 4</title>
    </head>
    <body>
        <div class="row">     
			<h2 class="subheader">Formulario de registro con ajax en laravel 4</h2> 
             <div class="small-12 columns">
                <!--pintamos el formulario haciendo uso de la clase form de laravel-->
            <div class="form">
              
                {{ Form::open(array('url' => 'ajax', 'class' => 'register_ajax')) }}
                
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
            <!--en este div mostramos el preloader-->
            <div style="margin: 10px 0px 0px 48%" class="before"></div>   
            <!--en este los errores del formulario--> 
            <div class="errors_form"></div>
            <!--en este el mensaje de registro correcto-->
            <div style="display: none" class="success_message alert-box success"></div>     
            </div>       
        </div>
        <div class="row">
        	<!--al pulsar en el botón debajo de éste mostraremos los usuarios registrados-->
        	 <div class="small-12 pull users expand round">
            	{{ HTML::link(URL::to('#'), 
            	'Ver usuarios registrados', 
            	array("class" => "button round expand success show_users")) }} 	
            	<!--div para mostrar un preloader mientras cargamos los usuarios-->
            	<div style="margin: 10px 0px 0px 48%" class="preload_users"></div>
            	<!--aquí se mostrarán los usuarios-->
            	<div class="load_ajax"></div>
            </div>
        </div>
    </body>
</html>