#����������� ������ AD � ������������� �������� �������
Import-Module ActiveDirectory
Set-ExecutionPolicy RemoteSigned

#�������� �������� ���������� �� ���-�����
$Mail =  $args[0]
$Button = $args[1]
$Login = $Mail.Split("@")[-2] #�������� SAMAccName �� �����
$existemail_check = [bool] (Get-ADUser -Filter { EmailAddress -eq $Mail}) #����� ����������?
 if ($existemail_check -eq $True) {  #���� ��� � ����� ������ ����������
     if ($Button -eq "1") {
        Get-ADUser -Filter {EmailAddress -eq $Mail} | Set-ADUser -Enabled $false #����� ����� � ����� ������ � ��������
        echo "S1"} #������ ���: ��������� �� �����
     else {
        Get-ADUser -Filter {EmailAddress -eq $Mail} | Set-ADUser -Enabled $true #����� ����� � ����� ������ � �������
        echo "S01"} #������ ���: �������� �� �����
        }
    else {
        echo "S2"} #������ ���: �������� � ����� ������ ���
         
            