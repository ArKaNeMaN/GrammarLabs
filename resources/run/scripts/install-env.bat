@echo off

call resources\run\scripts\config

if not exist %NODE_DIR% mkdir %NODE_DIR%
if not exist %NODE_EXECUTABLE% (
    echo NodeJS executable not found.
    echo Installing NodeJS v19.4.0 from %NODE_PACKAGE_URL%...
    echo.

    powershell -Command "Invoke-WebRequest '%NODE_PACKAGE_URL%' -OutFile '%NODE_PACKAGE_ZIP%'"
    powershell -Command "Expand-Archive -Path '%NODE_PACKAGE_ZIP%' -DestinationPath '%NODE_DIR%' -Force"
    del %NODE_PACKAGE_ZIP%
)

if not exist %PHP_DIR% mkdir %PHP_DIR%
if not exist %PHP_EXECUTABLE% (
    echo PHP executable not found.
    echo Installing PHP v8.2 from %PHP_PACKAGE_URL%...
    echo.

    powershell -Command "Invoke-WebRequest '%PHP_PACKAGE_URL%' -OutFile '%PHP_PACKAGE_ZIP%'"
    powershell -Command "Expand-Archive -Path '%PHP_PACKAGE_ZIP%' -DestinationPath '%PHP_DIR%' -Force"
    del %PHP_PACKAGE_ZIP%
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
