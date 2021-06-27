# BiblioMxWeb



> Not official and not endorsed by Micla Multimedia Onlus

A system to extract data from a [BiblioMx](http://www.micla.org/freeware/bibliomx.html) system and display it on the Internet in a searchable fashion, trough a semi-automatic process

> **Notice**
>
> The GUI present in this software is in Italian, because of the primary audience of said software
> However, you may freely and easily fix this in your implementation

## Preamble

BiblioMx, despite being a pretty common library management software, saves data in custom binary files, and only allows exporting data to CSV.

This approach greatly limits the possibility of accessing and querying data through means other than the desktop program itself.

This is the major limitation that this project tries to address.

## Components

### Server

The server receives a CSV (trough chunking, if necessary) and concerts it into a sqllite database.

The PHP application provides a Web UI for searching and viewing books, including bibliographical data and availability

### Agent

The agent must be set to boot hidden at the start of the computer (functionality not included int the code)

``biblio.ini`` must be configured with the correct information, under the ``[DATA]`` section:

| Key  | Value |
| ---- | ----- |
|databasePath|The path to the xbb database|
|csvPath|The path to the csv export file|
|serverUrl|The URL to ``up.php``|
|authCode|The authentication code for that server instance|
|significance|The number of action that must be taken before the server shall be synced again|
|verbose|Show verbose output|
|updateUserWait|After prompting the user to update the CSV, how much time (s) to wait before moving on and uploading the file, starts after pressing "OK"|
|chunkSize|Chunk size (rows) for uploading the CSV|



Once the librarian performs a set number of actions, they will be asked to export the database manually to a csv, then the agent will upload it accordingly

The upload will also trigger the refresh of the sqllite database on the server when ended

