@extends('front.common.base')
@section('title', '訂單資料頁')
@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
.btn-order-status { 
    position: relative; 
    margin-right: 10px; 
    bottom: 25px;
}
@media (min-width: 642px) {
    .btn-order-status {
        bottom: 155px;
    } 
}
</style>
<h1 class="title--mobile">訂單資料</h1>
<section class="activities">
    @if (!empty($lists))
        @foreach ($lists as $list)
            <div class="activity">
                <div class="info">
                    <h3 class="title">{{ $list->tour->t_title }}</h3>
                    <p class="desc">{{ $list->apply_date }}</p>
                    <span class="price price--order">
                        <span>TWD.</span>{{ $list->total_price }}
                        <button class="btn {{ isset(config('common.order_status_css')[$list->o_status])? config('common.order_status_css')[$list->o_status] : 'btn_loght' }} btn-order-status float-right" data-id="{{ $list->o_id }}">{{ isset(config('common.order_front_status')[$list['o_status']])? config('common.order_front_status')[$list['o_status']] : '' }}</button>
                    </span>
                </div>
                <img class="cover" src="{{ $list->tour->album->cover->picturePath }}">
            </div>
        @endforeach
    @endif

</section>

<script>
    $(document).ready(function() {
        $('.btn-primary').click(function(){
            var o_id = $(this).data('id')
                block = $(this).parents('.activity');
                console.log(block.find('.desc').text());
            $.ajax({
                type: 'GET',
                url: '/member/token',
                data: {'o_id' : o_id},
                success: function(response){
                    console.log(response);
                    if (response.status) {
                        var s = document.createElement("script");    
                        s.type = "text/javascript";
                        if (s.readyState) {  //IE
                            s.onreadystatechange = function() {
                                if ( s.readyState === "loaded" || s.readyState === "complete" ) {
                                    s.onreadystatechange = null;
                                }
                            }
                        } else {  //Others
                            s.onload = function() {
                                block.find('#Btn_Pay').click();
                            };
                        }
                        s.setAttribute("data-MerchantID", "2000132");
                        s.setAttribute("data-SPToken", response.token);
                        s.setAttribute("data-PaymentType", response.type);
                        s.setAttribute("data-PaymentName", response.typeName);
                        s.setAttribute("data-CustomerBtn", "0");

                        $(block).append(s);
                        s.src = "https://payment-stage.ecpay.com.tw/Scripts/SP/ECPayPayment_1.0.0.js";
                    }
                },
                dataType: 'json'
            });
        });
    });
</script>
@endsection
