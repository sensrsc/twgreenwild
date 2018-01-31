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
                        <input type="hidden" name="t_id" value="{{ isset($data->t_id)? $data->t_id : '0' }}" />
                        <input type="hidden" id="role_permission" value="{{ isset($role_permission)? $role_permission : '' }}" />
                        <div class="form-body">
                        	<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">行程名稱：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="行程名稱" class="form-control" name="t_title" value="{{ isset($data->t_title)? $data->t_title : '' }}" />
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
				                            		<option value="{{ $category->c_id }}" {{ (isset($data->c_id) && $data->c_id == $category->c_id)? 'selected' : '' }}>{{ $category->c_title }}</option>
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
					                            		<option value="{{ $area->area_id }}" {{ (isset($data->area_id) && $data->area_id == $area->area_id)? 'selected' : '' }}>{{ $area->area_name }}</option>
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
											<select class="form-control" name="t_status">
												<option value="">請選擇</option>
												@if (!empty(config('common.general_status')))
													@foreach (config('common.general_status') as $status => $statusTitle)
														<option value="{{ $status }}" {{ (isset($data->t_status) && $data->t_status == $status)? 'selected' : '' }}> {{ $statusTitle }} </option>
													@endforeach
												@endif		
											</select>
										</div>
									</div>
	                           	</div>
                            </div>

                            <div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">最低人數：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="number" placeholder="最低人數" class="form-control" name="min_people" value="{{ isset($data->min_people)? $data->min_people : '' }}" />
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="control-label col-md-3">滿團人數：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="number" placeholder="滿團人數" class="form-control" name="full_people" value="{{ isset($data->full_people)? $data->full_people : '' }}" />
										</div>
									</div>
								</div>
							</div>

                            <div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">行程價格：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="number" placeholder="行程價格" class="form-control" name="t_price" value="{{ isset($data->t_price)? $data->t_price : '' }}" />
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="control-label col-md-3">接單截止日：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="number" placeholder="接單截止日" class="form-control" name="days_apply" value="{{ isset($data->days_apply)? $data->days_apply : '' }}" />
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2"> 行程說明：</div>
									<div class="col-md-10">
							            <textarea name="t_description" class="form-control {{ isset($data->t_description)? $data->t_description : '' }}" rows="3"></textarea>
									</div>
								</div>
							</div>

							<hr />

                             <div id="description_block">

                             	@if (isset($data))
                             		@each('admin.tour.description', $data->descriptions, 'data')
                             	@endif

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
    <script src="/js/ckeditor/ckeditor.js"></script>
    <script src="/assets/apps/scripts/admin/tour.js"></script>
@endsection
