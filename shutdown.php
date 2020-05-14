<!DOCTYPE html>
<!--- страница управления аккаунтом --->
<html>
<head>
    <meta charset="UTF-8">
    <title>Управление персоналом</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./styles.css">
</head>
<body>
<p><img src="./logo.png" alt="Embria" class="center"></p>
<br />
<br />
<div class="form">
    <form class="login-form" action="down.php" method="post">
    <h2 align="center">Чтобы отключить аккаунт, введите почту сотрудника</h2>
    <br />
    <div class="col-md-6" style="margin:0 auto; float:none;">
        <div>
            <h3 align="center" class="text-danger"><?php echo $error2; ?></h3>
            <h3 align="center" class="text-success"><?php if ($switch !== 'S2') {echo $error;} ?></h3>

        </div>
        <br />
            <div class="form-group">
                <label>Почта</label>
                <input email="text" name="email" class="form-control" placeholder="i.ivanov@embria.com" value="<?php echo $email; ?>" />
            </div>
            <br/>
        <div>
        <button input type="submit" name = "submit1">Отключить</button>
    </div>
       <!--- <div>
        <br/>
        <button input type="submit" name = "submit2">Включить</button>
        </div> --->
        <br/>
        <p class="message">Передумали? <a href="mainpage.php">Вернуться</a></p>
    </div>
</div>
</body>
</html>
