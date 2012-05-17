'*******************************************************************************
'
' Copyright (c) 2010 Benjamin Carl
' 
' Licensed under the Apache License, Version 2.0 (the "License");
' you may not use this file except in compliance with the License.
' You may obtain a copy of the License at
'
'    http://www.apache.org/licenses/LICENSE-2.0
'
' Unless required by applicable law or agreed to in writing, software
' distributed under the License is distributed on an "AS IS" BASIS,
' WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
' See the License for the specific language governing permissions and
' limitations under the License.
'
'*******************************************************************************
Option Explicit

Dim txt, path

txt = "Select folder containing PHP source (e.g. C:\PHP-5.3.3)." & vbcrlf &_
"The source folder should contain the folder TSRM\ Zend\ and win32\ for example"

path = BrowseFolder("My Computer", False, txt)

if (Len(path) = 0) then
    WScript.Echo "The path seems to be invalid! Can't continue ..."
Else
    Process "xhprof.example.dsp", path
    WScript.Echo "Now open xhprof.dsw with the VC++ IDE and enjoy coding!"
End If


Function BrowseFolder(myStartLocation, blnSimpleDialog, txt)
    Const MY_COMPUTER = &H11&
    Const WINDOW_HANDLE = 0

    Dim numOptions, objFolder, objFolderItem
    Dim objPath, objShell, strPath, strPrompt

    ' Set the options for the dialog window
    If (Len(txt) = 0) then
        txt = "Select a folder:"
    End If
    strPrompt = txt
    If blnSimpleDialog = True Then
        numOptions = 0      ' Simple dialog
    Else
        numOptions = &H10&  ' Additional text field to type folder path
    End If
    
    ' Create a Windows Shell object
    Set objShell = CreateObject("Shell.Application")

    ' If specified, convert "My Computer" to a valid
    ' path for the Windows Shell's BrowseFolder method
    If UCase(myStartLocation) = "MY COMPUTER" Then
        Set objFolder = objShell.Namespace(MY_COMPUTER)
        Set objFolderItem = objFolder.Self
        strPath = objFolderItem.Path
    Else
        strPath = myStartLocation
    End If

    Set objFolder = objShell.BrowseForFolder(WINDOW_HANDLE, strPrompt, _
                                              numOptions, strPath)

    ' Quit if no folder was selected
    If objFolder Is Nothing Then
        BrowseFolder = ""
        Exit Function
    End If

    ' Retrieve the path of the selected folder
    Set objFolderItem = objFolder.Self
    objPath = objFolderItem.Path

    ' Return the path of the selected folder
    BrowseFolder = objPath
End Function


Function Process(templateFile, phpSourcePath)
    Dim fso, fileIn, fileOut
    Dim content
    Set fso = CreateObject("Scripting.FileSystemObject")
    
    Set fileIn = fso.OpenTextFile(templateFile, 1, false)
    
    content = fileIn.ReadAll
    content = Replace(content, "__PHP_SOURCE_FOLDER__", phpSourcePath)
    
    Set fileOut = fso.CreateTextFile("xhprof.dsp")
    fileOut.Write(content)
End Function