@extends('FrontEnd.Public.master')
@section('title','Reset')
@section('content')
@include('FrontEnd.Public.navbar')
<div class="registration-page-area bg-secondary center">
    <div class="container">
        <h2 class="sidebar-title">Reset Password</h2>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="registration-details-area inner-page-padding">
            <form id="checkout-form" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="control-label" for="email">E-Mail Address *</label>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>                                        
                            
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="pLace-order mt-30">
                            <button type="submit" class="view-all-accent-btn disabled">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
