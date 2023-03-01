@echo off

call resources\run\scripts\config

call resources\run\scripts\print-env-info

echo Starting web-server on %SERVER_PORT% port.
echo Ctrl+C for exit.
echo.
%PHP_EXECUTABLE% -S 0.0.0.0:%SERVER_PORT% -t %PUBLIC_DIR%

