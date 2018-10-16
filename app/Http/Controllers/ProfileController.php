<?php

namespace App\Http\Controllers;

use App\ActivateProfile;
use App\Friend;
use App\Images;
use App\Profiles;
use App\RoleMaster;
use App\UserMaster;
use App\ViewContacts;
use App\ViewedContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

session_start();

class ProfileController extends Controller
{

    public function viewcontact()
    {
        if (isset($_SESSION['user_master'])) {
//            $user = $_SESSION['user_master'];
            $view_user_id = request('search_user_id');
            $user = Profiles::find($_SESSION['user_master']->id);
            $active = ActivateProfile::find($user->id);
            if ($active->active != 'no' && $active->active != '') {
                $viewed_contact = ViewedContact::where(['user_id' => $user->id, 'viewed_id' => $view_user_id])->first();
                if (!isset($viewed_contact)) {
                    $viewed_contact_add = new ViewedContact();
                    $viewed_contact_add->user_id = $user->id;
                    $viewed_contact_add->viewed_id = $view_user_id;
                    $viewed_contact_add->save();

                    $contact = ViewContacts::where(['user_id' => $user->id])->first();
                    $contact->contact_left -= 1;
                    $contact->save();
                }
                echo 'success';
            } else {
                echo 'unpaid';
            }
        } else {
            echo 'Please login first';
        }
    }


    public function show_contact()
    {
        if (isset($_SESSION['user_master'])) {
            $user_ses = $_SESSION['user_master'];
            $user = Profiles::find(request('user_id'));
            $image = Images::find(request('user_id'));
            return view('web.profile.show_contact')->with(['user' => $user, 'image' => $image]);
        } else {
            return redirect('/')->withErrors('Please login first');
        }
    }


    public function sendrequest()
    {
        if (isset($_SESSION['user_master'])) {
            $user = $_SESSION['user_master'];
            DB::table('friends')->where(['user_id' => $user->id, 'friend_id' => request('search_user_id')])->where(['user_id' => request('search_user_id'), 'friend_id' => $user->id])->delete();
            $friend = new Friend();
            $friend->user_id = $user->id;
            $friend->friend_id = request('search_user_id');
            $friend->status = 'pending';
            $friend->save();
            echo 'success';
        } else {
            echo 'Please login first';
        }
    }

    public function cancelrequest() ////by user send/cancel button
    {
        if (isset($_SESSION['user_master'])) {
            $user = $_SESSION['user_master'];
            $friend = Friend::where(['user_id' => $user->id, 'friend_id' => request('search_user_id'), 'status' => 'pending'])->delete();
            echo 'success';
        } else {
            echo 'Please login first';
        }
    }

    public function acceptfrequest()
    {
        $user = $_SESSION['user_master'];
        $friend = Friend::where(['user_id' => request('search_user_id'), 'friend_id' => $user->id])->first();
        $friend->status = 'friends';
        $friend->save();
        echo "Friends";
    }


    public function unfriend() ////by user send/cancel button
    {
        $user_id = $_SESSION['user_master']->id;
        $friend_id = request('friend_id');
        $friend = DB::select("select f.id, f.status as status from friends f where (f.user_id = $user_id and f.friend_id = $friend_id or f.user_id = $friend_id and f.friend_id = $user_id)");
        if ($friend != null) {
            $f = Friend::find($friend[0]->id);
            $f->delete();
            echo 'unfriend';
        } else {
            echo 'No record available';
        }
    }

    public function myprofile()
    {
        if (isset($_SESSION['user_master'])) {
            $user = Profiles::find($_SESSION['user_master']->id);
            return view('web.my_profile_new')->with(['user' => $user]);
        } else {
            return Redirect::back()->withInput()->withErrors(array('message' => 'Please login first'));
        }
    }

    public function profile_photo()
    {
        if (isset($_SESSION['user_master'])) {
            $user = Profiles::find($_SESSION['user_master']->id);
            return view('web.profile_photo')->with(['user' => $user]);
        } else {
            return Redirect::back()->withInput()->withErrors(array('message' => 'Please login first'));
        }
    }

    public function edit_profile()
    {
        if (isset($_SESSION['user_master'])) {
            $user = Profiles::find($_SESSION['user_master']->id);
            return view('web.edit_profile')->with(['user' => $user]);
        } else {
            return Redirect::back()->withInput()->withErrors(array('message' => 'Please login first'));
        }
    }

    public function edit_profile_admin($id)
    {
        $user = Profiles::find($id);
        return view('web.edit_profile_admin')->with(['user' => $user]);
    }

    public
    function change_password()
    {
        $curr_pass = $_SESSION['user_master']->password;
        if (request('oldpassword') == $curr_pass) {
//            if (request('newpassword') == request('confirmpassword')) {
            $user = Profiles::find($_SESSION['user_master']->id);
            $user->password = request('newpassword');
            $user->save();
            $_SESSION['user_master'] = $user;
            echo 'ok';
        } else
            echo 'Incorrect';
    }

    public function create()
    {
        $role_masters = RoleMaster::getRoleDropdown();
        $user_no = Profiles::GenerateUserNumber();
        return view('user.create_user_master')->with(['role_masters' => $role_masters, 'user_no' => $user_no]);
    }

    public function index()
    {
        $role_masters = RoleMaster::getRoleDropdown();
        $user_no = Profiles::GenerateUserNumber();
//        $user_masters = Profiles::get();
        $users = DB::table('profiles')->orderBy('id', 'desc')->paginate(5);
        return view('user.admin_candidate_list')->with(['users' => $users, 'user_no' => $user_no]);
    }

    public function store(Request $request)
    {
//        if (request('id_proof') != null)
//            echo "No";
        $user_master = new Profiles();
        if (!$user_master->checkUsername(request('username'))) {
            return Redirect::back()->withInput()->withErrors('Username already exists in the system. Please type a different username.');
        }
        if (strlen(request('username')) < 5 || strlen(request('password')) < 5) {
            return Redirect::back()->withInput()->withErrors('Username or password must be at least 5 character long');
        }

        $user = new Profiles();
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
        $user_master = Profiles::find($id);
        return view('user.edit_user_master')->with(['user_master' => $user_master, 'role_masters' => $role_masters]);
    }

    public function update($id, Request $request)
    {

        $user_master = Profiles::find($id);
        $user_master->name = request('name');
        $user_master->contact = request('contact');
        $user_master->role_master_id = request('role_master_id');
        $user_master->save();
        return Redirect::back();
    }

    public
    function destroy($id)
    {
        $user_master = Profiles::find($id);
        $user_master->is_active = 0;
        $user_master->save();
        return redirect('user_master');
    }

//
    public function activate($id)
    {
        $user_master = Profiles::find($id);
        $user_master->is_active = 1;
        $user_master->save();
        return redirect('user_master');
    }

    public
    function checkUsername($username)
    {
        $user = Profiles::where(['is_active' => 1, 'username' => $username])->first();
        if (is_null($user)) return true;
        else return false;
    }
}
