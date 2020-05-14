<!DOCTYPE html>
<!--- сотрудник зарегистрирован --->
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
<?php
//очищаем вывод от спецсимволов и пробелов
function clean_text($string)
	{
		$string = trim($string);
		$string = stripslashes($string);
		$string = strip_tags($string);
		$string = htmlspecialchars($string);
		return $string;
	}
$email = '';
$email = clean_text($_GET["email"]);
//var_dump($email);
//var_dump($_POST);
?>
<div class="form">
    <form class="login-form" action="mainpage.php" method="post">
    <h1 align="center">Почта для сотрудника успешно создана!</h1>
    <br/>
    <h2 align="center">Почта: <?php echo $email;?></h2>
        <br />
        <link rel="stylesheet" type="text/css" href="./hide.css">
    <h3 align="center">Пароль: <a href="done.php">qwertyuiop</a></h3>
    <br />
    <div class="col-md-6" style="margin:0 auto; float:none;">
        <h3 align="center"></h3>
        <br />
        <div class="form-group" align="center">
            <h2 align="center">Вернуться в главное меню</h2>
            <button input type="submit" name = "submit">Поехали!</button>
        </div>
    </div>
    </form>
</div>

</body>
</html>
<?php
$email = '';
$_GET["email"] = '';
?>


