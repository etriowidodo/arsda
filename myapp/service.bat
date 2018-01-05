CD c:\     
cd c:\myapp\apache\bin 
httpd.exe -k install -n "ArfaHttpd"
net start "ArfaHttpd"
cd c:\myapp\db\App\PgSQL\bin
pg_ctl.exe register -N PostgreSqlArfa -D "c:\myapp\db\Data\data"
net start "PostgreSqlArfa"

exit
#pindah direktory c
#pindah direktory c ke d
#pindah kedirektory d s/d bin
#install httpd.exenya install untuk install uninstall untuk uninstall
#httpd.exe -k install -n "Nama Service"
#net start "TestApp" running service
#exit keluar dari cmd
#Filename: "{cmd}"; Parameters: "/C ""{app}\service.bat"""
