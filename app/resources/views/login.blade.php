<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .error {
            display: block;
            margin-bottom: 20px;

            color: red;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h1 class="p-3">Login</h1>
    <div>
        {{ Form::open(['url' => 'login', 'method' => 'post']) }}
            @csrf
            {{ Form::label('l_login', 'Login:') }}
            {{ Form::text('c_login') }}

            {{ Form::label('l_password', 'Password:') }}
            {{ Form::password('c_password') }}

            {{ Form::submit('Login', ['name' => 'e_login']) }}

        {{ Form::close() }}
    </div>
</body>
</html>