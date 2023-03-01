@echo off

call resources\run\scripts\config

call resources\run\scripts\install-deps

if not exist %DOT_ENV% (
    echo .env file not found.
    echo Initialization app...
    echo.

    copy %APP_DIR%\.env.prod %DOT_ENV%
    %ARTISAN% key:gen
)

%ARTISAN% migrate --force

