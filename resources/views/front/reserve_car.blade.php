@extends('front.common.base')
@section('title', '預約叫車')
@section('content')
    <form>
        <p>
            <span>類型</span>
            <select id="reserve-type">
                <option value="airport">機場接送</option>
                <option value="car">商務包車</option>
            </select>
        </p>
        <!-- 機場接送選項 -->
        <div id="airport-block" class="airport-block">
            <p>
                <span>選項</span>
                <select id="reserve-airport-type">
                    <option>去程</option>
                    <option>回程</option>
                    <option>來回</option>
                </select>
            </p>

            <!-- 機場接送去程選項 -->
            <div id="airport-block__to" id="airport-block__to">
                <p>
                    <span>人數</span>
                    <span>
                        <input type="number" value="1">大人
                        <input type="number" value="1">小孩
                    </span>
                </p>
                <p>
                    <span>去程日期</span>
                    <span>
                        <select>
                            <option value="" selected disabled hidden>年</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                        </select>
                    </span>
                    <span>
                            <select>
                                <option value="" selected disabled hidden>月</option>
                                @for ($month = 1; $month <= 12; $month++)
                                    <option value="{{ $month }}">{{ $month }}</option>
                                @endfor
                            </select>
                    </span>
                    <span>
                            <select>
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
                        <select>
                            <option value="第一航廈" selected>第一航廈</option>
                            <option value="第二航廈">第二航廈</option>
                        </select>
                    </span>
                </p>
                <p>
                    <span>上車時間</span>
                    <input type="text">
                </p>
                <p>
                    <span>上車地址</span>
                    <select>
                        <option value="" selected disabled hidden>都市</option>
                    </select>
                    <select>
                        <option value="" selected disabled hidden>行政區</option>
                    </select>
                </p>
            </div>
            <!-- 機場接送去程選項 end -->
            <!-- 機場接送回程選項 -->
            <div class="airport-block__back" id="airport-block__back">
                <p>
                    <span>回程日期</span>
                    <span>
                        <select>
                            <option value="" selected disabled hidden>年</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                        </select>
                    </span>
                    <span>
                            <select>
                                <option value="" selected disabled hidden>月</option>
                                @for ($month = 1; $month <= 12; $month++)
                                    <option value="{{ $month }}">{{ $month }}</option>
                                @endfor
                            </select>
                    </span>
                    <span>
                            <select>
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
                        <input type="number" value="1">大人
                        <input type="number" value="1">小孩
                    </span>
                </p>
                <p>
                    <span>機場</span>
                    <span>
                        桃園國際機場
                        <select>
                            <option value="第一航廈" selected>第一航廈</option>
                            <option value="第二航廈">第二航廈</option>
                        </select>
                    </span>
                </p>
                <p>
                    <span>航班</span>
                    <input type="text">
                </p>
                <p>
                    <span>預約時間</span>
                    <input type="text">
                </p>
            </div>
            <!-- 機場接送回程選項 end -->
        </div>
        <!-- 機場接送選項 end -->

        <!-- 商務包車選項 -->
        <div id="car-block" class="car-block">
            <p>
                <span>日期</span>
                <span>
                    <select>
                        <option value="" selected disabled hidden>年</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                    </select>
                </span>
                <span>
                        <select>
                            <option value="" selected disabled hidden>月</option>
                            @for ($month = 1; $month <= 12; $month++)
                                <option value="{{ $month }}">{{ $month }}</option>
                            @endfor
                        </select>
                </span>
                <span>
                        <select>
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
                    <input type="number" value="1">大人
                    <input type="number" value="1">小孩
                </span>
            </p>
            <p>
                <span>上車時間</span>
                <input type="text">
            </p>
            <p>
                <span>上車地址</span>
                <select>
                    <option value="" selected disabled hidden>都市</option>
                </select>
                <select>
                    <option value="" selected disabled hidden>行政區</option>
                </select>
            </p>
        </div>
        <!-- 商務包車 end -->

        <p>
            <span>姓名</span>
            <input type="text">
        </p>
        <p>
            <span>電話</span>
            <input type="text">
        </p>

        <input type="button" value="送出預約">
    </form>

@endsection