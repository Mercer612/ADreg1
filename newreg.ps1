Import-Module ActiveDirectory
Set-ExecutionPolicy ByPass  

#получаем значени€ переменных из веб-формы
$Name = $args[0] 

$Surname = $args[1] 

$MidName = " " 

$Mail = $args[2] 

$OU = $args[3] 

$Desc = $args[4] 

#$Phone = $args[5] 

$Company = "ќќќ Ёмбриа" 

$Password="qwertyuiop"

$SecurePwd = ConvertTo-SecureString -AsPlainText -Force -String $Password 

#функци€ склейки подразделени€ и домена
$OUTmp = $OU ЦSplit У/Ф

$Path = УФ 

$OUTmp | ForEach-Object {$Path = "OU=$_," + $Path}

$Path += УOU=Embria,DC=embria,DC=comФ

$Displayname = $Name + " " + $Surname #в кавычках Ц пробел 

$Login = $Mail.Split("@")[-2] #отдел€ем SAMAccName от почтового суффикса

#запускаем командлет PS дл€ создани€ пользовател€ с нашими данными
#делаем проверки на существующий логин\почту
$login_check = [bool] (Get-ADUser -Filter { SamAccountName -eq $Login }) #есть юзер с таким SAM-логином ? да\нет
$email_check = [bool] (Get-ADUser -Filter { EmailAddress -eq $Mail }) #есть юзер с такой почтой ? да\нет
$name_check = [bool] (Get-ADUser -Filter { DisplayName -eq $DisplayName }) #есть юзер с таким выводимым именем? да\нет
if ($login_check -ne $True) { #1 если юзера с таким логином нет
    if ($email_check -ne $True) { #2 если юзера с такой почтой нет
        if ($name_check -ne $True) { #3 если юзера с таким именем нет
 New-ADUser $Displayname ЦSamAccountName $Login -GivenName $Name -Surname $Surname -Company $Company ЦUserPrincipalName $Mail -Description $Desc -Title $Desc  -EmailAddress $Mail -DisplayName $DisplayName -Enabled $true -AccountPassword $SecurePwd -ChangePasswordAtLogon 1 -Path $Path 
echo "S1"} #3 создать юзера с текущими параметрами и вывести S1
    else { #3 или
    $Displayname = $Name + " " + $Midname + " " + $Surname #модифицируем выводимое им€
    New-ADUser $DisplayName ЦSamAccountName $Login  -GivenName $Name -Surname $Surname -Company $Company ЦUserPrincipalName $Mail  -Description $Desc -Title $Desc  -EmailAddress $Mail -DisplayName $DisplayName -Enabled $true -AccountPassword $SecurePwd -ChangePasswordAtLogon 1 -Path $Path 
echo "S1"} #3 создать юзера с модифицированными параметрами и вывести S1
}
    else {echo "S2"} #2 юзер с такой почтой есть! вывести S2
}
else {echo "S3"} #1 юзер с таким логином есть! вывести S3

$Name = $Surname = $OU =$Mail = $Desc = '' #очищаем переменные дл€ следующего цикла
