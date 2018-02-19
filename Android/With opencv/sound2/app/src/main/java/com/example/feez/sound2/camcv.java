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

import org.opencv.core.MatOfPoint2f;
import org.opencv.core.Point;
import org.opencv.core.Scalar;
import org.opencv.core.Size;
import org.opencv.imgproc.Imgproc;
import static android.content.ContentValues.TAG;
import static org.opencv.imgproc.Imgproc.CV_HOUGH_GRADIENT;
import static org.opencv.imgproc.Imgproc.GaussianBlur;
import static org.opencv.imgproc.Imgproc.putText;

import android.os.Handler;
import android.os.Looper;
import android.widget.Toast;

import java.io.IOException;
import java.util.UUID;


public class camcv extends Activity implements CameraBridgeViewBase.CvCameraViewListener2{//scope

    //Bluetooth
    String address = null;
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
    int iLowH = 80;
    int iLowS = 100;
    int iLowV = 100;

    int iHighH = 100;
    int iHighS = 255;
    int iHighV = 255;

    Mat imgHSV;
    Mat hue;
    Mat hue_image;
    Mat rgbimg;


    Mat contourImage;
    Mat hierarchyOutputVector;
    MatOfPoint2f approxCurve;



    Scalar sc1,sc2;

    //Red RGB
    private static final Scalar RGB_RED = new Scalar(255, 0, 0);

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


        sc1 = new Scalar(iLowH,iLowS,iLowV);    //Low HSV
        sc2 = new Scalar(iHighH,iHighS,iHighV);  //High HSV




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
            progress = ProgressDialog.show(camcv.this, "Connecting...", "Please wait!!!");  //show a progress dialog
        }

        @Override
        protected Void doInBackground(Void... devices) //while the progress dialog is shown, the connection is done in background
        {

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
            }
            return null;
        }
        @Override
        protected void onPostExecute(Void result) //after the doInBackground, it checks if everything went fine
        {
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
                btSocket.getOutputStream().write("GO".toString().getBytes());
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
                btSocket.getOutputStream().write("STOP".toString().getBytes());
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
                btSocket.getOutputStream().write("Disconnect".toString().getBytes());
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
        Core.inRange(imgHSV,sc1,sc2,hue);
        Core.addWeighted(hue, 1.0, hue, 1.0, 0 , hue_image);


        //GaussianBlur
        org.opencv.core.Size s = new Size(9,9);
        GaussianBlur(hue_image, hue_image, s ,2, 2);


        // apply canny to get edges only
        Imgproc.Canny(hue_image, hue_image, 0, 255);


        //Detect Circle
        Mat circles = new Mat();

        //default min r =  30  ,  max r = 200
        //current min r = 20 , max r = 200
        Imgproc.HoughCircles(hue_image, circles, CV_HOUGH_GRADIENT, 1, 100 , 100, 20, 20, 200);



        // holes between edge segments
        Imgproc.dilate(hue_image, hue_image, new Mat(), new Point(-1, 1), 1);


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
                Imgproc.circle(Torgb, center, radius , new Scalar(0, 128, 0), 7);
            }

            putText(Torgb,"O",new Point(30, 50),3,2,RGB_RED,1);
            forward_run();
        }else  if (circles.cols() == 0){
            putText(Torgb,"",new Point(30, 25),3,2,new Scalar(255,255,255),2);
            stop_run();
        }//end drawcircle


        Core.flip(Torgb,Torgb, 1);
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

    public void stop_run(){
        Handler refresh = new Handler(Looper.getMainLooper());
        refresh.post(new Runnable() {
            public void run()
            {
                break_motor();
            }
        });
    }

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
    }







}//scope
