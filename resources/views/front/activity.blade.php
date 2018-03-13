@extends('front.common.base')
@section('title', '分類列表')
@section('content')
    @include('front.common.carousel')

    <style>
        #calendar .full a {
            background-color: #ff5722 !important;
            background-image :none !important;
            color: #ffffff !important;
        }
    </style>
    <div class="activity-form">
        <div id="calendar"></div>
        <button id="open-form" class="btn btn-primary">我要報名</button>
        <div id="form-container" style="display: none;">
            <ul class="nav nav-tabs" id="form-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="single-tab" data-toggle="tab" href="#single" role="tab" aria-controls="single" aria-selected="true">個人報名</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="group-tab" data-toggle="tab" href="#group" role="tab" aria-controls="group" aria-selected="false">團體報名</a>
                </li>
            </ul>
            <div class="tab-content" id="form-tab-content">
                <div class="tab-pane fade show active" id="single" role="tabpanel" aria-labelledby="single-tab">
                    <div class="single-form">@include('front.common.single_apply_form')</div>
                </div>
                <div class="tab-pane fade" id="group" role="tabpanel" aria-labelledby="group-tab">
                    <div class="group-form">@include('front.common.group_apply_form')</div>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div>上稿區</div>

    <script>
        $(document).ready(function() {
            var openFormBtn = document.getElementById('open-form');
            var formContainer = document.getElementById('form-container');

            openFormBtn.addEventListener('click', function (e) {
                e.target.style.display = 'none';
                formContainer.style.display = 'block';
            });

            var singleTab = document.getElementById('single-tab');
            var groupTab = document.getElementById('group-tab');
            var singleContent = document.getElementById('single');
            var groupContent = document.getElementById('group');
            var singleApplyDate = document.getElementById('single-apply-date');
            var groupApplyDate = document.getElementById('group-apply-date');
            var activityDate = JSON.parse('{!! json_encode($activityDate) !!}');

            var eventDates = {};
            activityDate.ready_date.forEach(function (date) {
                eventDates[new Date(date)] = new Date(date);
            });

            singleApplyDate.innerText = activityDate.apply_date;
            groupApplyDate.innerText = activityDate.apply_date;

            // datepicker
            $('#calendar').datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: new Date(activityDate.apply_date),
                beforeShowDay: function (date) {
                    var highlight = eventDates[date];
                    if(highlight) {
                         return [true, "full", highlight];
                    } else {
                         return [true, '', ''];
                    }
                },
                onSelect: function (dateText) {
                    singleApplyDate.innerText = dateText;
                    groupApplyDate.innerText = dateText;
                },
            });

            singleTab.addEventListener('click', function (e) {
                e.preventDefault();
                singleContent.classList.add('show');
                groupContent.classList.remove('show');
            });

            groupTab.addEventListener('click', function (e) {
                e.preventDefault();
                singleContent.classList.remove('show');
                groupContent.classList.add('show');
            });
        });
    </script>
@endsection

