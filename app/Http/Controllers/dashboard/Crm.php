<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerLead;

use DB;
class Crm extends Controller
{
    public function index(){
      return view('content.dashboard.dashboards-crm');
    }

    
  public function jsonLeadList() {
    $Inventory = DB::table('customer_leads')
    // ->where('status', '=', 1)
    ->get();
    foreach($Inventory as $value) {
      $array[] = array(
        '' => '',
        'id' => $value->id,
        'linkedin_url' => $value->linkedin_url,
        'full_name' => $value->name,
        'email' => $value->email,
        'start_date' => $value->page_visited,
        'status' => $value->status,
        'website' => $value->website,
        'status' => $value->phone,
        'date' => $value->created_at,
        'title' => $value->title,
        '' => '',
      );
    }
    $inventory['data'] = $array;
    return response()->json($inventory);
  }
}
