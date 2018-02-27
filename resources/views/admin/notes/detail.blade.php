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
                        <span class="caption-subject font-blue-madison bold uppercase">活動筆記資料</span>
                    </div>
                </div>                
                <div class="portlet-body form">                    
                    <form id="data-form" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    	{{ csrf_field() }}
                        <input type="hidden" name="an_id" value="{{ isset($data['an_id'])? $data['an_id'] : '0' }}" />
                        <input type="hidden" id="role_permission" value="{{ isset($role_permission)? $role_permission : '' }}" />
                        <div class="form-body">
                        	<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">筆記名稱：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="筆記名稱" class="form-control" name="an_name" value="{{ isset($data['an_name'])? $data['an_name'] : '' }}" />
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="control-label col-md-3">筆記日期：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="筆記日期" class="form-control date-picker" name="an_date" data-date-format="yyyy-mm-dd" value="{{ isset($data['an_date'])? $data['an_date'] : '' }}" />
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">筆記內容：</div>
									<div class="col-md-10">
										<div class="input-icon right">
											<textarea placeholder="筆記內容" class="form-control" name="an_body">{{ isset($data['an_body'])? $data['an_body'] : '' }}</textarea>
										</div>
									</div>
								</div>
                            </div>

                            <div class="form-group">
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
								<div class="col-md-6">
									<div class="control-label col-md-3">相簿：</div>
									<div class="col-md-9">
										<select id="a_id" name="a_id" data-aid="{{ isset($data->picture->a_id)? $data->picture->a_id : 0 }}" class="form-control country">
											<option value="">請選擇</option>
				                        </select>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12">
									<select id="image-picker" data-apid="{{ isset($data->an_cover)? $data->an_cover : 0 }}" name="an_cover" class="image-picker show-html">
									</select>
								</div>
							</div>
                        	
	                        <div class="form-actions right">
	                            <a href="/admin/notes" class="btn btn-default"> 返回活動筆記列表 </a>
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
<link href="/assets/global/plugins/image-picker/image-picker.css" rel="stylesheet" type="text/css" />
<style>
	.img-picker {
		width : 200px;
		height : 200px;
	}
</style>
@endsection

@section('js_script')
    <script src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <script src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/global/plugins/image-picker/image-picker.min.js"></script>
    <script src="/js/ckeditor/ckeditor.js"></script>
    <script src="/assets/apps/scripts/admin/notes.js"></script>
@endsection
