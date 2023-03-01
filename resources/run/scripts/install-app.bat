@echo off

call resources\run\scripts\config

copy %APP_DIR%\.env.prod %DOT_ENV%
%ARTISAN% key:gen
%ARTISAN% migrate --force
