@extends('layouts.base')
@section('title', 'Payments')
@section('content')
<div class='content-registered'>
    <div class='page-title'>
        <span class='payments-page-title'>
            Payments (Total: USD 3214.21)
        </span>
    </div>
    
    <div class="payments-table-holder">
        <table class="payments-table">
            <thead>
                <tr>
                    <th>Requested on</th>
                    <th>Paid on</th>
                    <th>Method</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2014-03-15 11:31:25</td>
                    <td>Under Processing</td>
                    <td>Webmoney (Z7232323432)</td>
                    <td>USD 21.44</td>
                </tr>
                <tr>
                    <td>2014-03-15 11:31:25</td>
                    <td>Under Processing</td>
                    <td>Webmoney (Z7232323432)</td>
                    <td>USD 21.44</td>
                </tr>
                <tr>
                    <td>2014-03-15 11:31:25</td>
                    <td>2014-03-15 11:31:25</td>
                    <td>Webmoney (Z7232323432)</td>
                    <td>USD 21.44</td>
                </tr>
                <tr>
                    <td>2014-03-15 11:31:25</td>
                    <td>2014-03-15 11:31:25</td>
                    <td>Webmoney (Z7232323432)</td>
                    <td>USD 21.44</td>
                </tr>
                <tr>
                    <td>2014-03-15 11:31:25</td>
                    <td>2014-03-15 11:31:25</td>
                    <td>Webmoney (Z7232323432)</td>
                    <td>USD 21.44</td>
                </tr>
            </tbody>
        </table>
        <div class="table-pagination">
                <div class="pull-left folder-entrys">
                    Showing 10 of 2432 entries
                </div>
                <div class="pull-right">
                    <div class="pull-left folder-showing-results">1-10 of 2432</div>
                    <div class="pull-left">
                        <ul class="pagination">
                            <li><a href="#"><</a></li>
                            <li><a href="#">></a></li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        
    </div>
</div>
@stop