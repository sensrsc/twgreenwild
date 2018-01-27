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
                        <span class="caption-subject font-blue-madison bold uppercase">相簿資料</span>
                    </div>
                </div>                
                <div class="portlet-body form">                    
                    <form id="data-form" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    	{{ csrf_field() }}
                        <input type="hidden" name="a_id" value="{{ isset($data['a_id'])? $data['a_id'] : '0' }}" />
                        <input type="hidden" id="role_permission" value="{{ isset($role_permission)? $role_permission : '' }}" />
                        <div class="form-body">
                        	<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">相簿名稱：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="相簿名稱" class="form-control" name="a_title" value="{{ isset($data['a_title'])? $data['a_title'] : '' }}" />
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
									<div class="control-label col-md-3">相簿說明：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="相簿說明" class="form-control" name="a_description" value="{{ isset($data['a_description'])? $data['a_description'] : '' }}" />
										</div>
									</div>
								</div>
	                            <div class="col-md-6">
	                            	<div class="control-label col-md-3">狀態：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<select class="form-control" name="a_status">
												<option value="">請選擇</option>
												@if (!empty(config('common.general_status')))
													@foreach (config('common.general_status') as $status => $statusTitle)
														<option value="{{ $status }}" {{ (isset($data['a_status']) && $data['a_status'] == $status)? 'selected' : '' }}> {{ $statusTitle }} </option>
													@endforeach
												@endif		
											</select>
										</div>
									</div>
	                           	</div>
                            </div>

                            <div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">外部連結：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="外部連結 url" class="form-control" name="a_outside_link" value="{{ isset($data['a_outside_link'])? $data['a_outside_link'] : '' }}" />
										</div>
									</div>
								</div>
							</div>
			
                        	
	                        <div class="form-actions right">
	                            <a href="/admin/album" class="btn btn-default"> 返回相簿列表 </a>
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
    <script src="/assets/apps/scripts/admin/album.js"></script>
@endsection
