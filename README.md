# ardui-webiface
PHP web interface for data collection with Arduino

This is a quick hack to monitor data sent from an Arduino board, and could be extended for remote control purposes: think IoT.

- The sample arduino program is in arduino/FinalArduiMonitor.ino, which measures Temperature, Humidity, Light & Sound levels every 10sec and send them via wifi to the PHP app.

- The app saves received data in json format under the directory ardui-webiface/output/$date...

- The UI plots measured data with Google Charts, and reloads every few secs.
 
Deployable under any web server or with the PHP internal server: e.g.  php -S localhost:9000

(C) 2016 Makhtar Diouf

