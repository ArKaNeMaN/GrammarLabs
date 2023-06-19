@echo off

call resources\run\scripts\config

echo Installing env...
call resources\run\scripts\install-env
call resources\run\scripts\print-env-info

echo Installing deps...
call resources\run\scripts\install-deps

echo Installing app...
call resources\run\scripts\install-app

%ARTISAN% admin:create

echo App installed.
