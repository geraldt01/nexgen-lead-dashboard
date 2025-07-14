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
        foreach($requestJson  as $key => $value) {
            if($key == 'name') {
                $new->name = $value ? $value : "";
            }
            if($key == 'email') {
                $new->email = $value ? $value : "";
            }
            $new->save();
        }
    });
