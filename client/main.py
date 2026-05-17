from sync import sync
import time
from datetime import datetime

count = 1
while True:
    result = sync()
    status = "OK" if result == 1 else "ERROR"
    print(f"[{count}] {status} ({datetime.now().strftime('%H:%M:%S')})")
    count += 1
    time.sleep(3)
