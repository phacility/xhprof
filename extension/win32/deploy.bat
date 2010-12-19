@echo off
TITLE deployment
cls

REM config
set path_ext=%1
set name_ext=%2
set name_service=%3
set mode=%4
set packer=upx.exe
set tmpname=tmp.dll
set deploy_logfile=deploy.log

REM header/banner
echo .
echo *****************************************************************************
echo * deploying ...
echo * 
echo * file: %name_ext%
echo * source: %cd%\%mode%\%name_ext%
echo * packer: %packer%
echo * destination: %path_ext%
echo * service: %name_service%
echo * %path_ext%%name_ext%
echo * ... please wait
echo *****************************************************************************
echo .

REM stop Apache + PHP for extension overwrite
echo stopping apache + php [service = "%name_service%"] ...
NET STOP %name_service% > %deploy_logfile%

REM packing dll
echo packing extension [%name_ext%] with packer [%packer%] ...
%packer% -9 -o "%cd%\%mode%\%tmpname%" "%cd%\%mode%\%name_ext%" >> %deploy_logfile%

REM delete old extension
echo removing existing extension [%name_ext%] ...
del %path_ext%%name_ext% >> %deploy_logfile%

REM copy new version of extension
echo copying extension [%name_ext%] to target-folder ...
copy %cd%\%mode%\%tmpname% %path_ext%%name_ext% >> %deploy_logfile%

REM delete tmp file
echo removing temporary created files ...
del %cd%\%mode%\%tmpname% >> %deploy_logfile%

REM start
echo starting apache + php [service = "%name_service%"] ...
NET START %name_service% >> %deploy_logfile%

REM log.info
echo for more information view: "%deploy_logfile%"

REM close console
pause