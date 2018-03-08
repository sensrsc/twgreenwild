@extends('front.common.base')
@section('title', '會員資料頁')
@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<h1 class="title--mobile">會員資料</h1>
<form class="bd-example">
	<button class="btn-fb btn btn-primary">已使用 Fackbook 帳號登入</button>
	<p>登入資料</p>
	<p>
        <span>信箱</span>
        <input type="mail">
    </p>
    <p>
        <span>密碼</span>
        <input type="password">
        <span>
        	<button class="btn-fb btn btn-danger">修改密碼</button>
        </span>	
 
    </p>
	<p>登入資料</p>
	<p>
		<span>姓名</span>
		<input type="text">
	</p>
	<p>
		<span>身分證號碼</span>
		<input type="text">
		<p>*非台灣客戶請輸入身份識別碼</p>
	</p>
	<p>
		<span>姓名</span>
		<select name="" id="">
			<option value="">男</option>
			<option value="">女</option>
		</select>
	</p>
	<p>
		<span>生日</span>
		<select name="" id="">
			<option value="" selected disabled hidden>年</option>
			<option value="">2018</option>
		</select>
		<select name="" id="">
			<option value="" selected disabled hidden>月</option>
			@for ($month = 1; $month <= 12; $month++)
				<option value="">{{ $month }}</option>
			@endfor
		</select>
		<select name="" id="">
			<option value="" selected disabled hidden>日</option>
			<option value=""></option>
			@for ($day = 1; $day <= 12; $day++)
				<option value="">{{ $day }}</option>
			@endfor
		</select>
	</p>
	<p>
		<span>身高</span>
		<input type="text">
		<span>公分</span>
	</p>
	<p>
		<span>體重</span>
		<input type="text">
		<span>公斤</span>
	</p>
	<p>
		<span>腳掌</span>
		<input type="text">
		<span>公分</span>
	</p>
	<p>
		<span>電話</span>
		<input type="tel">
	</p>
	<p>
		<span>地址</span>
		<input type="text">
	</p>
	<p>
		<span>信箱</span>
		<input type="mail">
	</p>
	<p>緊急聯絡人資料</p>
	<p>
		<span>姓名</span>
		<input type="text">
	</p>
	<p>
		<span>電話</span>
		<input type="tel">
	</p>
	<button class="btn-fb btn btn-info">儲存修改</button>
</form>

@endsection