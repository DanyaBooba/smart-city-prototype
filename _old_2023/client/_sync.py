from formatdate import *
import os.path


def getjson():
    path = "files/localjson0.txt"
    if (os.path.exists(path) == False):
        return None

    with open(path, 'r', encoding='utf-8') as f:  # local
        text = f.read()
        f.close()
    return text


def logs(val, isdebug=False):
    if isdebug == False:
        with open('logs/logs.txt', 'a') as f:
            f.write(val+"\n")
            f.close()
    else:
        with open('logs_debug/logs.txt', 'a') as f:
            f.write(val+"\n")
            f.close()


def format(val):
    if (val == None):
        return "0"
    return round(val)


# additional substation
def id(val):
    if val == "Завод №1":
        return "Factory No.1"
    elif val == "Завод №2":
        return "Factory No.2"
    elif val == "Больница №1":
        return "Hospital No.1"
    elif val == "Больница №2":
        return "Hospital No.2"
    elif val == "Микро район №1":
        return "Housing No.1"
    elif val == "Микро район №2":
        return "Housing No.2"
    elif val == "Микро район №3":
        return "Housing No.3"
    elif val == "Микро район №4":
        return "Housing No.4"
    elif val == "Микро район №5":
        return "Housing No.5"
    elif val == "Микро район №6":
        return "Housing No.6"


def getbuild(val):
    returnarray = {
        "generatedpower": format(val['GeneratedPower']),
        "id": val['ID'],
        "active": val['IsON'],
        "type": val['ObjectType'],
        "power": format(val['Power']),
        "requiredpower": format(val['RequiredPower']),
    }

    return returnarray
