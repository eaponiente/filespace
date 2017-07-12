@extends('layouts.base')
@section('title', 'Profile')
@section('content')
<div class='content-registered'>
    <div class='page-title'>
        <span class='profile-page-title'>
           Profile: john_doe
        </span>
    </div>

    <div class="profile-body">
        <table class="profile-body-table">
            <tr>
                <td class="profile-label">Email</td>
                <td>
                    <div class="pull-left">
                        <span class="profile-info">test@email.com</span>
                    </div>
                    <div class="pull-right">
                        <a href="{{ URL::to('profile/change-email') }}" class="profile-edit-link">Change Email</a>
                        <a href="{{ URL::to('profile/change-password') }}" class="profile-edit-link">Change Password</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="profile-label">Status</td>
                <td><span class="profile-info">
                    Active
                </span></td>
            </tr>
            <tr>
                <td class="profile-label">Discount Rate</td>
                <td><span class="profile-info">
                    $15.00
                </span></td>
            </tr>
            <tr>
                <td class="profile-label">Balance</td>
                <td><span class="profile-info">
                    $0.99
                </span></td>
            </tr>
        </table>
    </div>

</div>

@stop