import io
import cv2
import socket
import struct
from PIL import Image

cap = cv2.VideoCapture(1)
clientsocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
clientsocket.connect(('dev.izobretarium.ru', 9093))
while True:
    ret, frame = cap.read()
    if ret:
        buf = io.BytesIO()
        Image.fromarray(cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)).save(buf, "JPEG")
        data = buf.getvalue()
        message_size = struct.pack("L", len(data))
        clientsocket.sendall(message_size + data)
