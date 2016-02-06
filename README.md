# ardui-webiface
PHP web interface for data collection with Arduino

This was a quick hack to visualize data sent from an Arduino board.

- The sample arduino program is in arduino/FinalArduiMonitor.ino, which measures Temperature, Humidity, Light & Sound levels every 10sec and send them via wifi to the PHP app.

- The app saves received data in json format under the directory ardui-webiface/output/$date...

- The UI plots measured data with Google Charts, and reloads every few secs.
 
