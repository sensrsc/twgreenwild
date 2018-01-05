@extends('layouts.admin.master')

@section('content')
<h3 class="form-title font-green">{{ isset($title)? $title : '' }}</h3>
<div class="portlet light ">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-social-dribbble font-green"></i>
            <span class="caption-subject font-green bold uppercase">
            	{{ isset($caption)? $caption : '' }}
			</span>
        </div>
    </div>
    <div class="portlet-body">
        <blockquote>
            <p>
            	{{ isset($message)? $message : '' }}
            </p>
        </blockquote>
    </div>
</div>
<div class="form-actions">
    <a type="button" id="register-back-btn" class="btn btn-default" href='{{ isset($url)? $url : "/login" }}'>
    	{{ isset($linkName)? $linkName : '反回登入' }}
    </a>
</div>
@endsection
