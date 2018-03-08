
<body>

	<div>親愛的 {{ $data['cro_name'] }} 先生／小姐</div><br />

	<div>感謝您的預約，以下是您的預約資料</div><br />

	<div>預約單號：{{ $data['order_id'] }}</div>
	<div>類型：{{ $data['cro_type'] == 'airport'? '機場接送' : '商務包車' }} {{ $data['cro_type'] == 'airport'? '（' . $data['cro_way'] . '）' : '' }}</div>


	@if ($data['cro_type'] == 'airport')
		@if ($data['cro_way'] == '去程' || $data['cro_way'] == '來回')
			<div>日期：{{ $data['cro_detail']['date_go'] }}</div>
			<div>時間：{{ $data['cro_detail']['time_go'] }}</div>
		@else
			<div>日期：{{ $data['cro_detail']['date_back'] }}</div>
			<div>時間：{{ $data['cro_detail']['time_back'] }}</div>
		@endif
	@else
		<div>日期：{{ $data['cro_detail']['date'] }}</div>
		<div>時間：{{ $data['cro_detail']['time'] }}</div>
	@endif

	<div>車款：{{ $data['cro_car_model'] }}</div>
	<div>------------</div>
	<div>姓名：{{ $data['cro_name'] }}</div>	
	<div>連絡電話：{{ $data['cro_telno'] }}</div>
	<div>地址：{{ $data['cro_city'] . ' ' . $data['cro_district'] . ' ' . $data['cro_address'] }}</div>

	@if ($data['cro_type'] == 'airport')
		
		@if ($data['cro_way'] == '去程' || $data['cro_way'] == '來回')
			<div>去程：機場 桃園國際機場 {{ $data['cro_detail']['airport_go'] }}</div>
			<div>大人人數：{{ $data['cro_detail']['go_adult'] }}</div>
			<div>小孩人數：{{ $data['cro_detail']['go_children'] }}</div>
		@endif

		@if ($data['cro_way'] == '回程' || $data['cro_way'] == '來回')
			<br />
			<div>回程：機場 桃園國際機場 {{ $data['cro_detail']['airport_back'] }}</div>
			<div>航班： {{ $data['cro_detail']['flight'] }}</div>
			<div>大人人數：{{ $data['cro_adult'] }}</div>
			<div>小孩人數：{{ $data['cro_children'] }}</div>
		@endif

	@else
		<div>大人人數：{{ $data['cro_adult'] }}</div>
		<div>小孩人數：{{ $data['cro_children'] }}</div>
	@endif

	<br />
	<div>價格：{{ number_format($data['cro_est_fee']) }}</div>

	<div>------------</div><br />

	<div>我們將會儘速與您聯絡</div>
	<div>如果有問題，請來電 xx-xxxx-xxxx 〇小姐</div><br />

	<div>綠葉戶外</div>

</body>