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


    if( robot.IsOnTouch() ){
      
        Car1.SetSpeed(250);

        
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
    else if( robot.IsOnJoy() ){
      
        if(robot.joyZone==1) Car1.SetSpeed(150);
        else Car1.SetSpeed(250);

        
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
    else if( robot.IsOnVoice() ){
      
        Car1.SetSpeed(250);

        
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
    else if( robot.IsOnImage() ){
        
        Car1.SetSpeed(125);
        
        if(robot.CurrentStatus == "LEFT") 
        {   
            Car1.Backward(1);
            Car1.Left(5);
        }
    
         if(robot.CurrentStatus == "RIGHT") 
        {
            Car1.Backward(1);
            Car1.Right(5);
        }
             
        if(robot.CurrentStatus =="CENTER")
        {
            if(robot.size < 50) Car1.Backward(5);
            else if(robot.size > 100) Car1.Forward(5);
            else { robot.IsBreak(); Car1.Brake(); }
        }

    }
    
  }
}
