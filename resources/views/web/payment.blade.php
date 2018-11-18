﻿@extends('web.web_master')

@section('title','Mangal Mandap : Payment')
@section('head')
    <style type="text/css">
        .candidate_list_box {
            margin-top: 88px;
        }

        .f-color {
            font-size: 15px;
        }

        b {
            color: #00933d;
            font-size: 15px;

        }

        .pri_title_heading {
            border-bottom: 1px solid #b9b8b8;
            display: inline-block;
            width: 100%;
            margin-bottom: 20px;
            padding-top: 77px;
            padding-bottom: 17px;
        }

        .Privacy_title {
            font-size: 25px;
            border-bottom: 2px solid #f99f5f;
            padding-bottom: 17px;
        }

        .heading_title {
            font-size: 15px;
            border-bottom: 2px solid #f99f5f;
            padding-bottom: 17px;
        }
        .black_text{
            color: #000 !important;
        }
    </style>
@stop
@section('content')
    <div class="container">
        <div class="col-sm-12">
            <div class="col-sm-12 col-md-9">
                <div class="pri_title_heading">
                    <span class="Privacy_title">Payment Option</span>
                </div>
                {{--<div class="col-sm-12">--}}
                <b class="heading_title">We offer payment options to pay us</b>
                <br/>
                <br/>
                <br/>
                <br/>
                <a target="_blank" href="https://www.payumoney.com/paybypayumoney/#/308811">
                    <img src="{{url('images/online.jpg')}}" alt="">
                </a>

                {{--</div>--}}
                <br/>
                <br/>
                <br/>
                <b class="heading_title">NOTE:</b>
                <hr/>
                <p class="f-color">
                    If you choose this payment Option and You Pay The Membership Charges with this payment Option Then
                    your
                    payment will be Debit to your Account but Your Payment Will be credit in Mangal Mandap Matrimony
                    Account
                    After Three Working days Of PayuMoney After Then Your Account will be Activate and Start Your
                    Service.</p>
                <hr/>
                {{--<b class="heading_title">Personal Cheque</b>--}}
                {{--<hr/>--}}
                {{--<p class="f-color">1)You can make payment by sending personal cheque/ demand draft in favour of Mangal--}}
                {{--Mandap services Payable at Jabalpur.</p>--}}
                {{--<p class="f-color">2)Please write the Emsil, ID & Name which you have used when registering your profile--}}
                {{--in--}}
                {{--our website behind the Cheque / Demand Draft..</p>--}}
                {{--<p class="f-color">3) Please mail/courier your draft or cheque to <b>Mangal Mandap Services</b>.</p>--}}
                <p class="f-color"><strong>Phone: +91 7354933132</strong>.</p>
                <p class="f-color"><strong>Email: mangalmandap@gmail.com</strong>.</p>
                <hr/>
                <p class="f-color">
                    You can direct deposit the cheque, cash or transfer payment online at any branch of State Bank of
                    India.
                    Please send / inform about your payment (User Id, Cheque No. or online reference no.) by an email /
                    SMS
                    or via Phone. Or you can mail at MangalMandap@gmail.com.</p>
                <hr/>


                <b class="heading_title">Account Details</b>
                <hr/>
                <div class="col-sm-12">
                    <div class="col-sm-6">
                        <img src="{{url('images/SBI-Logo.png')}}" style="width: 100%; height: 50%" alt="">
                    </div>
                    <div class="col-sm-6">
                        <p class="f-color"><strong>Account Number :- 36751854429</strong></p>
                        <p class="f-color"><strong>Account Name :- Mangal Mandap Matrimony</strong></p>
                        <p class="f-color"><strong>IFSC Code :- SBIN0001398</strong></p>
                        <p class="f-color"><strong>Branch Name :- TULARAM CHOWK, STATE BANK OF INDIA, JABALPUR</strong></p>
                    </div>
                </div>
                <hr/>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="candidate_list_box cl_list_box">
                    <div class="cand_search_filterbox">
                        <div class="search_filter_head">Benifits Of Paid Membership</div>
                        <ul class="style-scroll promise_member">
                            <li>
                                <i class="promise_icon mdi mdi-account-card-details"></i>
                                <h4 class="promise_caption">Best Matches</h4>
                            </li>
                            <li>
                                <i class="promise_icon mdi mdi-account-star"></i>
                                <h4 class="promise_caption">Verified Profile</h4>
                            </li>
                            <li>
                                <i class="promise_icon mdi mdi-security-network"></i>
                                <h4 class="promise_caption">Privacy Control</h4>
                            </li>
                            <li>
                                <i class="promise_icon mdi mdi-server-security"></i>
                                <h4 class="promise_caption">Fully Secure</h4>
                            </li>
                        </ul>
                    </div>


                </div>
                <a class="btn-pay" target="_blank" href="https://www.payumoney.com/paybypayumoney/#/308811">
                    <img src="{{url('images/PayOnlineButton.png')}}"
                         style="width: 100%; height: 100%; margin-top: 169%;" alt="">
                </a>
            </div>
        </div>
    </div>
@stop
