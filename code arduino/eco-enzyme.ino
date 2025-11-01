#include <DHT.h>
#include <WiFi.h>
#include <EEPROM.h>
#include <Firebase_ESP_Client.h>
#include "addons/TokenHelper.h"
#include "addons/RTDBHelper.h"
#include "GravityTDS.h"

// WiFi credentials
#define WIFI_SSID ""
#define WIFI_PASSWORD ""

// Firebase credentials
#define API_KEY ""
#define DATABASE_URL ""
#define USER_EMAIL ""
#define USER_PASSWORD ""

// DHT setup
#define DHTPIN 21
#define DHTTYPE DHT22
DHT dht(DHTPIN, DHTTYPE);

// Gravity TDS Setup
#define EEPROM_SIZE 512
GravityTDS gravityTds;
float temperature = 25, tdsValue;

// Calibration PH
float PH4 = 3.15;
float PH7 = 2.46;

// Firebase objects
FirebaseData fbdo;
FirebaseAuth auth;
FirebaseConfig config;

unsigned long sendDataPrevMillis = 0;

void setup() {
  Serial.begin(115200);
  dht.begin();
  EEPROM.begin(EEPROM_SIZE);
  gravityTds.setPin(34);
  gravityTds.setAref(3.3);
  gravityTds.setAdcRange(4096);
  gravityTds.begin();

  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  Serial.print("Menghubungkan ke WiFi...");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    delay(300);
  }
  Serial.println();
  Serial.println("Terhubung ke WiFi: " + WiFi.localIP().toString());

  config.api_key = API_KEY;
  config.database_url = DATABASE_URL;
  config.token_status_callback = tokenStatusCallback;

  auth.user.email = USER_EMAIL;
  auth.user.password = USER_PASSWORD;

  Firebase.begin(&config, &auth);
  Firebase.reconnectWiFi(true);
}

void loop() {
  if (Firebase.ready() && (millis() - sendDataPrevMillis > 5000 || sendDataPrevMillis == 0)) {
    sendDataPrevMillis = millis();

    float h = dht.readHumidity();
    float t = dht.readTemperature();

    // pH Value
    float phRaw = analogRead(35) * (3.3 / 4095.0);
    float PH_step = (PH4 - PH7) / 3;
    float pHValue = 7 + ((PH7 - phRaw) / PH_step);

    // Turbidity Value
    float voltage = analogRead(39) * (3.3 / 4096.0);
    float turbidityValue = -1120.4 * voltage * voltage + 5742.3 * voltage - 4352.9;

    // Salinity Value
    gravityTds.setTemperature(temperature);  
    gravityTds.update(); 
    tdsValue = gravityTds.getTdsValue();

    // MQ-7 Value
    int mq7Raw = analogRead(36);
    float coPPM = map(mq7Raw, 0, 4096, 0, 1000);

    Serial.println("DATA SENSOR:");
    Serial.print("Suhu : "); 
    Serial.println(t, 2); 
    Serial.print("Kelembapan : "); 
    Serial.println(h, 2); 

    Serial.print("Volt : "); 
    Serial.println(phRaw, 2); 
    Serial.print("PH : "); 
    Serial.println(pHValue, 2); 

    Serial.print("Turbiditas : "); 
    Serial.println(turbidityValue, 2); 

    Serial.print("Salinitas : "); 
    Serial.println(tdsValue, 2); 

    Serial.print("MQ-7 : "); 
    Serial.println(coPPM, 2); 
    Serial.println("------------------------------------------------------");

    // ✅ Validate before sending
    simpanDataSensor("/sensor_data/suhu", t, "°C");
    simpanDataSensor("/sensor_data/kelembaban", h, "%");
    simpanDataSensor("/sensor_data/mq7", coPPM, "ppm");
    simpanDataSensor("/sensor_data/pH", pHValue, "pH");
    simpanDataSensor("/sensor_data/turbiditas", turbidityValue, "NTU");
    simpanDataSensor("/sensor_data/salinitas", tdsValue, "ppt");
  }

  delay(1800000);  // 30 minute delay
}

void simpanDataSensor(String path, float value, String unit) {
  Serial.print("Menyimpan ke Firebase: ");
  Serial.print(path); Serial.print(" = "); Serial.print(value); Serial.println(" " + unit);

  if (Firebase.RTDB.setFloat(&fbdo, path + "/value", value)) {
    Firebase.RTDB.setString(&fbdo, path + "/unit", unit);
    Serial.println("Tersimpan di Firebase.");
  } else {
    Serial.print("Gagal simpan: ");
    Serial.println(fbdo.errorReason());
  }
}

float mapFloat(float x, float in_min, float in_max, float out_min, float out_max) {
  return (x - in_min) * (out_max - out_min) / (in_max - in_min) + out_min;
}
