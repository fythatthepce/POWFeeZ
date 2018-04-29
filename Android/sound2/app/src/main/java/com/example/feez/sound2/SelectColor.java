package com.example.feez.sound2;
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;



public class SelectColor extends Activity{//SCOPE

    ListView listView;

    // Define string array.
    //String[] listValue = new String[] {"RED","GREEN","YELLOW","BLUE"};
    String[] listValue = new String[] {"YELLOW"};

    //Bluetooth
    String address = null;
    public static String EXTRA_ADDRESS = "device_address";



    @Override
    protected void onCreate(Bundle savedInstanceState) {//MAIN
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_select_color);

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


                if(TempListViewClickedValue == "YELLOW"){
                    Intent newint = getIntent();
                    address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS);

                    Intent i = new Intent(SelectColor.this,camcv.class);
                    i.putExtra(EXTRA_ADDRESS, address);
                    startActivity(i);
                }

                /*
                else if(TempListViewClickedValue == "RED"){
                    Intent newint = getIntent();
                    address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS);

                    Intent i = new Intent(SelectColor.this,camcvred.class);
                    i.putExtra(EXTRA_ADDRESS, address);
                    startActivity(i);
                }

                else if(TempListViewClickedValue == "GREEN"){
                    Intent newint = getIntent();
                    address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS);

                    Intent i = new Intent(SelectColor.this,camcvgreen.class);
                    i.putExtra(EXTRA_ADDRESS, address);
                    startActivity(i);
                }

                else if(TempListViewClickedValue == "BLUE"){
                    Intent newint = getIntent();
                    address = newint.getStringExtra(DeviceList.EXTRA_ADDRESS);

                    Intent i = new Intent(SelectColor.this,camcvblue.class);
                    i.putExtra(EXTRA_ADDRESS, address);
                    startActivity(i);
                }*/

            }
        });//END LISTVIEW

    }//MAIN

}//SCOPE
