Import-Module ActiveDirectory
Set-ExecutionPolicy ByPass  

#�������� �������� ���������� �� ���-�����
$Name = $args[0] 

$Surname = $args[1] 

$MidName = " " 

$Mail = $args[2] 

$OU = $args[3] 

$Desc = $args[4] 

#$Phone = $args[5] 

$Company = "��� ������" 

$Password="qwertyuiop"

$SecurePwd = ConvertTo-SecureString -AsPlainText -Force -String $Password 

#������� ������� ������������� � ������
$OUTmp = $OU �Split �/�

$Path = �� 

$OUTmp | ForEach-Object {$Path = "OU=$_," + $Path}

$Path += �OU=Embria,DC=embria,DC=com�

$Displayname = $Name + " " + $Surname #� �������� � ������ 

$Login = $Mail.Split("@")[-2] #�������� SAMAccName �� ��������� ��������

#��������� ��������� PS ��� �������� ������������ � ������ �������
#������ �������� �� ������������ �����\�����
$login_check = [bool] (Get-ADUser -Filter { SamAccountName -eq $Login }) #���� ���� � ����� SAM-������� ? ��\���
$email_check = [bool] (Get-ADUser -Filter { EmailAddress -eq $Mail }) #���� ���� � ����� ������ ? ��\���
$name_check = [bool] (Get-ADUser -Filter { DisplayName -eq $DisplayName }) #���� ���� � ����� ��������� ������? ��\���
if ($login_check -ne $True) { #1 ���� ����� � ����� ������� ���
    if ($email_check -ne $True) { #2 ���� ����� � ����� ������ ���
        if ($name_check -ne $True) { #3 ���� ����� � ����� ������ ���
 New-ADUser $Displayname �SamAccountName $Login -GivenName $Name -Surname $Surname -Company $Company �UserPrincipalName $Mail -Description $Desc -Title $Desc  -EmailAddress $Mail -DisplayName $DisplayName -Enabled $true -AccountPassword $SecurePwd -ChangePasswordAtLogon 1 -Path $Path 
echo "S1"} #3 ������� ����� � �������� ����������� � ������� S1
    else { #3 ���
    $Displayname = $Name + " " + $Midname + " " + $Surname #������������ ��������� ���
    New-ADUser $DisplayName �SamAccountName $Login  -GivenName $Name -Surname $Surname -Company $Company �UserPrincipalName $Mail  -Description $Desc -Title $Desc  -EmailAddress $Mail -DisplayName $DisplayName -Enabled $true -AccountPassword $SecurePwd -ChangePasswordAtLogon 1 -Path $Path 
echo "S1"} #3 ������� ����� � ����������������� ����������� � ������� S1
}
    else {echo "S2"} #2 ���� � ����� ������ ����! ������� S2
}
else {echo "S3"} #1 ���� � ����� ������� ����! ������� S3

$Name = $Surname = $OU =$Mail = $Desc = '' #������� ���������� ��� ���������� �����
