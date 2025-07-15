<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\CustomerLead;




use Symfony\Component\HttpFoundation\Response;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

    Route::post('/leads', function(Request $request) {
          $requestJson = Request::capture()->json();
           $new = new CustomerLead();
            foreach($requestJson as $key => $value) {
              $new->linkedin_url= ((isset($value['linked_in'])) ? $value['linked_in'] : "");
              $new->email = ((isset($value['email'])) ? $value['email'] : "");
              $new->name = ((isset($value['name'])) ? $value['name'] : "");
              $new->fullname = ((isset($value['fullname'])) ? $value['fullname'] : "");
              $new->username = ((isset($value['username'])) ? $value['username'] : "");
              $new->provider_id = ((isset($value['provider_id'])) ? $value['provider_id'] : "");
              $new->location = ((isset($value['location'])) ? $value['location'] : "");
              $new->page_visited = ((isset($value['page_visited'])) ? $value['page_visited'] : "");
              $new->website = ((isset($value['website'])) ? $value['website'] : "");
              $new->title = ((isset($value['title'])) ? $value['title'] : "");
              $new->mobile = ((isset($value['mobile'])) ? $value['mobile'] : "");
              $new->repliq_html = ((isset($value['repliq_html'])) ? $value['repliq_html'] : "");
              $new->linkedin_connection_sent = ((isset($value['linkedin_connection_sent'])) ? $value['linkedin_connection_sent'] : "");
              $new->email_sent = ((isset($value['email_sent'])) ? $value['email_sent'] : "");
            $new->save();
        }
    });
