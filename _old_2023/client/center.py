# Control for builds
# from server
#
# Author: Daniil Dybka
# daniil@dybka.ru

import c
import time
import json
import requests
from datetime import datetime
from formatdate import *

timesleep = 1.25

url = {
    "get": "https://vr.creagoo.ru/stats/return.php",
    "set": "https://vr.creagoo.ru/stats/set.php",
    "energo": "http://" + c.IP_ENERGO + ":8004/JSONGreenCity/"
}

changename = {
    "hospital_1": "Больница №1",
    "hospital_2": "Больница №2",
    "factory_1": "Завод №1",
    "factory_2": "Завод №2",
    "md_1": "Микро район №1",
    "md_2": "Микро район №2",
    "md_3": "Микро район №3",
    "md_4": "Микро район №4",
    "md_5": "Микро район №5",
    "md_6": "Микро район №6",
    "minisub_1": "МП1",
    "minisub_2": "МП2",
    "substation": "П",
}

debuglist = {}


def changestate(build):
    # requests.get(changestateturn('TurnOff', build['name']))
    if (build['state'] == 1):
        changestateturn('TurnOn', build['name'])  # local
    elif (build['state'] == 0):
        changestateturn('TurnOff', build['name'])  # local


def changestateturn(turn, name):
    return url['energo'] + turn + "?key=" +\
        changename[name]+"&soketnum=-1"


def getstate(buildname):
    ret = requests.get(url['get'], params={"b": buildname})
    if str(ret.text) == "0" or str(ret.text) == "1":
        return int(ret.text)
    return None

    # requests.post('https://httpbin.org/post', data = {'key':'value'})


def center():
    count = 0
    debuglist['info'] = {
        "datetime": datetimeformat(datetime.now())
    }
    for i in changename:
        changestate({
            "name": str(i),
            "state": getstate(str(i)),
        })

        debuglist[count] = {
            "name": str(i),
            "state": getstate(str(i)),
        }
        count += 1


def logs(getjson):
    with open('logs/logs_center.txt', 'a') as f:
        f.write(str(getjson)+"\n")
        f.close()


count = 1
while True:
    center()
    logs(json.dumps(debuglist))

    print("[" + str(count) + "] Cycle completed (" +
          datetimeformat(datetime.now()) + ")")
    count += 1
    time.sleep(timesleep)
