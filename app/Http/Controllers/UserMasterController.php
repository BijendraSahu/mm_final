<?php

namespace App\Http\Controllers;

use App\ActivateProfile;
use App\Plan;
use App\Profiles;
use App\RoleMaster;
use App\UserMaster;
use App\ViewContacts;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

session_start();

class UserMasterController extends Controller
{
    public function getdetails()
    {
        return view('user.user_details')->with('user_masters', UserMaster::getUserMaster());
    }

    public function index()
    {
        return view('user.view_user_master')->with('user_masters', UserMaster::getUserMaster());
    }

    public function create()
    {
        $role_masters = RoleMaster::getRoleDropdown();
        $user_no = UserMaster::GenerateUserNumber();
        return view('user.create_user_master')->with(['role_masters' => $role_masters, 'user_no' => $user_no]);
    }

    public function store(Request $request)
    {
//        if (request('id_proof') != null)
//            echo "No";
        $user_master = new UserMaster();
        if (!$user_master->checkUsername(request('username'))) {
            return Redirect::back()->withInput()->withErrors('Username already exists in the system. Please type a different username.');
        }
        if (strlen(request('username')) < 5 || strlen(request('password')) < 5) {
            return Redirect::back()->withInput()->withErrors('Username or password must be at least 5 character long');
        }

        $user = new UserMaster();
        $user->name = request('name');
        $user->contact = request('contact');
        $user->username = request('username');
        $user->password = md5(request('password'));
        $user->role_master_id = request('role_master_id');
        $user->full_user_no = request('full_user_no');
        $user->user_no = request('user_no');
        $user->save();
        return redirect('user_master');
    }

    public function edit($id)
    {
        $role_masters = RoleMaster::getRoleDropdown();
        $user_master = UserMaster::find($id);
        return view('user.edit_user_master')->with(['user_master' => $user_master, 'role_masters' => $role_masters]);
    }

    public function update($id, Request $request)
    {

        $user_master = UserMaster::find($id);
        $user_master->name = request('name');
        $user_master->contact = request('contact');
        $user_master->role_master_id = request('role_master_id');
        $user_master->save();
        return Redirect::back();
    }

    public
    function destroy($id)
    {
        $user_master = UserMaster::find($id);
        $user_master->is_active = 0;
        $user_master->save();
        return redirect('user_master');
    }
//
    public function activate($id)
    {
        $user_master = UserMaster::find($id);
        $user_master->is_active = 1;
        $user_master->save();
        return redirect('user_master');
    }

    public function mark_as_paid($user_id)
    {
        $user = Profiles::find($user_id);
        $activate = ActivateProfile::find($user->id);
        $plan_id = 1;
        $plan = Plan::find($plan_id);
        $activate->active = 'yes';
        $activate->plan = 'Gold';
        $activate->plan_id = $plan_id;
        $activate->activated_at = Carbon::now();
        $activate->deactivated_at = Carbon::now()->addMonth($plan->valid)->format('Y-m-d');
        $activate->save();

        $contact = ViewContacts::where(['user_id' => $user->id])->first();
        if (isset($contact)) {
            $contact->contact_left += $plan->contact_view;
            $contact->save();
        } else {
            $new_c = new ViewContacts();
            $new_c->user_id = $user->id;
            $new_c->contact_left = $plan->contact_view;
            $new_c->save();
        }
        return redirect('user_master')->with('message', 'Congratulation...this user is now paid member');
//        $user_master = UserMaster::find($id);
//        $user_master->is_active = 1;
//        $user_master->save();
//        return redirect('user_master');
    }

    public
    function checkUsername($username)
    {
        $user = UserMaster::where(['is_active' => 1, 'username' => $username])->first();
        if (is_null($user)) return true;
        else return false;
    }
}
