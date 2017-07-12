@extends('layouts.base')
@section('title', 'Vouchers')
@section('metadata')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">


@stop
@section('content')
<style>
.dataTable thead th{
    background: none repeat scroll 0% 0% #EFF1F8 !important;
    border: 1px solid #CACEDD !important;
    font-size: 13px !important;
    padding: 9px !important;
}
.jkl
{
    *cursor: hand;
    cursor: pointer;
}
td:first-child + td {
 word-break: break-all; !important;
}
td:last-child a{
    margin: 12px 7px 0 !important;
}
</style>
<div class="content-registered">
    <div class="page-title">
        <span class="voucher-page-title">
            Voucher Generator
        </span>
    </div>
    <div class="folders-body">
        
        <div class="row folders-nav voucher-head">
            <div class="col-sm-6 voucher-head-col">
                <span class="voucher-balance-label">Balance:</span>
                <span class="voucher-balance-text">USD {{ Auth::guard('resellers')->user()->balance }}</span>
                @if( session('error') )
                <span class="not-enugh-founds">
                    {!! session('error') !!}
                </span>
                @endif
            </div>
            
            <div class="col-sm-6 voucher-head-col-select">
                <div class="pull-right">
                    <div class="pull-left folders-nav-search-label">Select package</div>
                    <div class="pull-left folders-nav-input-holder">
                        <form method="POST" action="{!! route('resellers_generate_voucher') !!}" id="package">
                        {!! csrf_field() !!} 
                        <select class="form-control" name="data[package]">
                            <option value="0">Select Package</option>
                            @foreach( $packages as $package )
                                <option value="{{ $package->id }}">{{ $package->premium_days . ' days $' . $package->price }}</option>
                            @endforeach
                        </select>
                        </form>
                    </div>
                    <div class="pull-left folders-nav-btn-holder">
                        <button class="btn btn-default btn-sm" onclick="$('#package').submit()">Generate</button>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="folder-table-holder">
            <table class="table-folders" id="sample_1" data-source="{{ route('resellers_vouchers_listing' ) }}">
                <thead>
                    <tr>
                        <th width="20%">Voucher</th>
                        <th width="20%">Pin</th>
                        <th width="20%">Generation Date and Time</th>
                        <th width="20%">Used By</th>
                        <th width="20%">Used Date and Time</th>
                    </tr>
                </thead>
                <tbody>
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
 FilesManagerTable.init();
});
</script>
@stop