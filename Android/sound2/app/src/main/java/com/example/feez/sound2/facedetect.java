package com.example.feez.sound2;

import android.app.Activity;
import android.app.ProgressDialog;
import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothDevice;
import android.bluetooth.BluetoothSocket;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.Rect;
import android.hardware.Camera;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.speech.RecognizerIntent;
import android.speech.tts.TextToSpeech;
import android.support.annotation.RequiresApi;
import android.util.Log;
import android.view.SurfaceHolder;
import android.view.SurfaceView;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Locale;
import java.util.UUID;
import android.graphics.Canvas;

import static android.content.ContentValues.TAG;

public class facedetect extends Activity implements SurfaceHolder.Callback{//SCOPE


    SurfaceHolder mHolder;
    Camera mCamera;
    int camId;

    SurfaceView surfaceView;
    //SurfaceHolder surfaceHolder;

    TextView myTextView;
    TextView myNumface;

    Button btnsound;
    Button btnDis;

    TextView textvoice;

    TextToSpeech speak;

    //Bluetooth
    String address = null;
    private ProgressDialog progress;
    BluetoothAdapter myBluetooth = null;
    BluetoothSocket btSocket = null;
    private boolean isBtConnected = false;
    private Paint paint;

    //SPP UUID. Look for it
    static final UUID myUUID = UUID.fromString("00001101-0000-1000-8000-00805F9B34FB");

    @Override
    protected void onCreate(Bundle savedInstanceState) {//MAIN
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_facedetect);



        //connect bluetooth
        Intent newint = getIntent();
        address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS); //receive the address of the bluetooth device
        new facedetect.ConnectBT().execute(); //Call the class to connect




        myTextView = (TextView) findViewById(R.id.textView);
        myNumface = (TextView) findViewById(R.id.Numface);

        textvoice = (TextView)findViewById(R.id.textvoice);


        surfaceView = (SurfaceView)findViewById(R.id.camera_view);
        mHolder = surfaceView.getHolder();
        mHolder.addCallback(this);
        mHolder.setType(mHolder.SURFACE_TYPE_PUSH_BUFFERS);



        mCamera = Camera.open(0);
        mCamera.setDisplayOrientation(90);
        setFocus();
        myTextView.setText("Back camera");

        //Button switch cam
        Button otherCamera = (Button) findViewById(R.id.OtherCamera);
        otherCamera.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                switchCamera();    // pass switchCamera() from CameraView.java
                if(camId == 1){    // pass camId from CameraView.java
                    myTextView.setText("Front camera");

                }else{
                    myTextView.setText("Back camera");

                }
            }
        });


        //btn disconnect
        btnDis = (Button)findViewById(R.id.button_disconnect);
        btnDis.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Disconnect(); //close connection
            }
        });

        //btn sound
        btnsound = (Button)findViewById(R.id.button);



        btnsound.setEnabled(false);
        btnsound.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                //System.exit(0);
                OpenMic();
            }
        });


        speak = new TextToSpeech(getApplicationContext(), new TextToSpeech.OnInitListener() {
            @Override
            public void onInit(int i) {
                if(i != TextToSpeech.ERROR){
                    speak.setLanguage(Locale.ENGLISH);
                }
            }
        });
    }//MAIN


    //Call Toast
    private void msg(String s)
    {
        Toast.makeText(getApplicationContext(),s,Toast.LENGTH_LONG).show();
    }

    private void Disconnect()
    {
        if (btSocket!=null) //If the btSocket is busy
        {
            try
            {
                //btSocket.getOutputStream().write("Disconnect".toString().getBytes());
                btSocket.close(); //close connection
            }
            catch (IOException e)
            {
                //msg("Error");
            }
        }
        finish(); //return to the first layout
    }

    //SOUND
    public void OpenMic(){
        Intent intent = new Intent(RecognizerIntent.ACTION_RECOGNIZE_SPEECH);
        intent.putExtra(RecognizerIntent.EXTRA_LANGUAGE_MODEL,RecognizerIntent.LANGUAGE_MODEL_FREE_FORM);
        //intent.putExtra(RecognizerIntent.EXTRA_SPEECH_INPUT_MINIMUM_LENGTH_MILLIS,100);
        intent.putExtra(RecognizerIntent.EXTRA_LANGUAGE, "th-TH");
        intent.putExtra(RecognizerIntent.EXTRA_PROMPT,"พูดเพื่อสั่งงาน ...");

        if (intent.resolveActivity(getPackageManager()) != null) {
            startActivityForResult(intent, 10);

        } else {
            Toast.makeText(this, "Your Device Don't Support Speech Input", Toast.LENGTH_SHORT).show();
        }
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        String str1 = "ขวา";
        String str2 = "ซ้าย";
        String str3 = "หน้า";
        String str4 = "หลัง";
        String str5 = "หยุด";


        switch (requestCode) {
            case 10:
                if (resultCode == RESULT_OK && null!= data){
                    ArrayList<String> result = data.getStringArrayListExtra(RecognizerIntent.EXTRA_RESULTS);
                    if(result.get(0).contains(str1)){
                        right_command();
                        textvoice.setText("ไปทางขวา ...");
                    }else if(result.get(0).contains(str2)){
                        left_command();
                        textvoice.setText("ไปทางซ้าย ...");
                    }else if(result.get(0).contains(str3)){
                        forward_command();
                        textvoice.setText("ไปข้างหน้า ...");
                    }else if(result.get(0).contains(str4)) {
                        backward_command();
                        textvoice.setText("ถอยหลัง ...");
                    }else if(result.get(0).contains(str5)){
                        stop_command();
                        textvoice.setText("หยุด ...");
                    }else{
                        //stop_command();
                        textvoice.setText("ผิดพลาด");
                    }

                }
                break;
        }
    }


    @Override
    public void surfaceCreated(SurfaceHolder surfaceHolder) {
        try {
            //when the surface is created, we can set the camera to draw images in this surfaceholder
            mCamera.setPreviewDisplay(surfaceHolder);
            mCamera.startPreview();


            //start facedetect
            mCamera.setFaceDetectionListener(faceDetectionListener);
            mCamera.startFaceDetection();
        } catch (IOException e) {
            Log.d("ERROR", "Camera error on surfaceCreated " + e.getMessage());
        }
    }

    @Override
    public void surfaceChanged(SurfaceHolder surfaceHolder, int i, int i1, int i2) {
        //before changing the application orientation, you need to stop the preview, rotate and then start it again
        if (mHolder.getSurface() == null)//check if the surface is ready to receive camera data
            return;

        try {
            mCamera.stopFaceDetection();
            mCamera.stopPreview();
        } catch (Exception e) {
            //this will happen when you are trying the camera if it's not running
        }

        //now, recreate the camera preview
        try {

            //start camera
            mCamera.setPreviewDisplay(mHolder);
            mCamera.startPreview();

            //start facedetect
            mCamera.setFaceDetectionListener(faceDetectionListener);
            mCamera.startFaceDetection();

        } catch (IOException e) {
            Log.d("ERROR", "Camera error on surfaceChanged " + e.getMessage());
        }
    }

    @Override
    public void surfaceDestroyed(SurfaceHolder surfaceHolder) {
        mCamera.stopFaceDetection();
        mCamera.stopPreview();
        mCamera.release();
    }

    //switch cam
    public void switchCamera(){
        Log.i(TAG, "Switching Camera");
        if (mCamera != null) {
            mCamera.stopFaceDetection();
            mCamera.stopPreview();
            mCamera.release();
        }

        //swap the id of the camera to be used
        if (camId == Camera.CameraInfo.CAMERA_FACING_BACK) {
            camId = Camera.CameraInfo.CAMERA_FACING_FRONT;
        }else {
            camId = Camera.CameraInfo.CAMERA_FACING_BACK;
        }
        try {
            if(camId == 1) //front cam
            {
                mCamera = Camera.open(camId);
                mCamera.setDisplayOrientation(90);


                //You must get the holder of SurfaceView!!!
                mCamera.setPreviewDisplay(mHolder);

                //Then resume preview...
                mCamera.startPreview();

                //start facedetect
                mCamera.setFaceDetectionListener(faceDetectionListener);
                mCamera.startFaceDetection();
            }
            else if (camId == 0) //back cam
            {

                mCamera = Camera.open(camId);
                setFocus();

                mCamera.setDisplayOrientation(90);

                //You must get the holder of SurfaceView!!!
                mCamera.setPreviewDisplay(mHolder);
                //Then resume preview...
                mCamera.startPreview();

                //start facedetect
                mCamera.setFaceDetectionListener(faceDetectionListener);
                mCamera.startFaceDetection();
            }
        }
        catch (Exception e) { e.printStackTrace(); }
    }

    //Param Auto focus
    public void setFocus() {
        Camera.Parameters mParameters = mCamera.getParameters();
        mParameters.setFocusMode(Camera.Parameters.FOCUS_MODE_CONTINUOUS_PICTURE);
        mCamera.setParameters(mParameters);
    }


    //face detect function
    public Camera.FaceDetectionListener faceDetectionListener = new Camera.FaceDetectionListener() {

        @RequiresApi(api = Build.VERSION_CODES.LOLLIPOP)
        @Override
        public void onFaceDetection(Camera.Face[] faces, Camera camera) {
            if (faces.length > 0){
                myNumface.setText(String.valueOf(faces.length));
                btnsound.setEnabled(true);


                /*
                List<Rect> faceRects;
                faceRects = new ArrayList<Rect>();

                for (int i=0; i<faces.length; i++) {
                    int left = faces[i].rect.left;
                    int right = faces[i].rect.right;
                    int top = faces[i].rect.top;
                    int bottom = faces[i].rect.bottom;
                    Rect uRect = new Rect(left, top, right, bottom);
                    //faceRects.add(uRect);

                    Canvas canvas = new Canvas();
                    paint = new Paint();
                    paint.setColor(Color.GRAY);
                    canvas.drawColor(Color.BLUE);
                    canvas.drawRect(uRect, paint);

                }*/



                Log.v("FaceDetection", "face detected: "+ faces.length +
                        " Face 1 Location X: " + faces[0].rect.centerX() +
                        "Y: " + faces[0].rect.centerY() );

            }else{
                myNumface.setText(String.valueOf(faces.length));
                btnsound.setEnabled(false);
                textvoice.setText("รอรับคำสั่งเสียง");

                String str_speak = "Voice Activated";
                speak.speak(str_speak,TextToSpeech.QUEUE_FLUSH,null,null);
            }


        }
    };



    //Function Bluetooth
    private class ConnectBT extends AsyncTask<Void, Void, Void>  // UI thread
    {
        private boolean ConnectSuccess = true; //if it's here, it's almost connected
        // BluetoothDevice dispositivo;
        @Override
        protected void onPreExecute()
        {
            progress = ProgressDialog.show(facedetect.this, "Connecting...", "Please wait!!!");  //show a progress dialog
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



    //send data to arduino
    private void right_command(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("VORIGHT.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }

    private void left_command(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("VOLEFT.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }

    private void forward_command(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("VOGO.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }

    private void backward_command(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("VOBACK.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }

    private void stop_command(){
        if (btSocket!=null)
        {
            try
            {
                //btSocket.getOutputStream().write("STOP".toString().getBytes());
                btSocket.getOutputStream().write("VOBREAK.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }

}//SCOPE
