#include <Servo.h>
#include <LiquidCrystal.h>

int pinGerbang  = 9; //PIN servo roda4
int servoAngle;
int ledMerah    = 12;
int ledHijau    = 13;
int buzzer      = 8;

String command;
String attr;

LiquidCrystal lcd(7, 6, 5, 4, 3, 2);
Servo gerbang;

/* VSS -> GND
 * VDD -> 5V
 * V0  -> POTENTIOMETER CENTER
 * RS  -> PIN 7
 * RW  -> GND
 * E   -> PIN 6
 * D4  -> PIN 5
 * D5  -> PIN 4
 * D6  -> PIN 3
 * D7  -> PIN 2
 * A   -> 5V
 * K   -> GND
 */
 
void welcome(){
  
  digitalWrite(buzzer, LOW); //low
  
  lcd.clear();
  lcd.setCursor(6, 0);
  lcd.print("SMART");
  lcd.setCursor(5, 1);
  lcd.print("HIGHWAY");
  
  digitalWrite(ledMerah, HIGH);
  digitalWrite(ledHijau, LOW); //low
  
  gerbang.write(100);
  
}

void setup() {
  // put your setup code here, to run once:
  Serial.begin(9600); //38400
  
  pinMode(pinGerbang, OUTPUT);
  pinMode(ledMerah, OUTPUT);
  pinMode(ledHijau, OUTPUT);
  pinMode(buzzer, OUTPUT);
  
  digitalWrite(pinGerbang, HIGH);
  gerbang.attach(pinGerbang);
  
  lcd.begin(16, 2);
  
  welcome();

}

void loop() {
  while(Serial.available()){
    delay(5);

    char c  = Serial.read();
    command += c;
  }
  
  if(command.length() > 0){
      //Serial.println(command);
      char key  = command.charAt(0);
      if(key == '1' || key == '2'){
        
        for(int i=0; i<command.length(); i++){
          if(i+2 < command.length()){
            attr += command.charAt(i+2);
          }
        }
  
        digitalWrite(ledHijau, HIGH);
        digitalWrite(ledMerah, LOW);
        
        lcd.clear();
        lcd.setCursor(1,0);
        if(key == '1'){
          lcd.print("SILAHKAN LEWAT");
        }
        else{
          lcd.print("SELAMAT JALAN");
          lcd.setCursor(1,1);
          lcd.print("TERIMAKASIH");
        }
        
        for(servoAngle = 100; servoAngle >= 0; servoAngle--)
        {                
          digitalWrite(buzzer, HIGH);                  
          gerbang.write(servoAngle);
                       
          delay(20);
          digitalWrite(buzzer, LOW);
                       
        }
        
        delay(5000); // lama gerbang terbuka
        
        for(servoAngle = 0; servoAngle <= 100; servoAngle++)
        {             
          digitalWrite(buzzer, HIGH);                     
          gerbang.write(servoAngle);              
          delay(20);
          digitalWrite(buzzer, LOW);                  
        }
        
        digitalWrite(ledMerah, HIGH);
        digitalWrite(ledHijau, LOW);
        
  
        /*
        delay(1000);
        lcd.clear();
        lcd.setCursor(0,0);
        lcd.print("SISA SALDO ANDA");
        lcd.setCursor(0,1);
        lcd.print("RP.");
        lcd.print(attr);
        delay(5000); // lama menunjukkan nilai saldo
        */
        
        welcome();
      
      
        command = ""; 
        attr   = "";
      }
  }
}  
