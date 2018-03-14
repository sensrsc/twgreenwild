@extends('front.common.base')
@section('title', '活動列表')
@section('content')
    @include('front.common.activities', [
        'section_title' => $categoryTitle,
        'activities' => $activities
    ])
@endsection
