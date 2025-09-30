<!DOCTYPE html>
<html>

<head>
    <title>{{ $assunto }}</title>
</head>

<body>
    <p>Olá,</p>
    <p>{!! nl2br(e($mensagem)) !!}</p>
    <br>
    <p>Atenciosamente,</p>
    <p>{{ $user->name }}</p>
</body>

</html>