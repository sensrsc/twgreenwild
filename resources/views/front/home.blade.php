@extends('front.common.base')
@section('title', '首頁')
@section('content')
    @include('front.common.carousel')
    @include('front.common.activities', [
        'section_title' => '近期成行活動',
        'activities' => array()
    ])
    @include('front.common.activities', [
        'section_title' => '季節推薦',
        'activities' => $seasonActivities
    ])
    @include('front.common.activities', [
        'section_title' => '熱門活動',
        'activities' => $hotActivities
    ])
@endsection
