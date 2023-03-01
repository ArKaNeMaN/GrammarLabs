@echo off

call resources\run\scripts\config

del /s /f /q %APP_DIR%\.run\*.*
for /f %%f in ('dir /ad /b %APP_DIR%\.run\') do rd /s /q %APP_DIR%\.run\%%f

del /q %APP_DIR%\database\database.sqlite
del /q %DOT_ENV%
