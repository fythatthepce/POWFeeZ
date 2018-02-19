package com.example.feez.sound2;

import android.app.Activity;
import android.app.ProgressDialog;
import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothDevice;
import android.bluetooth.BluetoothSocket;
import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.os.AsyncTask;
import android.os.Bundle;

import android.hardware.Sensor;
import android.hardware.SensorManager;
import android.hardware.SensorEvent;
import android.hardware.SensorEventListener;
import android.view.View;
import android.widget.Button;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import java.io.IOException;
import java.util.UUID;


public class AccControl extends Activity{

    String address = null;
    private ProgressDialog progress;
    BluetoothAdapter myBluetooth = null;
    BluetoothSocket btSocket = null;
    private boolean isBtConnected = false;

    //SPP UUID. Look for it
    static final UUID myUUID = UUID.fromString("00001101-0000-1000-8000-00805F9B34FB");

    private TextView textX, textY, textZ;
    SensorManager sensorManager;
    Sensor sensor;

    private RelativeLayout laybg;


    Button btndisconnect;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_acc_control);

        Intent newint = getIntent();
        address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS); //receive the address of the bluetooth device

        laybg = (RelativeLayout) findViewById(R.id.layid);


        sensorManager = (SensorManager) getSystemService(Context.SENSOR_SERVICE);
        sensor = sensorManager.getDefaultSensor(Sensor.TYPE_ACCELEROMETER);

        // Assign TextView
        textX = (TextView)findViewById(R.id.xText);
        textY = (TextView)findViewById(R.id.yText);
        textZ = (TextView)findViewById(R.id.zText);

        //connect bluetooth
        new AccControl.ConnectBT().execute(); //Call the class to connect


        btndisconnect = (Button)findViewById(R.id.btndis);

        btndisconnect.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Disconnect(); //close connection
            }
        });

    }//main

    public void onResume() {
        super.onResume();
        sensorManager.registerListener(accelListener, sensor,
                SensorManager.SENSOR_DELAY_NORMAL);
    }

    public void onStop() {
        super.onStop();
        sensorManager.unregisterListener(accelListener);
    }

    SensorEventListener accelListener = new SensorEventListener() {
        public void onAccuracyChanged(Sensor sensor, int acc) { }

        public void onSensorChanged(SensorEvent event) {
            float x = event.values[0];
            float y = event.values[1];
            float z = event.values[2];

            textX.setText("X : " + (int)x);
            textY.setText("Y : " + (int)y);
            textZ.setText("Z : " + (int)z);



            //if((x > -2 && x < 1) && (y > 3 && y < 6) && (z > 7 && z < 10)){
            //}

            if((x==0) && (y >= -3 && y < -1) && (z >=8 )){
                //forward();
                laybg.setBackgroundColor(Color.GREEN);
            }else{
                //break_motor();
            }




        }
    };



    // fast way to call Toast
    private void msg(String s)
    {
        Toast.makeText(getApplicationContext(),s,Toast.LENGTH_LONG).show();
    }

    //function to command in arduino
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

    private void backward(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("BACK".toString().getBytes());
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
                btSocket.getOutputStream().write("LEFT".toString().getBytes());
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
                btSocket.getOutputStream().write("RIGHT".toString().getBytes());
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
                //msg("Error");
            }
        }
        finish(); //return to the first layout

    }



    private class ConnectBT extends AsyncTask<Void, Void, Void>  // UI thread
    {
        private boolean ConnectSuccess = true; //if it's here, it's almost connected
        // BluetoothDevice dispositivo;
        @Override
        protected void onPreExecute()
        {
            progress = ProgressDialog.show(AccControl.this, "Connecting...", "Please wait!!!");  //show a progress dialog
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




    /*
    @Override
    public void onAccuracyChanged(Sensor sensor, int accuracy) {
        // Not in use
    }


    @Override
    public void onSensorChanged(SensorEvent event) {

        float xVal = event.values[0];
        float yVal = event.values[1];
        float zVal = event.values[2];

        xText.setText("X: " + (int)xVal);
        yText.setText("Y: " + (int)yVal);
        zText.setText("Z: " + (int)zVal);



        //stop
        laybg.setBackgroundColor(Color.BLUE);
        //break_motor();

        //forward
        if ( (xVal > -2 && xVal < 1) && (yVal > -7 && yVal < 0.8) && (zVal > 7 && zVal < 9.6)){
            laybg.setBackgroundColor(Color.RED);
            //forward();

            //backward
        }else if( (xVal > -2 && xVal < 1) && (yVal > 3 && yVal < 6) && (zVal > 7 && zVal < 10)){
            laybg.setBackgroundColor(Color.GREEN);
            //backward();
        }



        //left

        else if( (xVal > -2 && xVal < 1) && (yVal > 3 && yVal < 6) && (zVal > 7 && zVal < 10)){
            laybg.setBackgroundColor(Color.GREEN);
            left();
        }


        //right

        else if( (xVal > -2 && xVal < 1) && (yVal > 3 && yVal < 6) && (zVal > 7 && zVal < 10)) {
            laybg.setBackgroundColor(Color.GREEN);
            right();
        }

    }*/


}//scope
