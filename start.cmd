@echo off

set APP_DIR=%CD%
set APP_RUN_RESOURCES_DIR=%APP_DIR%\resources\run

set NODE_DIR=%APP_DIR%\.run\nodejs
set NODE_PACKAGE_URL=https://nodejs.org/dist/v19.4.0/node-v19.4.0-win-x64.zip
set NODE_PACKAGE_FOLDER=node-v19.4.0-win-x64
set NODE_PACKAGE_ZIP=%NODE_DIR%\%NODE_PACKAGE_FOLDER%.zip
set NODE_PACKAGE_DIR=%NODE_DIR%\%NODE_PACKAGE_FOLDER%
set NODE_EXECUTABLE=%NODE_PACKAGE_DIR%\node.exe
set NPM_EXECUTABLE=%NODE_PACKAGE_DIR%\npm.cmd

set PHP_DIR=%APP_DIR%\.run\php
set PHP_EXECUTABLE=%APP_DIR%\.run\php\php.exe
set PHP_PACKAGE_URL=https://windows.php.net/downloads/releases/php-8.2.3-nts-Win32-vs16-x64.zip
set PHP_PACKAGE_ZIP=%PHP_DIR%\php.zip

set COMPOSER_DIR=%APP_DIR%\.run\composer
set COMPOSER_INSTALLER=%COMPOSER_DIR%\composer-setup.php
set COMPOSER_EXECUTABLE_FILE=%COMPOSER_DIR%\composer.phar
set COMPOSER_EXECUTABLE=%PHP_EXECUTABLE% %COMPOSER_EXECUTABLE_FILE%

set DOT_ENV=%APP_DIR%\.env
set PUBLIC_DIR=%APP_DIR%\public
set ARTISAN=%PHP_EXECUTABLE% %APP_DIR%\artisan
set SERVER_PORT=80


if not exist %NODE_DIR% mkdir %NODE_DIR%

if not exist %NODE_EXECUTABLE% (
    echo NodeJS executable not found.
    echo Installing NodeJS v19.4.0 from %NODE_PACKAGE_URL%...
    echo.

    powershell -Command "Invoke-WebRequest '%NODE_PACKAGE_URL%' -OutFile '%NODE_PACKAGE_ZIP%'"
    powershell -Command "Expand-Archive -Path '%NODE_PACKAGE_ZIP%' -DestinationPath '%NODE_DIR%' -Force"
    del %NODE_PACKAGE_ZIP%
)

echo NodeJS version:
%NODE_EXECUTABLE% -v
echo NPM version:
call %NPM_EXECUTABLE% -v
echo.


if not exist %PHP_DIR% mkdir %PHP_DIR%

if not exist %PHP_EXECUTABLE% (
    echo PHP executable not found.
    echo Installing PHP v8.2 from %PHP_PACKAGE_URL%...
    echo.

    powershell -Command "Invoke-WebRequest '%PHP_PACKAGE_URL%' -OutFile '%PHP_PACKAGE_ZIP%'"
    powershell -Command "Expand-Archive -Path '%PHP_PACKAGE_ZIP%' -DestinationPath '%PHP_DIR%' -Force"
    del %PHP_PACKAGE_ZIP%
)
copy /Y %APP_RUN_RESOURCES_DIR%\php.ini %PHP_DIR%\php.ini

%PHP_EXECUTABLE% -v
echo.


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

%COMPOSER_EXECUTABLE% -V
echo.


echo Update/Install composer packages...
echo.
%COMPOSER_EXECUTABLE% install


echo Update/Install node modules...
echo.
call %NPM_EXECUTABLE% install

echo Build front-end static files...
echo.
call %NPM_EXECUTABLE% run build


if not exist %DOT_ENV% (
    echo .env file not found.
    echo Initialization app...
    echo.

    copy %APP_DIR%\.env.prod %DOT_ENV%
    %ARTISAN% key:gen
    %ARTISAN% migrate --force
)


echo Starting web-server on %SERVER_PORT% port.
echo Ctrl+C for exit.
echo.
%PHP_EXECUTABLE% -S 0.0.0.0:%SERVER_PORT% -t %PUBLIC_DIR%

