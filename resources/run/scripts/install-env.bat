@echo off

call resources\run\scripts\config

if not exist %NODE_DIR% mkdir %NODE_DIR%
if not exist %NODE_EXECUTABLE% (
    echo NodeJS executable not found.
    echo Unpack NodeJS v19.4.0 from %PHP_PACKAGE_ZIP%...
    rem echo Installing NodeJS v19.4.0 from %NODE_PACKAGE_URL%...
    echo.

    rem powershell -Command "(New-Object Net.WebClient).DownloadFile('%NODE_PACKAGE_URL%', '%NODE_PACKAGE_ZIP%')"
    Call :UnZipFile "%NODE_DIR%" "%NODE_PACKAGE_ZIP%"
    rem del %NODE_PACKAGE_ZIP%
    rem Can't download on win7 :(
)

if not exist %PHP_DIR% mkdir %PHP_DIR%
if not exist %PHP_EXECUTABLE% (
    echo PHP executable not found.
    echo Unpack PHP v8.2 from %PHP_PACKAGE_ZIP%...
    rem echo Installing PHP v8.2 from %PHP_PACKAGE_URL%...
    echo.

    rem powershell -Command "(New-Object Net.WebClient).DownloadFile('%PHP_PACKAGE_URL%', '%PHP_PACKAGE_ZIP%')"
    Call :UnZipFile "%PHP_DIR%" "%PHP_PACKAGE_ZIP%"
    rem del %PHP_PACKAGE_ZIP%
    rem Can't download win binaries without user-agent :(
)
copy /Y %APP_RUN_RESOURCES_DIR%\configs\php.ini %PHP_DIR%\php.ini

if not exist %COMPOSER_DIR% mkdir %COMPOSER_DIR%
if not exist %COMPOSER_EXECUTABLE_FILE% (
    echo Composer executable not found.
    echo Installing Composer by installer...
    echo.

    cd %COMPOSER_DIR%
    php -r "copy('https://getcomposer.org/installer', '%COMPOSER_INSTALLER%');"
    php %COMPOSER_INSTALLER%
    php -r "unlink('%COMPOSER_INSTALLER%');"
    cd %APP_DIR%
)

echo %CD%

goto :end

:UnZipFile <ExtractTo> <newzipfile>
set vbs="%temp%\_.vbs"
if exist %vbs% del /f /q %vbs%
>%vbs%  echo Set fso = CreateObject("Scripting.FileSystemObject")
>>%vbs% echo If NOT fso.FolderExists(%1) Then
>>%vbs% echo fso.CreateFolder(%1)
>>%vbs% echo End If
>>%vbs% echo set objShell = CreateObject("Shell.Application")
>>%vbs% echo set FilesInZip=objShell.NameSpace(%2).items
>>%vbs% echo objShell.NameSpace(%1).CopyHere(FilesInZip)
>>%vbs% echo Set fso = Nothing
>>%vbs% echo Set objShell = Nothing
cscript //nologo %vbs%
if exist %vbs% del /f /q %vbs%
exit /b

:end
