<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function jsonPResponse($status = 0 , $message = '' , $data='')
  {
    return '_jqjsp('.json_encode(['status' => $status, 'message'=>$message ,'values' => $data], JSON_UNESCAPED_UNICODE).')';
  }
}
