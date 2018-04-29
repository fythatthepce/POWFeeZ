package com.example.feez.sound2;

import android.app.Activity;
import android.app.ActivityManager;
import android.app.ProgressDialog;
import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothDevice;
import android.bluetooth.BluetoothSocket;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Handler;
import android.os.Looper;
import android.os.Bundle;
import android.util.Log;
import android.view.WindowManager;
import android.widget.Toast;

import org.opencv.android.BaseLoaderCallback;
import org.opencv.android.CameraBridgeViewBase;
import org.opencv.android.JavaCameraView;
import org.opencv.android.LoaderCallbackInterface;
import org.opencv.android.OpenCVLoader;
import org.opencv.core.Core;
import org.opencv.core.CvType;
import org.opencv.core.Mat;
import org.opencv.core.MatOfPoint;
import org.opencv.core.MatOfPoint2f;
import org.opencv.core.Point;
import org.opencv.core.Rect;
import org.opencv.core.Scalar;
import org.opencv.core.Size;
import org.opencv.imgproc.Imgproc;

import java.io.IOException;
import java.util.ArrayList;
import java.util.Collections;
import java.util.List;
import java.util.UUID;

import static android.content.ContentValues.TAG;
import static org.opencv.imgproc.Imgproc.CV_HOUGH_GRADIENT;
import static org.opencv.imgproc.Imgproc.GaussianBlur;
import static org.opencv.imgproc.Imgproc.putText;
import static org.opencv.imgproc.Imgproc.rectangle;

public class humancv extends Activity implements CameraBridgeViewBase.CvCameraViewListener2{

    //Bluetooth
    String address = null;
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

    String Bcenter;
    String Bleft;
    String Bright;
    String Bback;

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






    Scalar sc1_R,sc2_R;
    Scalar sc1_G,sc2_G;
    Scalar sc1_Y,sc2_Y;





    JavaCameraView cameraView;

    /**
     * class name for debugging with logcat
     */
    //private static final String TAG = MainActivity.class.getName();
    /**
     * the camera view
     */
    private CameraBridgeViewBase mOpenCvCameraView;
    /**
     * for displaying Toast info messages
     */
    private Toast toast;
    /**
     * responsible for displaying images on top of the camera picture
     */
    //private OverlayView overlayView;
    /**
     * whether or not to log the memory usage per frame
     */
    private static final boolean LOG_MEM_USAGE = true;
    /**
     * detect only red objects
     */
    private static final boolean DETECT_RED_OBJECTS_ONLY = false;
    /**
     * the lower red HSV range (lower limit)
     */
    private static final Scalar HSV_LOW_RED1 = new Scalar(0, 100, 100);
    /**
     * the lower red HSV range (upper limit)
     */
    private static final Scalar HSV_LOW_RED2 = new Scalar(10, 255, 255);
    /**
     * the upper red HSV range (lower limit)
     */
    private static final Scalar HSV_HIGH_RED1 = new Scalar(160, 100, 100);
    /**
     * the upper red HSV range (upper limit)
     */
    private static final Scalar HSV_HIGH_RED2 = new Scalar(179, 255, 255);
    /**
     * definition of RGB red
     */
    private static final Scalar RGB_RED = new Scalar(255, 0, 0);
    /**
     * frame size width
     */
    private static final int FRAME_SIZE_WIDTH = 640;
    /**
     * frame size height
     */
    private static final int FRAME_SIZE_HEIGHT = 480;
    /**
     * whether or not to use a fixed frame size -> results usually in higher FPS
     * 640 x 480
     */
    private static final boolean FIXED_FRAME_SIZE = true;
    /**
     * whether or not to use the database to display
     * an image on top of the camera
     * when false the objects are labeled with writing
     */
    private static final boolean DISPLAY_IMAGES = false;
    /**
     * image thresholded to black and white
     */
    private Mat bw;
    /**
     * image converted to HSV
     */
    private Mat hsv;
    /**
     * the image thresholded for the lower HSV red range
     */
    private Mat lowerRedRange;
    /**
     * the image thresholded for the upper HSV red range
     */
    private Mat upperRedRange;
    /**
     * the downscaled image (for removing noise)
     */
    private Mat downscaled;
    /**
     * the upscaled image (for removing noise)
     */
    private Mat upscaled;
    /**
     * the image changed by findContours
     */
    private Mat contourImage;
    /**
     * the activity manager needed for getting the memory info
     * which is necessary for getting the memory usage
     */
    private ActivityManager activityManager;
    /**
     * responsible for getting memory information
     */
    private ActivityManager.MemoryInfo mi;
    /**
     * the found contour as hierarchy vector
     */
    private Mat hierarchyOutputVector;
    /**
     * approximated polygonal curve with specified precision
     */
    private MatOfPoint2f approxCurve;


    private BaseLoaderCallback mLoaderCallback = new BaseLoaderCallback(this) {
        @Override
        public void onManagerConnected(int status) {
            switch (status) {
                case LoaderCallbackInterface.SUCCESS:
                {
                    Log.i(TAG, "OpenCV loaded successfully");

                    bw = new Mat();
                    hsv = new Mat();
                    lowerRedRange = new Mat();
                    upperRedRange = new Mat();
                    downscaled = new Mat();
                    upscaled = new Mat();
                    contourImage = new Mat();

                    hierarchyOutputVector = new Mat();
                    approxCurve = new MatOfPoint2f();

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
        color = getIntent().getStringExtra("ListViewClickedValue");


        //connect bluetooth
        new humancv.ConnectBT().execute(); //Call the class to connect



        getWindow().addFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON);
        setContentView(R.layout.activity_humancv);
        cameraView = (JavaCameraView)findViewById(R.id.cameraview);

        if (FIXED_FRAME_SIZE) {
            cameraView.setMaxFrameSize(FRAME_SIZE_WIDTH, FRAME_SIZE_HEIGHT);
        }

        cameraView.setCameraIndex(0);  // 0 = rear , 1 = front
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


            progress = ProgressDialog.show(humancv.this, "Connecting...", "Please wait!!!");  //show a progress dialog
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
                //msg("Connection Failed. Is it a SPP Bluetooth? Try again.");
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
            Log.d(TAG, "available mem: " + availableMegs);
        }


        // get the camera frame as gray scale image
        Mat gray = null;

        if (DETECT_RED_OBJECTS_ONLY) {
            gray = inputFrame.rgba();
        } else {
            gray = inputFrame.gray();
        }


        // the image to output on the screen in the end
        // -> get the unchanged color image
        Mat dst = inputFrame.rgba();

        Core.flip(dst,dst, -1);

        // down-scale and upscale the image to filter out the noise
        Imgproc.pyrDown(gray, downscaled, new Size(gray.cols()/2, gray.rows()/2));
        Imgproc.pyrUp(downscaled, upscaled, gray.size());

        if (DETECT_RED_OBJECTS_ONLY) {
            // convert the image from RGBA to HSV
            Imgproc.cvtColor(upscaled, hsv, Imgproc.COLOR_RGB2HSV);
            // threshold the image for the lower and upper HSV red range
            Core.inRange(hsv, HSV_LOW_RED1, HSV_LOW_RED2, lowerRedRange);
            Core.inRange(hsv, HSV_HIGH_RED1, HSV_HIGH_RED2, upperRedRange);
            // put the two thresholded images together
            Core.addWeighted(lowerRedRange, 1.0, upperRedRange, 1.0, 0.0, bw);
            // apply canny to get edges only
            Imgproc.Canny(bw, bw, 0, 255);
        } else {
            // Use Canny instead of threshold to catch squares with gradient shading
            Imgproc.Canny(upscaled, bw, 0, 255);
        }


        // dilate canny output to remove potential
        // holes between edge segments
        Imgproc.dilate(bw, bw, new Mat(), new Point(-1, 1), 1);

        // find contours and store them all as a list
        List<MatOfPoint> contours = new ArrayList<MatOfPoint>();
        contourImage = bw.clone();
        Imgproc.findContours(
                contourImage,
                contours,
                hierarchyOutputVector,
                Imgproc.RETR_EXTERNAL,
                Imgproc.CHAIN_APPROX_SIMPLE
        );

        // loop over all found contours
        for (MatOfPoint cnt : contours) {
            MatOfPoint2f curve = new MatOfPoint2f(cnt.toArray());

            // approximates a polygonal curve with the specified precision
            Imgproc.approxPolyDP(
                    curve,
                    approxCurve,
                    0.02 * Imgproc.arcLength(curve, true),
                    true
            );

            int numberVertices = (int)approxCurve.total();
            double contourArea = Imgproc.contourArea(cnt);

            Log.d(TAG, "vertices:" + numberVertices);

            // ignore to small areas
            if (Math.abs(contourArea) < 100
                // || !Imgproc.isContourConvex(
                    ) {
                continue;
            }

            // triangle detection
            if(numberVertices == 3) {
                if (DISPLAY_IMAGES) {
                    //doSomethingWithContent("triangle");
                } else {
                    setLabel(dst, "TRI", cnt);
                }


            }

            // rectangle, pentagon and hexagon detection
            if (numberVertices >= 4 && numberVertices <= 6) {

                List<Double> cos = new ArrayList<>();
                for (int j = 2; j < numberVertices + 1; j++) {
                    cos.add(
                            angle(
                                    approxCurve.toArray()[j % numberVertices],
                                    approxCurve.toArray()[j - 2],
                                    approxCurve.toArray()[j - 1]
                            )
                    );
                }
                Collections.sort(cos);

                double mincos = cos.get(0);
                double maxcos = cos.get(cos.size()-1);

                // rectangle detection
                if (numberVertices == 4
                        && mincos >= -0.1 && maxcos <= 0.3
                        ) {
                    if (DISPLAY_IMAGES) {
                        //doSomethingWithContent("rectangle");
                    }
                    else {
                        setLabel(dst, "RECT", cnt);
                    }
                }
                // pentagon detection
                else if(numberVertices == 5
                        && mincos >= -0.34 && maxcos <= -0.27) {
                    if (!DISPLAY_IMAGES) {
                        setLabel(dst, "PENTA", cnt);
                    }
                }
                // hexagon detection
                else if (numberVertices == 6
                        && mincos >= -0.55 && maxcos <= -0.45) {
                    if (!DISPLAY_IMAGES) {
                        setLabel(dst, "HEXA", cnt);
                    }
                }
            }
            // circle detection
            else {
                Rect r = Imgproc.boundingRect(cnt);
                int radius = r.width / 2;

                if (Math.abs(
                        1 - (
                                r.width / r.height
                        )
                ) <= 0.2 &&
                        Math.abs(
                                1 - (
                                        contourArea / (Math.PI * radius * radius)
                                )
                        ) <= 0.2
                        ) {
                    if (!DISPLAY_IMAGES) {
                        setLabel(dst, "CIR", cnt);
                    }
                }

            }


        }

        // return the matrix / image to show on the screen
        return dst;

    }


    private static double angle(Point pt1, Point pt2, Point pt0)
    {
        double dx1 = pt1.x - pt0.x;
        double dy1 = pt1.y - pt0.y;
        double dx2 = pt2.x - pt0.x;
        double dy2 = pt2.y - pt0.y;
        return (dx1 * dx2 + dy1 * dy2)
                / Math.sqrt(
                (dx1 * dx1 + dy1 * dy1) * (dx2 * dx2 + dy2 * dy2) + 1e-10
        );
    }


    private void setLabel(Mat im, String label, MatOfPoint contour) {
        int fontface = Core.FONT_HERSHEY_SIMPLEX;
        double scale = 3;//0.4;
        int thickness = 3;//1;
        int[] baseline = new int[1];

        Size text = Imgproc.getTextSize(label, fontface, scale, thickness, baseline);
        Rect r = Imgproc.boundingRect(contour);

        Point pt = new Point(
                r.x + ((r.width - text.width) / 2),
                r.y + ((r.height + text.height) /2)
        );
        /*
        Imgproc.rectangle(
                im,
                new Point(r.x + 0, r.y + baseline[0]),
                new Point(r.x + text.width, r.y -text.height),
                new Scalar(255,255,255),
                -1
                );
        */

        Imgproc.putText(im, label, pt, fontface, scale, RGB_RED, thickness);

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


    public void ball_run_left(){
        Handler refresh = new Handler(Looper.getMainLooper());
        refresh.post(new Runnable() {
            public void run()
            {
                ball_left();
            }
        });
    }

    public void ball_run_right(){
        Handler refresh = new Handler(Looper.getMainLooper());
        refresh.post(new Runnable() {
            public void run()
            {
                ball_right();
            }
        });
    }


    public void back_run(){
        Handler refresh = new Handler(Looper.getMainLooper());
        refresh.post(new Runnable() {
            public void run()
            {
                ball_back();
            }
        });
    }


    private void ball(){
        if (btSocket!=null)
        {
            try
            {
                //btSocket.getOutputStream().write("BALL.".toString().getBytes());
                btSocket.getOutputStream().write(Bcenter.toString().getBytes());
            }
            catch (IOException e)
            {
                //msg("Error");
            }
        }
    }



    private void ball_back(){
        if (btSocket!=null)
        {
            try
            {
                //btSocket.getOutputStream().write("BACK100.".toString().getBytes());
                btSocket.getOutputStream().write(Bback.toString().getBytes());
            }
            catch (IOException e)
            {
                //msg("Error");
            }
        }
    }

    private void ball_left(){
        if (btSocket!=null)
        {
            try
            {
                //btSocket.getOutputStream().write("BALLLEFT.".toString().getBytes());
                btSocket.getOutputStream().write(Bleft.toString().getBytes());
            }
            catch (IOException e)
            {
                //msg("Error");
            }
        }
    }


    private void ball_right(){
        if (btSocket!=null)
        {
            try
            {
                //btSocket.getOutputStream().write("BALLRIGHT.".toString().getBytes());
                btSocket.getOutputStream().write(Bright.toString().getBytes());
            }
            catch (IOException e)
            {
                //msg("Error");
            }
        }
    }



    private void Disconnect()
    {
        if (btSocket!=null) //If the btSocket is busy
        {
            try
            {
                //btSocket.getOutputStream().write("Disconnect.".toString().getBytes());
                btSocket.close(); //close connection
            }
            catch (IOException e)
            {
                //msg("Error");
            }
        }
        finish(); //return to the first layout

    }
    //End Function command to arduino



}//scope
