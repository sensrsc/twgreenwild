@extends('front.common.base')
@section('title', '會員資料頁')
@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<h1 class="title--mobile">會員資料</h1>
<form class="bd-example" method="post">
	{{ csrf_field() }}
	@if ($user->fb_id)
		<button class="btn-fb btn btn-primary">已使用 Fackbook 帳號登入</button>
	@endif
	<p>登入資料</p>
	<p>
        <span>帳號</span>
        <input disabled="disabled" type="mail" name="account" value="{{ $user->u_account }}">
    </p>
    <!-- <p>
        <span>密碼</span>
        <input type="password">
        <span>
        	<button class="btn-fb btn btn-danger">修改密碼</button>
        </span>	
 
    </p> -->
	<p>登入資料</p>
	<p>
		<span>姓名</span>
		<input type="text" name="name" value="{{ $user->u_name }}">
	</p>
	<p>
		<span>身分證號碼</span>
		<input type="text" name="identity" value="{{ $user->u_identity }}">
		<p>*非台灣客戶請輸入身份識別碼</p>
	</p>
	<p>
		<span>性別</span>
		<select name="gender" id="">
			<option value="1" {{ $user->u_gender == 1? 'selected' : '' }}>男</option>
			<option value="0" {{ $user->u_gender == 0? 'selected' : '' }}>女</option>
		</select>
	</p>
	<p>
		<span>生日</span>
		<select name="year" id="">
			<option value="" selected disabled hidden>年</option>
			@for ($year = date('Y'); $year > (date('Y') -50); $year --)
				<option value="{{ $year }}" {{ substr($user->u_birthday, 0, 4) == $year? 'selected' : '' }}>{{ $year }}</option>
			@endfor
		</select>
		<select name="month" id="">
			<option value="" selected disabled hidden>月</option>
			@for ($month = 1; $month <= 12; $month++)
				<option value="{{ $month }}" {{ substr($user->u_birthday, 5, 2) == $month? 'selected' : '' }}>{{ $month }}</option>
			@endfor
		</select>
		<select name="day" id="">
			<option value="" selected disabled hidden>日</option>
			<option value=""></option>
			@for ($day = 1; $day <= 12; $day++)
				<option value="{{ $day }}" {{ substr($user->u_birthday, 8, 2) == $day? 'selected' : '' }}>{{ $day }}</option>
			@endfor
		</select>
	</p>
	<p>
		<span>身高</span>
		<input type="text" name="height" value="{{ $user->u_height }}">
		<span>公分</span>
	</p>
	<p>
		<span>體重</span>
		<input type="text" name="weight" value="{{ $user->u_weight }}">
		<span>公斤</span>
	</p>
	<p>
		<span>腳掌</span>
		<input type="text" name="foot" value="{{ $user->u_foot }}">
		<span>公分</span>
	</p>
	<p>
		<span>電話</span>
		<input type="tel" name="phone" value="{{ $user->u_phone }}">
	</p>
	<p>
		<span>地址</span>
		<input type="text" name="address" value="{{ $user->u_address }}">
	</p>
	<!-- <p>
		<span>信箱</span>
		<input type="mail">
	</p> -->
	<p>緊急聯絡人資料</p>
	<p>
		<span>姓名</span>
		<input type="text" name="emergency_name" value="{{ $user->u_emergency_name }}">
	</p>
	<p>
		<span>電話</span>
		<input type="tel" name="emergency_phone" value="{{ $user->u_emergency_phone }}">
	</p>
	<button type="submit" class="btn-fb btn btn-info">儲存修改</button>
</form>

@if ($msg)
	<div class="text-danger" style="text-align: center;">
		{!! $msg !!}
	</div>
@endif

@endsection