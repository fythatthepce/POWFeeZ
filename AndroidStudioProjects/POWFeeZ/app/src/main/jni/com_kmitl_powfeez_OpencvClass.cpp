#include "com_kmitl_powfeez_OpencvClass.h"

JNIEXPORT void JNICALL Java_com_kmitl_powfeez_OpencvClass_Obj1Detection
  (JNIEnv *, jclass, jlong addrRgba){
    Mat& frame = *(Mat*)addrRgba;
    detect(frame);
}

void detect(Mat& frame){
    String human_cascade_name = "/storage/emulated/0/Download/1.xml";
    CascadeClassifier human_cascade;

    if( !human_cascade.load( human_cascade_name ) ){ printf("--(!)Error loading\n"); return; };

    std::vector<Rect> humans;
    Mat frame_gray;

    cvtColor( frame, frame_gray, CV_BGR2GRAY );
    equalizeHist( frame_gray, frame_gray );

    //-- Detect
    human_cascade.detectMultiScale( frame_gray, humans, 1.1, 2, 0|CV_HAAR_SCALE_IMAGE, Size(30, 30) );


    //draw rectangle
    for(int i=0;i<humans.size();i++)
        rectangle(frame,Point(humans[i].x , humans[i].y),Point(humans[i].x+humans[i].width , humans[i].y+humans[i].height),Scalar( 0, 255, 0 ),2);

    /*
    //draw ellipse
    for( int j = 0; j <  humans.size(); j++ )
    {
        Point center( humans[j].x + humans[j].width*0.5, humans[j].y+ + humans[j].height*0.5 );
        ellipse( frame, center, Size( humans[j].width*0.5, humans[j].height*0.5), 0, 0, 360, Scalar( 0, 255, 0  ), 4, 8, 0 );
    }
     */

}
