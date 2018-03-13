@extends('front.common.base')
@section('title', '預約叫車')
@section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .car-block,
        .airport-block__back {
            display: none;
        }
    </style>
    <div class="bd-example">
        <span>類型</span>
        <select name="type" id="reserve-type">
            <option value="airport">機場接送</option>
            <option value="car">商務包車</option>
        </select>
    </div>
    <form id="airport-block" class="bd-example airport-block">
        {{ csrf_field() }}
        <!-- 機場接送選項 -->
        <div class="airport-block">
            <p>
                <span>選項</span>
                <select name="way" id="reserve-airport-type">
                    <option value="去程">去程</option>
                    <option value="回程">回程</option>
                    <option value="來回">來回</option>
                </select>
            </p>

            <!-- 機場接送去程選項 -->
            <div id="airport-block__to" id="airport-block__to">
                <p>
                    <span>人數</span>
                    <span>
                        <input name="go_adult" type="number" value="1">大人
                        <input name="go_children" type="number" value="1">小孩
                    </span>
                </p>
                <p>
                    <span>去程日期</span>
                    <span>
                        <select name="date_go_year">
                            <option value="" selected disabled hidden>年</option>
                            @for ($i = 0; $i < 3; $i++)
                                <option value="{{ date('Y') + $i }}">{{ date('Y') + $i }}</option>
                            @endfor
                        </select>
                    </span>
                    <span>
                            <select name="date_go_month">
                                <option value="" selected disabled hidden>月</option>
                                @for ($month = 1; $month <= 12; $month++)
                                    <option value="{{ $month }}">{{ $month }}</option>
                                @endfor
                            </select>
                    </span>
                    <span>
                            <select name="date_go_day">
                                <option value="" selected disabled hidden>日</option>
                                @for ($day = 1; $day <= 31; $day++)
                                    <option value="{{ $day }}">{{ $day }}</option>
                                @endfor
                            </select>
                    </span>
                </p>
                <p>
                    <span>機場</span>
                    <span>
                        桃園國際機場
                        <select name="airport_go">
                            <option value="第一航廈" selected>第一航廈</option>
                            <option value="第二航廈">第二航廈</option>
                        </select>
                    </span>
                </p>
                <p>
                    <span>上車時間</span>
                    <input name="time_go" type="time">
                </p>
                <p>
                    <span>上車地址</span>
                    <select name="city" class="city">
                        <option value="" selected disabled hidden>都市</option>
                    </select>
                    <select name="district" class="area">
                        <option value="" selected disabled hidden>行政區</option>
                    </select>
                    <select name="model" class="car" id="car-airport">
                        <option value="" selected disabled hidden>車型</option>
                    </select>
                </p>
                <p>
                    <span>地址</span>
                    <input name="address" type="text">
                </p>
                <p>
                    <span>價格:</span>
                    <span class="price" id="price-airport">0</span>
                </p>
            </div>
            <!-- 機場接送去程選項 end -->
            <!-- 機場接送回程選項 -->
            <div class="airport-block__back" id="airport-block__back">
                <p>
                    <span>回程日期</span>
                    <span>
                        <select name="date_back_year">
                            <option value="" selected disabled hidden>年</option>
                            @for ($i = 0; $i < 3; $i++)
                                <option value="{{ date('Y') + $i }}">{{ date('Y') + $i }}</option>
                            @endfor
                        </select>
                    </span>
                    <span>
                            <select name="date_back_month">
                                <option value="" selected disabled hidden>月</option>
                                @for ($month = 1; $month <= 12; $month++)
                                    <option value="{{ $month }}">{{ $month }}</option>
                                @endfor
                            </select>
                    </span>
                    <span>
                            <select name="date_back_day">
                                <option value="" selected disabled hidden>日</option>
                                @for ($day = 1; $day <= 31; $day++)
                                    <option value="{{ $day }}">{{ $day }}</option>
                                @endfor
                            </select>
                    </span>
                </p>
                <p>
                    <span>人數</span>
                    <span>
                        <input name="back_adult" type="number" value="1">大人
                        <input name="back_children" type="number" value="1">小孩
                    </span>
                </p>
                <p>
                    <span>機場</span>
                    <span>
                        桃園國際機場
                        <select name="airport_back">
                            <option value="第一航廈" selected>第一航廈</option>
                            <option value="第二航廈">第二航廈</option>
                        </select>
                    </span>
                </p>
                <p>
                    <span>航班</span>
                    <input name="flight" type="text">
                </p>
                <p>
                    <span>預約時間</span>
                    <input name="time_back" type="time">
                </p>

            </div>
            <!-- 機場接送回程選項 end -->
            <p>
                <span>姓名</span>
                <input name="name" type="text">
            </p>
            <p>
                <span>電話</span>
                <input name="phone" type="text">
            </p>
            <p>
                <span>Email</span>
                <input name="email" type="text">
            </p>

            <input class="btn btn-light" data-type="airport" type="button" value="送出預約">
        </div>
        <!-- 機場接送選項 end -->
        
    </form>

    <!-- 商務包車選項 -->
    <form id="car-block" class="bd-example car-block">
        {{ csrf_field() }}
        <div>
            <p>
                <span>日期</span>
                <span>
                    <select name="date_year">
                        <option value="" selected disabled hidden>年</option>
                        @for ($i = 0; $i < 3; $i++)
                            <option value="{{ date('Y') + $i }}">{{ date('Y') + $i }}</option>
                        @endfor
                    </select>
                </span>
                <span>
                        <select name="date_month">
                            <option value="" selected disabled hidden>月</option>
                            @for ($month = 1; $month <= 12; $month++)
                                <option value="{{ $month }}">{{ $month }}</option>
                            @endfor
                        </select>
                </span>
                <span>
                        <select name="date_day">
                            <option value="" selected disabled hidden>日</option>
                            @for ($day = 1; $day <= 31; $day++)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endfor
                        </select>
                </span>
            </p>
            <p>
                <span>人數</span>
                <span>
                    <input name="adult" type="number" value="1">大人
                    <input name="children" type="number" value="1">小孩
                </span>
            </p>
            <p>
                <span>上車時間</span>
                <input name="time" type="time">
            </p>
            <p>
                <span>上車地點</span>
                <select name="city" class="city">
                    <option value="" selected disabled hidden>都市</option>
                </select>
                <select name="district" class="area">
                    <option value="" selected disabled hidden>行政區</option>
                </select>
            </p>
            <p>
                <span>地址</span>
                <input name="address" type="text">
            </p>
            <p>
                <span>車型</span>
                <select name="model" id="car-all-day">
                    <option value="" selected disabled hidden>車型</option>
                    @foreach ($models as $model)
                        <option value="{{ $model->cr_model }}">{{ $model->cr_model }}</option>
                    @endforeach
                </select>
            </p>
            <p>
                <span>價格:</span>
                <span class="price" id="price-all-day">0</span>
            </p>
            <p>
                <span>姓名</span>
                <input name="name" type="text">
            </p>
            <p>
                <span>電話</span>
                <input name="phone" type="text">
            </p>
            <p>
                <span>Email</span>
                <input name="email" type="text">
            </p>

            <input class="btn btn-light" data-type="car" type="button" value="送出預約">
        </div>
        <!-- 商務包車 end -->
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
    <script>
        (function () {
            var reserveType = document.querySelector('#reserve-type'),
                reserveTypeOption = document.querySelectorAll('#reserve-type > option'),
                airportBlock = document.querySelector('#airport-block'),
                carBlock = document.querySelector('#car-block'),
                reserveAirportType = document.querySelector('#reserve-airport-type'),
                reserveAirportTypeOption = document.querySelectorAll('#reserve-airport-type > option'),
                airportTo = document.querySelector('#airport-block__to'),
                airportBack = document.querySelector('#airport-block__back'),
                citySelects = document.querySelectorAll('.city'),
                areaSelects = document.querySelectorAll('.area'),
                carSelects = document.querySelectorAll('.car'),
                prices = document.querySelectorAll('.price'),
                priceAirport = document.querySelector('#price-airport');

            reserveType.addEventListener('change', function () {
                showSelectReserveType();
            });
            reserveAirportType.addEventListener('change', function () {
                showSelectReserveAirportType();
            });

            function showSelectReserveType () {
                Array.prototype.forEach.call(reserveTypeOption, function (el) {
                    if (el.innerText.match(/機場接送/) && el.selected) {
                        airportBlock.style.display = 'block';
                        carBlock.style.display = 'none';
                    }
                    if (el.innerText.match(/商務包車/) && el.selected) {
                        carBlock.style.display = 'block';
                        airportBlock.style.display = 'none';
                    }
                });
            };

            var selectAll = false;

            function showSelectReserveAirportType () {
                Array.prototype.forEach.call(reserveAirportTypeOption, function (el) {
                    if (el.selected) {
                        airportTo.style.display = 'block';
                        airportBack.style.display = 'block';

                        if (el.innerText.match(/去程/)) {
                            airportTo.style.display = 'block';
                            airportBack.style.display = 'none';
                        }
                        if (el.innerText.match(/回程/)) {
                            airportBack.style.display = 'block';
                            airportTo.style.display = 'none';
                        }
                        if (el.innerText.match(/來回/)) {
                            priceAirport.innerText = priceAirport.innerText * 2;
                                selectAll = true;
                        }

                        if (selectAll && !el.innerText.match(/來回/)) {
                            priceAirport.innerText = priceAirport.innerText / 2;
                            selectAll = false;
                        }
                    }
                });
            };

            /**** 行政區 ****/
            var cityData = {
            "台北市": {"中正區":"100","大同區":"103","中山區":"104","松山區":"105","大安區":"106","萬華區":"108","信義區":"110","士林區":"111","北投區":"112","內湖區":"114","南港區":"115","文山區":"116"},
            "新北市": {"萬里區":"207","金山區":"208","板橋區":"220","汐止區":"221","深坑區":"222","石碇區":"223","瑞芳區":"224","平溪區":"226","雙溪區":"227","貢寮區":"228","新店區":"231","坪林區":"232","烏來區":"233","永和區":"234","中和區":"235","土城區":"236","三峽區":"237","樹林區":"238","鶯歌區":"239","三重區":"241","新莊區":"242","泰山區":"243","林口區":"244","蘆洲區":"247","五股區":"248","八里區":"249","淡水區":"251","三芝區":"252","石門區":"253"},
            "基隆市": {"仁愛區":"200","信義區":"201","中正區":"202","中山區":"203","安樂區":"204","暖暖區":"205","七堵區":"206"},
            "新竹市": {"東區":"300", "北區":"300", "香山區":"300"},
            "新竹縣": {"湖口鄉":"303","新豐鄉":"304","新埔鎮":"305","關西鎮":"306","芎林鄉":"307","寶山鄉":"308","竹東鎮":"310","五峰鄉":"311","橫山鄉":"312","尖石鄉":"313","北埔鄉":"314","峨眉鄉":"315"},
            "桃園市": {"中壢區":"320","平鎮區":"324","龍潭區":"325","楊梅區":"326","新屋區":"327","觀音區":"328","桃園區":"330","龜山區":"333","八德區":"334","大溪區":"335","復興區":"336","大園區":"337","蘆竹區":"338"},
            "苗栗縣": {"竹南鎮":"350","頭份鎮":"351","三灣鄉":"352","南庄鄉":"353","獅潭鄉":"354","後龍鎮":"356","通霄鎮":"357","苑裡鎮":"358","苗栗市":"360","造橋鄉":"361","頭屋鄉":"362","公館鄉":"363","大湖鄉":"364","泰安鄉":"365","銅鑼鄉":"366","三義鄉":"367","西湖鄉":"368","卓蘭鎮":"369"},
            "台中市": {"中　區":"400","東　區":"401","南　區":"402","西　區":"403","北　區":"404","北屯區":"406","西屯區":"407","南屯區":"408","太平區":"411","大里區":"412","霧峰區":"413","烏日區":"414","豐原區":"420","后里區":"421","石岡區":"422","東勢區":"423","和平區":"424","新社區":"426","潭子區":"427","大雅區":"428","神岡區":"429","大肚區":"432","沙鹿區":"433","龍井區":"434","梧棲區":"435","清水區":"436","大甲區":"437","外埔區":"438","大安區":"439"},
            }

            var cityStr = Object.keys(cityData).map(function (key) {
                return '<option value="' + key + '">' + key + '</option>';
            }).join('');

            Array.prototype.forEach.call(citySelects, function (citySelect, citySelectIndex) {
                citySelect.insertAdjacentHTML('beforeEnd', cityStr);

                citySelect.addEventListener('change', function (e) {
                    var options = citySelect.querySelectorAll('option');

                    Array.prototype.forEach.call(options, function (option) {

                        if (option.selected) {
                            var optionsStr = Object.keys(cityData[option.innerText]).map(function (key) {
                                return '<option value="' + key + '">' + key + '</option>';
                            }).join(''),
                                currentAreaSelect = areaSelects[citySelectIndex];

                            Array.prototype.forEach.call(currentAreaSelect.querySelectorAll('option'), function (option) {
                                currentAreaSelect.removeChild(option);
                            });

                            currentAreaSelect.insertAdjacentHTML('beforeEnd', optionsStr);
                        }
                    });
                    
                    if (carSelects[citySelectIndex]) {
                        carSelects[citySelectIndex].innerHTML = '<option value="" selected disabled hidden>車型</option>';
                    
                        prices[citySelectIndex].innerText = 0;
                    }

                });
            });

            // 取得車型
            Array.prototype.forEach.call(areaSelects, function (areaSelect, areaSelectIndex) {

                areaSelect.addEventListener('change', function (e) {
                    axios.get('/api/carreserve/carmodel?city=' + citySelects[areaSelectIndex].value).then(function (res) {

                        carSelects[areaSelectIndex].innerText = '';
                        prices[areaSelectIndex].innerText = 0;

                        var optionsStr = res.data.data.map(function (value, key) {
                            return '<option value="' + value.cr_model + '">' + value.cr_model + '</option>';
                        });

                        optionsStr = '<option value="" selected disabled hidden>車型</option>'.concat(optionsStr);

                        carSelects[areaSelectIndex].insertAdjacentHTML('beforeEnd', optionsStr);


                        // 機場接送取得價格
                        document.querySelector('#car-airport').addEventListener('change', function (e) {

                            axios.get('/api/carreserve/calculate?type=airport&model=' + e.target.value + '&city=' + citySelects[areaSelectIndex].value + '&district=' + areaSelect.value).then(function (res) {

                                    document.querySelector('#price-airport').innerText = res.data.price;

                                    if (selectAll) {
                                        document.querySelector('#price-airport').innerText = res.data.price * 2;
                                    }

                                }).catch(function (error) {
                                    console.log(error);
                                });
                        });

                    }).catch(function (error) {
                        console.log(error);
                    });

                });
            });

            
            // 商務包車取得價格
            document.querySelector('#car-all-day').addEventListener('change', function (e) {

                axios.get('/api/carreserve/calculate?type=all_day&model=' + e.target.value).then(function (res) {
                        console.log(res)
                        document.querySelector('#price-all-day').innerText = res.data.price;

                    }).catch(function (error) {
                        console.log(error);
                    });
            });

            document.querySelector('.btn').addEventListener('click', function(e) {
                console.log(e);
                console.log(this.dataset.type);



                var formData = new FormData(airportBlock);
                formData.forEach(function(value, key){
                    console.log(key, value);
                });
                formData.append('type', document.querySelector('#reserve-type').value);
                // console.log(formData.get('city'));
                // console.log(airportBlock);
                // console.log(formData);
                // console.log(document.forms[0]);
                // console.log(new FormData(document.querySelector("#airport-block")));



                axios.post('/reserve/create', formData)
                  .then(function (response) {
                    console.log(response);
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            });

        })();
    </script>
@endsection