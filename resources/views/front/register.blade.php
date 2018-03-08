@extends('front.common.base')
@section('title', '會員註冊')
@section('content')
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<h1 class="title--mobile">會員註冊</h1>
	<form class="bd-example" style="center">
		<button class="btn-fb btn btn-primary">使用 Fackbook 註冊</button>
		<p>一般註冊</p>
		<p><input type="text" placeholder="Email"></p>
		<p><input type="password" placeholder="密碼"></p>
		<p><input type="password" placeholder="再輸入一次密碼"></p>
		<button class="btn-fb btn btn-primary">註冊帳號</button>
		<p>已經有使用綠葉戶外帳號</p>
		<a href="/login">會員登入</a>
	</form>

	<div style="text-align: center;">
		<p>安全與歡樂是我們的基本配備</p>
		<p>若要全配，請把你玩樂的心帶過來</p>
	</div>
@endsection
