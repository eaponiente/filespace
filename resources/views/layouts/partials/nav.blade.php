@if( Auth::check() )
    @if( Auth::user()->is_affiliate == 'NO')
    <!-- registered -->
    <div class="menu">
    <ul>
        <li class="{!! Request::segment(1) == 'profile' ? 'active' : '' !!}"  >
        	<a href="{{ route('user_profile') }}">Profile</a>
        </li>

        <li class="{{ Request::segment(1) == '' ? 'active' : '' }}" >
        <a href="{{ url('/') }}">Upload</a>
        </li>

        <li class="{!! Request::segment(1) == 'files' ? 'active' : '' !!}"" >
        	<a href="{{ url('files') }}">Files ( {!! Auth::user()->fileuploads()->count() !!} )</a>
        </li>

        <li class="{{ Request::segment(1) == 'folders' ? 'active' : '' }}" >
        	<a href="{{ route('folders.index') }}">Folders ( {!! Auth::user()->filefolders()->count() !!} )</a>
        </li>
    </ul>
    <div class="clearfix"></div>
    </div>
    <!-- end -->
    @else
    <!-- affiliate -->

    <div class="menu-affiliate">
        <ul>
            <li class="{!! Request::segment(1) == 'profile' ? 'active' : '' !!}" ><a href="{{ url('profile') }}">Profile</a></li>
            <li class="{{ Request::segment(1) == '' ? 'active' : '' }}"  ><a href="{{ url('/') }}">Upload</a></li>
            
            <li class="{{ Request::segment(1) == 'files' ? 'active' : '' }}">
            	<a href="{{ url('files') }}">Files <span>( {!! Auth::user()->fileuploads()->count() !!} )</span></a>
            </li>
            
            <li class="{{ Request::segment(1) == 'folders' ? 'active' : '' }}">
            	<a href="{{ route('folders.index') }}">Folders <span>( {!! Auth::user()->filefolders()->count() !!} )</span></a>
            </li>
            <li class="{{ Request::segment(1) == 'referrals' ? 'active' : '' }}">
            	<a href="{!! url('referrals') !!}" class="orange">Referrals</a>
            </li>
            <li class="{{ Request::segment(1) == 'site-codes' ? 'active' : '' }}" >
            	<a href="{!! url('site-codes') !!}" class="orange">Site Codes</a>
            </li>
            
            <li class="{{ Request::segment(1) == 'stats' ? 'active' : '' }}" >
            	<a href="{!! url('stats') !!}" class="orange">Stats</a>
            </li>
            
            <li class="{{ Request::segment(1) == 'payments' ? 'active' : '' }}" >
            	<a href="{!! url('payments') !!}" class="orange">Payments</a>
            </li> 

        </ul> 
        <div class="clearfix"></div>
    </div>
    <!-- end -->
    @endif
@endif

@if( Auth::guard('resellers')->check() )
    <div class="menu">
        <ul>
            <li {{ Request::segment(2) == 'profile' ? 'class="active"' : '' }} ><a href="{{ URL::to('resellers/profile') }}">Profile</a></li>
            <li class="{{ Request::segment(1) == 'resellers' ? 'active' : '' }}"><a href="{{ route('reseller_login') }}">Vouchers</a></li>
            <li {{ Request::segment(2) == 'transactions' ? 'class="active"' : '' }} ><a href="{{ url('resellers/transactions') }}">Transactions</a></li>
        </ul>
        <div class="clearfix"></div>
    </div>
@endif