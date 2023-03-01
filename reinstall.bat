@echo off

call resources\run\scripts\config

echo Uninstalling app and env...
call resources\scripts\uninstall

call install

echo App reinstalled.
