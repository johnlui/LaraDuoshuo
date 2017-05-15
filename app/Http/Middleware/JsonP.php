<?php

namespace App\Http\Middleware;

use Closure;

class JsonP
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    $seed = $request->get('seed','');
    $sign = $request->get('sign','');
    if ( $seed < time() - 86400 || $seed > time() + 86400 ) {
      return response((new \App\Http\Controllers\Controller)->jsonPResponse(403, '客户端时间错误'));
    }
    $newStr = $seed.\Config::get('app.key');
    $newArr = str_split($newStr);
    sort($newArr);
    if ( md5(implode('',$newArr)) != $sign ) {
      return response((new \App\Http\Controllers\Controller)->jsonPResponse(403, '签名错误'));
    }
    return $next($request);
  }
}
