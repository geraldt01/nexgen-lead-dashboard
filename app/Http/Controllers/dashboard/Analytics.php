<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Analytics extends Controller
{
  public function index()
  {
    return view('content.dashboard.dashboards-crm');
  }

  public function jsonJobOrderList() {
    date_default_timezone_set("Asia/Manila");
    $date_today =  date('Y-m-d');
      $jobOrderInfo = DB::table('job_orders')
     ->join('cars', 'cars.id', '=', 'job_orders.car_id')
     ->join('owners', 'owners.id', '=', 'cars.owner_id')
   ->select('job_orders.id as id', 'job_orders.job_order_number as job_order_number', 
    'cars.id as car_id', 
    'job_orders.date as date', 
    'cars.plate_number as plate_number', 
    'cars.manufacturer as manufacturer', 
    'cars.vehicle_model as vehicle_model', 
    'job_orders.mileage as mileage', 
    'job_orders.status as status', 
    'job_orders.status_display as status_display', 
    'cars.owner_id as owner_id', 
    'cars.vehicle_type as vehicle_type', 
    'cars.year as year', 
    'owners.owner_name as owner_name', 
    'owners.address as address', 
    'owners.mobile_number as mobile_number', 
  )
    ->where('job_orders.date', $date_today)
    ->get();
    $array = array();


    foreach ($jobOrderInfo as $key => $value) {

      switch ($value->vehicle_type) {
      case "Sedan":
        $vehicle_type = 0;
        break;
      case "SUV":
        $vehicle_type = 1;
        break;
          case "Hatchback":
        $vehicle_type = 2;
        break;
          case "Pickup":
        $vehicle_type = 3;
        break;
          case "MPV":
        $vehicle_type = 4;
        break;
         case "Others":
        $vehicle_type = 5;
        break;
      }

       switch ($value->status_display) {
      case "estimate":
        $status_display = 1;
        break;
      case "job order":
        $status_display = 2;
        break;
          case "completed":
        $status_display = 3;
   
      }
    $array[] = array(
      'id' => $value->plate_number,
        'product_name' => $value->plate_number,
        'category' => $vehicle_type,
        'stock' => $value->mileage,
        'sku' => $value->owner_name,
        'price' => "$656.85",
        'qty' => 679,
        'status' => $status_display,
        'image' =>"car-placeholder.jpg",
        'product_brand' => $value->manufacturer." ".$value->vehicle_model." ".$value->year,
        'car_overview_link' => "/app/car/view/".$value->car_id,
        'job_order_link' => "/app/job-order/".$value->id,
        
      );
    
 }

 $jo['data'] = $array;
    return response()->json($jo);
}



  //  "id": 99,
  //     "product_name": "Komainer",
  //     "category": 0,
  //     "stock": 1,
  //     "sku": 59592,
  //     "price": "$656.85",
  //     "qty": 679,
  //     "status": 3,
  //     "image": "product-10.png",
  //     "product_brand": "Feest Group"
  //   },

  
}
