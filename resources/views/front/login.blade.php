@extends('front.common.base')
@section('title', '會員註冊')
@section('content')
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<h1 class="title--mobile">會員登入</h1>
	<form class="bd-example" style="center">
		<button class="btn-fb btn btn-primary">使用 Fackbook 登入</button>
		<p>或使用</p>
		<p><input type="text" placeholder="您的 Email"></p>
		<p><input type="password" placeholder="您的密碼"></p>
		<button class="btn-fb btn btn-primary">登入</button>
		<p>
			<a>忘記密碼</a>
			<a href="/register">註冊新帳號</a>
		</p>
	</form>

	<div style="text-align: center;">
		<p>安全與歡樂是我們的基本配備</p>
		<p>若要全配，請把你玩樂的心帶過來</p>
	</div>
@endsection