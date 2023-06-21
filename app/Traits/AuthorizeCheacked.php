<?php
 
namespace App\Traits;
use Auth;

trait AuthorizeCheacked
{
   public function authorizeCheacked($permission){
    if (!Auth::user()->can($permission)){
        throw new \Illuminate\Auth\Access\AuthorizationException(__('auth.admin only Unauthorised'));

    }
   }


}



