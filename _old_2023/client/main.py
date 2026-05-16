# Main script of sync
# IoT with server
#
# Author: Daniil Dybka
# daniil@dybka.ru

from datetime import datetime
from sync import *
import time

count = 1
while True:

    retsync = sync()

    gettime = datetimeformat(datetime.now())
    if (retsync == 1):
        print("[" + str(count) + "] load success (" + str(gettime) + ")")
        count += 1
    else:
        print("[Program error] " + str(gettime))

    time.sleep(timesleep)
