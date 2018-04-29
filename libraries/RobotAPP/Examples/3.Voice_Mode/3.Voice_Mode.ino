#include <RobotAPP.h>
#include "AlphaBot.h"

AlphaBot Car1 = AlphaBot();
RobotAPP robot(0,1,"Robot","Car");

void setup() {
  Car1.SetSpeed(250); 
  robot.begin(9600);
}

void loop() {
  if( robot.available() ){

    if( robot.IsOnVoice() ){
 
           if(robot.CurrentStatus == "RIGHT") 
            {   
                Car1.Backward(1);
                Car1.Left(50);
            }
        
             if(robot.CurrentStatus == "LEFT") 
            {
                Car1.Backward(1);
                Car1.Right(50);
                
            }
            if(robot.CurrentStatus == "GO") 
            {
                Car1.Backward(50);
            }
        
             if(robot.CurrentStatus == "BACK") 
            {
                Car1.Forward(50);
            }

            if(robot.CurrentStatus =="BREAK")
            {
                Car1.Brake();
                robot.IsBreak();
            } 
    }

    
  }
}
