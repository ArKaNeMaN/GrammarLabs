@echo off

call resources\run\scripts\config

echo NodeJS version:
%NODE_EXECUTABLE% -v
echo NPM version:
call %NPM_EXECUTABLE% -v
echo.

%PHP_EXECUTABLE% -v
echo.

%COMPOSER_EXECUTABLE% -V
echo.
