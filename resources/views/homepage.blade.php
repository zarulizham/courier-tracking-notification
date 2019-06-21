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
<div id="services">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 col-sm-12 text-center feature-title">

                <h2 id="privacy-policy">Privacy Policy</h2>
                <p>Our commitment to protecting your personal information.</p>
            </div>
        </div>
        <div class="row row-feat">
            <div class="col-md-12">
                <h3>1. Information We Collect</h3>
                <p>We collect personal information about you to provide the services you request, to improve the user’s interaction with Courier Notify, and to communicate with you about shipping information, services, promotions and contests. We try to limit the collected information to support the intended purpose of collection.</p>

                <h4>1.1. Personal Information</h4>
                <p>We collect personal information from you in a variety of ways when you interact with Courier Notify through the Website and Mobile Application. Some examples are when you:</p>

                <ul>
                    <li>Submit notification;</li>
                    <li>Request courier tracking history;</li>
                    <li>Request customer service or contact us;</li>
                    <li>Otherwise submit personal information to Courier Notify.</li>
                </ul>

                <p>When you ask us to provide services for the benefit of a third party, you shall be legally authorized by said third party to disclose his/her personal information to Courier Notify. This authorization shall cover personal information including but not limited to the name, address, phone number, email address. You agree that you must bear all risks associated with the use of any third party’s personal information communicated by you and that under no circumstances will Courier Notify be liable in any way for any personal information or for any loss or damage of any kind incurred as a result of the use of any personal information. Courier Notify is merely acting as a passive channel for the use of the personal information and is not undertaking any obligation or liability relating to any third party’s personal information communicated by you and/or your company.</p>

                <h4>1.2. Usage Information</h4>
                <p>We receive and store certain types of information about your use of the Website or Mobile Application when you use the Website or Mobile Application. Our purpose is to allow the Website or Mobile Application to work correctly, to allow us to provide our services, to evaluate use of the Website, for marketing purposes and to personalize and enhance your interaction with Courier Notify. Some examples include:</p>
                <p>We may collect technical information such as your IP address, the address of a referring website or application, the type of web browser or mobile device you use, your operating system, your Internet Service Provider and the path you take through the Website; </p>
                <p>When you purchase services, we collect information about the transaction, such as services details and the date of the purchase/return.</p>

                <h4>Changes to this Privacy Policy</h4>
                <p>Courier Notify may change the Privacy Policy from time to time. We will inform you by posting the revised Privacy Policy on the Website. Please check our Privacy Policy periodically for changes. We will post the date the Privacy Policy was last updated at the top of the Privacy Policy. The changes will go into effect on the "Last Updated" date shown in the revised Privacy Policy. By continuing to use the Website, you consent to the revised Privacy Policy.</p>
            </div>
        </div>
    </div>
</div>
@endsection
