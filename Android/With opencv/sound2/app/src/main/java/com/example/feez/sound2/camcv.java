package com.example.feez.sound2;

import android.app.Activity;
import android.app.ProgressDialog;
import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothDevice;
import android.bluetooth.BluetoothSocket;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;

import org.opencv.android.CameraBridgeViewBase;
import org.opencv.core.Mat;

import android.app.ActivityManager;
import android.util.Log;
import android.view.WindowManager;
import org.opencv.android.BaseLoaderCallback;
import org.opencv.android.JavaCameraView;
import org.opencv.android.LoaderCallbackInterface;
import org.opencv.android.OpenCVLoader;

import org.opencv.core.Core;
import org.opencv.core.CvType;

import org.opencv.core.Point;
import org.opencv.core.Scalar;
import org.opencv.core.Size;
import org.opencv.imgproc.Imgproc;
import static android.content.ContentValues.TAG;
import static org.opencv.imgproc.Imgproc.CV_HOUGH_GRADIENT;
import static org.opencv.imgproc.Imgproc.GaussianBlur;
import static org.opencv.imgproc.Imgproc.putText;
import static org.opencv.imgproc.Imgproc.rectangle;

import android.os.Handler;
import android.os.Looper;
import android.widget.Toast;

import java.io.IOException;
import java.util.UUID;


public class camcv extends Activity implements CameraBridgeViewBase.CvCameraViewListener2{//scope

    //Bluetooth
    String address = null;
    //ArrayList<String> color = null;
    String color = null;

    private ProgressDialog progress;
    BluetoothAdapter myBluetooth = null;
    BluetoothSocket btSocket = null;
    private boolean isBtConnected = false;

    //SPP UUID. Look for it
    static final UUID myUUID = UUID.fromString("00001101-0000-1000-8000-00805F9B34FB");



    static{
        if(!OpenCVLoader.initDebug()){
            Log.d("TAG","OpenCV not loaded");
        }
        else{
            Log.d("TAG","OpenCV loaded");
        }
    }


    //YELLOW
    int iLowH_Y = 80;
    int iLowS_Y = 100;
    int iLowV_Y = 100;

    int iHighH_Y = 100;
    int iHighS_Y = 255;
    int iHighV_Y = 255;


    //RED
    int iLowH_R = 110;
    int iLowS_R = 100;
    int iLowV_R = 100;

    int iHighH_R = 130;
    int iHighS_R = 255;
    int iHighV_R = 255;


    //GREEN
    int iLowH_G = 50;
    int iLowS_G = 100;
    int iLowV_G = 100;

    int iHighH_G = 70;
    int iHighS_G = 255;
    int iHighV_G = 255;



    Mat imgHSV;
    Mat hue;
    Mat hue_image;
    Mat rgbimg;

    Mat overlay;


    Scalar sc1,sc2;

    Scalar sc1_R,sc2_R;
    Scalar sc1_G,sc2_G;
    Scalar sc1_Y,sc2_Y;


    //RGB color

    private static final Scalar RGB_RED = new Scalar(255, 0, 0);
    private static final Scalar RGB_WHITE = new Scalar(255, 255, 255);
    private static final Scalar RGB_GREEN = new Scalar(0,255,0);
    private static final Scalar RGB_YELLOW = new Scalar(255,255,0);
    private static final Scalar RGB_BLACK = new Scalar(0,0,0);
    private static final Scalar RGB_ORANGE = new Scalar(255,165,0);
    private static final Scalar RGB_BLUE = new Scalar(0,0,255);
    private static final Scalar RGB_PURPLE = new Scalar(255,0,255);
    private static final Scalar RGB_CYAN = new Scalar(0,255,255);



    //fixed frame size  640 x 480 -> results usually in higher FPS
    private static final boolean FIXED_FRAME_SIZE = true;

    //frame size width
    private static final int FRAME_SIZE_WIDTH = 640;

    //frame size height
    private static final int FRAME_SIZE_HEIGHT = 480;


    //log the memory usage per frame
    private static final boolean LOG_MEM_USAGE = true;

    //activity manager which is necessary for getting the memory usage
    private ActivityManager activityManager;

    //responsible for getting memory information
    private ActivityManager.MemoryInfo mi;


    JavaCameraView cameraView;

    private BaseLoaderCallback mLoaderCallback = new BaseLoaderCallback(this) {
        @Override
        public void onManagerConnected(int status) {
            switch (status) {
                case LoaderCallbackInterface.SUCCESS:
                {
                    Log.i(TAG, "OpenCV loaded successfully");

                    imgHSV = new Mat();
                    hue = new Mat();
                    hue_image = new Mat();
                    rgbimg = new Mat();
                    cameraView.enableView();

                    overlay = new Mat();

                    /*
                    //test fail
                    if(progress!=null) {
                        progress.dismiss();
                        progress = null;
                    }*/

                } break;
                default:
                {
                    super.onManagerConnected(status);
                } break;
            }
        }
    };



    @Override
    protected void onCreate(Bundle savedInstanceState) {//main
        super.onCreate(savedInstanceState);


        Intent newint = getIntent();
        address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS); //receive the address of the bluetooth device
        //color = getIntent().getStringArrayListExtra("ListViewClickedValue");
        color = getIntent().getStringExtra("ListViewClickedValue");

        /*
        if(color == "YELLOW"){
            sc1 = new Scalar(iLowH_Y,iLowS_Y,iLowV_Y);    //Low HSV
            sc2 = new Scalar(iHighH_Y,iHighS_Y,iHighV_Y);  //High HSV
        }else if(color == "RED"){
            sc1 = new Scalar(iLowH_R,iLowS_R,iLowV_R);
            sc2 = new Scalar(iHighH_R,iHighS_R,iHighV_R);
        }else if(color == "GREEN") {
            sc1 = new Scalar(iLowH_G, iLowS_G, iLowV_G);
            sc2 = new Scalar(iHighH_G, iHighS_G, iHighV_G);
        }*/


        //connect bluetooth
        new camcv.ConnectBT().execute(); //Call the class to connect



        getWindow().addFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON);
        setContentView(R.layout.activity_camcv);
        cameraView = (JavaCameraView)findViewById(R.id.cameraview);

        if (FIXED_FRAME_SIZE) {
            cameraView.setMaxFrameSize(FRAME_SIZE_WIDTH, FRAME_SIZE_HEIGHT);
        }

        cameraView.setCameraIndex(1);  // 0 = rear , 1 = front
        cameraView.setCvCameraViewListener(this);
        cameraView.enableView();
        //END SET SCREEN


        //Memory manage
        mi = new ActivityManager.MemoryInfo();
        activityManager = (ActivityManager) getSystemService(ACTIVITY_SERVICE);



        //Yellow Scalar
        sc1_Y = new Scalar(iLowH_Y,iLowS_Y,iLowV_Y);    //Low HSV
        sc2_Y = new Scalar(iHighH_Y,iHighS_Y,iHighV_Y);  //High HSV

        //RED
        sc1_R = new Scalar(iLowH_R,iLowS_R,iLowV_R);
        sc2_R = new Scalar(iHighH_R,iHighS_R,iHighV_R);

        //GREEN
        sc1_G = new Scalar(iLowH_G, iLowS_G, iLowV_G);
        sc2_G = new Scalar(iHighH_G, iHighS_G, iHighV_G);



        /*
        if(color == "YELLOW") {
            sc1 = sc1_Y;
            sc2 = sc2_Y;
        }
        */

        //Yellow Scalar
        //sc1 = new Scalar(iLowH_Y,iLowS_Y,iLowV_Y);    //Low HSV
        //sc2 = new Scalar(iHighH_Y,iHighS_Y,iHighV_Y);  //High HSV




        /*
        //test fail
        if(progress!=null) {
            progress.dismiss();
            progress = null;
        }*/

    }//main

    // fast way to call Toast
    private void msg(String s)
    {
        Toast.makeText(getApplicationContext(),s,Toast.LENGTH_LONG).show();
    }



    //Function Bluetooth
    private class ConnectBT extends AsyncTask<Void, Void, Void>  // UI thread
    {

        private boolean ConnectSuccess = true; //if it's here, it's almost connected
        // BluetoothDevice dispositivo;

        @Override
        protected void onPreExecute()
        {

            //test OK
            if(progress!=null) {
                progress.dismiss();
                progress = null;
            }


            progress = ProgressDialog.show(camcv.this, "Connecting...", "Please wait!!!");  //show a progress dialog
        }

        @Override
        protected Void doInBackground(Void... devices) //while the progress dialog is shown, the connection is done in background
        {
            /*
            //TEST Fail
            if(progress!=null) {
                progress.dismiss();
                progress = null;
            }
            */

            try
            {
                if (btSocket == null || !isBtConnected)
                {
                    myBluetooth = BluetoothAdapter.getDefaultAdapter();//get the mobile bluetooth device
                    BluetoothDevice dispositivo = myBluetooth.getRemoteDevice(address);//connects to the device's address and checks if it's available

                    btSocket = dispositivo.createInsecureRfcommSocketToServiceRecord(myUUID);//create a RFCOMM (SPP) connection
                    BluetoothAdapter.getDefaultAdapter().cancelDiscovery();
                    btSocket.connect();//start connection
                }
            }
            catch (IOException e)
            {
                ConnectSuccess = false;//if the try failed, you can check the exception here
                 /*
                //TEST Fail
                if(progress!=null) {
                    progress.dismiss();
                    progress = null;
                }
                */
            }
            return null;
        }

        @Override
        protected void onPostExecute(Void result) //after the doInBackground, it checks if everything went fine
        {
            /*
            //TEST FAIL
            if(progress!=null) {
                progress.dismiss();
                progress = null;
            }
            */

            super.onPostExecute(result);

            if (!ConnectSuccess) {
                msg("Connection Failed. Is it a SPP Bluetooth? Try again.");
                finish();
            }
            else
            {
                msg("Connected.");
                isBtConnected = true;

            }
            progress.dismiss();
        }
    }
    //END Function Bluetooth



    //Function command to arduino
    private void forward(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("GO.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }


    private void backward(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("BACK.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }

    private void left(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("LEFT.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }


    private void right(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("RIGHT.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }



    private void break_motor(){
        if (btSocket!=null)
        {
            try
            {
                //btSocket.getOutputStream().write("STOP".toString().getBytes());
                btSocket.getOutputStream().write("BREAK.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }

    private void ball(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("BALL.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }

    private void Disconnect()
    {
        if (btSocket!=null) //If the btSocket is busy
        {
            try
            {
                btSocket.getOutputStream().write("Disconnect.".toString().getBytes());
                btSocket.close(); //close connection
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
        finish(); //return to the first layout

    }
    //End Function command to arduino


    //Function Opencv
    @Override
    public void onResume()
    {


        /*
        //test fail
        if(progress!=null) {
            progress.dismiss();
            progress = null;
        }*/

        super.onResume();
        if (!OpenCVLoader.initDebug()) {
            Log.d(TAG, "Internal OpenCV library not found. Using OpenCV Manager for initialization");
            OpenCVLoader.initAsync(OpenCVLoader.OPENCV_VERSION_3_4_0, this, mLoaderCallback);

        } else {
            Log.d(TAG, "OpenCV library found inside package. Using it!");
            mLoaderCallback.onManagerConnected(LoaderCallbackInterface.SUCCESS);
        }

    }

    @Override
    protected void onPause() {
        super.onPause();
        if (cameraView != null)
            cameraView.disableView();

        if(progress!=null) {
            progress.dismiss();
            progress = null;
        }

        Disconnect();

    }


    @Override
    public void onCameraViewStarted(int width, int height) {
        imgHSV = new Mat(width,height, CvType.CV_16UC4);
        hue = new Mat(width,height, CvType.CV_16UC4);
        hue_image  = new Mat(width,height, CvType.CV_16UC4);
        rgbimg = new Mat(width,height, CvType.CV_16UC4);
        overlay = new Mat(width,height, CvType.CV_16UC4);
    }

    @Override
    public void onCameraViewStopped() {

        if(progress!=null) {
            progress.dismiss();
            progress = null;
        }

        Disconnect();

    }


    @Override
    public void onDestroy() {
        super.onDestroy();

        if (cameraView != null)
            cameraView.disableView();

        if(progress!=null) {
            progress.dismiss();
            progress = null;
        }

        Disconnect();
    }


    @Override
    public Mat onCameraFrame(CameraBridgeViewBase.CvCameraViewFrame inputFrame) {

        if (LOG_MEM_USAGE) {
            activityManager.getMemoryInfo(mi);
            long availableMegs = mi.availMem / 1048576L; // 1024 x 1024
            //Percentage can be calculated for API 16+
            //long percentAvail = mi.availMem / mi.totalMem;
            Log.d(TAG, "available mem: " + availableMegs);
        }


        //get rgb frame
        Mat Torgb = inputFrame.rgba();

        //Detect Color
        // Convert input image to HSV// Convert input image to HSV
        Imgproc.cvtColor(inputFrame.rgba(),imgHSV,Imgproc.COLOR_BGR2HSV);

        //fix mirror imgHSV
        Core.flip(imgHSV,imgHSV, 1);

        //Yellow color range
        Core.inRange(imgHSV,sc1_Y,sc2_Y,hue);  //YELLOW
        //Core.inRange(imgHSV,sc1,sc2,hue);
        Core.addWeighted(hue, 1.0, hue, 1.0, 0 , hue_image);

        //GaussianBlur
        org.opencv.core.Size s = new Size(9,9);
        GaussianBlur(hue_image, hue_image, s ,2, 2);

        //Canny to get edges only
        Imgproc.Canny(hue_image, hue_image, 0, 255);

        //Detect Circle
        Mat circles = new Mat();

        //default min r =  30  ,  max r = 200
        //current min r = 20 , max r = 200
        Imgproc.HoughCircles(hue_image, circles, CV_HOUGH_GRADIENT, 1, 100 , 100, 20, 20, 200);

        // holes between edge segments
        Imgproc.dilate(hue_image, hue_image, new Mat(), new Point(-1, 1), 1);

        //fix mirror rgb
        Core.flip(Torgb,Torgb, 1);

        //Screen width = 640 , height = 480;
        //Draw left rectangle
        int thick_l = -1;
        Point pos_l1 = new Point(0, 0);
        Point pos_l2 = new Point(213 , 480);   //x width , y height


        Torgb.copyTo(overlay);
        rectangle(overlay,pos_l1,pos_l2,RGB_PURPLE,thick_l);
        Core.addWeighted(overlay, 0.3, Torgb, 1 - 0.3, 0 , Torgb);


        //Draw right rectangle
        int thick_r = -1;
        Point pos_r1 = new Point(427, 0);
        Point pos_r2 = new Point(640 , 480);   //x width , y height

        Torgb.copyTo(overlay);
        rectangle(Torgb,pos_r1,pos_r2,RGB_GREEN,thick_r);
        Core.addWeighted(overlay, 0.3, Torgb, 1 - 0.3, 0 , Torgb);


        //Draw forward rectangle
        int thick_f = -1;
        Point pos_f1 = new Point(214, 0);
        Point pos_f2 = new Point(426 , 240);   //x width , y height

        Torgb.copyTo(overlay);
        rectangle(Torgb,pos_f1,pos_f2,RGB_YELLOW,thick_f);
        Core.addWeighted(overlay, 0.3, Torgb, 1 - 0.3, 0 , Torgb);


        //Draw backward rectangle
        int thick_b = -1;
        Point pos_b1 = new Point(214, 241);
        Point pos_b2 = new Point(426 , 480);   //x width , y height

        Torgb.copyTo(overlay);
        //rectangle(Torgb,pos_b1,pos_b2,RGB_CYAN,thick_b);
        rectangle(Torgb,pos_b1,pos_b2,RGB_YELLOW,thick_b);
        Core.addWeighted(overlay, 0.3, Torgb, 1 - 0.3, 0 , Torgb);


        //Draw circle
        Log.i(TAG, String.valueOf("size: " + circles.cols()) + ", " + String.valueOf(circles.rows()));
        if (circles.cols() > 0) {
            //Math.min(circles.cols(), 1) -> 1 Circle
            for (int x=0; x < Math.min(circles.cols(), 1); x++ ) {
                double circleVec[] = circles.get(0, x);

                if (circleVec == null) {
                    break;
                }

                Point center = new Point((int) circleVec[0], (int) circleVec[1]);
                int radius = (int) circleVec[2];

                //Draw circle in Torgb
                Imgproc.circle(Torgb, center, radius ,RGB_RED, 7);


                /*
                //Check point in range
                Point a_f1 = new Point(23,52);
                Point a_f2 = new Point(24,52);
                if( (center == a_f1) || (center == a_f2)){
                    forward_run();
                }*/


                Point pos_to_show = new Point(30, 50);
                Point pos_to_show2 = new Point(30, 100);
                String str_pos = String.format("("+"X:"+String.valueOf(circleVec[0])+","+"Y:"+String.valueOf(circleVec[1])+")");
                int fontface = Core.FONT_HERSHEY_SIMPLEX;
                double scale = 0.5;
                double scale2 = 1.5;

                int thickness1 = 1;
                int thickness2 = 2;

                //Show (x,y)
                Imgproc.putText(Torgb, str_pos, pos_to_show, fontface, scale, RGB_WHITE, thickness1);


                if(circleVec[0] < 213){
                    Imgproc.putText(Torgb,"Left", pos_to_show2, fontface, scale2,RGB_WHITE, thickness2);
                    //left_run();
                    right_run();
                }else if(circleVec[0] > 213 && circleVec[0] < 427 && circleVec[1] < 240){
                    Imgproc.putText(Torgb,"Forward", pos_to_show2, fontface, scale2,RGB_WHITE, thickness2);
                    //forward_run();
                    ball_run();
                }else if(circleVec[0] > 213 && circleVec[0] < 427 && circleVec[1] > 240){
                    //Imgproc.putText(Torgb,"Backward", pos_to_show2, fontface, scale2,RGB_WHITE, thickness2);
                    Imgproc.putText(Torgb,"Forward", pos_to_show2, fontface, scale2,RGB_WHITE, thickness2);
                    //backward_run();
                    ball_run();
                }else if(circleVec[0] > 427){
                    Imgproc.putText(Torgb,"Right", pos_to_show2, fontface, scale2, RGB_WHITE, thickness2);
                    //right_run();
                    left_run();
                }

            }

        }else  if (circles.cols() == 0){
            Point pos_to_show = new Point(30, 50);
            Point pos_to_show2 = new Point(30, 100);
            int fontface = Core.FONT_HERSHEY_SIMPLEX;
            double scale = 1.5; //0.4;
            int thickness = 2;//1;

            putText(Torgb,"",pos_to_show,fontface, scale, RGB_RED, thickness);
            stop_run();
        }//end drawcircle


        return Torgb;
    }
    //END Function Opencv


    public void forward_run(){
        Handler refresh = new Handler(Looper.getMainLooper());
        refresh.post(new Runnable() {
            public void run()
            {
                forward();
            }
        });
    }

    public void backward_run(){
        Handler refresh = new Handler(Looper.getMainLooper());
        refresh.post(new Runnable() {
            public void run()
            {
                backward();
            }
        });
    }

    public void right_run(){
        Handler refresh = new Handler(Looper.getMainLooper());
        refresh.post(new Runnable() {
            public void run()
            {
                right();
            }
        });
    }

    public void left_run(){
        Handler refresh = new Handler(Looper.getMainLooper());
        refresh.post(new Runnable() {
            public void run()
            {
                left();
            }
        });
    }




    public void stop_run(){
        Handler refresh = new Handler(Looper.getMainLooper());
        refresh.post(new Runnable() {
            public void run()
            {
                break_motor();
            }
        });
    }


    public void ball_run(){
        Handler refresh = new Handler(Looper.getMainLooper());
        refresh.post(new Runnable() {
            public void run()
            {
                ball();
            }
        });
    }


    /*
    public void connect_bluetooth(){
        Handler refresh = new Handler(Looper.getMainLooper());
        refresh.post(new Runnable() {
            public void run()
            {
                Intent newint = getIntent();
                address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS); //receive the address of the bluetooth device

                //connect bluetooth
                new camcv.ConnectBT().execute(); //Call the class to connect

            }
        });
    }*/

}//scope
