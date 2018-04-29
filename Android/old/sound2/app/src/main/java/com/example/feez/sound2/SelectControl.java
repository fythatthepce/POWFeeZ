package com.example.feez.sound2;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.content.Intent;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ImageButton;
import android.widget.ListView;

public class SelectControl extends AppCompatActivity {

    String address = null;
    public static String EXTRA_ADDRESS = "device_address";

    ListView listView;

    // Define string array.
    String[] listValue = new String[] {"Touch Control","Voice Control","Joy Control","Face Detect Control","Ball Detect Control"};

    /*
    ImageButton sound;
    ImageButton touch;
    ImageButton joy;
    ImageButton ball;
    ImageButton face;
    //ImageButton acc;
    */


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_select_control);

        /*
        sound = (ImageButton)findViewById(R.id.sound);
        touch = (ImageButton)findViewById(R.id.touch);
        joy = (ImageButton)findViewById(R.id.joy);
        ball = (ImageButton)findViewById(R.id.ball);
        face = (ImageButton)findViewById(R.id.face);
        //acc = (ImageButton)findViewById(R.id.acc);


        //SoundControl
        touch.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view) {
                //get address
                Intent newint = getIntent();
                address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS); //receive the address of the bluetooth device

                //send address
                Intent i = new Intent(SelectControl.this, TouchControl.class);
                //Change the activity.
                i.putExtra(EXTRA_ADDRESS, address); //this will be received at ledControl (class) Activity
                startActivity(i);
            }
        });


        //SoundControl
        sound.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view) {

                //get address
                Intent newint = getIntent();
                address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS); //receive the address of the bluetooth device

                //send address
                Intent i = new Intent(SelectControl.this, SoundControl.class);
                //Change the activity.
                i.putExtra(EXTRA_ADDRESS, address); //this will be received at ledControl (class) Activity
                startActivity(i);
            }
        });

        //joycontrol
        joy.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view) {

                //get address
                Intent newint = getIntent();
                address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS); //receive the address of the bluetooth device

                //send address
                Intent i = new Intent(SelectControl.this, joycontrol.class);
                //Change the activity.
                i.putExtra(EXTRA_ADDRESS, address); //this will be received at ledControl (class) Activity
                startActivity(i);

            }
        });


        //camcv
        ball.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view) {
                //get address
                Intent newint = getIntent();
                address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS); //receive the address of the bluetooth device

                //send address
                Intent i = new Intent(SelectControl.this, SelectColor.class);
                //Change the activity.
                i.putExtra(EXTRA_ADDRESS, address); //this will be received at ledControl (class) Activity
                i.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                startActivity(i);

            }
        });


        //facedetect
        face.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view) {
                //get address
                Intent newint = getIntent();
                address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS); //receive the address of the bluetooth device

                //send address
                Intent i = new Intent(SelectControl.this, facedetect.class);
                //Change the activity.
                i.putExtra(EXTRA_ADDRESS, address); //this will be received at ledControl (class) Activity
                startActivity(i);

            }
        });




        //AccControl
        acc.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view) {
                //get address
                Intent newint = getIntent();
                address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS); //receive the address of the bluetooth device

                //send address
                Intent i = new Intent(SelectControl.this, AccControl.class);
                //Change the activity.
                i.putExtra(EXTRA_ADDRESS, address); //this will be received at ledControl (class) Activity
                startActivity(i);

            }
        });
      */

        listView = (ListView)findViewById(R.id.listview);
        ArrayAdapter<String> adapter = new ArrayAdapter<String>(this,android.R.layout.simple_list_item_1, android.R.id.text1, listValue);


        listView.setAdapter(adapter);


        // ListView on item selected listener.
        listView.setOnItemClickListener(new AdapterView.OnItemClickListener()
        {

            @Override
            public void onItemClick(AdapterView<?> parent, View view,
                                    int position, long id) {
                // TODO Auto-generated method stub

                // Getting listview click value into String variable.
                String TempListViewClickedValue = listValue[position].toString();


                if(TempListViewClickedValue == "Touch Control"){
                    Intent newint = getIntent();
                    address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS);

                    Intent i = new Intent(SelectControl.this,TouchControl.class);
                    i.putExtra(EXTRA_ADDRESS, address);
                    startActivity(i);
                }

                else if(TempListViewClickedValue == "Voice Control"){
                    Intent newint = getIntent();
                    address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS);

                    Intent i = new Intent(SelectControl.this,SoundControl.class);
                    i.putExtra(EXTRA_ADDRESS, address);
                    startActivity(i);
                }

                else if(TempListViewClickedValue == "Joy Control"){
                    Intent newint = getIntent();
                    address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS);

                    Intent i = new Intent(SelectControl.this,joycontrol.class);
                    i.putExtra(EXTRA_ADDRESS, address);
                    startActivity(i);
                }

                else if(TempListViewClickedValue == "Face Detect Control"){
                    Intent newint = getIntent();
                    address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS);

                    Intent i = new Intent(SelectControl.this,facedetect.class);
                    i.putExtra(EXTRA_ADDRESS, address);
                    startActivity(i);
                }

                else if(TempListViewClickedValue == "Ball Detect Control"){
                    Intent newint = getIntent();
                    address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS);

                    Intent i = new Intent(SelectControl.this,SelectColor.class);
                    i.putExtra(EXTRA_ADDRESS, address);
                    startActivity(i);
                }

                /*
                else if(TempListViewClickedValue == "TEST"){
                    Intent newint = getIntent();
                    address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS);

                    Intent i = new Intent(SelectControl.this,humancv.class);
                    i.putExtra(EXTRA_ADDRESS, address);
                    startActivity(i);
                }*/


            }
        });//END LISTVIEW
    }//main

}//scope
