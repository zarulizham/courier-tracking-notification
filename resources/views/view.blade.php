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
        <div class="row">
            <div class="col-md-12">
                <h3>Tracking Code: {{ $tracking_code->code.' ('.$tracking_code->courier->name.')' }}</h3>
            </div>
        </div>
        <div class="row row-feat">
            <div class="col-md-12">
                @includeWhen($tracking_code->courier_id == 1 || $tracking_code->courier_id == 3, 'details.poslaju', ['tracking_code' => $tracking_code])
                @includeWhen($tracking_code->courier_id == 4, 'details.ninjavan', ['tracking_code' => $tracking_code])
                @includeWhen($tracking_code->courier_id == 5, 'details.jnt', ['tracking_code' => $tracking_code])
            </div>
        </div>
    </div>
</div>
@endsection
