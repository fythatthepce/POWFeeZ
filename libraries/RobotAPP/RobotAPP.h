

#ifndef RobotAPP_h

#define RobotAPP_h

#include <SoftwareSerial.h>
#include "Arduino.h"

class RobotAPP
{
	public:
		RobotAPP(uint8_t RxPin, uint8_t TxPin,const char* Name,const char* Type);
		void begin(long speed);


		bool available();
		

		bool IsOnTouch();
		bool IsOnJoy();
		bool IsOnVoice();
		bool IsOnImage();
		void IsBreak();
		

		String CurrentStatus="No Status";
		int size = 0;
		int joyZone = 0;

		String Name = "";
		String Type = "";

		

	private:
		void GetStatus();

		uint8_t Rx = 0;
		uint8_t Tx = 1;
		
		SoftwareSerial *Robot;

		bool ontouch = false;
		bool onvoice = false;
		bool onjoy = false;
		bool onimage = false;
};

#endif




