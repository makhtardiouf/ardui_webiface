// Environment monitoring using an Arduino Board
// (C) 2015 - Makhtar Diouf
// Requires libraries from the Ardu-ez CD

// Files to be moved to a main.h  header
#include "Humidity.h"
#include "RgbLed.h"
#include "Buzzer.h"
#include "Light.h"
#include "Sound.h"
#include "UltraSonic.h"
#include "RgbLcd.h"
#include "SPI.h"
#include "WiFly.h"
#include "WiFlyServer.h"
#include "Wire.h"

#define TEMP_ADDR  72
#define TEMP_REG  0
#define CONF_REG  1

#define SOUND_PIN 56
#define LIGHT_PIN 57
#define HUM_PIN 54
#define BUZ_PIN 11
#define RGB_DPIN 81
#define RGB_CPIN 82
#define LED_PIN  11
#define ULTRA_PIN 75
#define HUM_WARN_VAL 38

Humidity hum;
Light light;
Sound sound;
RgbLcd lcd;
UltraSonic ultra;

bool connected = false;

// Server side http://203.255.56.53:9000
byte server[] = { 203, 255, 56, 53 };
WiFlyClient client(server, 9000);

// Arduino side
WiFlyServer srv(9000);

void setup() {
  hum.begin(HUM_PIN);
  light.begin(LIGHT_PIN);
  sound.begin(SOUND_PIN);
  ultra.begin(ULTRA_PIN);

  Wire.begin();
  pinMode(LED_PIN, OUTPUT);
  lcd.begin(62, 63, 64, 65, 66, 67, 45, 44, 43, 42);
  lcd.onBacklightGreen();

  Serial.begin(9600);
  configWifi();
}


void loop() {
  lcd.clear();
  lcd.print("Monitoring...");
  lcd.setCursor(0, 1);

  //testNwData();
  txData();
  readNwData();
  receiveInput(); 
}

// Connect to Wifi Access point, then remote server
void configWifi() {
  char ssid[] = "digitalcomm";
  char pass[] = "";
  WiFly.begin();

  if (!WiFly.join(ssid, pass)) {
    Serial.println("WiFi assoc failed!!");
    return;
  }
  delay(100);
  Serial.print("IP: ");
  Serial.println(WiFly.ip());
  Serial.println("\n\rWiFly shield terminal routine: \"$$\n");

  // Start the local server
  srv.begin();
  connectToRemoteSrv();
}

//*** Data collection
double getHumidity() {
  // unit dBm
  return hum.read();
}

double getLight() {
  // unit Lux
  return light.read();
}

double getSoundLevel() {
  // unit dBm
  return sound.read();
}

double getDistance() {
  // unit mm
  int nDist = ultra.ReadDistanceMilimeter();

  if (nDist < 100) {
    ledOn(true);
  } else {
    ledOn(false);
  }
  return nDist;
}

double getTemperature() {
  Wire.beginTransmission(TEMP_ADDR);
  Wire.write(byte(TEMP_REG));
  Wire.endTransmission();
  Wire.requestFrom(TEMP_ADDR, 2);
  byte hData = Wire.read();
  byte lData = Wire.read();

  int tmpVal = hData;
  tmpVal = (tmpVal << 8) | lData;
  tmpVal = tmpVal >> 4;

  float tmpFlt = float(tmpVal) * 0.0625;
  return  tmpFlt;
}

void ledOn(boolean isOn) {
  if (isOn) {
    digitalWrite(LED_PIN, HIGH);
  } else {
    digitalWrite(LED_PIN, LOW);
  }

  delay(500);
}

// Connect to web server
void connectToRemoteSrv() {
  if (client.connect()) {
    connected = true;
    Serial.println("connected");
  } else {
    Serial.println("connection failed");
    connected = false;
  }
}

//  Transmit collected data to server
void txData() {
  String data = "GET /rxdata.php?hum=";
  data += getHumidity();
  data += "&light=" ;
  data += getLight();
  data += "&sound=";
  data += getSoundLevel();
  data += "&temp=";
  data += getTemperature();
  data += "&fromardui=true";
  data += " HTTP/1.1";

  if (!client.connected()) {
    connectToRemoteSrv();
  }

  client.println(data);
  client.println();
  Serial.print("TXed: ");
  Serial.println(data);
  lcd.clear();
  lcd.print("TXed...");
  
  delay(100);
  readNwData();
  delay(10000);
  txData();
}

// Read response from server
void readNwData() {
  String data;
  int waitingTime = 0;

  while (data.length() < 300) {
    if (client.available()) {
      data += client.readChar();
    } else {
      delay(50);
      waitingTime++;
    }
    if (waitingTime > 5) {
      break;
    }
  }

  if (data.length() > 0) {
    Serial.print("RXed: ");
    Serial.println(data);
    lcd.clear();
    lcd.print("RXed...");
  }
}

// Receive instruction from the server, and perform an action on Arduino
// Adapted from libraries/WiFly_Shield/examples/WiFly_WebServer
void receiveInput() {
  
  WiFlyClient client = srv.available();
  if (client) {
    boolean isBlankLine = true;
    while (client.connected()) {
      if (client.available()) {
        char c = client.read();
        if (c == '\n' && isBlankLine) {
          client.println("HTTP/1.1 200 OK");
          client.println("Content-Type: text/html");
          client.println();

          // Trigger Alert...etc
          ledOn(true);
          break;
        }
        if (c == '\n') {
          isBlankLine = true;
        } else if (c != '\r') {
          isBlankLine = false;
        }
      }
    }
  }
  delay(100);
  ledOn(false);
}

// Network TxRx test
void testNwData() {
  delay(1000);
  if (connected) {
    client.println("GET /rxdata.php?hum=1.0 HTTP/1.1");
    client.println();
    //delay(100);
    readNwData();

  }
}
