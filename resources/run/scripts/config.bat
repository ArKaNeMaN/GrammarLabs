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
