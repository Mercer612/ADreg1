Import-Module ActiveDirectory
Set-ExecutionPolicy ByPass  

#Get parameters from php side
$Name = $args[0] 

$Surname = $args[1] 

$MidName = " " 

$Mail = $args[2] 

$OU = $args[3] 

$Desc = $args[4] 

$Phone = $args[5] 

$Company = "Local.Inc" 

$Password="Qwertyuiop123"

$SecurePwd = ConvertTo-SecureString -AsPlainText -Force -String $Password 

#Department+Domain
$OUTmp = $OU –Split “/”

$Path = “” 

$OUTmp | ForEach-Object {$Path = "OU=$_," + $Path}

$Path += “DC=localtest,DC=com”

$Displayname = $Name + " " + $Surname #there is a space in quotes

$Login = $Mail.Split("@")[-2] #split SAMAccountName from mail domain

$UserPrincipalName = $Mail 

#Check if login or mail exists
$login_check = [bool] (Get-ADUser -Filter { SamAccountName -eq $Login }) #check if the same samaccount name exists 
$email_check = [bool] (Get-ADUser -Filter { EmailAddress -eq $Mail }) #check if the same mail exists
$name_check = [bool] (Get-ADUser -Filter { DisplayName -eq $DisplayName }) #check if the same displayname name exists
if ($login_check -ne $True) { #1 if the same samaccount name doesn't exist
    if ($email_check -ne $True) { #2  if the same mail doesn't exist
        if ($name_check -ne $True) { #3  if the same displayname doesn't exist
 New-ADUser $Displayname –SamAccountName $Login -GivenName $Name -Surname $Surname -Company $Company –UserPrincipalName $Mail -OfficePhone $Phone -Description $Desc -Title $Desc  -EmailAddress $Mail -DisplayName $DisplayName -Enabled $true -AccountPassword $SecurePwd -ChangePasswordAtLogon 1 -Path $Path 
echo "S1"} #3 create user and echo "S1" as a result (we'll use it for the next php-page)
    else { #3 or
    $Displayname = $Name + " " + $Midname + " " + $Surname #modify DisplayName with spaces
    New-ADUser $DisplayName –SamAccountName $Login  -GivenName $Name -Surname $Surname -Company $Company –UserPrincipalName $Mail -OfficePhone $Phone -Description $Desc -Title $Desc  -EmailAddress $Mail -DisplayName $DisplayName -Enabled $true -AccountPassword $SecurePwd -ChangePasswordAtLogon 1 -Path $Path 
echo "S1"} #3 create user and echo "S1" as a result (we'll use it for the next php-page)
}
    else {echo "S2"} #2 the user with the same mail exists. echo "S2"
}
else {echo "S3"} #1 the user with the same samaccountname exists. echo "S3"

$Name = $Surname = $OU =$Mail = $Desc = $Phone = '' #clear var-s for the next load of php-page
