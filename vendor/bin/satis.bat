@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../composer/satis/bin/satis
php "%BIN_TARGET%" %*
