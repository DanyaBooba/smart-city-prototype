from datetime import datetime
from sync import *
import time

count = 1
while True:

    sync(isdebug=True)

    gettime = datetimeformat(datetime.now())
    print("[" + str(count) + "] load success (" + str(gettime) + ") [DEBUG]")
    count += 1

    time.sleep(timesleep)
