@extends('layouts.base')
@section('title', 'Credit Card Payment')
@section('content')
    <div class='content'>
        <div class='page-title'>

            <span class='succ-transaction-page-title'>
                Upgrade to Premium for {!! $data['duration'] !!} by Credit Card
            </span>

        </div>

        <div class='payment-detail-form-holder'>
            <div class='payment-detail-form'>
                <form class="form-horizontal" method="POST" id="credit_payment" action="{!! route('profile_upgrade_process') !!}" role="form">
                    {!! csrf_field() !!}
                    <input type="hidden" name="amount" value="{!! $data['amount'] !!}">
                    <div class="form-group registration-form-group">
                        <label  class="col-sm-12 control-label registration-label"></label>
                        <div class="col-sm-8 payment-detail-price" >
                            Price: USD {!! $data['amount'] !!}

                        </div>


                    </div>
                    <div id="payment-error" class="col-sm-8 alert alert-danger"></div>
                    <div id="payment-success" class="col-sm-8 alert alert-success"></div>

                    <div class="form-group registration-form-group">
                        <label  class="col-sm-12 control-label registration-label">Name on card:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="cchn" placeholder="">
                        </div>
                        <div class="col-sm-4 sign-up-success">
                            <img src="{!! url('img/icons/success.png') !!}" /> Succesfull
                        </div>
                    </div>
                    <div class="form-group registration-form-group">
                        <label  class="col-sm-12 control-label registration-label">Email:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="cchm" placeholder="">
                        </div>
                        <div class="col-sm-4 sign-up-success">
                            <img src="{!! url('img/icons/success.png') !!}" /> Succesfull
                        </div>
                    </div>
                    <div class="form-group registration-form-group">
                        <label  class="col-sm-12 control-label registration-label">Credit card number:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="ccnr" placeholder="">
                        </div>
                        <div class="col-sm-4 sign-up-success sign-up-success-payment ">
                            <img src="{!! url('img/icons/visa.png') !!}" />&nbsp;
                            <img src="{!! url('img/icons/success.png')  !!}" /> Succesfull
                        </div>
                    </div>
                    <div class="form-group registration-form-group">
                        <label  class="col-sm-12 control-label registration-label">Expiring date:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="Month" name="ccem">
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="Year" name="ccey">
                        </div>
                        <div class="col-sm-4 sign-up-success" >
                            <img src="{!! url('img/icons/success.png') !!}" /> Succesfull
                        </div>
                    </div>
                    <div class="form-group registration-form-group">
                        <label  class="col-sm-12 control-label registration-label">CCV:</label>
                        <div class="col-sm-4">
                            <input type="password" name="ccv2" class="form-control" placeholder="">
                        </div>
                        <div class="col-sm-4 col-sm-offset-4 sign-up-success" >
                            <img src="{!! url('img/icons/success.png') !!}" /> Succesfull
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9 payment-detail-btn">
                            <button type="submit" id='credit-submit' class="btn btn-default">Submit</button>
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>
    <script>
        $(document).ready(function() {
            $('input').keyup(function() {
                var value = $(this).val();
                //var parent = $(this).parent();
                if (value.length > 1 ){
                    $('.sign-up-success', $(this).parent().parent()).fadeIn(400)
                }
            });

            $('#credit_payment').submit(function(e) {
                e.preventDefault();
                $('#credit-submit').prop('disabled', true);
                $.ajax({
                    type: 'POST',
                    url: '{!! route('profile_upgrade_process') !!}',
                    data: $('#credit_payment').serialize()
                }).done(function(data) {
                    if( ! data.success ) {
                        $('#payment-error').addClass('show').text(data.message);
                        $('#payment-success').removeClass('show');
                    } else {
                        $('#payment-error').removeClass('show');
                        $('#payment-success').addClass('show').text(data.message);
                    }

                    setTimeout(function() {
                        $('#credit-submit').prop('disabled', false);
                    }, 1000);

                });
            });
        });
    </script>
@stop