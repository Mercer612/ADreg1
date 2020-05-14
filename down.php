<?php
//обработчик странички управления аккаунтами

header('Content-Type: text/html; charset=UTF-8');
//объявляем переменные, опустошаем их
$email = '';
$message = '';
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
if(isset($_POST["submit1"]))
{  $button = '1';
goto next;}
/*elseif (isset($_POST["submit2"]))
{  $button = '2';
goto next;}*/
next:if(empty($_POST["email"]))
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
if($error == '') {
    $email = ($_POST["email"]);
    $acc = '<label class="text-success">Аккаунт</label>';
    $success = '<label class="text-success">успешно отключен </label>';
   // $success2 = '<label class="text-success">успешно включен</label>';
    $failemail = '<label class="text-danger">Не удалось найти аккаунт</label>';}
    //если ошибки есть, прерываем цикл и опустошаем переменные, чтобы они не ушли в powershell-скрипт
else
    {
        $email='';
    }
//вызываем наш скрипт, подкидываем ему значения полей из формы
if ($email !== "0") {
    $res = $email.' '.$button;
    $switch = Shell_Exec ('powershell.exe -ExecutionPolicy ByPass -NoProfile -File C:\inetpub\wwwroot\shutdown.ps1 '.$res.'');}

//вывод результата скрипта в окно браузера. уже не актуально. оставлю для дебага.
//echo $switch;

//убираем пробел, который подсовывает PowerShell
$switch = trim($switch);
//вывод полного содержания переменной в браузер. для дебага
//var_dump($switch);
//var_dump($email);
//var_dump($error);
$error = '';
$error2 = '';
//смотрим, какой результат покажет PowerShell и от него выбираем сообщение
if ($switch == 'S1')
    {$error .= $acc.' '.$email.' '.$success;}
//elseif ($switch == 'S01')
//    {$error .= $acc.' '.$email.' '.$success2;}
elseif ($switch == 'S2')
    {$error2 .= $failemail.' '.$email;}
//вывод сообщения вынесен в отрисовку формы shutdown.php
//if ($switch !== 0)
//    {echo $error;}

//очищаем переменные для следующего цикла
$_POST=$email=$message=$switch=$button='';

//запрашиваем шаблон формы, чтобы не остаться на пустой странице после отправки
require_once 'shutup.php';
?>