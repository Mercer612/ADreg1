<?php
//обработчик веб-формы

header('Content-Type: text/html; charset=UTF-8');
//объявляем переменные, опустошаем их
$name = '';
$surname = '';
$depart = '';
$email = '';
//$phone = '';
$error = '';
$reg = '0';
$success = '<label class="text-success">Сотрудник успешно зарегистрирован! Пароль от почты: qwertyuiop</label>';
$failemail = '<label class="text-danger">Сотрудник с такой почтой уже существует.</label>';
$faillogin = '<label class="text-danger">Сотрудник с таким логином уже существует.</label>';
//очищаем вывод от спецсимволов и пробелов
function clean_text($string)
	{
		$string = trim($string);
		$string = stripslashes($string);
		$string = strip_tags($string);
		$string = htmlspecialchars($string);
		return $string;
	}
// делаем форму с проверкой правильности ввода данных
if(isset($_POST["submit"]))
	{
		if(empty($_POST["name"]))
		{
	$error .= '<p><label class="text-danger">Введите имя</label></p>';
		}
else
	{
		$name = clean_text($_POST["name"]);
		if(!preg_match("/^[A-Za-zА-Яа-яЁё]+/u",$name))
		{
    $error .= '<p><label class="text-danger">Имя может содержать только буквы и пробелы</label></p>';
		}
	}
		if(empty($_POST["surname"]))
	{
	$error .= '<p><label class="text-danger">Введите Фамилию</label></p>';
	}
else
	{
		$surname = clean_text($_POST["surname"]);
		if(!preg_match("/^[A-Za-zА-Яа-яЁё]+/u",$surname))
		{
	$error .= '<p><label class="text-danger">Фамилия может содержать только буквы и пробелы</label></p>';
		}
	}
if(empty($_POST["email"]))
	{
	$error .= '<p><label class="text-danger">Введите Почту</label> <?php echo $error ?> </p>';
	}
else
	{
		$email = clean_text($_POST["email"]);
		//проверка корректности почты по паттерну
		if(!preg_match("~^([a-z0-9_\-\.])+@([a-z0-9_\-\.])+\.([a-z0-9])+$~i",$email))
		//проверка почты через функцию валидатора. нам не подходит, но юзабельно
		//$email_validate = filter_var($email, FILTER_VALIDATE_EMAIL);
		{
	$error .= '<p><label class="text-danger">Неверный формат почты</label></p>';
		}
	}
if(empty($_POST["depart"]))
	{
	$error .= '<p><label class="text-danger">Выберите отдел</label></p>';
	}
else
	{
	$depart = clean_text($_POST["depart"]);
	}
if(empty($_POST["desc"]))
	{
	$error .= '<p><label class="text-danger">Введите Должность</label></p>';
	}
else
	{
	$desc = clean_text($_POST["desc"]);
	if(!preg_match("/^[A-Za-zА-Яа-яЁё0-9]+/u",$desc))
		{
		$error .= '<p><label class="text-danger">Должность может содержать только буквы, пробелы и цифры</label></p>';
		}
	}
/*if(empty($_POST["phone"]))
	{
	$error .= '<p><label class="text-danger">Введите номер телефона</label></p>';
	}
else
	{
	$phone = clean_text($_POST["phone"]);
	if(!preg_match("/^[0-9]*$/",$phone))
		{
		$error .= '<p><label class="text-danger">Номер телефона может содержать только цифры</label></p>';
		}
	}*/
//если все поля заполнены верно, наполняем переменные
if($error == '')
	{
		$name = ($_POST["name"]);
		$surname = ($_POST["surname"]);
		$email = ($_POST["email"]);
		$depart = ($_POST["depart"]);
		$desc = ($_POST["desc"]);
		//$phone = ($_POST["phone"]);
		$message = '';
	}
//если ошибки есть, прерываем цикл и опустошаем переменные, чтобы они не ушли в powershell-скрипт
else
    {
        $name=$surname=$depart=$phone=$_POST=$email=$desc=$us=$message=$reg='';
    }
}
//суём текст из всех переменных в одну, через пробел. важно соблюдать порядок
//тк PowerShell будет принимать значения именно в этом порядке
$us= "0";
$us = $name.' '.$surname.' '.$email.' '.$depart.' '.$desc/*.' '.$phone*/;
//вывод в окно браузера не понадобился. оставлю для дебага.
//echo $us;

//вызываем наш скрипт, подкидываем ему значения полей из формы
if ($us !== "0")
{$reg = Shell_Exec ('powershell.exe -ExecutionPolicy ByPass -NoProfile -File C:\inetpub\wwwroot\newad.ps1 '.$us.'');}

//вывод результата скрипта в окно браузера. уже не актуально. оставлю для дебага.
//echo $reg;

//убираем пробел, который подсовывает PowerShell
	$reg = trim($reg);

//вывод полного содержания переменной в браузер. для дебага
var_dump($reg);
//var_dump($_POST);
//var_dump($error);

//смотрим, какой результат покажет PowerShell и от него выбираем сообщение
if ($reg == 'S1') {
    if ($email !== '')
    {
        // {$message = $success;}
        header("Location: http://localhost/done.php?email=$email");
    }
}
elseif ($reg == 'S2')
    {$message .= $faillogin;}
elseif ($reg == 'S3')
    {$message .= $failemail;}
//if ($reg !== null)
//{echo $message;}

//очищаем переменные для следующего цикла
$name=$surname=$depart=$phone=$_POST=$email=$desc=$us=$reg='';

//запрашиваем шаблон формы, чтобы не остаться на пустой странице после отправки
require_once 'adreg.php';
?>