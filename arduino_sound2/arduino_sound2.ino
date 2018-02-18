//Arduino
//HC-O5 Bluetooth
#include <SoftwareSerial.h>



//set BTSerial 2 =  RX , 3 = TX 
SoftwareSerial BTSerial(2, 3); // RX | TX

char command; //command = string from android studio
String string;  //string of arduno




  void setup()
  {
    
    pinMode(4, OUTPUT); //RIGHT
    pinMode(5, OUTPUT); //LEFT
    pinMode(6, OUTPUT); //GO
    pinMode(7, OUTPUT); //BACK
    
    Serial.begin(9600);
    BTSerial.begin(9600); 
  }

  void loop()
  {
    
    if (BTSerial.available() > 0) 
    {string = "";}    //init string = NULL
    
    while(BTSerial.available() > 0)
    {
      command = ((byte)BTSerial.read());  //get string from android studio
      
      if(command == ':')
      {
        break;
      }
      
      else
      {
        string += command;  //move command(string from android studio) to string of arduino
      }
      
      delay(1);
    }
    
    if(string == "RIGHT") //if string of arduino == TO
    {
        STOP_Off();
        RIGHT_On();

    }

     if(string == "LEFT") //if string of arduino == TO
    {
        STOP_Off();
        LEFT_On();

    }

    if(string == "GO") //if string of arduino == TO
    {
        STOP_Off();
        GO_On();

    }

     if(string == "BACK") //if string of arduino == TO
    {
        STOP_Off();
        DOWN_On();
    }

    
    
    if(string =="STOP") //if string of arduino == TF
    {
        STOP_Off();

    }
    Serial.println(string);  //show string of arduino in serial monitor
    
 }


//fuct to do
void RIGHT_On()
{
      digitalWrite(4,HIGH);
      delay(10);
}

void LEFT_On()
{
      digitalWrite(5,HIGH);
      delay(10);
}

void GO_On()
{
      digitalWrite(6,HIGH);
      delay(10);
}

void DOWN_On()
{
      digitalWrite(7,HIGH);
      delay(10);
}


 
 void STOP_Off()
 {
      digitalWrite(4, LOW);
      digitalWrite(5, LOW);
      digitalWrite(6, LOW);
      digitalWrite(7, LOW);
      delay(10);
 }
 

  
