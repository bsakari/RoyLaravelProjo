<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AdminusersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $User = $request->all();
        $PhoneNumber= $User["phone_number"];
        $UserExists = User::wherePhoneNumber($PhoneNumber)->first();
        if (isset($UserExists->id)){
            return  json_encode(["value"=>"0","message"=>"Thank you. You already have an account","phone"=>$PhoneNumber]);
        }
        User::create($User);
        return  json_encode(["value"=>"0","message"=>"Thank you. Account created successfully","phone"=>$PhoneNumber]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function set_service_pin(Request $request)
    {
        $User = $request->all();
        $PhoneNumber = $User["phoneNumber"];
        $Privilege = $User["Privilege"];
        $ThisUser = User::wherePhoneNumber($PhoneNumber)->first();
        if (isset($ThisUser->id)){
            if ($ThisUser->pin_number==null){
                $ThisUser->update(["name"=>$User["FullName"],"email"=>$User["RecoveryEmail"],"pin_number"=>$User["PinNumber"],"privilege"=>$Privilege]);
                return json_encode(["value"=>0,"message"=>"Success. Pin number set successfully"]);
            }else{
                return json_encode(["value"=>0,"message"=>"Sorry. Please reset pin instead"]);
            }
        }else{
            return json_encode(["value"=>1,"message"=>"No such user. Please register first"]);
        }
    }
    public function login_user(Request $request)
    {
        $User = $request->all();
        $PhoneNumber = $User["PhoneNumber"];
        $PinNumber = $User["PinNumber"];
        $ThisUser = User::wherePhoneNumber($PhoneNumber)->wherePinNumber($PinNumber)->first();
        if (isset($ThisUser->id)){
            if ($ThisUser->privilege == 1){
                return json_encode(["value"=>0,"message"=>"Success. Logged in successfully","privilege"=>1]);
            }else{
                return json_encode(["value"=>0,"message"=>"Success. Logged in successfully","privilege"=>2]);
            }
        }else{
            return json_encode(["value"=>1,"message"=>"No such user. Please register first","privilege"=>3]);
        }
    }
}
