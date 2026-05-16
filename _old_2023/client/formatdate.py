def datetimeformat(dt, isdebug=False):
    if isdebug == True:
        return str(dt.day) + "_" + str(dt.month) + "_" + \
            str(dt.year) + " " + str(dt.hour) + "_" + str(dt.minute)
    return str(dt.day) + "." + str(dt.month) + "." + \
        str(dt.year) + " " + str(dt.hour) + ":" + str(dt.minute)
