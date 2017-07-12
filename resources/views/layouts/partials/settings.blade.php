@if( Auth::guard('resellers')->check() )
<a href="{{ route('reseller_logout') }}" class='btn btn-header btn-login'>
    Logout
</a>
@endif

@if( Auth::check() )
<a href="{{ route('profile_upgrade') }}" class='btn btn-upgrade'>
    {{ isPremium(Auth::user()) ? 'Extend' : 'Upgrade' }}
</a>
<a href="{{ route('user_logout') }}" class='btn btn-header btn-login'>
    Logout
</a>
@endif

@if( ! Auth::check() && ! Auth::guard('resellers')->check() )
<a href="{!! route('user_login') !!}" class="btn btn-header btn-login">Login</a>
<a href="{!! route('user_signup') !!}" class="btn btn-header btn-signup">Sign Up</a>
<!-- end -->
@endif