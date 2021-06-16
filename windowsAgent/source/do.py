import storage
import pymsgbox, os, time, requests, uuid, configparser
config = configparser.ConfigParser()
config.read('biblio.ini')
path=config["DATA"]["databasePath"]
csvPath=config["DATA"]["csvPath"]
serverurl=config["DATA"]["serverUrl"]
auth=config["DATA"]["authCode"]
significance=int(config["DATA"]["significance"])
verbose=bool(config["DATA"]["verbose"])
upwait=int(config["DATA"]["updateUserWait"])
chunkRowNum=int(config["DATA"]["chunkSize"])
def vprint(data):
    global verbose
    if verbose:
        print(data)
def upload(csvPath):
    global serverurl
    global auth
    vprint("Generating nonce uuid")
    uid=str(uuid.uuid4())
    data=auth+"\n"+uid+"\nBEGIN"
    requests.post(serverurl, data=data)
    vprint("Sent BEGIN")
    accumulator=""
    index=0
    for line in open(csvPath):
        if index==0:
            data=auth+"\n"+uid+"\nWRITE\n"
            accumulator=data
        accumulator+=line
        index+=1
        if index>chunkRowNum:
            vprint("Sent WRITE")
            requests.post(serverurl, data=accumulator)
            index=0
    requests.post(serverurl, data=accumulator)
    vprint("Sent WRITE")
    data=auth+"\n"+uid+"\nCONCLUDE"
    requests.post(serverurl, data=data)
    vprint("Sent CONCLUDE")
            
if not storage.exists("lastUpdate"):
    vprint("Last database update record has been initialized")
    storage.save("lastUpdate",0)
if not storage.exists("updateTick"):
    vprint("Update tick record has been initialized")
    storage.save("updateTick",0)
if not storage.exists("lastCSVUpdate"):
    vprint("Last csv upsate record has been initialized")
    storage.save("lastCSVUpdate",0)

while True:
    vprint("Main loop entered")
    try:
        vprint("In try-catch wrapper")
        if storage.load("lastUpdate")<os.path.getmtime(path):
            vprint("The database file has been updated since the last recorded time")
            storage.save("lastUpdate",os.path.getmtime(path))
            vprint("Updating the last recorded time accordingly")
            i=storage.load("updateTick")
            vprint("Reading tick register: "+str(i))
            if i>significance:
                vprint("The counter has overflowed the significance threshold")
                storage.save("updateTick",0)
                vprint("Resetting the counter to 0 accordingly")
                vprint("Displaying update dialog")
                pymsgbox.alert('Il catalogo dei libri è stato aggiornato.\nSi prega di cliccare File > Esporta Archivio > Esporta > Sì', 'Catalogo aggiornato')
                vprint("Dialog displayed, waiting "+str(upwait)+"s")
                time.sleep(upwait)
                vprint("Wait expired")
                if storage.load("lastCSVUpdate")<os.path.getmtime(csvPath):
                    vprint("Csv has been updated, good librarian!")
                    storage.save("lastCSVUpdate",os.path.getmtime(csvPath))
                    vprint("Updating the last recorded time accordingly")
                    vprint("Beginning upload")
                    upload(csvPath)#maybe check if export has been varied?
                
            else:
                storage.save("updateTick",i+1)
    except Exception as e:
        vprint("OOPS! :"+str(e))
        time.sleep(5)
    time.sleep(30)
