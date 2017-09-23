package com.kmitl.powfeez;

import android.content.Context;
import android.content.Intent;
import android.content.res.Resources;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.SurfaceView;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.SeekBar;
import android.widget.TextView;

import org.opencv.android.BaseLoaderCallback;
import org.opencv.android.CameraBridgeViewBase;
import org.opencv.android.JavaCameraView;
import org.opencv.android.LoaderCallbackInterface;
import org.opencv.android.OpenCVLoader;
import org.opencv.core.Core;
import org.opencv.core.CvType;
import org.opencv.core.Mat;
import org.opencv.imgproc.Imgproc;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.util.ArrayList;

import android.view.SurfaceView;
import android.widget.Toast;

public class DetectMain1 extends AppCompatActivity implements CameraBridgeViewBase.CvCameraViewListener2{

    JavaCameraView javaCameraView;
    private static final String TAG="DetectMain1";
    Mat mRgba,mRgbaF,mRgbaT;;

    //int width =getScreenWidth();
    //int height=getScreenHeight();

    int width = 640;
    int height = 480;

    //normal
    //int width = 480;
    //int height = 360;



    //int width = 352;
    //int height = 240;

    //bad detect
    //int width = 256;
    //int height = 144;





    //int progress = 100;







    BaseLoaderCallback mLoaderCallback = new BaseLoaderCallback(this) {
        @Override
        public void onManagerConnected(int status) {
            switch(status){
                case BaseLoaderCallback.SUCCESS:{
                    javaCameraView.enableView();
                    break;
                }
                default:{
                    super.onManagerConnected(status);
                    break;
                }
            }
            super.onManagerConnected(status);
        }
    };



    static {
        System.loadLibrary("opencv_java3");
        System.loadLibrary("MyLibs");
    }




    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        //set Fullscreen of JavaCameraView
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
                WindowManager.LayoutParams.FLAG_FULLSCREEN);

        setContentView(R.layout.activity_detect_main1);
        javaCameraView = (JavaCameraView)findViewById(R.id.java_camera_view);
        javaCameraView.setVisibility(SurfaceView.VISIBLE);
        javaCameraView.setCvCameraViewListener(this);



        //set resolution
        javaCameraView.setMaxFrameSize(width, height);


        //set Text , button , seekbar in cameraview
        ArrayList<View> views = new ArrayList<View>();
        //javaCameraView.addTouchables(views);
        views.add(findViewById(R.id.txtDisp));
        views.add(findViewById(R.id.resolution));
        //views.add(findViewById(R.id.buttonDisp));
        //views.add(findViewById(R.id.seekBar));



        final TextView disp = (TextView)findViewById(R.id.txtDisp);
        TextView disp_resolution = (TextView)findViewById(R.id.resolution);
        //disp.setText("FaceDetect by feez");
        //disp.setText("FaceDetect : " + width + "*" + height);
        disp_resolution.setText("Resolution : "+ width + "*" + height);
        disp.setText("ObjDetect");



        /*
        //seekbar
        SeekBar disp_seekBar = (SeekBar)findViewById(R.id.seekBar);
        disp_seekBar.setMax(100);
        disp_seekBar.setProgress(progress);
        disp_seekBar.setOnSeekBarChangeListener(new SeekBar.OnSeekBarChangeListener() {
            @Override
            public void onProgressChanged(SeekBar seekBar, int i, boolean b) {
                progress = i;
                if(progress == 100){
                    javaCameraView.setMaxFrameSize(width, height);
                    disp.setText("FaceDetect : " + width + "*" + height);

                }else if(progress == 50){
                    int width2 = 640;
                    int height2 = 480;
                    javaCameraView.setMaxFrameSize(width2, height2);
                    disp.setText("FaceDetect : " + width2 + "*" + height2);
                    Toast.makeText(getApplicationContext(), "640*480",
                            Toast.LENGTH_LONG).show();
                }else if(progress == 0){
                    int width3 = 320;
                    int height3 = 240;
                    javaCameraView.setMaxFrameSize(width3, height3);
                    disp.setText("FaceDetect : " + width3 + "*" + height3);
                    Toast.makeText(getApplicationContext(), "320*240",
                            Toast.LENGTH_LONG).show();
                }
            }

            @Override
            public void onStartTrackingTouch(SeekBar seekBar) {
                    //NULL
            }

            @Override
            public void onStopTrackingTouch(SeekBar seekBar) {
                   //NULL
            }
        });*/





        /*
        Button btndisp  = (Button)findViewById(R.id.buttonDisp);
        btndisp.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Toast.makeText(getApplicationContext(), "Test Button",
                        Toast.LENGTH_LONG).show();
            }
        });*/

    }

    public static int getScreenWidth() {
        return Resources.getSystem().getDisplayMetrics().widthPixels;
    }

    public static int getScreenHeight() {
        return Resources.getSystem().getDisplayMetrics().heightPixels;
    }

    @Override
    protected void onDestroy(){
        super.onDestroy();
        if(javaCameraView!=null){
            javaCameraView.disableView();
        }
    }


    @Override
    protected void onPause(){
        super.onPause();
        if(javaCameraView!=null){
            javaCameraView.disableView();
        }
    }


    @Override
    protected void onResume(){
        super.onResume();

        if(OpenCVLoader.initDebug()){
            Log.d(TAG,"Opencv Install !!!");
            mLoaderCallback.onManagerConnected(LoaderCallbackInterface.SUCCESS);
        }
        else{
            Log.d(TAG,"Opencv Not Install");
            OpenCVLoader.initAsync(OpenCVLoader.OPENCV_VERSION_3_3_0,this,mLoaderCallback);
        }

    }


    @Override
    public void onCameraViewStarted(int width, int height) {
        mRgba = new Mat(height,width, CvType.CV_8UC4);
        mRgbaF = new Mat(height, width, CvType.CV_8UC4);
        mRgbaT = new Mat(width, width, CvType.CV_8UC4);

    }

    @Override
    public void onCameraViewStopped() {
        mRgba.release();

    }


    @Override
    public Mat onCameraFrame(CameraBridgeViewBase.CvCameraViewFrame inputFrame) {


        mRgba = inputFrame.rgba();

        OpencvClass.Obj1Detection(mRgba.getNativeObjAddr());
        //OpencvClass.humanDetection(mRgba.getNativeObjAddr());


        // Rotate mRgba 90 degrees
        //Core.transpose(mRgba, mRgbaT);
        //Imgproc.resize(mRgbaT, mRgbaF, mRgbaF.size(), 0,0, 0);
        //Core.flip(mRgbaF, mRgba, 1 );


        return mRgba;
    }
}//scope

