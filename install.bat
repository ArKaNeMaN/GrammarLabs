@echo off

call resources\run\scripts\config

echo Installing env...
call resources\run\scripts\install-env
call resources\run\scripts\print-env-info

echo Installing deps...
call "resources\scripts\install-deps"

echo Installing app...
call resources\run\scripts\install-app

echo App installed.
