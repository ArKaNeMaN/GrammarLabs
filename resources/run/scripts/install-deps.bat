@echo off

call resources\run\scripts\config

echo Update/Install composer packages...
echo.
%COMPOSER_EXECUTABLE% install

echo Update/Install node modules...
echo.
call %NPM_EXECUTABLE% install

echo Build front-end static files...
echo.
call %NPM_EXECUTABLE% run build
