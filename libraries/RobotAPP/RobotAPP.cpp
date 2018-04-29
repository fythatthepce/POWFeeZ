

#include "RobotAPP.h"

RobotAPP::RobotAPP(uint8_t RxPin, uint8_t TxPin,const char* Name,const char* Type) 
{

  this->Name = Name;
  this->Type = Type;
  this->Rx = RxPin;
  this->Tx = TxPin;

  Robot = new SoftwareSerial(this->Rx, this->Tx);
}

void RobotAPP::begin(long speed)
{

  Robot->begin(speed);
  //Serial.begin(9600);
}

bool RobotAPP::available()
{
  if( Robot->available() ){
  	GetStatus();
  	return true;
  }
  else false ;
}

void RobotAPP::GetStatus()
{

    this->CurrentStatus = Robot->readStringUntil('.'); 
    //Serial.println(this->CurrentStatus);
}


bool RobotAPP::IsOnTouch()
{
  
  if( this->CurrentStatus[0]=='T' && this->CurrentStatus[1]=='O') 
  {
  	this->CurrentStatus = (this->CurrentStatus).substring(2);
    this->ontouch = true;
    return true;
  }
  else if(this->ontouch){
    return true;
  }
  else 
  {
    return false;
  }
  
}

bool RobotAPP::IsOnJoy()
{
  
  if( this->CurrentStatus[0]=='J' && this->CurrentStatus[1]=='O') 
  {
  	this->joyZone = (this->CurrentStatus[2])-48;
  	this->CurrentStatus = (this->CurrentStatus).substring(3);
    this->onjoy = true;
    //Serial.println(this->joyZone);
    return true;
  }
  else if(this->onjoy){
    return true;
  }
  else 
  {
    return false;
  }
  
}

bool RobotAPP::IsOnVoice()
{
  
  if( this->CurrentStatus[0]=='V' && this->CurrentStatus[1]=='O' ) 
  {
  	this->CurrentStatus = (this->CurrentStatus).substring(2);
    this->onvoice = true;
    return true;
  }
  else if(this->onvoice){
    return true;
  }
  else 
  {
    return false;
  }
  
}


bool RobotAPP::IsOnImage()
{
  
  if( this->CurrentStatus[0]=='I' && this->CurrentStatus[1]=='M' ) 
  {
  	this->size = this->CurrentStatus[2];

    if( this->CurrentStatus[4] < 48 || this->CurrentStatus[4] > 57 )
    {
      String temp1 = (this->CurrentStatus).substring(2,4);
      this->size = temp1.toInt();
      this->CurrentStatus = (this->CurrentStatus).substring(4);
      this->CurrentStatus.toUpperCase();
    }
    else{
      String temp2 = (this->CurrentStatus).substring(2,5);
      this->size = temp2.toInt();
      this->CurrentStatus = (this->CurrentStatus).substring(5);
      (this->CurrentStatus).toUpperCase();
    }
    this->onimage = true;
    //Serial.println(this->size);
    return true;
  }
  else if(this->onimage){
    return true;
  }
  else 
  {
    return false;
  }
  
}

void RobotAPP::IsBreak()
{
  this->ontouch = false;
  this->onvoice = false;
  this->onjoy = false;
  this->onimage = false;
}





