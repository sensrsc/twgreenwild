@extends('front.common.base')
@section('title', '訂單資料頁')
@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
.btn-order-status {	
	position: relative; 
	margin-right: 10px; 
	bottom: 15px;
}
@media (min-width: 642px) {
	.btn-order-status {
		bottom: 155px;
	} 
}
</style>
<h1 class="title--mobile">訂單資料</h1>
<section class="activities">
	<div class="activity">
	    <div class="info">
	        <h3 class="title">新竹尖石梅花溪溯溪</h3>
	        <p class="desc">2017-12-02</p>
			<span class="price price--order">
				<span>TWD.</span>10000
				<button class="btn btn-secondary btn-order-status float-right">確認中</button>
			</span>
			
	    </div>
	    <img class="cover" src="http://twgreenwild.chibakuma.com/images/river.jpg">
	</div>
	<div class="activity">
	    <div class="info">
	        <h3 class="title">新竹尖石梅花溪溯溪</h3>
	        <p class="desc">2017-12-02</p>
			<span class="price price--order">
				<span>TWD.</span>10000
				<button class="btn btn-primary btn-order-status float-right">待付款</button>
			</span>
			
	    </div>
	    <img class="cover" src="http://twgreenwild.chibakuma.com/images/river.jpg">
	</div>
	<div class="activity">
	    <div class="info">
	        <h3 class="title">新竹尖石梅花溪溯溪</h3>
	        <p class="desc">2017-12-02</p>
			<span class="price price--order">
				<span>TWD.</span>10000
				<button class="btn btn-light btn-order-status float-right">已付款</button>
			</span>
			
	    </div>
	    <img class="cover" src="http://twgreenwild.chibakuma.com/images/river.jpg">
	</div>
</section>
@endsection