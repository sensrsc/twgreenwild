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
                        <span class="caption-subject font-blue-madison bold uppercase">行程資料</span>
                    </div>
                </div>                
                <div class="portlet-body form">                    
                    <form id="data-form" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    	{{ csrf_field() }}
                        <input type="hidden" name="t_id" value="{{ isset($data['t_id'])? $data['t_id'] : '0' }}" />
                        <input type="hidden" id="role_permission" value="{{ isset($role_permission)? $role_permission : '' }}" />
                        <div class="form-body">
                        	<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">行程名稱：</div>
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
	                            	<div class="control-label col-md-3">地區：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<select class="form-control" name="area_id">
												<option value="">請選擇</option>
												@if (isset($areas))
					                            	@foreach ($areas as $area)
					                            		<option value="{{ $area->area_id }}" {{ (isset($data['area_id']) && $data['area_id'] == $category->c_id)? 'selected' : '' }}>{{ $area->area_name }}</option>
					                            	@endforeach
					                            @endif
											</select>
										</div>
									</div>
	                           	</div>
	                           	<div class="col-md-6">
	                            	<div class="control-label col-md-3">等級：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<select class="form-control" name="cl_id">
												<option value="">請選擇</option>
											</select>
										</div>
									</div>
	                           	</div>
                            </div>

							<div class="form-group">
								<div class="col-md-6">
	                            	<div class="control-label col-md-3">相簿：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<select class="form-control" name="a_id">
												<option value="">請選擇</option>
											</select>
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
									<div class="control-label col-md-3">行程價格：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="number" placeholder="行程價格" class="form-control" name="t_price" value="{{ isset($data['t_price'])? $data['t_price'] : '' }}" />
										</div>
									</div>
								</div>
							</div>

                             <div class="form-group">

                             </div>
                        	
	                        <div class="form-actions right">
	                            <a href="/admin/tour" class="btn btn-default"> 返回行程列表 </a>
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
    <script src="/assets/apps/scripts/admin/tour.js"></script>
@endsection
