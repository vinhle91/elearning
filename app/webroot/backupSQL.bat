@echo off

set hr=%TIME:~0,2%
set min=%TIME:~3,2%

IF %hr% LSS 10 SET hr=0%hr:~1,1%
IF %min% LSS 10 SET min=0%min:~1,1%

For /f "tokens=2-4 delims=/ " %%a in ('date /t') do (set mydate=%%c-%%a-%%b)

set backuptime=%mydate%_%hr%-%min%

C:\xampp\mysql\bin\mysqldump --add-drop-table --host=localhost --user=root --result-file="C:\xampp\htdocs\elearning\app\webroot\backups_db\db-backup_%backuptime%.sql" e-learning