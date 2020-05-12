#импортируем модуль AD и устанавливаем политику запуска
Import-Module ActiveDirectory
Set-ExecutionPolicy RemoteSigned

#получаем значения переменных из веб-формы
$Mail =  $args[0]
$Button = $args[1]
$Login = $Mail.Split("@")[-2] #отделяем SAMAccName от почты
$existemail_check = [bool] (Get-ADUser -Filter { EmailAddress -eq $Mail}) #почта существует?
 if ($existemail_check -eq $True) {  #если акк с такой почтой существует
     if ($Button -eq "1") {
        Get-ADUser -Filter {EmailAddress -eq $Mail} | Set-ADUser -Enabled $false #найти юзера с такой почтой и вырубить
        echo "S1"} #выдать код: отключено по почте
     else {
        Get-ADUser -Filter {EmailAddress -eq $Mail} | Set-ADUser -Enabled $true #найти юзера с такой почтой и врубить
        echo "S01"} #выдать код: включено по почте
        }
    else {
        echo "S2"} #выдать код: аккаунта с такой почтой нет
         
            