<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOrder;
use App\Models\Car;
use DB;



class EcommerceCustomerDetailsOverview extends Controller
{
  public function index($car_id)
  {

    $carInfo = DB::table('cars')
    ->where('cars.id', '=', $car_id)
    ->join('owners', 'owners.id', '=', 'cars.owner_id')
   ->select('cars.id as car_id', 'owners.id as owner_id', 'cars.manufacturer as manufacturer', 'cars.vehicle_type as vehicle_type', 'cars.vehicle_model as vehicle_model', 'cars.year as year', 'cars.plate_number as plate_number', 'cars.status as status', 'owners.owner_name as owner_name', 'owners.address as address', 'owners.mobile_number as mobile_number' )
    ->get();

    $otherCars = DB::table('owners')
    ->where('cars.id', '!=', $car_id)
    ->where('owners.id', '=', $carInfo[0]->owner_id)
    ->join('cars', 'cars.owner_id', '=', 'owners.id')
    ->get();
 
    $htmlAddCar = "";
    if(isset($otherCars['id']) == false) {
      $htmlAddCar = '<div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-body section-add-car">
            <div class="card-icon mb-3">
              <div class="avatar">
                      <div class="avatar-initial rounded bg-label-primary"><i class="mdi mdi-car mdi-24px"></i>
                </div>
              </div>
            </div>
            <div class="card-info">
              <div class="d-flex justify-content-center">
                <a href="javascript:;" class="btn btn-primary me-3" data-bs-target="#addNewCar" data-bs-toggle="modal">Add Car</a>
              </div>
            </div>
          </div>
        </div>
      </div>';
    }

   
    return view('content.apps.app-ecommerce-customer-details-overview', ['selectedCar' => $carInfo, 'otherCars' => $otherCars, 'htmlAddCar' => $htmlAddCar]);
  }

  public function saveJobOrder($car_id) {
    $c = new JobOrder();
    $c->car_id    = $_GET['car_id'] ? $_GET['car_id'] : "";
    $c->job_order_number    = $_GET['est'] ? $_GET['est'] : "";
    $c->date   = $_GET['date'] ? $_GET['date'] : "";
    $c->plate_number            = $_GET['modalPlateNumber'] ? $_GET['modalPlateNumber'] : "";
    $c->manufacturer    = $_GET['modalManufacturer'] ? $_GET['modalManufacturer'] : "";
    $c->model    = $_GET['modalVehicleModel'] ? $_GET['modalVehicleModel'] : "";
    $c->mileage    = $_GET['modalMileage'] ? $_GET['modalMileage'] : "";
    $c->status_display    = $_GET['modalStatus'] ? $_GET['modalStatus'] : "";
    $c->save();
     return response()->json(['success'=> true, 'message' => 'Job Order added successfully!']);
  }

  public function jsonJobOrder($car_id) {
    $jobOrderInfo = DB::table('job_orders')
    ->where('car_id', '=', $car_id)
    ->OrderBy('date', 'Desc')
    ->get();
    $array = array();
    foreach ($jobOrderInfo as $key => $value) {
    $array[] = array('id' => $value->id,
        'order' => $value->job_order_number,
        'customer' => "Gabrielle Feyer",
        'email' => "gfeyer0@nyu.edu",
        'avatar' => "8.png",
        'payment' => 1,
        'status' => $value->status,
        'spent' => "-",
        'method' => "paypal_logo",
        'date' => $value->date,
        'time' => "2:11 AM",
        'method_number' => 6522);
    }
    $jo['data'] = $array;
    return response()->json($jo);
  }
  

    public function addNewCar() {
 
    $c = new Car();
    $c->owner_id   = $_GET['owner_id'] ? $_GET['owner_id'] : "";
    $c->plate_number            = $_GET['modalPlateNumber'] ? $_GET['modalPlateNumber'] : "";
    $c->manufacturer    = $_GET['modalManufacturer'] ? $_GET['modalManufacturer'] : "";
    $c->vehicle_model    = $_GET['modalVehicleModel'] ? $_GET['modalVehicleModel'] : "";
    $c->vehicle_type    = $_GET['modalVehicleModel'] ? $_GET['modalVehicleModel'] : "";
    $c->mileage    = $_GET['modalMileage'] ? $_GET['modalMileage'] : "";
    $c->save();

      $car_id  = $c->id; 
     $carInfo = DB::table('cars')
    ->where('cars.id', '=', $car_id)
    ->join('owners', 'owners.id', '=', 'cars.owner_id')
   ->select('cars.id as car_id', 'owners.id as owner_id', 'cars.manufacturer as manufacturer', 'cars.vehicle_type as vehicle_type', 'cars.vehicle_model as vehicle_model', 'cars.year as year', 'cars.plate_number as plate_number', 'cars.status as status', 'owners.owner_name as owner_name', 'owners.address as address', 'owners.mobile_number as mobile_number' )
    ->get();

   
    $htmlAddCar = "";
    foreach($carInfo as $car) {
      $htmlAddCar = '
        <a href="/app/car/view/'.$car_id.'">
          <div class="card h-100">
            <div class="card-body">
              <div class="card-icon mb-3">
                <div class="avatar">
                  <div class="avatar-initial rounded bg-label-primary"><i class="mdi mdi-car mdi-24px"></i>
                  </div>
                </div>
              </div>
              <div class="card-info">
                <h4 class="card-title mb-3">'.$car->plate_number.'</h4>
                <div class="d-flex align-items-end mb-1 gap-1">
                  <h4 class="text-primary mb-0">'.$car->manufacturer.'</h4>
                  <p class="mb-0"> '.$car->vehicle_model.' '.$car->year.' </p>

                </div>
              </div>
            </div>
          </div>
        </a>
      ';
    }

   
     return response()->json(['success'=> true, 'message' => 'New Car Added!', 'selectedCar' => $carInfo, 'htmlAddCar' => $htmlAddCar]);
  }


}
