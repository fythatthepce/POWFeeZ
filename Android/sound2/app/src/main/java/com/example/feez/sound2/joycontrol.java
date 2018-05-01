package com.example.feez.sound2;

import android.app.Activity;
import android.app.ProgressDialog;
import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothDevice;
import android.bluetooth.BluetoothSocket;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnTouchListener;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;

import java.io.IOException;
import java.util.UUID;


import android.view.MotionEvent;
import android.view.View;
import android.widget.Toast;

import android.os.AsyncTask;
import android.widget.ProgressBar;


public class joycontrol extends Activity  {


    Button btndisconnect;

    String address = null;
    private ProgressDialog progress;
    BluetoothAdapter myBluetooth = null;
    BluetoothSocket btSocket = null;
    private boolean isBtConnected = false;

    //SPP UUID. Look for it
    static final UUID myUUID = UUID.fromString("00001101-0000-1000-8000-00805F9B34FB");


    RelativeLayout layout_joystick;
    ImageView image_joystick, image_border;
    TextView textView2,textView5;

    JoyStickClass js;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.joystick);

        Intent newint = getIntent();
        address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS); //receive the address of the bluetooth device

        btndisconnect = (Button)findViewById(R.id.button_disconnect);

        btndisconnect.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view) {
                Disconnect();
            }
        });



        //connect bluetooth
        new joycontrol.ConnectBT().execute(); //Call the class to connect

        textView5 = (TextView)findViewById(R.id.textView5);
        //textView2 = (TextView)findViewById(R.id.textView2);


        layout_joystick = (RelativeLayout)findViewById(R.id.layout_joystick);

        js = new JoyStickClass(getApplicationContext()
                , layout_joystick, R.drawable.image_button);

        js.setStickSize(150, 150);
        //js.setStickSize(200, 200);



        js.setLayoutSize(500, 500);
        //js.setLayoutSize(450, 450);


        //ความโปร่ง
        js.setLayoutAlpha(150);
        js.setStickAlpha(100);

        //js.setOffset(90);
        //js.setOffset(170);
        js.setOffset(100);
        js.setMinimumDistance(50);




        layout_joystick.setOnTouchListener(new OnTouchListener() {
            public boolean onTouch(View arg0, MotionEvent arg1) {
                js.drawStick(arg1);
                if(arg1.getAction() == MotionEvent.ACTION_DOWN || arg1.getAction() == MotionEvent.ACTION_MOVE)
                {
                    //textView2.setText("X : " + String.valueOf(js.getX()));
                    //textView8.setText("Y : " + String.valueOf(js.getY()));
                    //textView2.setText("D : " + String.valueOf(js.getDistance()));

                    int direction = js.get8Direction();
                    //int direction = js.get4Direction();

                    if(direction == JoyStickClass.STICK_UP) {
                        textView5.setText("GO");

                        if(js.getDistance() >= 0 && js.getDistance() <= 100)
                        {
                            //zone1
                            forward1();
                        }else
                        {
                            //zone2
                            forward2();
                        }

                        final Handler handler = new Handler();
                        handler.postDelayed(new Runnable() {
                            @Override
                            public void run() {
                                // Do something after 5s = 5000ms
                                //buttons[inew][jnew].setBackgroundColor(Color.BLACK);
                            }
                        }, 500);

                    } else if(direction == JoyStickClass.STICK_RIGHT) {
                        textView5.setText("RIGHT");


                        if(js.getDistance() >= 0 && js.getDistance() <= 100)
                        {
                            //zone1
                            right1();
                        }else {
                            //zone2
                            right2();
                        }


                        final Handler handler = new Handler();
                        handler.postDelayed(new Runnable() {
                            @Override
                            public void run() {
                                // Do something after 5s = 5000ms
                                //buttons[inew][jnew].setBackgroundColor(Color.BLACK);
                            }
                        }, 500);
                    } else if(direction == JoyStickClass.STICK_DOWN) {
                        textView5.setText("DOWN");

                        if(js.getDistance() >= 0 && js.getDistance() <= 100)
                        {
                            //zone1
                            backward1();
                        }else {
                            //zone2
                            backward2();
                        }


                        final Handler handler = new Handler();
                        handler.postDelayed(new Runnable() {
                            @Override
                            public void run() {
                                // Do something after 5s = 5000ms
                                //buttons[inew][jnew].setBackgroundColor(Color.BLACK);
                            }
                        }, 500);
                    } else if(direction == JoyStickClass.STICK_LEFT) {
                        textView5.setText("LEFT");


                        if(js.getDistance() >= 0 && js.getDistance() <= 100)
                        {
                            //zone1
                            left1();
                        }else {
                            //zone2
                            left2();
                        }


                        final Handler handler = new Handler();
                        handler.postDelayed(new Runnable() {
                            @Override
                            public void run() {
                                // Do something after 5s = 5000ms
                                //buttons[inew][jnew].setBackgroundColor(Color.BLACK);
                            }
                        }, 500);
                    } else if(direction == JoyStickClass.STICK_NONE) {
                        textView5.setText("STOP");
                        break_motor();


                        final Handler handler = new Handler();
                        handler.postDelayed(new Runnable() {
                            @Override
                            public void run() {
                                // Do something after 5s = 5000ms
                                //buttons[inew][jnew].setBackgroundColor(Color.BLACK);
                            }
                        }, 500);
                    }else if(direction == JoyStickClass.STICK_UPRIGHT) {
                        textView5.setText("UPRIGHT");

                        if(js.getDistance() >= 0 && js.getDistance() <= 100)
                        {
                            //zone1
                            upright1();
                        }else {
                            //zone2
                            upright2();
                        }

                        final Handler handler = new Handler();
                        handler.postDelayed(new Runnable() {
                            @Override
                            public void run() {
                                // Do something after 5s = 5000ms
                                //buttons[inew][jnew].setBackgroundColor(Color.BLACK);
                            }
                        }, 500);

                    }else if(direction == JoyStickClass.STICK_DOWNRIGHT) {
                        textView5.setText("DOWNRIGHT");

                        if(js.getDistance() >= 0 && js.getDistance() <= 100)
                        {
                            //zone1
                            downright1();
                        }else {
                            //zone2
                            downright2();
                        }


                        final Handler handler = new Handler();
                        handler.postDelayed(new Runnable() {
                            @Override
                            public void run() {
                                // Do something after 5s = 5000ms
                                //buttons[inew][jnew].setBackgroundColor(Color.BLACK);
                            }
                        }, 500);
                    }else if(direction == JoyStickClass.STICK_UPLEFT) {
                        textView5.setText("UPLEFT");

                        if(js.getDistance() >= 0 && js.getDistance() <= 100)
                        {
                            //zone1
                            upleft1();
                        }else {
                            //zone2
                            upleft2();
                        }

                        final Handler handler = new Handler();
                        handler.postDelayed(new Runnable() {
                            @Override
                            public void run() {
                                // Do something after 5s = 5000ms
                                //buttons[inew][jnew].setBackgroundColor(Color.BLACK);
                            }
                        }, 500);
                    }else if(direction == JoyStickClass.STICK_DOWNLEFT) {
                        textView5.setText("DOWNLEFT");

                        if(js.getDistance() >= 0 && js.getDistance() <= 100)
                        {
                            //zone1
                            downleft1();
                        }else {
                            //zone2
                            downleft2();
                        }


                        final Handler handler = new Handler();
                        handler.postDelayed(new Runnable() {
                            @Override
                            public void run() {
                                // Do something after 5s = 5000ms
                                //buttons[inew][jnew].setBackgroundColor(Color.BLACK);
                            }
                        }, 500);
                    }

                } else if(arg1.getAction() == MotionEvent.ACTION_UP) {
                    textView5.setText("");
                    break_motor();


                    final Handler handler = new Handler();
                    handler.postDelayed(new Runnable() {
                        @Override
                        public void run() {
                            // Do something after 5s = 5000ms
                            //buttons[inew][jnew].setBackgroundColor(Color.BLACK);
                        }
                    }, 500);
                }
                return true;
            }
        });
    }

    //main


    //function
    private void forward1(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("JO1GO.".toString().getBytes());

            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }

    private void forward2(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("JO2GO.".toString().getBytes());

            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }

    private void backward1(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("JO1BACK.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }

    private void backward2(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("JO2BACK.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }

    private void left1(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("JO1LEFT.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }


    private void left2(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("JO2LEFT.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }

    private void right1(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("JO1RIGHT.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }

    private void right2(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("JO2RIGHT.".toString().getBytes());
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
                btSocket.getOutputStream().write("JO1BREAK.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }

    private void upright1(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("JO1UPRIGHT.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }

    private void upright2(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("JO2UPRIGHT.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }


    private void downright1(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("JO1DOWNRIGHT.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }

    private void downright2(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("JO2DOWNRIGHT.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }

    private void upleft1(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("JO1UPLEFT.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }

    private void upleft2(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("JO2UPLEFT.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }


    private void downleft1(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("JO1DOWNLEFT.".toString().getBytes());
            }
            catch (IOException e)
            {
                msg("Error");
            }
        }
    }

    private void downleft2(){
        if (btSocket!=null)
        {
            try
            {
                btSocket.getOutputStream().write("JO2DOWNLEFT.".toString().getBytes());
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


    // fast way to call Toast
    private void msg(String s)
    {
        Toast.makeText(getApplicationContext(),s,Toast.LENGTH_LONG).show();
    }

    private class ConnectBT extends AsyncTask<Void, Void, Void>  // UI thread
    {
        private boolean ConnectSuccess = true; //if it's here, it's almost connected
        // BluetoothDevice dispositivo;
        @Override
        protected void onPreExecute()
        {
            progress = ProgressDialog.show(joycontrol.this, "Connecting...", "Please wait!!!");  //show a progress dialog
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




}//scope
