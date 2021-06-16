from pathlib import Path
import json, os

loadCache = {}


class CorruptDataException(Exception):
    pass


def flushLoadCache():
    loadCache = {}


class AbsentRecordException(Exception):
    pass


def exists(name, saveSpace="Default"):
    f = Path("data/storage/" + saveSpace + "/" + name + ".json")
    return f.is_file()


def delete(name, saveSpace="Default", silent=False):
    if exists(name, saveSpace):
        os.unlink("data/storage/" + saveSpace + "/" + name + ".json")
    else:
        if not silent:
            raise AbsentRecordException("Record " + name +
                                        " not found in savespace " + saveSpace)


def commitToDisk(name=False, Savespace=False):
    for ISaveSpace in loadCache.keys():
        if Savespace != False:
            if ISaveSpace != Savespace:
                continue
        for Iname in loadCache[ISaveSpace].keys():
            if name != False:
                if Iname != name:
                    continue
            save(Iname, loadCache[ISaveSpace][Iname], ISaveSpace)


def refreshFromDisk(name=False, Savespace=False):
    for ISaveSpace in loadCache.keys():
        if Savespace != False:
            if ISaveSpace != Savespace:
                continue
        for Iname in loadCache[ISaveSpace].keys():
            if name != False:
                if Iname != name:
                    continue
            load(Iname, ISaveSpace, True)


def save(name, value, saveSpace="Default", useCacheOnly=False):
    if saveSpace in loadCache.keys():
        if name in loadCache[saveSpace].keys():
            loadCache[saveSpace][name] = value
    if useCacheOnly:
        if saveSpace not in loadCache.keys():
            loadCache[saveSpace] = {}
        if name not in loadCache[saveSpace].keys():
            loadCache[saveSpace][name] = value
    else:
        Path("data/storage/" + saveSpace).mkdir(parents=True, exist_ok=True)
        with open("data/storage/" + saveSpace + "/" + name + ".json",
                  "w+") as file:
            file.write(json.dumps(value))


def load(name, saveSpace="Default", cached=False):
    if cached and saveSpace in loadCache.keys():
        if name in loadCache[saveSpace].keys():
            return loadCache[saveSpace][name]
    try:
        with open("data/storage/" + saveSpace + "/" + name + ".json",
                  "r") as file:
            try:
                res = json.loads(file.read())
                if cached:
                    if saveSpace not in loadCache.keys():
                        loadCache[saveSpace] = {}
                    if name not in loadCache[saveSpace].keys():
                        loadCache[saveSpace][name] = res
                return res

            except json.decoder.JSONDecodeError as e:
                raise CorruptDataException("Data inside " + name +
                                           " (savespace " + saveSpace +
                                           ") is not valid Json")
    except FileNotFoundError as e:
        raise AbsentRecordException("Record " + name +
                                    " not found in savespace " + saveSpace)
