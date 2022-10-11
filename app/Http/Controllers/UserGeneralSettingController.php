<?php

namespace App\Http\Controllers;

use App\UserGeneralSetting;
use Illuminate\Http\Request;
use Auth;

class UserGeneralSettingController extends Controller
{
    public function updateOrCreateCompanyId($id) {
        $userGeneralSetting = UserGeneralSetting::firstOrNew(array('user_id' => Auth::user()->id));
        $userGeneralSetting->user_id = Auth::user()->id;
        $userGeneralSetting->role_id = Auth::user()->role_id;
        $userGeneralSetting->company_id = $id;
        $userGeneralSetting->save();

        return redirect('/');
    }
    
}
