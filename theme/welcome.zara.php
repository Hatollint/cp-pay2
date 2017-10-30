@extends("main")
@section("content")
<div class="container">
    
    @foreach($shops as $item)
    <div class="col-md-4 col-sm-6" onclick="ajax_url('/project/{{ $item['shop_id'] }}')" style="cursor: pointer;">
        <div id="best-selling" class="dash-widget-item">
            <div class="dash-widget-header">
                <div class="dash-widget-title">{{ $item['shop_name'] }}</div>
                <img src="http://mini.s-shot.ru/?http://{{ $item['shop_domain'] }}" alt="">
                <div class="main-item">
                    <small>{{ $item['shop_domain'] }}</small>
                    <h2>{{ (float)$item['shop_balance'] }} <i class="fa fa-rub"></i></h2>
                </div>
            </div>
        </div>
    </div>
    @endforeach
<?php header( 'Location: http://cp.localpay.ru/profile', true, 301 ); ?>
</div>
<script src="/assets/js/flot-charts/line-chart.js"></script>
<script src="/assets/js/charts.js"></script>
@stop