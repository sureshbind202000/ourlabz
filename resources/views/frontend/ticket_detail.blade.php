@extends('frontend.includes.dashboard_layout')
@section('css')

@endsection
@section('dash_content')

<div class="user-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="user-card user-ticket-detail">
                <div class="user-card-header">
                    <h4 class="user-card-title">Ticket Details (#28VR5K59)</h4>
                    <div class="user-card-header-right">
                        <a href="{{route('support_ticket')}}" class="theme-btn"><span class="fas fa-arrow-left"></span>Support Ticket</a>
                    </div>
                </div>
                <div class="ticket-detail-content">
                    <div class="ticket-chat-item">
                        <div class="ticket-img">
                            <img src="assets/img/account/01.jpg" alt="">
                        </div>
                        <div class="ticket-info">
                            <h5>Antoni Jonson</h5>
                            <span>10:20 PM | August 12, 2024</span>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
                        </div>
                    </div>
                    <div class="ticket-chat-item ms-lg-5">
                        <div class="ticket-img">
                            <img src="assets/img/account/02.jpg" alt="">
                        </div>
                        <div class="ticket-info">
                            <h5>Nikol Habitex</h5>
                            <span>10:20 PM | August 12, 2024</span>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
                        </div>
                    </div>
                    <div class="ticket-chat-item">
                        <div class="ticket-img">
                            <img src="assets/img/account/01.jpg" alt="">
                        </div>
                        <div class="ticket-info">
                            <h5>Antoni Jonson</h5>
                            <span>10:20 PM | August 12, 2024</span>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
                        </div>
                    </div>
                </div>
                <div class="ticket-chat-box">
                    <div class="ticket-chat-form user-form">
                        <form action="#">
                            <div class="form-group">
                                <textarea class="form-control" cols="30" rows="6" placeholder="Type Your Message"></textarea>
                            </div>
                            <button type="submit" class="theme-btn"><span class="far fa-paper-plane"></span> Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')

@endsection