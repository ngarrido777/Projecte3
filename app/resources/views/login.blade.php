<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 30px;
        }
        .login-form {
            width: 100%;
            max-width: 400px;
            padding: 15px;
        }
        .error {
            display: block;
            margin-bottom: 20px;

            color: red;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="login-container">
    <div class="login-form card shadow">
        <div class="card-body">
            <h1 class="p-3 text-center">Login</h1>
            {{ Form::open(['url' => 'login', 'method' => 'post']) }}
                @csrf
                <div class="form-group">
                    {{ Form::label('l_login', 'Login:') }}
                    {{ Form::text('c_login', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('l_password', 'Password:') }}
                    {{ Form::password('c_password', ['class' => 'form-control']) }}
                </div>
                <div class="form-group text-center">
                    {{ Form::submit('Login', ['name' => 'e_login', 'class' => 'btn btn-primary btn-block']) }}
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
</body>
</html>