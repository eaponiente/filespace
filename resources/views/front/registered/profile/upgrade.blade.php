@extends('layouts.base')
@section('title', 'Upgrade to Premium')
@section('content')
<div class='content'>
    <div class='page-title'>
        <span class='upgrade-page-title'>
            Upgrade To Premium
        </span>
    </div>


    <div class="upgrade-modern-holder">
        <div class="upgrade-modern-title">
            Chose Your Plan
        </div>
        <div class="upgrade-modern-body">
            <!-- UPGRADE BOX -->
            <div class="upgrade-modern-box upgrade-modern-1">
                
                    <div class="upgrade-modern-icon">

                        <img src="{!! url('img/icons/upgrade-icon-1.png') !!}">
                    </div>
                    <div class="upgrade-modern-blue-title">
                        5000 GB AVAILABLE
                        STORAGE SPACE
                    </div>
                    <div class="upgrade-modern-sticker">
                        <div class="upgrade-modern-sticker-inner">
                            30 DAYS<br />upg
                            <span>USD 9.99</span>
                        </div>
                    </div>
                    <div class="upgrade-modern-cards">
                        <div class="upgrade-modern-card-block">
                            <div class="upgrade-modern-cc">
                                <a href="{{ URL::to( 'upgrade/payment' ) }}"><img src="{!! url('img/icons/blue-visa.png') !!}"></a>
                            </div>
                            <div class="upgrade-modern-cc-button">
                                <form method="POST" action="{!! route('credit_card_payment') !!}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="amount" value="9.99">
                                    <input type="hidden" name="duration" value="30 Days">
                                    {{--<input type="hidden" name="data[price]" value="9.99">
                                    <input type="hidden" name="data[duration]" value="30 days">--}}
                                    <button class="upgrade-modern-btn">Credit Card</button>
                                </form>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="upgrade-modern-card-block">
                            <div class="upgrade-modern-cc">
                                <img src="{!! url('img/icons/blue-webmoney.png') !!}">
                            </div>
                            <div class="upgrade-modern-cc-button">
                                <form method="POST" action="https://merchant.wmtransfer.com/lmi/payment.asp" accept-charset="windows-1251">
                                    <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="9.99">
                                    <input type="hidden" name="LMI_PAYMENT_DESC" value="30 Days 5000 GB AVAILABLE STORAGE SPACE">
                                    <input type="hidden" name="LMI_PAYMENT_DESC_BASE64" value="SnVub2Nsb3VkIFJlbW90ZSBTdG9yYWdlIFNlcnZpY2U=">
                                    <input type="hidden" name="LMI_PAYEE_PURSE" value="E344737701921">
                                    <input type="hidden" name="LMI_SUCCESS_URL" value="{{ route('payment_successful') }}">
                                    <input type="hidden" name="LMI_SUCCESS_METHOD" value="1">
                                    <input type="hidden" name="LMI_SIM_MODE" value="0">
                                    <input type="hidden" name="LMI_MODE" value="1">
                                    <input type="hidden" name="duration" value="30">
                                    <button class="upgrade-modern-btn">WMZ Voucher</button>
                                </form>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="upgrade-modern-card-block">
                            <div class="upgrade-modern-cc">
                                <img src="{!! url('img/icons/blue-voucher.png') !!}">
                            </div>
                            <div class="upgrade-modern-cc-button upgrade-modern-cc-button-voucher">
                                <form method="POST" action="{{ url('vouchers/validate') }}">
                                {!! csrf_field() !!}
                                <button type="submit" class="upgrade-modern-btn">Voucher</button>
                                </form>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        
                    </div>
                
            </div>
            <!-- UPGRADE BOX END -->
            <!-- UPGRADE BOX -->
            <div class="upgrade-modern-box upgrade-modern-2">
                <div class="upgrade-modern-icon">
                    <img src="{!! url('img/icons/upgrade-icon-2.png') !!}">
                </div>
                <div class="upgrade-modern-blue-title">
                    UNLIMITED<br />
                    DATA TRANSFER
                </div>
                <div class="upgrade-modern-sticker">
                    <div class="upgrade-modern-sticker-inner-dicsount">
                        30 DAYS<br />
                        <span class="upgrade-modern-price">USD 25.99</span><br />
                        <span class="upgrade-modern-discount">(15% Discount)</span>
                    </div>
                </div>
                <div class="upgrade-modern-cards">
                    <div class="upgrade-modern-card-block">
                        <div class="upgrade-modern-cc">
                            <a href="{{ URL::to( 'upgrade/payment' ) }}"><img src="{!! url('img/icons/blue-visa.png') !!}"></a>
                        </div>
                        <div class="upgrade-modern-cc-button">
                            <form method="POST" action="{!! route('credit_card_payment') !!}">
                                {!! csrf_field() !!}
                                <input type="hidden" name="amount" value="25.99">
                                <input type="hidden" name="duration" value="30 days">
                                {{--<input type="hidden" name="data[price]" value="9.99">
                                <input type="hidden" name="data[duration]" value="30 days">--}}
                                <button class="upgrade-modern-btn">Credit Card</button>
                            </form>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="upgrade-modern-card-block">
                        <div class="upgrade-modern-cc">
                            
                            <img src="{{ url('img/icons/blue-webmoney.png') }}">
                        </div>
                        <div class="upgrade-modern-cc-button">
                            <form action="https://merchant.wmtransfer.com/lmi/payment.asp" method="POST" accept-charset="windows-1251">
                                <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="25.99">
                                <input type="hidden" name="LMI_PAYMENT_DESC" value="30 Days UNLIMITED DATA TRANSFER">
                                <input type="hidden" name="LMI_PAYMENT_DESC_BASE64" value="SnVub2Nsb3VkIFJlbW90ZSBTdG9yYWdlIFNlcnZpY2U=">
                                <input type="hidden" name="LMI_SUCCESS_URL" value="{{ route('payment_successful') }}">
                                <input type="hidden" name="LMI_SUCCESS_METHOD" value="1">
                                <input type="hidden" name="LMI_PAYMENT_NO" value="1234">
                                <input type="hidden" name="LMI_PAYEE_PURSE" value="E344737701921">
                                <input type="hidden" name="LMI_SIM_MODE" value="0">
                                <input type="hidden" name="LMI_MODE" value="1">
                                <input type="hidden" name="duration" value="30">
                                <button class="upgrade-modern-btn">WMZ Voucher</button>
                            </form>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="upgrade-modern-card-block">
                        <div class="upgrade-modern-cc">
                            
                            <img src="{{ url('img/icons/blue-voucher.png') }}">
                        </div>
                        <div class="upgrade-modern-cc-button upgrade-modern-cc-button-voucher">
                            <form action="{{ url('vouchers/validate') }}">
                                <button type="submit" class="upgrade-modern-btn">Voucher</button>
                            </form>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- UPGRADE BOX END -->

            <!-- UPGRADE BOX -->
            <div class="upgrade-modern-box upgrade-modern-3">
                <div class="upgrade-modern-icon">
                    
                    <img src="{{ url('img/icons/upgrade-icon-3.png') }}">
                </div>
                <div class="upgrade-modern-blue-title">
                    UP TO 1 Gbps<br />
                    PARALLEL DOWLOADS
                </div>
                <div class="upgrade-modern-sticker">
                   <div class="upgrade-modern-sticker-inner-dicsount">
                    180 DAYS<br />
                    <span class="upgrade-modern-price">USD 55.99</span><br />
                    <span class="upgrade-modern-discount">(15% Discount)</span>
                </div>
            </div>
            <div class="upgrade-modern-cards">
                <div class="upgrade-modern-card-block">
                    <div class="upgrade-modern-cc">
                        <a href="{{ URL::to( 'upgrade/payment' ) }}"><img src="{{ url('img/icons/blue-visa.png') }}"></a>
                    </div>
                    <div class="upgrade-modern-cc-button">
                        <form method="POST" action="{!! route('credit_card_payment') !!}">
                            {!! csrf_field() !!}
                            <input type="hidden" name="amount" value="55.99">
                            <input type="hidden" name="duration" value="180 days">
                            {{--<input type="hidden" name="data[price]" value="9.99">
                            <input type="hidden" name="data[duration]" value="30 days">--}}
                            <button class="upgrade-modern-btn">Credit Card</button>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="upgrade-modern-card-block">
                    <div class="upgrade-modern-cc">
                        
                        <img src="{{ url('img/icons/blue-webmoney.png') }}">
                    </div>
                    <div class="upgrade-modern-cc-button">
                        <form method="POST" accept-charset="windows-1251" action="https://merchant.wmtransfer.com/lmi/payment.asp">
                            <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="55.99">
                            <input type="hidden" name="LMI_PAYMENT_DESC" value="180 Days UP TO 1 Gbps PARALLEL DOWLOADS">
                            <input type="hidden" name="LMI_PAYMENT_DESC_BASE64" value="SnVub2Nsb3VkIFJlbW90ZSBTdG9yYWdlIFNlcnZpY2U=">
                            <input type="hidden" name="LMI_SUCCESS_URL" value="{{ route('payment_successful') }}">
                            <input type="hidden" name="LMI_SUCCESS_METHOD" value="1">
                            <input type="hidden" name="LMI_PAYMENT_NO" value="1234">
                            <input type="hidden" name="LMI_PAYEE_PURSE" value="E344737701921">
                            <input type="hidden" name="LMI_SIM_MODE" value="0">
                            <input type="hidden" name="LMI_MODE" value="1">
                            <input type="hidden" name="duration" value="180">
                            <button class="upgrade-modern-btn">WMZ Voucher</button>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="upgrade-modern-card-block">
                    <div class="upgrade-modern-cc">
                        
                        <img src="{{ url('img/icons/blue-voucher.png') }}">
                    </div>
                    <div class="upgrade-modern-cc-button upgrade-modern-cc-button-voucher">
                        <form action="{{ url('vouchers/validate') }}">
                        <button type="submit" class="upgrade-modern-btn">Voucher</button>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- UPGRADE BOX END -->
        <!-- UPGRADE BOX -->
        <div class="upgrade-modern-box upgrade-modern-4">
            <div class="upgrade-modern-icon">
                
                <img src="{{ url('img/icons/upgrade-icon-4.png') }}">
            </div>
            <div class="upgrade-modern-blue-title">
                NO ADS<br />
                AND NO WAITING TIME
            </div>
            <div class="upgrade-modern-sticker">
             <div class="upgrade-modern-sticker-inner-dicsount">
                365 DAYS<br />
                <span class="upgrade-modern-price">USD 55.99</span><br />
                <span class="upgrade-modern-discount">(15% Discount)</span>
            </div>
        </div>
        <div class="upgrade-modern-cards">
            <div class="upgrade-modern-card-block">
                <div class="upgrade-modern-cc">
                   <a href="{{ URL::to( 'upgrade/payment' ) }}"><img src="{{ url('img/icons/blue-visa.png') }}"></a>
                </div>
                <div class="upgrade-modern-cc-button">
                    <form method="POST" action="{!! route('credit_card_payment') !!}">
                        {!! csrf_field() !!}
                        <input type="hidden" name="amount" value="55.99">
                        <input type="hidden" name="duration" value="365 days">
                        {{--<input type="hidden" name="data[price]" value="9.99">
                        <input type="hidden" name="data[duration]" value="30 days">--}}
                        <button class="upgrade-modern-btn">Credit Card</button>
                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="upgrade-modern-card-block">
                <div class="upgrade-modern-cc">
                    
                    <img src="{{ url('img/icons/blue-webmoney.png') }}">
                </div>
                <div class="upgrade-modern-cc-button">
                    <form action="https://merchant.wmtransfer.com/lmi/payment.asp" method="POST" accept-charset="windows-1251">
                        <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="55.99">
                        <input type="hidden" name="LMI_PAYMENT_DESC" value="365 Days NO ADS AND NO WAITING TIME ">
                        <input type="hidden" name="LMI_PAYMENT_DESC_BASE64" value="SnVub2Nsb3VkIFJlbW90ZSBTdG9yYWdlIFNlcnZpY2U=">
                        <input type="hidden" name="LMI_SUCCESS_URL" value="{{ route('payment_successful') }}">
                        <input type="hidden" name="LMI_SUCCESS_METHOD" value="1">
                        <input type="hidden" name="LMI_PAYMENT_NO" value="1234">
                        <input type="hidden" name="LMI_PAYEE_PURSE" value="E344737701921">
                        <input type="hidden" name="LMI_SIM_MODE" value="0">
                        <input type="hidden" name="LMI_MODE" value="1">
                        <input type="hidden" name="duration" value="365">
                        <button class="upgrade-modern-btn">WMZ Voucher</button>
                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="upgrade-modern-card-block">
                <div class="upgrade-modern-cc">
                    
                    <img src="{{ url('img/icons/blue-voucher.png') }}">
                </div>
                <div class="upgrade-modern-cc-button upgrade-modern-cc-button-voucher">
                    <form action="{{ url('vouchers/validate') }}">
                    {!! csrf_field() !!}
                        <button type="submit" class="upgrade-modern-btn">Voucher</button>
                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- UPGRADE BOX END -->
    <div class="clearfix"></div>
</div>
</div>
</div>
@stop