<?php

namespace App\Http\Controllers;

use App\ActivateProfile;
use App\Images;
use App\Profiles;
use App\UserMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

session_start();

class User_loginController extends Controller
{
    public function register()
    {
        $contact = trim(request('contact'));
        $useremail = Profiles::where(['email' => request('email_id')])->first();
        $usermob = Profiles::where(['contact' => $contact])->first();
        if (isset($useremail)) {
            return redirect('registration')->withInput()->withErrors('Email is Already Linked With Another Account!!!!');
        } elseif (isset($usermob)) {
            return redirect('registration')->withInput()->withErrors('Mobile Number Already Linked With Another Account!!!!!!');
        } else {
            $reg = new Profiles();
            $reg->email = request('email');
            $reg->contact = request('contact');
            $reg->password = request('password');
            $reg->gender = request('gender');
            if (request('name') != null)
                $reg->name = request('name');
            if (request('create_for') != null)
                $reg->create_for = request('create_for');
            if (request('dob') != null)
                $reg->dob = Carbon::parse(request('dob'))->format('Y-m-d');
            if (request('height') != null)
                $reg->height = request('height');
            if (request('gotra') != null)
                $reg->gotra = request('gotra') == '' ? 'Not mentioned' : request('gotra');
            if (request('father_side_gotra') != null)
                $reg->father_side_gotra = request('father_side_gotra');
            if (request('mother_side_gotra') != null)
                $reg->mother_side_gotra = request('mother_side_gotra');
            if (request('status') != null)
                $reg->status = request('status');
            if (request('living') != null)
                $reg->living = request('living');
            if (request('religion') != null)
                $reg->religion = request('religion');
            if (request('caste') != null)
                $reg->caste = request('caste');
            if (request('subcaste') != null)
                $reg->subcaste = request('subcaste');
            if (request('manglik') != null)
                $reg->manglik = request('manglik');
            if (request('language') != null)
                $reg->language = request('language');
            if (request('highest_degree') != null)
                $reg->highest_degree = request('highest_degree');
            if (request('college_name') != null)
                $reg->college_name = request('college_name');
            if (request('occupation') != null)
                $reg->occupation = request('occupation');
            if (request('occupation_detail') != null)
                $reg->occupation_detail = request('occupation_detail');
            if (request('anual_income') != null)
                $reg->anual_income = request('anual_income');
            if (request('f_values') != null)
                $reg->f_values = request('f_values');
            if (request('f_type') != null)
                $reg->f_type = request('f_type');
            if (request('f_status') != null)
                $reg->f_status = request('f_status');
            if (request('family_income') != null)
                $reg->f_income = request('family_income');
            if (request('brothers') != null)
                $reg->brothers = request('brothers');
            if (request('sisters') != null)
                $reg->sisters = request('sisters');
            if (request('bro_married') != null)
                $reg->bro_married = request('bro_married');
            if (request('sis_married') != null)
                $reg->sis_married = request('sis_married');
            if (request('father_occupation') != null)
                $reg->father_occupation = request('father_occupation');
            if (request('mother_occupation') != null)
                $reg->mother_occupation = request('mother_occupation');
            if (request('about_me') != null)
                $reg->about_me = request('about_me');
            if (request('horoscope_match') != null)
                $reg->horoscope_match = request('horoscope_match');
            if (request('bop') != null)
                $reg->bop = request('bop');
            if (request('p_agefrom') != null)
                $reg->p_agefrom = request('p_agefrom');
            if (request('p_ageto') != null)
                $reg->p_ageto = request('p_ageto');
            if (request('p_status') != null)
                $reg->p_status = request('p_status');
            if (request('p_heightfrom') != null)
                $reg->p_heightfrom = request('p_heightfrom');
            if (request('p_language') != null)
                $reg->p_language = request('p_language');
            if (request('p_city') != null)
                $reg->p_city = request('p_city');
            if (request('p_state') != null)
                $reg->p_state = request('p_state');
            if (request('p_salary') != null)
                $reg->p_salary = request('p_salary');
            if (request('p_religion') != null)
                $reg->p_religion = request('p_religion');
            if (request('dob') != null)
                $reg->age = Carbon::parse($reg->dob)->diff(Carbon::now())->format('%y');
            $otp = rand(100000, 999999);
            $reg->otp = $otp;
            $reg->save();

            $activate = new ActivateProfile();
            $activate->id = $reg->id;
            $activate->active = 'no';
            $activate->save();

            $images = new Images();
            $images->id = $reg->id;
            $images->save();
            if (request('admin_reg') == 0) {
                $this->sendmail($otp);
            }
            return redirect('/')->with('message', 'Registration has been successful');
        }
    }

    public
    function forgot_password()
    {
        $otp = rand(100000, 999999);
        $contact = request('contact');
        $user = UserMaster::where(['contact' => $contact])->first();
        if (isset($user)) {
            $user_master = UserMaster::find($user->id);
            $user_master->password = $otp;
            $user_master->save();
            file_get_contents("http://api.msg91.com/api/sendhttp.php?sender=CONONE&route=4&mobiles=$user_master->contact&authkey=213418AONRGdnQ5ae96f62&country=91&message=Dear%20user,%20Password%20to%20login%20into%20MangalMandap%20is%20$otp");
            $_SESSION['user_master'] = $user_master;
            echo 'ok';
        } else {
            echo 'Incorrect';
        }
    }

    public
    function sendmail($otp)
    {
        /***********Mail************/
        $allmails = [request('email'), 'mailprofile2016@gmail.com'];

        foreach ($allmails as $mail) {
            $email[] = $mail;
        }
        if (count($email) > 0) {
            $mail = new \App\Mail();
            $mail->to = implode(",", $email);
            $mail->subject = 'Welcome To Mangal Mandap';
            $siteurl = 'http://bijendrasahu-001-site1.itempurl.com/';
//            $siteurl = 'http://localhost:8000/';
            $username = request('name');
            $salutation = request('gender') == 'male' ? "Mr." : "Ms.";

            $message = '<table width="650" cellpadding="0" cellspacing="0" align="center" style="background-color:#ececec;padding:40px;font-family:sans-serif;overflow:scroll"><tbody><tr><td><table cellpadding="0" cellspacing="0" align="center" width="100%"><tbody><tr><td><div style="line-height:50px;text-align:center;background-color:#fff;border-radius:5px;padding:20px"><a href="' . $siteurl . '" target="_blank" ><img src="' . $siteurl . 'images/mangal_logo.jpg" style="width:100%"></a></div></td></tr><tr><td><div><img src="' . $siteurl . 'images/acknowledgement.jpg" style="height:auto;width:100%;" tabindex="0"><div dir="ltr" style="opacity: 0.01; left: 775px; top: 343px;"><div><div class="aSK J-J5-Ji aYr"></div></div></div></div></td></tr><tr><td style="background-color:#fff;padding:20px;border-radius:0px 0px 5px 5px;font-size:14px"><div style="width:100%"><h1 style="color:#007cc2;text-align:center">Thank you ' . $salutation . ' ' . $username . '</h1><p style="font-size:14px;text-align:center;color:#333;padding:10px 20px 10px 20px">Thank you for your registration in www.mangalmandap.com is Mangal Mandap is a leading Indian matrimonial matchmaking service provider. Our team is committed to provide 360 degree solutions to all prospective Indian brides and grooms for marriage.<br   /> Your otp is ' . $otp . '</p></div></td></tr></tbody></table></td></tr><tr><td style="padding:20px;font-size:12px;color:#797979;text-align:center;line-height:20px;border-radius:5px 5px 0px 0px">DISCLAIMER - The information contained in this electronic message (including any accompanying documents) is solely intended for the information of the addressee(s) not be reproduced or redistributed or passed on directly or indirectly in any form to any other person.</td></tr></tbody></table>';

            $mail->body = $message;
            if ($mail->send_mail()) {
                return redirect('/')->with('message', 'Registration has been successful1');
                //return redirect('mail')->withErrors('Email sent...');
            } else {
                return redirect('/')->with('message', 'Registration has been successful0');
                //return redirect('mail')->withInput()->withErrors('Something went wrong. Please contact admin');
            }
//            echo $message;
        }
        /***********Mail************/
    }

    public
    function login()
    {
        $mobile = request('login_mobile');
        $password = request('login_password');
        $user = DB::selectone("SELECT * FROM `profiles` WHERE is_active = '1' and email = '$mobile' and password = '$password'");
        if (isset($user)) {
            $_SESSION['user_master'] = $user;
            $_SESSION['age1'] = null;
            $_SESSION['age2'] = null;
            $_SESSION['gender'] = null;
            $_SESSION['religion'] = null;

            $_SESSION['age1'] = $user->gender == 'male' ? $user->age - 4 : $user->age;
            $_SESSION['age2'] = $user->gender == 'male' ? $user->age : $user->age + 4;
            $_SESSION['gender'] = $user->gender == 'male' ? 'female' : 'male';
            $_SESSION['religion'] = $user->religion;
            return 'Success';
        } else {
            return "Invalid";
        }
    }


    /*********************Profile update**************/
    public function profile_update()
    {
        if (isset($_SESSION['user_master'])) {
            $reg = Profiles::find($_SESSION['user_master']->id);
            $reg->email = request('email');
            $reg->contact = request('contact');
//            $reg->password = request('password');
//            $reg->gender = request('gender');
            if (request('name') != null)
                $reg->name = request('name');
            if (request('create_for') != null)
                $reg->create_for = request('create_for');
            if (request('dob') != null)
                $reg->dob = Carbon::parse(request('dob'))->format('Y-m-d');
            if (request('height') != null)
                $reg->height = request('height');
            if (request('gotra') != null)
                $reg->gotra = request('gotra') == '' ? 'Not mentioned' : request('gotra');
            if (request('father_side_gotra') != null)
                $reg->father_side_gotra = request('father_side_gotra');
            if (request('mother_side_gotra') != null)
                $reg->mother_side_gotra = request('mother_side_gotra');
            if (request('status') != null)
                $reg->status = request('status');
            if (request('living') != null)
                $reg->living = request('living');
            if (request('mob') != null)
                $reg->mob = request('mob');
            if (request('mob2') != null)
                $reg->mob2 = request('mob2');
            if (request('religion') != null)
                $reg->religion = request('religion');
            if (request('caste') != null)
                $reg->caste = request('caste');
            if (request('subcaste') != null)
                $reg->subcaste = request('subcaste');
            if (request('manglik') != null)
                $reg->manglik = request('manglik');
            if (request('language') != null)
                $reg->language = request('language');
            if (request('highest_degree') != null)
                $reg->highest_degree = request('highest_degree');
            if (request('college_name') != null)
                $reg->college_name = request('college_name');
            if (request('occupation') != null)
                $reg->occupation = request('occupation');
            if (request('occupation_detail') != null)
                $reg->occupation_detail = request('occupation_detail');
            if (request('anual_income') != null)
                $reg->anual_income = request('anual_income');
            if (request('f_values') != null)
                $reg->f_values = request('f_values');
            if (request('f_type') != null)
                $reg->f_type = request('f_type');
            if (request('f_status') != null)
                $reg->f_status = request('f_status');
            if (request('family_income') != null)
                $reg->f_income = request('family_income');
            if (request('brothers') != null)
                $reg->brothers = request('brothers');
            if (request('sisters') != null)
                $reg->sisters = request('sisters');
            if (request('bro_married') != null)
                $reg->bro_married = request('bro_married');
            if (request('sis_married') != null)
                $reg->sis_married = request('sis_married');
            if (request('father_occupation') != null)
                $reg->father_occupation = request('father_occupation');
            if (request('mother_occupation') != null)
                $reg->mother_occupation = request('mother_occupation');
            if (request('about_me') != null)
                $reg->about_me = request('about_me');
            if (request('horoscope_match') != null)
                $reg->horoscope_match = request('horoscope_match');
            if (request('bop') != null)
                $reg->bop = request('bop');
            if (request('p_agefrom') != null)
                $reg->p_agefrom = request('p_agefrom');
            if (request('p_ageto') != null)
                $reg->p_ageto = request('p_ageto');
            if (request('p_status') != null)
                $reg->p_status = request('p_status');
            if (request('p_heightfrom') != null)
                $reg->p_heightfrom = request('p_heightfrom');
            if (request('p_language') != null)
                $reg->p_language = request('p_language');
            if (request('p_city') != null)
                $reg->p_city = request('p_city');
            if (request('p_state') != null)
                $reg->p_state = request('p_state');
            if (request('p_salary') != null)
                $reg->p_salary = request('p_salary');
            if (request('p_religion') != null)
                $reg->p_religion = request('p_religion');
            if (request('dob') != null)
                $reg->age = Carbon::parse($reg->dob)->diff(Carbon::now())->format('%y');
//            $otp = rand(100000, 999999);
//            $reg->otp = $otp;
            $reg->save();

//            $activate = new ActivateProfile();
//            $activate->id = $reg->id;
//            $activate->active = 'no';
//            $activate->save();
//
//            $images = new Images();
//            $images->id = $reg->id;
//            $images->save();
//            return redirect('edit_profile')->with('message', 'Profile has been updated');
        } else {
            return redirect('/')->withErrors('Please login first');
        }

    }

    public function profile_update_admin()
    {
//        echo request('user_by_admin');
//        if (isset($_SESSION['user_master'])) {
//            $reg = Profiles::find(request('user_by_admin'));
        $reg = Profiles::find(request('user_by_admin'));
        $reg->email = request('email');
        $reg->contact = request('contact');
//            $reg->password = request('password');
//            $reg->gender = request('gender');
        if (request('name') != null)
            $reg->name = request('name');
        if (request('create_for') != null)
            $reg->create_for = request('create_for');
        if (request('dob') != null)
            $reg->dob = Carbon::parse(request('dob'))->format('Y-m-d');
        if (request('height') != null)
            $reg->height = request('height');
        if (request('gotra') != null)
            $reg->gotra = request('gotra') == '' ? 'Not mentioned' : request('gotra');
        if (request('father_side_gotra') != null)
            $reg->father_side_gotra = request('father_side_gotra');
        if (request('mother_side_gotra') != null)
            $reg->mother_side_gotra = request('mother_side_gotra');
        if (request('status') != null)
            $reg->status = request('status');
        if (request('living') != null)
            $reg->living = request('living');
        if (request('mob') != null)
            $reg->mob = request('mob');
        if (request('mob2') != null)
            $reg->mob2 = request('mob2');
        if (request('religion') != null)
            $reg->religion = request('religion');
        if (request('caste') != null)
            $reg->caste = request('caste');
        if (request('subcaste') != null)
            $reg->subcaste = request('subcaste');
        if (request('manglik') != null)
            $reg->manglik = request('manglik');
        if (request('language') != null)
            $reg->language = request('language');
        if (request('highest_degree') != null)
            $reg->highest_degree = request('highest_degree');
        if (request('college_name') != null)
            $reg->college_name = request('college_name');
        if (request('occupation') != null)
            $reg->occupation = request('occupation');
        if (request('occupation_detail') != null)
            $reg->occupation_detail = request('occupation_detail');
        if (request('anual_income') != null)
            $reg->anual_income = request('anual_income');
        if (request('f_values') != null)
            $reg->f_values = request('f_values');
        if (request('f_type') != null)
            $reg->f_type = request('f_type');
        if (request('f_status') != null)
            $reg->f_status = request('f_status');
        if (request('family_income') != null)
            $reg->f_income = request('family_income');
        if (request('brothers') != null)
            $reg->brothers = request('brothers');
        if (request('sisters') != null)
            $reg->sisters = request('sisters');
        if (request('bro_married') != null)
            $reg->bro_married = request('bro_married');
        if (request('sis_married') != null)
            $reg->sis_married = request('sis_married');
        if (request('father_occupation') != null)
            $reg->father_occupation = request('father_occupation');
        if (request('mother_occupation') != null)
            $reg->mother_occupation = request('mother_occupation');
        if (request('about_me') != null)
            $reg->about_me = request('about_me');
        if (request('horoscope_match') != null)
            $reg->horoscope_match = request('horoscope_match');
        if (request('bop') != null)
            $reg->bop = request('bop');
        if (request('p_agefrom') != null)
            $reg->p_agefrom = request('p_agefrom');
        if (request('p_ageto') != null)
            $reg->p_ageto = request('p_ageto');
        if (request('p_status') != null)
            $reg->p_status = request('p_status');
        if (request('p_heightfrom') != null)
            $reg->p_heightfrom = request('p_heightfrom');
        if (request('p_language') != null)
            $reg->p_language = request('p_language');
        if (request('p_city') != null)
            $reg->p_city = request('p_city');
        if (request('p_state') != null)
            $reg->p_state = request('p_state');
        if (request('p_salary') != null)
            $reg->p_salary = request('p_salary');
        if (request('p_religion') != null)
            $reg->p_religion = request('p_religion');
        if (request('dob') != null)
            $reg->age = Carbon::parse($reg->dob)->diff(Carbon::now())->format('%y');
//            $otp = rand(100000, 999999);
//            $reg->otp = $otp;
        $reg->save();

//            $activate = new ActivateProfile();
//            $activate->id = $reg->id;
//            $activate->active = 'no';
//            $activate->save();
//
//            $images = new Images();
//            $images->id = $reg->id;
//            $images->save();
//            return redirect('edit_profile')->with('message', 'Profile has been updated');
//        } else {
//            return redirect('/')->withErrors('Please login first');
//        }

    }


    public
    function getAadhar()
    {
        $user = Profiles::find($_SESSION['user_master']->id);
        return view('web.profile.upload_aadhar')->with(['user' => $user]);
    }

    public
    function aadhar_upload(Request $request)
    {
        if (isset($_SESSION['user_master'])) {
            $user = Profiles::find($_SESSION['user_master']->id);
            $destination_path = 'aadhar/';
            $file = $request->file('aadhar');
            if ($request->file('aadhar') != null) {
                $filename = rand(100000, 999999) . $user->id . '.jpg';
                $file->move($destination_path, $filename);
                $user->aadhar = $destination_path . $filename;
                $user->save();
            }
            $file = $request->file('aadhar_back');
            if ($request->file('aadhar_back') != null) {
                $filename = rand(100000, 999999) . $user->id . '.jpg';
                $file->move($destination_path, $filename);
                $user->aadhar_back = $destination_path . $filename;
                $user->save();
            }
            return redirect('candidate_list')->with('message', 'Aadhar has been updated');
        } else {
            return redirect('/')->withErrors('Please login first');
        }
    }

    public
    function aadharUpdate($id)
    {
        if (isset($_SESSION['user_master'])) {
            $user = Profiles::find($id);
            $user->aadhar = null;
            $user->aadhar_back = null;
            $user->save();
            return redirect('candidate_list')->with('message', 'Aadhar has been deleted');
        } else {
            return redirect('/')->withErrors('Please login first');
        }
    }


    public
    function getUpload()
    {
        return view('web.profile.upload_pic');
    }


    public
    function upload_pic(Request $request)
    {
        if (isset($_SESSION['user_master'])) {
            $user = Profiles::find($_SESSION['user_master']->id);
            $images = Images::find($user->id);
            $destination_path = 'uploads/';
            $file = $request->file('pp1');
            if ($request->file('pp1') != null) {
                $filename = rand(100000, 999999) . '_' . $user->id . '_1.jpg';
                $file->move($destination_path, $filename);
                $images->pic1 = $destination_path . $filename;
                $images->save();
            }
            $file = $request->file('pp2');
            if ($request->file('pp2') != null) {
                $filename = rand(100000, 999999) . '_' . $user->id . '_2.jpg';
                $file->move($destination_path, $filename);
                $images->pic2 = $destination_path . $filename;
                $images->save();
            }
            $file = $request->file('pp3');
            if ($request->file('pp3') != null) {
                $filename = rand(100000, 999999) . '_' . $user->id . '_3.jpg';
                $file->move($destination_path, $filename);
                $images->pic3 = $destination_path . $filename;
                $images->save();
            }
            return redirect('profile_photo')->with('message', 'Profile Pictures has been updated');
        } else {
            return redirect('/')->withErrors('Please login first');
        }
    }


    public
    function getUploadedUpdate($id)
    {
        if (isset($_SESSION['user_master'])) {
            $user = Profiles::find($_SESSION['user_master']->id);
            $images = Images::find($user->id);
            if ($id == 1)
                $images->pic1 = $user->gender == 'male' ? 'images/male.png' : 'images/female.png';
            else if ($id == 2)
                $images->pic2 = null;
            else
                $images->pic3 = null;
            $images->save();
            return redirect('profile_photo')->with('message', 'Profile Pictures has been deleted');
        } else {
            return redirect('/')->withErrors('Please login first');
        }
    }

    /*********************Profile update**************/


    public
    function userlist()
    {
        $user_data = Profiles::paginate(10);
        return view('adminview.userlist', ['user_data' => $user_data]);
    }

    public
    function deactivate_user()
    {
        $data = array(
            'is_active' => '0'
        );
        Profiles::where('id', request('IDD'))
            ->update($data);
        return 1;
    }


    public
    function activate_user()
    {
        $data = array(
            'is_active' => '1'
        );
        Profiles::where('id', request('IDD'))
            ->update($data);
        return 1;
    }

    public
    function usershow($id)
    {
        $user_data = Profiles::find($id);
        return view('adminview.show_user_full', ['user_data' => $user_data]);
    }

}
