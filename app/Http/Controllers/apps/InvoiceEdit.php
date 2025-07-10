<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOrder;
use App\Models\JobOrdersPackage;
use App\Models\JobOrdersPackageOption;
use App\Models\JobOrdersLaborOption;
use App\Models\JobOrdersLabor;
use App\Models\JobOrdersPartServiceOption;
use App\Models\JobOrdersPartService;



use App\Models\Package;

use DB;

class InvoiceEdit extends Controller
{
  public function index($job_order_id)
  {
    $jobOrderInfo = DB::table('job_orders')
    ->join('cars', 'cars.id', '=', 'job_orders.car_id')
    ->join('owners', 'owners.id', '=', 'cars.owner_id')
    ->where('job_orders.id', '=', $job_order_id)
   ->select('cars.*', 'owners.*', 'job_orders.*', 'job_orders.status as job_order_status')
    ->get(); 


    if($jobOrderInfo[0]->job_order_status  == 1) {
      $optionStatus = "bg-label-warning";
    } else if ($jobOrderInfo[0]->job_order_status  == 2) {
      $optionStatus = "bg-label-info";
    }else {
      $optionStatus = "bg-label-success";
    }
    $jobOrderPackageOption = DB::table('job_orders_package_options')
    ->where('status', '=', 1)
    ->get();
    $jobOrderPackageSelected = DB::table('job_orders_packages')
    ->where('status', '=', 1)
    ->where('job_order_id', '=', $job_order_id)
    ->get();

    $optionOneHtml = array();
    $keypckg = 1;
    if(isset($jobOrderPackageSelected[0]->job_order_id)) {
      foreach($jobOrderPackageSelected as $keypckg => $selected) {
        $optionOneHtml[] = '<div class="border row w-100  p-2"  data-repeater-item><div class="col-md-7 col-12 mb-md-0 mb-3"><select class="form-select item-details mb-3" name="package">';
        foreach($jobOrderPackageOption as $options) {
            $optionOneHtml[] = '<option value="'.$options->id.'" '.(($options->id == $selected->package_id) ? "selected" : "").'>'.$options->value.'</option>';
        }
        $optionOneHtml[] =  '</select></div></div>';
        $keypckg++;
      }
    } else {
      $optionOneHtml = false;
    }
   
    $jobOrderLaborOption = DB::table('job_orders_labor_options')
    ->where('status', '=', 1)
    ->get();
    $jobOrderLaborSelected = DB::table('job_orders_labors')
    ->where('status', '=', 1)
    ->where('job_order_id', '=', $job_order_id)
    ->get();

    // $optionTwoHtml = array();
    // if(isset($jobOrderLaborSelected[0]->job_order_id)) {
    //   foreach($jobOrderLaborSelected as $selectedLabor) {
    //     $optionTwoHtml[] = '<div class="border row w-100  p-2"  data-repeater-item><div class="col-md-7 col-12 mb-md-0 mb-3"><select class="form-select item-details mb-3" name="package">';
    //     foreach($jobOrderLaborOption as $options) {
    //         $optionTwoHtml[] = '<option value="'.$options->id.'" '.(($options->id == $selectedLabor->labor_id) ? "selected" : "").'>'.$options->value.'</option>';
    //     }
    //     $optionTwoHtml[] =  '</select></div></div>';
    //   }
    // } else {
    //   $optionTwoHtml = false;
    // }


    $keyl = 1;
    $optionTwoHtml = array();
    if(isset($jobOrderLaborSelected[0]->job_order_id)) {
      foreach($jobOrderLaborSelected as $keyl => $selectedLabor) {
                $keyl++;
                $sub_amount = $selectedLabor->labor_price * $selectedLabor->labor_qty;
                $optionTwoHtml[] = '<div class="border row w-100 p-3 pr-0" style="padding-right: 0px !important;" id="item-list-labor-'.$keyl.'"  data-repeater-item>
                 <div class="col-md-1 col-12 mb-md-0 mb-3 color-black">
                    <h6 class="mb-2 repeater-title fw-medium"><strong>No</strong></h6>
                    <span id="labor-counter-'.$keyl.'">'.$keyl.'</span>
                  </div>
                  <div class="col-md-5 col-12 mb-md-0 mb-3">
                    <h6 class="mb-2 repeater-title fw-medium"><strong>Service</strong></h6>
                    <select class="form-select item-details mb-3" name="labor" id="labor-option-'.$keyl.'" onchange="calculateLabor('.$keyl.')" >';
                  foreach($jobOrderLaborOption as $options) {
                      $optionTwoHtml[] = '<option value="'.$options->id.'" '.(($options->id == $selectedLabor->labor_id) ? "selected" : "").'>'.$options->value.'</option>';
                  }
               $optionTwoHtml[] = '</select>
                  </div>
                     <div class="col-md-2 col-12 mb-md-0 mb-3">
                    <h6 class="mb-2 repeater-title fw-medium">Qty</h6>
                    <input type="text" class="form-control invoice-item-qty" name="labor-qty" id="labor-qty-'.$keyl.'" value="'.$selectedLabor->labor_qty.'" placeholder="1" min="1" max="50"  onchange="calculateLabor('.$keyl.')"/>
                  </div>
                  <div class="col-md-2 col-12 mb-md-0 mb-3">
                    <h6 class="mb-2 repeater-title fw-medium">Price</h6>
                    <input type="text" class="form-control invoice-item-price mb-3" name="labor-price" id="labor-price-'.$keyl.'" value="'.$selectedLabor->labor_price.'" placeholder="" min="12"  onchange="calculateLabor('.$keyl.')"/>
                    
                  </div>
               
                  <div class="col-md-1 col-12 pe-0">
                    <h6 class="mb-2 repeater-title fw-medium">Amount</h6>
                    <p class="mb-0 pt-2 color-black amount-labor-sub d-flex" id="amount-labor-sub-'.$keyl.'">₱
                    <input type="text" class="form-control invoice-item-amount mb-3 p-0 border-0 pe-none" name="labor-amount" id="labor-amount-'.$keyl.'" value="'.$sub_amount.'"  placeholder="" min="12"/>
                    </p>
                  </div>

                <div class="col-md-1 col-12 border-start text-right">
                  <i class="mdi mdi-close cursor-pointer color-black" onclick="deleteItem('.$keyl.', 1)" data-repeater-delete></i>
                  <div class="dropdown">
                    <i class="mdi mdi-cog-outline cursor-pointer more-options-dropdown color-black" role="button" id="dropdownMenuButton" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    </i>
                    <div class="dropdown-menu dropdown-menu-end w-px-300 p-3" aria-labelledby="dropdownMenuButton">

                      <div class="row g-3">
                        <div class="col-12">
                          <label for="discountInput" class="form-label">Discount(%)</label>
                          <input type="number" class="form-control" id="discountInput" min="0" max="100" />
                        </div>
                        <div class="col-md-6">
                          <label for="taxInput1" class="form-label">Tax 1</label>
                          <select name="tax-1-input" id="taxInput1" class="form-select tax-select">
                            <option value="0%" selected>0%</option>
                            <option value="1%">1%</option>
                            <option value="10%">10%</option>
                            <option value="18%">18%</option>
                            <option value="40%">40%</option>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <label for="taxInput2" class="form-label">Tax 2</label>
                          <select name="tax-2-input" id="taxInput2" class="form-select tax-select">
                            <option value="0%" selected>0%</option>
                            <option value="1%">1%</option>
                            <option value="10%">10%</option>
                            <option value="18%">18%</option>
                            <option value="40%">40%</option>
                          </select>
                        </div>
                      </div>
                      <div class="dropdown-divider my-3"></div>
                      <button type="button" class="btn btn-outline-primary btn-apply-changes">Apply</button>
                    </div>
                  </div>
                </div>
                </div>
                ';
              }
          } else {
            $optionTwoHtml = false;
          }

    $jobOrderPartServiceOption = DB::table('job_orders_part_service_options')
    ->where('status', '=', 1)
    ->get();

    $jobOrderPartSelected = DB::table('job_orders_part_services')
    ->where('status', '=', 1)
    ->where('job_order_id', '=', $job_order_id)
    ->get();


    $keyprt = 1;
    $optionThreeHtml = array();
    if(isset($jobOrderPartSelected[0]->job_order_id)) {
      foreach($jobOrderPartSelected as $keyprt => $selectedPart) {
                $keyprt++;
                $sub_amount = $selectedPart->part_price * $selectedPart->part_qty;

                $optionThreeHtml[] = '<div class="border row w-100 p-3 pr-0" style="padding-right: 0px !important;"  id="item-list-part-'.$keyprt.'"  data-repeater-item>
                 <div class="col-md-1 col-12 mb-md-0 mb-3 color-black">
                    <h6 class="mb-2 repeater-title fw-medium"><strong>No</strong></h6>
                     <span id="part-counter-'.$keyprt.'">'.$keyprt.'</span>
                  </div>
                  <div class="col-md-5 col-12 mb-md-0 mb-3">
                    <h6 class="mb-2 repeater-title fw-medium"><strong>Service</strong></h6>
                    <select class="form-select item-details mb-3" name="part" id="part-option-'.$keyprt.'" onchange="calculatePart('.$keyprt.')">';
                  foreach($jobOrderPartServiceOption as $optionsPart) {
                      $optionThreeHtml[] = '<option value="'.$optionsPart->id.'" '.(($optionsPart->id == $selectedPart->part_id) ? "selected" : "").'>'.$optionsPart->value.'</option>';
                  }
               $optionThreeHtml[] = '</select>
                  </div>
                     <div class="col-md-2 col-12 mb-md-0 mb-3">
                    <h6 class="mb-2 repeater-title fw-medium">Qty</h6>
                    <input type="text" class="form-control invoice-item-qty" name="part-qty" id="part-qty-'.$keyprt.'" value="'.$selectedPart->part_qty.'" placeholder="1" min="1" max="50" onchange="calculatePart('.$keyprt.')"/>
                  </div>
                  <div class="col-md-2 col-12 mb-md-0 mb-3">
                    <h6 class="mb-2 repeater-title fw-medium">Price</h6>
                    <input type="text" class="form-control invoice-item-price mb-3" name="part-price" id="part-price-'.$keyprt.'" value="'.$selectedPart->part_price.'" placeholder="" min="12" />
                    
                  </div>
               
                 <div class="col-md-1 col-12 pe-0">
                    <h6 class="mb-2 repeater-title fw-medium">Amount</h6>
                    <p class="mb-0 pt-2 color-black amount-part-sub d-flex" id="amount-part-sub-'.$keyprt.'">₱
                    <input type="text" class="form-control invoice-item-amount mb-3 p-0 border-0 pe-none" name="part-amount" id="part-amount-'.$keyprt.'" value="'.$sub_amount.'" placeholder="" min="12"/>
                    </p>
                  </div>

                  <div class="col-md-1 col-12 border-start text-right">
                  <i class="mdi mdi-close cursor-pointer color-black" onclick="deleteItem('.$keyprt.', 2)" data-repeater-delete></i>
                  <div class="dropdown">
                    <i class="mdi mdi-cog-outline cursor-pointer more-options-dropdown color-black" role="button" id="dropdownMenuButton" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    </i>
                    <div class="dropdown-menu dropdown-menu-end w-px-300 p-3" aria-labelledby="dropdownMenuButton">

                      <div class="row g-3">
                        <div class="col-12">
                          <label for="discountInput" class="form-label">Discount(%)</label>
                          <input type="number" class="form-control" id="discountInput" min="0" max="100" />
                        </div>
                        <div class="col-md-6">
                          <label for="taxInput1" class="form-label">Tax 1</label>
                          <select name="tax-1-input" id="taxInput1" class="form-select tax-select">
                            <option value="0%" selected>0%</option>
                            <option value="1%">1%</option>
                            <option value="10%">10%</option>
                            <option value="18%">18%</option>
                            <option value="40%">40%</option>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <label for="taxInput2" class="form-label">Tax 2</label>
                          <select name="tax-2-input" id="taxInput2" class="form-select tax-select">
                            <option value="0%" selected>0%</option>
                            <option value="1%">1%</option>
                            <option value="10%">10%</option>
                            <option value="18%">18%</option>
                            <option value="40%">40%</option>
                          </select>
                        </div>
                      </div>
                      <div class="dropdown-divider my-3"></div>
                      <button type="button" class="btn btn-outline-primary btn-apply-changes">Apply</button>
                    </div>
                  </div>
                </div>
                </div>
                ';
              }
          } else {
            $optionThreeHtml = false;
          }

    return view('content.apps.app-invoice-edit', ['optionStatus' => $optionStatus, 'packageTotalItem' => $keypckg, 'partTotalItem' => $keyprt, 'laborTotalItem' => $keyl, 'optionThreeHtml' => $optionThreeHtml, 'optionTwoHtml' => $optionTwoHtml, 'optionOneHtml' => $optionOneHtml, 'job_order_id' => $job_order_id, 'jobOrderInfo' => $jobOrderInfo, 'jobOrderPartServiceOption' => $jobOrderPartServiceOption, 'jobOrderLaborOption' => $jobOrderLaborOption, 'jobOrderPackageOption' => $jobOrderPackageOption]);
  }
  public function saveJobOrderItem($job_order_id){

    $jobOrderInfo = DB::table('job_orders')
    ->join('cars', 'cars.id', '=', 'job_orders.car_id')
    ->join('owners', 'owners.id', '=', 'cars.owner_id')
    ->where('job_orders.id', '=', $job_order_id)
    ->get();

    if($_GET['status'] == 1) {
      $status_display = "estimate";
    } else if ($_GET['status'] == 2) {
      $status_display = "job order";
    }
    JobOrder::where("id", $job_order_id)->update(
      [
        "status" => $_GET['status'],
        "status_display" => $status_display,
      ]
    );
  

    $delPackage=JobOrdersPackage::where('job_order_id',$job_order_id)->delete();
    $delLabor=JobOrdersLabor::where('job_order_id',$job_order_id)->delete();
    $delPart=JobOrdersPartService::where('job_order_id',$job_order_id)->delete();

    foreach($_GET as $key => $value) {
      if($key== 'group-a') {
        foreach($value as $package){
            $pck = new JobOrdersPackage();
            $pck->job_order_id = $job_order_id;
            $pck->package_id    = $package['package'];
            $pck->package_value    =  JobOrdersPackageOption::find($package['package'])->value;
            $pck->package_price    = JobOrdersPackageOption::find($package['package'])->package_price;
            $pck->save();
        }
      }
      if($key== 'group-b') {
        foreach($value as $labor){
          if(isset($labor['labor']) && $labor['labor'] > "") {
            $lbr = new JobOrdersLabor();
            $lbr->job_order_id = $job_order_id;
            $lbr->labor_id      = $labor['labor'];
            $lbr->labor_qty     = $labor['labor-qty'];
            $lbr->labor_value   =  JobOrdersLaborOption::find($labor['labor'])->value;
            $lbr->labor_price   = ((isset($labor['labor-price'])) ? $labor['labor-price'] : 0);
            $lbr->save();
          }
            
        }
      }
      if($key== 'group-c') {
        foreach($value as $part){
          if(isset($part['part']) && $part['part'] > "") {
            $prt = new JobOrdersPartService();
            $prt->job_order_id = $job_order_id;
            $prt->part_id      = $part['part'];
            $prt->part_qty     = $part['part-qty'];
            $prt->part_value  =  JobOrdersPartServiceOption::find($part['part'])->value;
            $prt->part_price   = ((isset($part['part-price'])) ? $part['part-price'] : 0);
            $prt->save();
          }
        }
      }
    }
     return response()->json(['success'=> true, 'message' => 'Job Order Updated!']);
  }

  public function getJobOrderItemprice($job_order_id) {
    
    $jobOrderPartInfo = DB::table('job_orders_part_service_options')
    ->where('id', '=', $job_order_id)
    ->get();

     return response()->json(['success'=> true, 'price' => $jobOrderPartInfo[0]->price]);

  }
}
