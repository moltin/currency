@ECHO off
TITLE Moltin Currency Test Suite
GOTO RUN

REM #######################################################################
:RUN
REM #######################################################################

    CALL phpunit

CHOICE /C:RX /N /M "(R)un Tests Again or E(X)it: "
IF errorlevel 2 GOTO END
IF errorlevel 1 GOTO RUN

REM #######################################################################
:END
REM #######################################################################
ECHO.
ECHO.
ECHO All done!
ECHO.
ECHO.