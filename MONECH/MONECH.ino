#include <WiFi.h>
#include <HTTPClient.h>

// ================== KONFIGURASI WIFI ==================
const char* WIFI_SSID = "bruh";
const char* WIFI_PASSWORD = "abid2010";

// Ganti IP ini dengan IPv4 laptop/server kamu. ESP32 tidak bisa memakai localhost.
const char* SERVER_URL = "http://10.29.98.191/monech/api/device_reading.php";

// ================== IDENTITAS DEVICE ==================
// Samakan dengan ID Alat dan Token Alat yang tampil di halaman Profil.
const char* ID_ALAT = "MNC-003";
const char* DEVICE_TOKEN = "monech-device-003";

// ================== PIN ESP32 ==================
const int MQ2_PIN = 34;
const int BUZZER_PIN = 25;
const int LED_PIN = 26;

// ================== SETTING SENSOR ==================
const int BATAS_GAS_ON = 700;
const int BATAS_GAS_OFF = 600;

const int SEND_INTERVAL_MS = 3000;
const int READ_INTERVAL_MS = 300;
const int BUZZER_INTERVAL_MS = 200;

unsigned long lastSend = 0;
unsigned long lastRead = 0;
unsigned long lastBuzzer = 0;

int gasPpm = 0;
bool alarmAktif = false;
bool buzzerState = false;

// ================== BACA SENSOR RATA-RATA ==================
int readGasPpm() {
  long totalRaw = 0;

  for (int i = 0; i < 10; i++) {
    totalRaw += analogRead(MQ2_PIN);
    delay(10);
  }

  int raw = totalRaw / 10;

  // Mapping sederhana untuk demo. Untuk akurasi, MQ-2 perlu kalibrasi.
  int ppm = map(raw, 0, 4095, 0, 1000);
  return constrain(ppm, 0, 5000);
}

// ================== WIFI ==================
void connectWifi() {
  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  Serial.print("Menghubungkan WiFi");

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
    digitalWrite(LED_PIN, !digitalRead(LED_PIN));
  }

  Serial.println();
  Serial.println("WiFi terhubung");
  Serial.print("IP ESP32: ");
  Serial.println(WiFi.localIP());

  digitalWrite(LED_PIN, HIGH);
}

// ================== ALARM GAS STABIL ==================
void updateAlarm(int gasValue) {
  if (!alarmAktif && gasValue >= BATAS_GAS_ON) {
    alarmAktif = true;
    Serial.println("WARNING! Gas melewati batas!");
  }

  if (alarmAktif && gasValue <= BATAS_GAS_OFF) {
    alarmAktif = false;
    Serial.println("Gas kembali aman");
    digitalWrite(BUZZER_PIN, LOW);
    digitalWrite(LED_PIN, HIGH);
    buzzerState = false;
  }

  if (alarmAktif) {
    unsigned long now = millis();

    if (now - lastBuzzer >= BUZZER_INTERVAL_MS) {
      lastBuzzer = now;

      buzzerState = !buzzerState;
      digitalWrite(BUZZER_PIN, buzzerState);
      digitalWrite(LED_PIN, buzzerState);
    }
  } else {
    digitalWrite(BUZZER_PIN, LOW);
    digitalWrite(LED_PIN, HIGH);
  }
}

// ================== KIRIM KE SERVER ==================
void sendReading(int gasValue) {
  if (WiFi.status() != WL_CONNECTED) {
    connectWifi();
  }

  float suhu = 28.0;
  float kelembapan = 65.0;

  HTTPClient http;
  http.begin(SERVER_URL);
  http.addHeader("Content-Type", "application/json");

  String payload = "{";
  payload += "\"id_alat\":\"" + String(ID_ALAT) + "\",";
  payload += "\"token\":\"" + String(DEVICE_TOKEN) + "\",";
  payload += "\"gas_ppm\":" + String(gasValue) + ",";
  payload += "\"suhu\":" + String(suhu, 1) + ",";
  payload += "\"kelembapan\":" + String(kelembapan, 1);
  payload += "}";

  int httpCode = http.POST(payload);

  Serial.print("HTTP Code: ");
  Serial.println(httpCode);

  if (httpCode > 0) {
    Serial.println(http.getString());
  } else {
    Serial.println("Gagal mengirim data ke server");
  }

  http.end();
}

// ================== SETUP ==================
void setup() {
  Serial.begin(115200);

  pinMode(BUZZER_PIN, OUTPUT);
  pinMode(LED_PIN, OUTPUT);

  digitalWrite(BUZZER_PIN, LOW);
  digitalWrite(LED_PIN, LOW);

  analogReadResolution(12);
  analogSetPinAttenuation(MQ2_PIN, ADC_11db);

  connectWifi();

  Serial.println("Sistem deteksi gas siap");
}

// ================== LOOP ==================
void loop() {
  unsigned long now = millis();

  if (now - lastRead >= READ_INTERVAL_MS) {
    lastRead = now;

    gasPpm = readGasPpm();

    Serial.print("Gas PPM: ");
    Serial.print(gasPpm);

    Serial.print(" | Alarm: ");
    Serial.println(alarmAktif ? "MERAH / BAHAYA" : "AMAN");
  }

  updateAlarm(gasPpm);

  if (now - lastSend >= SEND_INTERVAL_MS) {
    lastSend = now;
    sendReading(gasPpm);
  }
}
