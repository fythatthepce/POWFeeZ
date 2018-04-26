package com.example.feez.sound2;

import android.content.Intent;
import android.os.Handler;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

public class Splashscreen extends AppCompatActivity {

    private Handler objHandle;

    @Override
    protected void onCreate(Bundle savedInstanceState) {


        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_splashscreen);


        objHandle = new Handler();
        objHandle.postDelayed(new Runnable() {
            @Override
            public void run() {
                Intent objIntent = new Intent(Splashscreen.this,DeviceList.class);
                startActivity(objIntent);
                finish();
            }
        },1500); // delay 3 sec
    }
}





