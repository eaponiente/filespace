@extends('layouts.base')
@section('title', 'Referrals')
@section('metadata')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<script type="text/javascript" src="{{ url('js/ZeroClipboard.min.js') }}"></script>


@stop
@section('content')
<style type="text/css">
.dataTable thead th{
    background: none repeat scroll 0% 0% #EFF1F8 !important;
    border: 1px solid #CACEDD !important;
    font-size: 13px !important;
    padding: 9px !important;
}
tbody td a {
    margin: 0 5px
}
table.dataTable {
    border-collapse: collapse;
    border-spacing: 0px;
}
#copy-link{
    background: none;
    border: 0;
    color: #428bca;
}
</style>
<div class='content-registered'>
    <div class='page-title'>
        <span class='refferals-page-title'>
            Refferals
        </span>
    </div>
    <div class="folders-body">
        
        <div class="folder-table-holder">
            <table class="table-folders" id="sample_1" data-source="{{ route('referrals_listings') }}">
                <thead>
                    <tr>
                        <th width="80" class="text-center">Username</th>
                        <th width="25%" class="text-center">Country</th>
                        <th width="80" class="text-center">Reg.Date</th>
                        <th width="25%" class="text-center" >Status</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ url('js/plugins/data-tables/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/data-tables/DT_bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/data-tables/table-ajax.js') }}"></script>

<script type="text/javascript">
jQuery(document).ready(function() {       
   RefferalsTable.init();
});
</script>
<script type="text/javascript">
$(function(){
    $('body').find('#test').html("<label class='form-control' style='box-shadow:none;border:0;border-radius:0'>Direct ref. link: { <a href='{{ url('/signup/' . Auth::user()->affiliate_ash) }}' onclick='return false'>LINK HERE</a> } <button id='copy-link' data-clipboard-text='{{ url('/signup/' . Auth::user()->affiliate_ash) }}'>Copy Now</button> </label>");

    ZeroClipboard.config( {
        debug: true
    } );

    var client = new ZeroClipboard( $( '#copy-link' ), {
        moviePath: '{{ url('js/plugins/swf/ZeroClipboard.swf') }}'
    } );

    
    client.on( "load", function(client) {
      // alert( "movie is loaded" );

      client.on( "complete", function(client, args) {
        // `this` is the element that was clicked
        //this.style.display = "none";
        alert("Copied referral link to clipboard" );
      } );
    } );


});
</script>


@stop