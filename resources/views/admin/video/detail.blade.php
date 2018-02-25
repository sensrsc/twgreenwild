@extends('layouts.admin.master')

@section('content')
<style type="text/css">
.textLeft {
    text-align: left !important;
}
</style>

<div class="profile-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe theme-font hide"></i>
                        <span class="caption-subject font-blue-madison bold uppercase">活動影音資料</span>
                    </div>
                </div>                
                <div class="portlet-body form">                    
                    <form id="data-form" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    	{{ csrf_field() }}
                        <input type="hidden" name="cv_id" value="{{ isset($data['cv_id'])? $data['cv_id'] : '0' }}" />
                        <input type="hidden" id="role_permission" value="{{ isset($role_permission)? $role_permission : '' }}" />
                        <div class="form-body">
                        	<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">影片名稱：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="影片名稱" class="form-control" name="cv_name" value="{{ isset($data['cv_name'])? $data['cv_name'] : '' }}" />
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="control-label col-md-3">行程分類：</div>
									<div class="col-md-9">
										<select id="country" name="c_id" class="form-control country">
											<option value="">請選擇</option>
											@if (isset($categorys))
				                            	@foreach ($categorys as $category)
				                            		<option value="{{ $category->c_id }}" {{ (isset($data['c_id']) && $data['c_id'] == $category->c_id)? 'selected' : '' }}>{{ $category->c_title }}</option>
				                            	@endforeach
				                            @endif
				                        </select>
									</div>
								</div>
							</div>

                            <div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">影片連結：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="影片連結 url" class="form-control" name="cv_youtube_link" value="{{ isset($data['cv_youtube_link'])? $data['cv_youtube_link'] : '' }}" />
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="control-label col-md-3">相簿日期：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="相簿日期" class="form-control date-picker" name="cv_date" data-date-format="yyyy-mm-dd" value="{{ isset($data['cv_date'])? $data['cv_date'] : '' }}" />
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">影片說明：</div>
									<div class="col-md-10">
										<div class="input-icon right">
											<textarea placeholder="影片說明" class="form-control" name="cv_description">{{ isset($data['cv_description'])? $data['cv_description'] : '' }}</textarea>
										</div>
									</div>
								</div>
                            </div>
			
                        	
	                        <div class="form-actions right">
	                            <a href="/admin/video" class="btn btn-default"> 返回活動影音列表 </a>
	                            <button class="btn green" id="data-form-btn" type="submit"> 儲存修改 </button>
	                        </div>
                    	</div>
                	</form>
            	</div>
        	</div>
    	</div>
	</div>
</div>

@endsection


@section('css_link')
<link href="/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('js_script')
    <script src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <script src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="/js/ckeditor/ckeditor.js"></script>
    <script src="/assets/apps/scripts/admin/video.js"></script>
@endsection
