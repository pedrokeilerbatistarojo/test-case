<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Users</title>
</head>
<body style="padding: 50px">
    <style>
        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        .row {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .col {
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            -ms-flex-positive: 1;
            flex-grow: 1;
            max-width: 100%;
        }

        .img-fluid {
            max-width: 100%;
            height: 100px;
            width: 100px;
        }


        .d-block{
            display: block!important;
        }

    </style>

    <div class="container">
        <?php foreach($users as $user): ?>
            <div class="row">
                <div class="col">
                    <img class="img-fluid" src="<?=site_url($user['picture']) ?>"  alt="<?=$user['picture'] ?>"/>
                </div>
                <div class="col">
                    <span class="d-block"><?=$user['first_name'] . ' ' . $user['last_name'] ?></span>
                    <span class="d-block"><?=$user['phone']?></span>
                    <span class="d-block"><a href="mailto:<?=$user['email']?>"><?=$user['email']?></a></span>
                    <span class="d-block"><?=$user['type']?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>