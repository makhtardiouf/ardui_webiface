# ardui-webiface
PHP web interface for data collection with Arduino

This is a quick implementation of a monitoring app that process data sent from an Arduino board. It could be extended for remote control purposes: think IoT.

- The sample arduino program is in arduino/FinalArduiMonitor.ino, which measures Temperature, Humidity, Light & Sound levels every 10sec and sends the data via wifi to the PHP web app.

- The app saves received data in json format under the directory ardui-webiface/output/$date...

- The UI plots measured data with Google Charts, and reloads every few secs.
 
Deployable under any web server or with the PHP internal server: e.g.  php -S 0.0.0.0:9000 , then set the server IP address in FinalArduiMonitor.ino

(C) 2016 Makhtar Diouf

