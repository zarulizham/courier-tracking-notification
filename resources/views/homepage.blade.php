@extends('master')


@section('content')
<div id="services">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 col-sm-12 text-center feature-title">

                <h2>Services</h2>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
            </div>
        </div>
        <div class="row row-feat">
            <div class="col-md-12">
                <div class="col-sm-4 feat-list">
                    <i class="pe-7s-config pe-5x pe-va wow fadeInUp"></i>
                    <div class="inner">
                        <h4>Courier Support</h4>
                        <p>Currently only Poslaju and Skynet are supported.
                        </p>
                    </div>
                </div>

                <div class="col-sm-4 feat-list">
                    <i class="pe-7s-display2 pe-5x pe-va wow fadeInUp" data-wow-delay="0.2s"></i>
                    <div class="inner">
                        <h4>Notification</h4>
                        <p>Just fill in your email in the form, we will notify right away if there is any updates on your parcel.</p>
                    </div>
                </div>

                <div class="col-sm-4 feat-list">
                    <i class="pe-7s-culture pe-5x pe-va wow fadeInUp" data-wow-delay="0.4s"></i>
                    <div class="inner">
                        <h4>Spam?</h4>
                        <p>We won't spam your inbox. We only send updates regarding your parcel, that's all.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="tracking">
    <div class="action fullscreen parallax" style="background-image:url('images/bg2.jpg');" data-img-width="2000" data-img-height="1334" data-diff="100">
        <div class="overlay downloadSection">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 col-sm-12 text-center">
                        <h2 class="wow fadeInLeft">Track your parcel, now!</h2>
                        <form method="POST" id="contact-form" class="form-horizontal" action="{{ route('tracking.submit') }}">
                            @csrf
                            <div class="form-group">
                                <select name="courier_id" id="courier_id" class="form-control wow fadeInUp">
                                    @foreach ($couriers as $courier)
                                    <option value="{{ $courier->id }}">{{ $courier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" name="code" id="code" class="form-control wow fadeInUp" placeholder="Tracking code" required />
                            </div>
                            <div class="form-group">
                                <input type="text" name="email" id="email" class="form-control wow fadeInUp" placeholder="Email Address" />
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" value="Submit" class="btn btn-success wow fadeInUp" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
