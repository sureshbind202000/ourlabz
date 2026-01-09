@extends('frontend.includes.dashboard_layout')
@section('css')

@endsection
@section('dash_content')

<div class="user-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="user-card">
                <div class="user-card-header">
                    <h4 class="user-card-title">Add New Payment</h4>
                    <div class="user-card-header-right">
                        <a href="{{route('payment_method')}}" class="theme-btn"><span class="fas fa-arrow-left"></span>Payment Method</a>
                    </div>
                </div>
                <div class="user-form">
                    <form action="#">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name On Card</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Card Number</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Expire Date</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CVC</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="theme-btn"><span class="far fa-save"></span> Save Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')

@endsection