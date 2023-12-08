<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Users</title>
</head>
<body>

    <h1>Users:</h1>
    <?php foreach($data['data'] as $user): ?>
        <p><?php $user->first_name ?></p>
    <?php endforeach; ?>
</body>
</html>