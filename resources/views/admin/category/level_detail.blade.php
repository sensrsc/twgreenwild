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
                        <span class="caption-subject font-blue-madison bold uppercase">{{ $category->c_title }} 行程分類等級資料</span>
                    </div>
                </div>                
                <div class="portlet-body form">                    
                    <form id="data-form" class="form-horizontal" role="form" method="post">
                    	{{ csrf_field() }}
                    	<input type="hidden" name="cl_id" value="{{ isset($data['cl_id'])? $data['cl_id'] : '0' }}" />
                        <input type="hidden" name="c_id" value="{{ $category->c_id }}" />
                        <input type="hidden" id="role_permission" value="{{ isset($role_permission)? $role_permission : '' }}" />
                        <div class="form-body">
                        	<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">等級名稱：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="等級名稱" class="form-control" name="cl_title" value="{{ isset($data['cl_title'])? $data['cl_title'] : '' }}" />
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="control-label col-md-3">等級狀態：</div>
									<div class="col-md-9">
										<select id="country" name="cl_status" class="form-control country">
			                            	<option value="">請選擇</option>
											@if (!empty(config('common.general_status')))
												@foreach (config('common.general_status') as $status => $statusTitle)
													<option value="{{ $status }}" {{ (isset($data['cl_status']) && $data['cl_status'] == $status)? 'selected' : '' }}> {{ $statusTitle }} </option>
												@endforeach
											@endif
				                        </select>
									</div>
								</div>
							</div>
                        	
	                        <div class="form-actions right">
	                            <a href="/admin/level/index/{{ $category->c_id }}" class="btn btn-default"> 返回行程分類等級列表 </a>
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

@section('js_script')
    <script src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <script src="/assets/apps/scripts/admin/category_level.js"></script>
@endsection
