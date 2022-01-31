' add to shell:startup to run the script hidden
Set WshShell = CreateObject("WScript.Shell") 
WshShell.Run chr(34) & "C:\Users\Utente\Desktop\webui\run.bat" & Chr(34), 0
Set WshShell = Nothing
