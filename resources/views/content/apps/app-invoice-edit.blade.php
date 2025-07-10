@extends('layouts/layoutMaster')

@section('title', 'Edit - Invoice')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/app-invoice.css')}}" />
@endsection
<style type="text/css">
.tbl-header {
  background-color: #fce800;
}
  </style>
@section('vendor-script')
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/offcanvas-add-payment.js')}}"></script>
<script src="{{asset('assets/js/offcanvas-send-invoice.js')}}"></script>
<script src="{{asset('assets/js/app-invoice-edit.js')}}"></script>
@endsection

@section('content')
@foreach($jobOrderInfo as $k => $data)
<form id="form-job-order">
  <input type="hidden" name="hidden-job-order-id" id="hidden-job-order-id" value="{{$job_order_id}}" />
  
  <input type="hidden" name="hidden-package-total-item" id="hidden-package-total-item" value="{{$packageTotalItem}}" />
  <input type="hidden" name="hidden-labor-total-item" id="hidden-labor-total-item" value="{{$laborTotalItem}}" />
  <input type="hidden" name="hidden-part-total-item" id="hidden-part-total-item" value="{{$partTotalItem}}" />

<div class="row invoice-edit">
  <!-- Invoice Edit-->
  <div class="col-lg-9 col-12 mb-lg-0 mb-4">
    <div class="card invoice-preview-card">
      <div class="card-body">
        <div class="row mx-0">
          <div class="col-md-7 mb-md-0 mb-4 ps-0">
            <div class="d-flex svg-illustration align-items-center gap-2 mb-4">
              <span class="app-brand-logo demo"><img src="/assets/img/branding/rapide-invoice-logo.jpg" /></span>
            </div>
            <!-- <p class="mb-1">Office 149, 450 South Brand Brooklyn</p>
            <p class="mb-1">San Diego County, CA 91905, USA</p>
            <p class="mb-0">+1 (123) 456 7891, +44 (876) 543 2198</p> -->
          </div>
          <div class="col-md-5 pe-0 ps-0 ps-md-2">
            <div class="row mb-2 g-2 justify-content-end">
              <div class="col-sm-6 mb-2 d-md-flex align-items-center justify-content-end"> 
                 <select class="form-select item-details mb-3 {{$optionStatus}}" name="status" id="job-order-status" onchange="showStatus()">
                      <option value="1" id="option1" class="bg-label-warning" {{$data->job_order_status == 1 ? 'selected' : ''}}>ESTIMATE</option>
                      <option value="2" class="bg-label-info"  {{$data->job_order_status == 2 ? 'selected' : ''}}>JOB ORDER</option>
                  </select>
              </div>
            </div>
            <dl class="row mb-2 g-2">
              <dt class="col-sm-6 mb-2 d-md-flex align-items-center justify-content-end">
                                <span class="fw-normal">EST</span>
              </dt>
              <dd class="col-sm-6">
                <div class="input-group input-group-merge disabled">
                  <span class="input-group-text">#</span>
                  <input type="text" class="form-control" disabled placeholder="74909" value="74909" id="invoiceId" />
                </div>
              </dd>
              <dt class="col-sm-6 mb-2 d-md-flex align-items-center justify-content-end">
                <span class="fw-normal">Date:</span>
              </dt>
              <dd class="col-sm-6">
                <input type="text" class="form-control invoice-date" placeholder="DD-MM-YYY" />
              </dd>
              <dt class="col-sm-6 mb-2 d-md-flex align-items-center justify-content-end">
                <span class="fw-normal">Expires:</span>
              </dt>
              <dd class="col-sm-6">
                <input type="text" class="form-control due-date" placeholder="YYYY-MM-DD" />
              </dd>
            </dl>
          </div>
        </div>
      </div>
      <hr class="my-0" />
      <div class="card-body">
        <div class="d-flex justify-content-between flex-wrap">
          <div class="col-md-12 ">
            <table style="width: 100%">
              <tbody>
                <tr>
                  <td rowspan="4"style="width:15%;vertical-align: top;" class="pe-3 fw-medium"><strong>Customer</strong></td>
                  <td class="pe-3 fw-medium capital-letter" style="width:45%">{{$data->owner_name}}</td>
                  <td style="width:20%"><strong>MILEAGE</strong></td>
                  <td style="width:20%">{{$data->mileage}}</td>
                </tr>
                <tr>
                  <td  rowspan="2" class="pe-3 fw-medium">{{$data->address}}</td>
                  <td><strong>PLATE NUMBER</strong></td>
                  <td>{{$data->plate_number}}</td>
                  <td></td>
                </tr>
                <tr>
                 <td><strong>VEHICLE MODEL</strong></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td class="pe-3 fw-medium">{{$data->mobile_number}}</td>
                  <td>{{$data->manufacturer}} {{$data->vehicle_model}} {{$data->year}}</td>
                  <td></td>
                  <td></td>
                </tr>
                
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <hr class="my-0" />
        <div class="card-body pb-0 tbl-header">
            <h6 class=""><strong>PACKAGE, EXPRESS</strong></h6>
      </div>
      <div class="card-body">
        <div class="source-item pt-1">
          <div class="mb-3" data-repeater-list="group-a">
            <div class="repeater-wrapper pt-0 pt-md-2">
              <div class=" rounded position-relative pe-0 color-white">
                @if($optionOneHtml == false)
                <div class="border row w-100  p-2"  data-repeater-item>
                  <div class="col-md-7 col-12 mb-md-0 mb-3">
                    <select class="form-select item-details mb-3" name="package">';
                        <option value="" selected></option>
                      @foreach($jobOrderPackageOption as $k => $op)
                        <option value="{{$op->id}}">{{$op->value}}</option>
                      @endforeach
                      </select>
                  </div>
                </div>
                @else 
                  @foreach($optionOneHtml as $k => $d)
                    {!!$d!!}
                  @endforeach
                @endif
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="button" class="btn btn-primary btn-sm" onclick="addItem('package')" data-repeater-create><i class="mdi mdi-plus me-1"></i> Add Item</button>
            </div>
          </div>
        </div>
      </div>



      <hr class="my-0" />
      <div class="card-body pb-0 tbl-header">
        <div class="mb-0 pb-0">
          <h6><strong>LABOR</strong></h6>
        </div>
      </div>
      <div class="card-body">
        <div class="source-item pt-1">
          <div class="mb-3" data-repeater-list="group-b">
            <div class="d-flex repeater-wrapper pt-0 pt-md-4">
              <div class="rounded position-relative pe-0 color-white">
                @if($optionTwoHtml == false)
                <div class="border row w-100 p-3 pr-0" style="padding-right: 0px !important;"  id="item-list-part-1"  data-repeater-item>
                 <div class="col-md-1 col-12 mb-md-0 mb-3 color-black">
                    <h6 class="mb-2 repeater-title fw-medium"><strong>No</strong></h6>
                    <span id="labor-counter-1">1</span>
                  </div>
                  <div class="col-md-5 col-12 mb-md-0 mb-3">
                    <h6 class="mb-2 repeater-title fw-medium"><strong>Service</strong></h6>
                    <select class="form-select item-details mb-3" name="labor" id="labor-option-1" onchange="calculateLabor(1)">';
                        <option value="" selected></option>
                      @foreach($jobOrderLaborOption as $keyl => $p)
                        <option value="{{$p->id}}" >{{$p->value}}</option>
                       @endforeach
                    </select>
                  </div>
                     <div class="col-md-2 col-12 mb-md-0 mb-3">
                    <h6 class="mb-2 repeater-title fw-medium">Qty</h6>
                    <input type="text" class="form-control invoice-item-qty" name="labor-qty" id="labor-qty-1" value="1" placeholder="1" min="1" max="50" onchange="calculateLabor(1)" />
                  </div>
                  <div class="col-md-2 col-12 mb-md-0 mb-3">
                    <h6 class="mb-2 repeater-title fw-medium">Price</h6>
                    <input type="text" class="form-control invoice-item-price mb-3" name="labor-price" id="labor-price-1" value="0" placeholder="0" min="12" onchange="calculateLabor(1)" />
                  </div>
                  <div class="col-md-1 col-12 pe-0">
                    <h6 class="mb-2 repeater-title fw-medium">Amount</h6>
                    <p class="mb-0 pt-2 color-black amount-labor-sub d-flex" id="amount-labor-sub-1">₱
                    <input type="text" class="form-control invoice-item-amount mb-3 p-0 border-0 pe-none" name="labor-amount" id="labor-amount-1" value="0" placeholder="" min="12"/>
                    </p>
                  </div>
                <div class="col-md-1 col-12 border-start text-right">
                  <i class="mdi mdi-close cursor-pointer color-black" onclick="deleteItem(1 , 1)" data-repeater-delete></i>
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
                @else 
                 @foreach($optionTwoHtml as $k => $l)
                    {!!$l!!}
                  @endforeach
                @endif
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="button" class="btn btn-primary btn-sm"  onclick="addItem('labor')" data-repeater-create><i class="mdi mdi-plus me-1"></i> Add Item</button>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body pt-0">
        <div class="row">
          <div class="col-md-6">
          </div>
          <div class="col-md-6 d-flex justify-content-md-end mt-2">
            <div class="invoice-calculations">
              <div class="d-flex justify-content-between mb-2">
                <span class="w-px-150">Total:</span>
                <h6 class="mb-0 pt-1">₱5000.25</h6>
              </div>
           
            </div>
          </div>
        </div>
      </div>









         <hr class="my-0" />
      <div class="card-body pb-0 tbl-header">
        <div class="mb-0 pb-0">
          <h6><strong>PARTS & MATERIALS</strong></h6>
        </div>
      </div>
      <div class="card-body">
        <div class="source-item pt-1">
          <div class="mb-3" data-repeater-list="group-c">
            <div class="d-flex repeater-wrapper pt-0 pt-md-4">
              <div class="rounded position-relative pe-0 color-white">
                @if($optionThreeHtml == false)
                <div class="border row w-100 p-3 pr-0" style="padding-right: 0px !important;"  id="item-list-part-1"  data-repeater-item>
                 <div class="col-md-1 col-12 mb-md-0 mb-3 color-black">
                    <h6 class="mb-2 repeater-title fw-medium"><strong>No</strong></h6>
                    <span id="part-counter-1">1</span>
                  </div>
                  <div class="col-md-5 col-12 mb-md-0 mb-3">
                    <h6 class="mb-2 repeater-title fw-medium"><strong>Service</strong></h6>
                    <select class="form-select item-details mb-3" name="part" id="part-option-1" onchange="calculatePart(1)">';
                        <option value="" selected></option>
                      @foreach($jobOrderPartServiceOption as $keyprt => $prt)
                        <option value="{{$prt->id}}" >{{$prt->value}}</option>
                       @endforeach
                    </select>
                  </div>
                     <div class="col-md-2 col-12 mb-md-0 mb-3">
                    <h6 class="mb-2 repeater-title fw-medium">Qty</h6>
                    <input type="text" class="form-control invoice-item-qty" name="part-qty" id="part-qty-1" value="1" placeholder="1" min="1" max="50" onchange="calculatePart(1)" />
                  </div>
                  <div class="col-md-2 col-12 mb-md-0 mb-3">
                    <h6 class="mb-2 repeater-title fw-medium">Price</h6>
                    <input type="text" class="form-control invoice-item-price mb-3" name="part-price" id="part-price-1" value="0" placeholder="0" min="12" onchange="calculatePart(1)" />
                  </div>
                  <div class="col-md-1 col-12 pe-0">
                    <h6 class="mb-2 repeater-title fw-medium">Amount</h6>
                    <p class="mb-0 pt-2 color-black amount-part-sub d-flex" id="amount-part-sub-1">₱
                    <input type="text" class="form-control invoice-item-amount mb-3 p-0 border-0 pe-none" name="part-amount" id="part-amount-1" value="0" placeholder="" min="12"/>
                    </p>
                  </div>
                <div class="col-md-1 col-12 border-start text-right">
                  <i class="mdi mdi-close cursor-pointer color-black" onclick="deleteItem(2 , 1)" data-repeater-delete></i>
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
                @else 
                 @foreach($optionThreeHtml as $k => $l)
                    {!!$l!!}
                  @endforeach
                @endif
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="button" class="btn btn-primary btn-sm"  onclick="addItem('part')" data-repeater-create><i class="mdi mdi-plus me-1"></i> Add Item</button>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body pt-0">
        <div class="row">
          <div class="col-md-6">
          </div>
          <div class="col-md-6 d-flex justify-content-md-end mt-2">
            <div class="invoice-calculations">
              <div class="d-flex justify-content-between mb-2">
                <span class="w-px-150">Total:</span>
                <h6 class="mb-0 pt-1">₱5000.25</h6>
              </div>
           
            </div>
          </div>
        </div>
      </div>









      
<!-- 

      <hr class="my-0" />
      <div class="card-body pb-0 tbl-header">
        <div class="mb-0 pb-0">
          <h6><strong>PARTS & MATERIALS</strong></h6>
        </div>
      </div>
      <div class="card-body">
        <div class="source-item pt-1">
          <div class="mb-3" data-repeater-list="group-c">
            <div class="repeater-wrapper pt-0 pt-md-4">
              <div class="border rounded position-relative pe-0">

                @if($optionThreeHtml == false)
                <div class="border row w-100 p-3"  data-repeater-item>
                      <div class="col-md-1 col-12 mb-md-0 mb-3">
                    <h6 class="mb-2 repeater-title fw-medium"><strong>No</strong></h6>
                    1
                  </div>
                  <div class="col-md-6 col-12 mb-md-0 mb-3">
                    <h6 class="mb-2 repeater-title fw-medium"><strong>Service</strong></h6>
                    <select class="form-select item-details mb-3" name="part" id="part-option-1" onchange="calculatePart(1)">';

                       @foreach($jobOrderPartServiceOption as $keyp => $prt)
                        <option value="{{$prt->id}}" selected>{{$prt->value}}</option>
                       @endforeach
                    </select>
                  </div>
                     <div class="col-md-2 col-12 mb-md-0 mb-3">
                    <h6 class="mb-2 repeater-title fw-medium">Qty</h6>
                    <input type="text" class="form-control invoice-item-qty" name="part-qty" id="part-qty-1" value="1" placeholder="1" min="1" max="50" />
                  </div>
                  <div class="col-md-2 col-12 mb-md-0 mb-3">
                    <h6 class="mb-2 repeater-title fw-medium">Price</h6>
                    <input type="text" class="form-control invoice-item-price mb-3" name="part-price" id="part-price-1" value="24" placeholder="24" min="12" />
                    
                  </div>
            
                <div class="col-md-1 col-12 pe-0">
                    <h6 class="mb-2 repeater-title fw-medium">Amount</h6>
                    <p class="mb-0 pt-2 color-black amount-part-sub d-flex" id="amount-part-sub-1">₱
                    <input type="text" class="form-control invoice-item-amount mb-3 p-0 border-0 pe-none" name="part-amount" id="part-amount-1" value="0" placeholder="" min="12"/>
                    </p>
                  </div>
                </div>
                <div class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                  <i class="mdi mdi-close cursor-pointer color-black" data-repeater-delete></i>
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
                @else 
                 @foreach($optionThreeHtml as $k => $prtSrvc)
                    {!!$prtSrvc!!}
                  @endforeach
                @endif

                <div class="row w-100 p-3">
                      <div class="col-md-1 col-12 mb-md-0 mb-3">
                    <h6 class="mb-2 repeater-title fw-medium"><strong>No</strong></h6>
                    1
                  </div>
                  <div class="col-md-6 col-12 mb-md-0 mb-3">
                    <h6 class="mb-2 repeater-title fw-medium"><strong>Service</strong></h6>
                    <select class="form-select item-details mb-3" name="part">
                      @foreach($jobOrderPartServiceOption as $k => $s)
                        <option value="{{$s->id}}" selected>{{$s->value}}</option>
                       @endforeach
                    </select>
                  </div>
                     <div class="col-md-2 col-12 mb-md-0 mb-3">
                    <h6 class="mb-2 repeater-title fw-medium">Qty</h6>
                    <input type="text" class="form-control invoice-item-qty" name="part-qty"  value="1" placeholder="1" min="1" max="50" />
                  </div>
                  <div class="col-md-2 col-12 mb-md-0 mb-3">
                    <h6 class="mb-2 repeater-title fw-medium">Price</h6>
                    <input type="text" class="form-control invoice-item-price mb-3" name="part-price" value="24" placeholder="24" min="12" />
                    
                  </div>
               
                  <div class="col-md-1 col-12 pe-0">
                    <h6 class="mb-2 repeater-title fw-medium">Amount</h6>
                    <p class="mb-0 pt-2" id="amount-sub">$1222</p>
                  </div>
                </div>
                <div class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                  <i class="mdi mdi-close cursor-pointer" data-repeater-delete></i>
                  <div class="dropdown">
                    <i class="mdi mdi-cog-outline cursor-pointer more-options-dropdown" role="button" id="dropdownMenuButton" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
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
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="button" class="btn btn-primary btn-sm"  onclick="addItem('part')" data-repeater-create><i class="mdi mdi-plus me-1"></i> Add Item</button>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body pt-0">
        <div class="row">
          <div class="col-md-6">
          </div>
          <div class="col-md-6 d-flex justify-content-md-end mt-2">
            <div class="invoice-calculations">
              <div class="d-flex justify-content-between mb-2">
                <span class="w-px-150">Total:</span>
                <h6 class="mb-0 pt-1">$5000.25</h6>
              </div>
            </div>
          </div>
        </div>
      </div> -->

      <hr class="my-0" />
      <div class="card-body pt-0">
        <div class="row">
          <div class="col-md-8 d-flex justify-content-md-start mt-2">
            <div class="invoice-calculations">
              <div class=" justify-content-between mb-2 mt-3">
                <h6 class="mb-0 pt-1">REMARKS</h6><br>
                <span class="">
                  <b>
                    This is merely an estimate. Cost of parts quoted may change depending on the availability of the above quoted parts. NO WARRANTY on service where PARTS/FLUIDS are provided by customer. NO WARRANTY on change oil service where OIL SLUDGE is detected upon inspection. Presence of oil sludge may cause engine trouble. ENGINE FLUSH does not guarantee the complete removal of oil sludge. Proper period of changing your oil is still the best way in preventing the build up of oil sludge.			
                  </b>  
                </span>
              </div>
            </div>
          </div>
            <div class="col-md-4 d-flex justify-content-md-end mt-2">
             <div class="invoice-calculations">
            </div>
          </div>
        </div>
      </div>



      <div class="card-body pt-0">
        <div class="row">
          <div class="col-md-8 d-flex justify-content-md-start">
            <div class="invoice-calculations">
              <div class=" justify-content-between mb-2">
                <span class="">
                  <b>
                  PLEASE READ: Under MAP Uniform Inspection Guidelines, we are required to document all our findings on your vehicle. This is your estimate. Our Store Manager should bring you to your car, show you the needed repairs and go over the estimate with you, item by item. All your questions should be answered. We want you to know all your options. This is your car. We want to help you keep it in good running condition
                  </b>  
                </span>
              </div>
            </div>
          </div>
            <div class="col-md-4 d-flex justify-content-md-end mt-2">
             <div class="invoice-calculations">
              <div class="d-flex justify-content-between mb-2">
                <span class="w-px-150"><b>SUBTOTAL</b></span>
                <h6 class="mb-0 pt-1">₱5000.25</h6>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span class="w-px-150"><b>VAT</b>(12%)</span>
                <h6 class="mb-0 pt-1">₱370.00</h6>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span class="w-px-150"><b>TOTAL AMOUNT</b></span>
                <h6 class="mb-0 pt-1">₱2,300.00</h6>
              </div>
               <div class="d-flex justify-content-between mb-2">
                <span class="w-px-150"><b>PAYMENT</b></span>
                <h6 class="mb-0 pt-1"></h6>
              </div>
              <hr />
              <div class="d-flex justify-content-between">
                <span class="w-px-150"><b>TOTAL</b></span>
                <h6 class="mb-0 pt-1">₱5100.25</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      



      <hr class="my-0" />
      <div class="card-body">
        <div class="row">
          <div class="col-md-6 mb-md-0 mb-3">
            <div class="form-floating form-floating-outline mb-4">
              <input type="text" class="form-control" id="salesperson" placeholder="Edward Crowley" value="FERDINAND ENCARNACION" />
              <label for="salesperson" class="fw-medium">STORE MANAGER</label>
            </div>
           
          </div>
          <div class="col-md-6 d-flex justify-content-md-end mt-2">
            <div class="form-floating form-floating-outline mb-4">
              <input type="text" class="form-control" id="invoiceMsg" placeholder="Gerald Tejero" value="Gerald Tejero" />
              <label for="invoiceMsg">Customer Signature</label>
            </div>
          </div>
        </div>
      </div>
      <hr class="my-0" />
      <!-- <div class="card-body">
        <div class="row">
          <div class="col-12">
            <div class="mb-3">
              <label for="note" class="form-label fw-medium text-heading">Note:</label>
              <textarea class="form-control" rows="2" id="note">It was a pleasure working with you and your team. We hope you will keep us in mind for future freelance projects. Thank You!</textarea>
            </div>
          </div>
        </div>
      </div> -->
    </div>
  </div>
  <!-- /Invoice Edit-->

  <!-- Invoice Actions -->
  <div class="col-lg-3 col-12 invoice-actions">
    <div class="card mb-4">
      <div class="card-body">
        <button class="btn btn-primary d-grid w-100 mb-3" data-bs-toggle="offcanvas" data-bs-target="#sendInvoiceOffcanvas">
          <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="mdi mdi-send-outline scaleX-n1-rtl me-2"></i>Send Invoice</span>
        </button>
        <a href="#" id="btn-preview" class="btn btn-outline-secondary w-100 me-2 mb-3">Preview</a>
        <button type="button" class="btn btn-success w-100 mb-3" onclick="saveInvoice({{$job_order_id}})">Save</button>
        <!-- <button class="btn btn-success d-grid w-100 mb-3" data-bs-toggle="offcanvas" data-bs-target="#addPaymentOffcanvas">
          <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="mdi mdi-currency-usd me-1"></i>Add Payment</span>
        </button> -->
      </div>
    </div>
    <div>
      <div class="form-floating form-floating-outline mb-4">
        <select class="form-select bg-body mb-4" id="select-payment-edit">
          <option value="Bank Account">Bank Account</option>
          <option value="Paypal">Paypal</option>
          <option value="Card">Credit/Debit Card</option>
          <option value="UPI Transfer">UPI Transfer</option>
        </select>
        <label for="select-payment-edit" class="bg-body">Accept payments via</label>
      </div>
      <div class="d-flex justify-content-between mb-2">
        <label for="payment-terms" class="mb-0">Payment Terms</label>
        <label class="switch switch-primary me-0">
          <input type="checkbox" class="switch-input" id="payment-terms" checked />
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"></span>
        </label>
      </div>
      <div class="d-flex justify-content-between mb-2">
        <label for="client-notes" class="mb-0">Client Notes</label>
        <label class="switch switch-primary me-0">
          <input type="checkbox" class="switch-input" id="client-notes" />
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"></span>
        </label>
      </div>
      <div class="d-flex justify-content-between">
        <label for="payment-stub" class="mb-0">Payment Stub</label>
        <label class="switch switch-primary me-0">
          <input type="checkbox" class="switch-input" id="payment-stub" />
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label"></span>
        </label>
      </div>
    </div>
  </div>
  <!-- /Invoice Actions -->
</div>
</form>
@endforeach
<!-- Offcanvas -->
@include('_partials/_offcanvas/offcanvas-send-invoice')
@include('_partials/_offcanvas/offcanvas-add-payment')
<!-- /Offcanvas -->
@endsection
