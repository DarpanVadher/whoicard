<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Who I Card</title>
</head>
<body>
    <h1>{{ $maildata['name']}}</h1>
    <h1>{{ $maildata['email']}}</h1>

    <h1>{{ $maildata['number']}}</h1>

    <h1>{{ $maildata['subject']}}</h1>

    <p>{{ $maildata['message']}}</p>

</body>
</html>