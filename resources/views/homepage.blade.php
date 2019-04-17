@extends('master')


@section('content')
<div id="services">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 col-sm-12 text-center feature-title">

                <h2>Our Services</h2>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
            </div>
        </div>
        <div class="row row-feat">

            <div class="col-md-12">

                <div class="col-sm-4 feat-list">
                    <i class="pe-7s-config pe-5x pe-va wow fadeInUp"></i>
                    <div class="inner">
                        <h4>Fully Customizable</h4>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature.
                        </p>
                    </div>
                </div>

                <div class="col-sm-4 feat-list">
                    <i class="pe-7s-display2 pe-5x pe-va wow fadeInUp" data-wow-delay="0.2s"></i>
                    <div class="inner">
                        <h4>Responsive Design</h4>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature.</p>
                    </div>
                </div>

                <div class="col-sm-4 feat-list">
                    <i class="pe-7s-culture pe-5x pe-va wow fadeInUp" data-wow-delay="0.4s"></i>
                    <div class="inner">
                        <h4>Amazing Design</h4>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature.</p>
                    </div>
                </div>



            </div>
        </div>
        <div class="row row-feat">

            <div class="col-md-12">

                <div class="col-sm-4 feat-list">
                    <i class="pe-7s-cloud-upload pe-5x pe-va wow fadeInUp"></i>
                    <div class="inner">
                        <h4>Upload Manager</h4>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature.
                        </p>
                    </div>
                </div>

                <div class="col-sm-4 feat-list">
                    <i class="pe-7s-mail-open-file pe-5x pe-va wow fadeInUp" data-wow-delay="0.2s"></i>
                    <div class="inner">
                        <h4>Best Solution</h4>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature.</p>
                    </div>
                </div>

                <div class="col-sm-4 feat-list">
                    <i class="pe-7s-science pe-5x pe-va wow fadeInUp" data-wow-delay="0.4s"></i>
                    <div class="inner">
                        <h4>Mobile App</h4>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature.</p>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<div id="download">
    <div class="action fullscreen parallax" style="background-image:url('images/bg2.jpg');" data-img-width="2000" data-img-height="1334" data-diff="100">
        <div class="overlay downloadSection">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 col-sm-12 text-center">
                        <h2 class="wow fadeInLeft">Apply now for a Demo</h2>
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
                        <div class="btn-section"><a href="#download" class="btn-default">Go!</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="about-us">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 col-sm-12 text-center feature-title">

                <h2>About Our Company</h2>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
            </div>
        </div>
        <div class="row row-feat">

            <div class="col-md-6 feature-2-pic wow fadeInLeft">
                <img src="images/feature2-image.jpg" alt="image" class="img-responsive">
            </div>

            <div class="col-md-6 wow fadeInRight">
                <h2>Who we are?</h2>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset.
                </p>

                <div class="btn-section"><a href="" class="btn-default">Read More</a></div>

            </div>

        </div>

    </div>
</div>


<div id="subscribe">
    <div class="subscribe fullscreen parallax" style="background-image:url('images/bg.jpg');" data-img-width="1920" data-img-height="1281" data-diff="100">
        <div class="overlay">
            <div class="container">

                <div class="col-md-4 col-md-offset-4 text-center">
                    <i class="pe-7s-mail pe-va letter wow fadeInUp"></i>
                </div>
                <div class="col-md-8 col-md-offset-2 text-center">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley.</p>

                    <div class="subscribe-form wow fadeInUp">
                        <form class="news-letter mailchimp" action="" role="form" method="POST">
                            <input type="hidden" name="u" value="">
                            <input type="hidden" name="id" value="">
                            <input class="form-control" type="email" name="" placeholder="Your email..." required="">
                            <button type="submit" class="subscribe-btn btn">SUBSCRIBE</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="portfolios">
    <div class="container">
        <div class="text-center">
            <h2 class="wow fadeInLeft">Our Profile</h2>
            <div class="title-line wow fadeInRight"></div>
        </div>
        <div class="row portfolio">

            <div id="portfolio" class="owl-carousel">

                <div class="screen wow fadeInUp">
                    <a href="images/img1.jpg" data-toggle="lightbox"><img src="images/img1.jpg" alt="portfolios"></a>
                </div>

                <div class="screen wow fadeInUp" data-wow-delay="0.1s">
                    <a href="images/img2.jpg" data-toggle="lightbox"><img src="images/img2.jpg" alt="portfolios"></a>
                </div>

                <div class="screen wow fadeInUp" data-wow-delay="0.2s">
                    <a href="images/img3.jpg" data-toggle="lightbox"><img src="images/img3.jpg" alt="portfolios"></a>
                </div>

                <div class="screen wow fadeInUp" data-wow-delay="0.3s">
                    <a href="images/img4.jpg" data-toggle="lightbox"><img src="images/img4.jpg" alt="portfolios"></a>
                </div>

                <div class="screen wow fadeInUp" data-wow-delay="0.4s">
                    <a href="images/img5.jpg" data-toggle="lightbox"><img src="images/img5.jpg" alt="portfolios"></a>
                </div>

                <div class="screen wow fadeInUp" data-wow-delay="0.5s">
                    <a href="images/img6.jpg" data-toggle="lightbox"><img src="images/img6.jpg" alt="portfolios"></a>
                </div>

                <div class="screen wow fadeInUp" data-wow-delay="0.6s">
                    <a href="images/img7.jpg" data-toggle="lightbox"><img src="images/img7.jpg" alt="portfolios"></a>
                </div>

                <div class="screen wow fadeInUp" data-wow-delay="0.7s">
                    <a href="images/img8.jpg" data-toggle="lightbox"><img src="images/img8.jpg" alt="portfolios"></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="clients">
    <div class="action fullscreen parallax" style="background-image:url('images/bg.jpg');" data-img-width="2000" data-img-height="1334" data-diff="100">
        <div class="overlay downloadSection">
            <div class="container">
                <div class="text-center">
                    <h2 class="wow fadeInLeft">Clients</h2>
                    <div class="title-line wow fadeInRight"></div>
                </div>
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div id="owl-clients" class="owl-carousel owl-theme wow fadeInUp">

                            <div class="clients-item">
                                <div class="client-pic text-center">

                                    <img src="images/client.jpg" alt="client">
                                </div>
                                <div class="box">

                                    <p class="message text-center">"Printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type dummy text of the printing."</p>
                                </div>
                                <div class="client-info text-center">

                                    John Doe, <span class="company">Google</span>
                                </div>
                            </div>

                            <div class="clients-item">
                                <div class="client-pic text-center">

                                    <img src="images/client2.jpg" alt="client">
                                </div>
                                <div class="box">

                                    <p class="message text-center">"Lorem Ipsum is simply dummy text of the printing and when an unknown printer took a galley of type dummy text of the printing and typesetting industry and scrambled."</p>
                                </div>
                                <div class="client-info text-center">

                                    Glen Micheal, <span class="company">CN Technology</span>
                                </div>
                            </div>

                            <div class="clients-item">
                                <div class="client-pic text-center">

                                    <img src="images/client3.jpg" alt="client">
                                </div>
                                <div class="box">

                                    <p class="message text-center">"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer."</p>
                                </div>
                                <div class="client-info text-center">

                                    Chris Russel, <span class="company">Facebook</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="pricing">
    <div class="container">
        <div class="text-center">

            <h2 class="wow fadeInLeft">Pricing</h2>
            <div class="title-line wow fadeInRight"></div>
        </div>
        <div class="row pricing-option">

            <div class="col-sm-4">
                <div class="price-box wow fadeInUp">
                    <div class="price-heading text-center">


                        <h3>Basic</h3>
                    </div>

                    <div class="price-group text-center">
                        <span class="dollar">$</span>
                        <span class="price">9</span>
                        <span class="time">/mo</span>
                    </div>

                    <ul class="price-feature text-center">
                        <li><strong>100MB</strong> Disk Space</li>
                        <li><strong>200MB</strong> Bandwidth</li>
                        <li><strong>2</strong> Subdomains</li>
                        <li><strong>5</strong> Email Accounts</li>
                        <li><strike>Webmail Support</strike></li>
                    </ul>

                    <div class="price-footer text-center">
                        <a class="btn btn-price" href="#">BUY NOW</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="price-box wow fadeInUp" data-wow-delay="0.2s">
                    <div class="price-heading text-center">


                        <h3>Standard</h3>
                    </div>

                    <div class="price-group text-center">
                        <span class="dollar">$</span>
                        <span class="price">19</span>
                        <span class="time">/mo</span>
                    </div>

                    <ul class="price-feature text-center">
                        <li><strong>300MB</strong> Disk Space</li>
                        <li><strong>400MB</strong> Bandwidth</li>
                        <li><strong>5</strong> Subdomains</li>
                        <li><strong>10</strong> Email Accounts</li>
                        <li><strike>Webmail Support</strike></li>
                    </ul>

                    <div class="price-footer text-center">
                        <a class="btn btn-price" href="#">BUY NOW</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="price-box wow fadeInUp" data-wow-delay="0.4s">
                    <div class="price-heading text-center">


                        <h3>Advance</h3>
                    </div>

                    <div class="price-group text-center">
                        <span class="dollar">$</span>
                        <span class="price">29</span>
                        <span class="time">/mo</span>
                    </div>

                    <ul class="price-feature text-center">
                        <li><strong>1GB</strong> Disk Space</li>
                        <li><strong>1GB</strong> Bandwidth</li>
                        <li><strong>10</strong> Subdomains</li>
                        <li><strong>25</strong> Email Accounts</li>
                        <li>Webmail Support</li>
                    </ul>

                    <div class="price-footer text-center">
                        <a class="btn btn-price" href="#">BUY NOW</a>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>


<div id="contact">
    <div class="contact fullscreen parallax" style="background-image:url('images/bg2.jpg');" data-img-width="2000" data-img-height="1334" data-diff="100">
        <div class="overlay">
            <div class="container">
                <div class="row contact-row">

                    <div class="col-sm-5 contact-left wow fadeInUp">
                        <h2><span class="highlight">Ask</span> US</h2>
                        <ul class="ul-address">
                            <li><i class="pe-7s-map-marker"></i>1234 Abcdef Town, Forest Area</br>
                                Mid world 10005
                            </li>
                            <li><i class="pe-7s-phone"></i>+0 (123) 456-7890</br>
                                +0 (123) 456-7890
                            </li>
                            <li><i class="pe-7s-mail"></i><a href="mailto:info@yoursite.com">info@yoursite.com</a></li>
                            <li><i class="pe-7s-look"></i><a href="#">www.yoursite.com</a></li>
                        </ul>

                    </div>

                    <div class="col-sm-7 contact-right">
                        <form method="POST" id="contact-form" class="form-horizontal" action="contactengine.php" onSubmit="alert('Thank you for your feedback!');">
                            <div class="form-group">
                                <input type="text" name="Name" id="Name" class="form-control wow fadeInUp" placeholder="Name" required />
                            </div>
                            <div class="form-group">
                                <input type="text" name="Email" id="Email" class="form-control wow fadeInUp" placeholder="Email" required />
                            </div>
                            <div class="form-group">
                                <textarea name="Message" rows="20" cols="20" id="Message" class="form-control input-message wow fadeInUp" placeholder="Message" required></textarea>
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
