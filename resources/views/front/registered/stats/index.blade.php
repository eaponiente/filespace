@extends('layouts.base')
@section('title', 'Stats')
@section('content')
<div class='content-registered'>
    <div class='page-title'>
        <span class='sales-page-title'>
            Stats

        </span>
    </div>

    <div class="stats-top-holder">
        <div class="stats-links">
            <a href="#">Today</a>
            <a href="#">Yesterday</a>
            <a href="#">This Week</a>
            <a href="#">Last Week</a>
            <a href="#">This Month</a>
            <a href="#">Last Month</a>
        </div>
        <div class="stats-search">
            <div class="pull-left stats-search-date">
                From: 
                <select>
                    <option>2014-11-28</option>
                </select>
                To:
                <select>
                    <option>2014-11-28</option>
                </select>
                <a href="#">Submit</a>
            </div>
            <div class="pull-right approved-holder">
                <div>
                    <span class="total-approved">Payable Revenue: </span>
                    <span class="total-approved-amount">USD 223.12</span>
                </div>
                <div class="payout-buttons">
                    <a href="#">Request Payout</a>
                    <a href="#">Previous Payouts</a>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="stats-row row">
        <div class="col-sm-6">
            <!--
            Downloads stats:
            <div class="stats-table-holder">
                <table class="stats-table stats-table-two-colums">
                    <thead>
                        <tr>
                            <th>Downloads</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>78.238</td>
                            <td>USD 22.22</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            -->
            Sales stats:
            <div class="stats-table-holder">
                <table class="stats-table stats-table-two-colums">
                    <thead>
                        <tr>
                            <th>Approved Initial Sales</th>
                            <th>Pending Initial Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>354 (USD 235.34)</td>
                            <td>2 (USD 11.32)</td>
                        </tr>
                    </tbody>
                </table>
                <table class="stats-table stats-table-two-colums stats-table-no-top-border">
                    <thead>
                        <tr>
                            <th>Approved Rebills</th>
                            <th>Pending Rebills</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>354 (USD 235.34)</td>
                            <td>354 (USD 235.34)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="stats-table-button">
                <a href="#">
                    Show Details
                </a>
            </div>
        </div>
        <div class="col-sm-6">
            Site sales stats:
            <div class="stats-table-holder">
                <table class="stats-table stats-table-tree-colums">
                    <thead>
                        <tr>
                            <th>Site Code</th>
                            <th>Approved Sales</th>
                            <th>Approved Rebills</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>hayqfv2</td>
                            <td>354 (USD 235.34)</td>
                            <td>354 (USD 235.34)</td>
                        </tr>
                        <tr>
                            <td>hayqfv2</td>
                            <td>354 (USD 235.34)</td>
                            <td>354 (USD 235.34)</td>
                        </tr>
                        <tr>
                            <td>hayqfv2</td>
                            <td>354 (USD 235.34)</td>
                            <td>354 (USD 235.34)</td>
                        </tr>
                        <tr>
                            <td>hayqfv2</td>
                            <td>354 (USD 235.34)</td>
                            <td>354 (USD 235.34)</td>
                        </tr>
                        <tr>
                            <td>hayqfv2</td>
                            <td>354 (USD 235.34)</td>
                            <td>354 (USD 235.34)</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total:</td>
                            <td>55354 (USD 55235.34)</td>
                            <td>55354 (USD 55235.34)</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="stats-table-button">
                <a href="#">
                    Show Details
                </a>
            </div>
        </div>
    </div>
</div>

@stop