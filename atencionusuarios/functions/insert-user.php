<?php

//Tomo el post de register-profile.php
if($_POST['name']){ 
$name = sanitize_text_field( $_POST['name'] );
$number = sanitize_text_field( $_POST['phone'] );
$email = sanitize_email( $_POST['email'] );
$dni = sanitize_text_field( $_POST['dni'] );
$username = sanitize_text_field( $_POST['username'] );
$adress = sanitize_text_field( $_POST['address'] );

//Genero password
$user_pass = wp_generate_password();

$user = array(
    'user_login' => $username,
    'user_pass' => $user_pass,
    'first_name' => $name,
    'user_email' => $email,
    'dni' => $dni,
    'telefono' => $number,
    'direccion' => $adress
    );

$response= new Users_Profile;
//Ejecuto metodo, class-users-profile
$response=create_profile($user);
}

