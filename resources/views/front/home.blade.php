@extends('front.common.base')
@section('title', '首頁')
@section('content')
    @include('front.common.carousel')
    @include('front.common.activities', [
        'section_title' => '近期成行活動',
        'activities' => array(
            array(
                'id' => '0',
                'title' => '發現台灣之美 南澳鹿皮溪',
                'type' => '朔溪',
                'region' => '北部',
                'cover' => asset('images/river.jpg'),
                'price' => '1,097'
            ),

            array(
                'id' => '0',
                'title' => '發現台灣之美 南澳鹿皮溪',
                'type' => '朔溪',
                'region' => '北部',
                'cover' => asset('images/river.jpg'),
                'price' => '1,097'
            ),

            array(
                'id' => '0',
                'title' => '發現台灣之美 南澳鹿皮溪',
                'type' => '朔溪',
                'region' => '北部',
                'cover' => asset('images/river.jpg'),
                'price' => '1,097'
            ),

            array(
                'id' => '0',
                'title' => '發現台灣之美 南澳鹿皮溪',
                'type' => '朔溪',
                'region' => '北部',
                'cover' => asset('images/river.jpg'),
                'price' => '1,097'
            ),

            array(
                'id' => '0',
                'title' => '發現台灣之美 南澳鹿皮溪',
                'type' => '朔溪',
                'region' => '北部',
                'cover' => asset('images/river.jpg'),
                'price' => '1,097'
            ),

            array(
                'id' => '0',
                'title' => '發現台灣之美 南澳鹿皮溪',
                'type' => '朔溪',
                'region' => '北部',
                'cover' => asset('images/river.jpg'),
                'price' => '1,097'
            ),
        )
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
