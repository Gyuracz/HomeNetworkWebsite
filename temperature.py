import serial
import os
import time

monitor = serial.Serial('/dev/ttyACM0')
monitor.baudrate = '9600'

path = os.path.abspath(os.path.dirname(__file__))
path = path + "/temperature.csv"
print(path)

while True:
	data=monitor.readline().decode('utf-8')
	if data:
		print(data)
		with open(path, "w") as f:
			f.write(data)
		time.sleep(900)
