package com.kmitl.powfeez;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

import android.Manifest;
import android.app.Dialog;
import android.app.DownloadManager;
import android.app.ProgressDialog;
import android.content.Context;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Environment;
import android.os.StrictMode;
import android.support.annotation.NonNull;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.widget.Button;
import android.view.View;
import android.widget.Toast;
import android.content.Intent;

import java.io.BufferedInputStream;
import java.io.File;
import java.io.FileOutputStream;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.URL;
import java.net.URLConnection;

import permissions.dispatcher.NeedsPermission;
import permissions.dispatcher.RuntimePermissions;


@RuntimePermissions
public class selectdetectmain extends AppCompatActivity {


    Button Download;
    Button Clear;
    Button Start;




    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_selectdetectmain);


        //declare permission of camera and storage
        final selectdetectmain temp = this;
        selectdetectmainPermissionsDispatcher.appPermissionWithCheck(temp);


        Download =  (Button) findViewById(R.id.download);
        Clear = (Button) findViewById(R.id.clear);
        Start = (Button) findViewById(R.id.start);


        //Download
        Download.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent myWebLink = new Intent(android.content.Intent.ACTION_VIEW);
                myWebLink.setData(Uri.parse("https://drive.google.com/drive/folders/0B8Y8tkQets1HSHZ2anRkaVdVX1k?usp=sharing"));
                startActivity(myWebLink);
                finish();
            }
        });


        //clear
        Clear.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                File file = new File("/storage/emulated/0/Download/1.xml");
                file.delete();
                Toast.makeText(getApplicationContext(), "Clear xml successful !!! ",
                        Toast.LENGTH_LONG).show();
            }
        });


        //start detect
        Start.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent i = new Intent(selectdetectmain .this,DetectMain1.class);
                startActivity(i);
            }
        });



    }//main

    @NeedsPermission({Manifest.permission.CAMERA, Manifest.permission.READ_EXTERNAL_STORAGE, Manifest.permission.WRITE_EXTERNAL_STORAGE})
    void appPermission() {
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
        selectdetectmainPermissionsDispatcher.onRequestPermissionsResult(this, requestCode, grantResults);
    }

}
