
@if( Auth::check() )
<!-- registered -->
<div class="header-user">
    <div class="header-user-username">
        <span class="{!! isPremium(Auth::user()) ? 'red' : 'blue' !!}-user-label">USERNAME:</span> {{ Auth::user()->username }}
    </div>
    <div class="header-user-status">

        @if(isPremium(Auth::user()))
            <span class="red-user-label">STATUS:</span> Premium till {!! Auth::user()->premium_expiration_date_and_time->format( 'H:i' ) !!} of {!! Auth::user()->premium_expiration_date_and_time->format('dS F Y' ) !!}
        @else
            <span class="blue-user-label">STATUS:</span> Registered
        @endif
    </div>
</div>
<!-- end -->

@endif

@if( Auth::guard('resellers')->check() )
<div class="header-user">
    <div class="header-user-username">
        <span class="blue-user-label">USERNAME:</span> {{ Auth::guard('resellers')->user()->username }}
    </div>
    <div class="header-user-status">
        <span class="blue-user-label">STATUS:</span> {{ strtoupper(Auth::guard('resellers')->user()->status) }}
    </div>
</div>
@endif