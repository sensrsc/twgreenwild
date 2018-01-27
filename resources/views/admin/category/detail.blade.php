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
                        <span class="caption-subject font-blue-madison bold uppercase">行程分類資料</span>
                    </div>
                </div>                
                <div class="portlet-body form">                    
                    <form id="data-form" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    	{{ csrf_field() }}
                        <input type="hidden" name="c_id" value="{{ isset($data['c_id'])? $data['c_id'] : '0' }}" />
                        <input type="hidden" id="role_permission" value="{{ isset($role_permission)? $role_permission : '' }}" />
                        <div class="form-body">
                        	<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">分類名稱：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="分類名稱" class="form-control" name="c_title" value="{{ isset($data['c_title'])? $data['c_title'] : '' }}" />
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="control-label col-md-3">分類區塊：</div>
									<div class="col-md-9">
										<select id="country" name="num" class="form-control country">
			                            	@for ($i = 1; $i <= 10; $i ++)
			                            		<option value="{{ $i }}" {{ !empty($descriptions) && $descriptions->count() == $i ? 'selected' : '' }}>{{ $i }}</option>
			                            	@endfor
				                        </select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6">
	                                <label class="control-label col-md-3">報名檔案：</label>
	                                <div class="col-md-9">
	                                    <div class="fileinput fileinput-new" data-provides="fileinput">
	                                        <div class="input-group input-large">
	                                            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
	                                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
	                                                <span class="fileinput-filename"> </span>
	                                            </div>
	                                            <span class="input-group-addon btn default btn-file">
	                                                <span class="fileinput-new"> Select file </span>
	                                                <span class="fileinput-exists"> Change </span>
	                                                <input type="file" name="c_file"> </span>
	                                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                            	<div class="control-label col-md-3">狀態：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<select class="form-control" name="c_status">
												<option value="">請選擇</option>
												@if (!empty(config('common.general_status')))
													@foreach (config('common.general_status') as $status => $statusTitle)
														<option value="{{ $status }}" {{ (isset($data['c_status']) && $data['c_status'] == $status)? 'selected' : '' }}> {{ $statusTitle }} </option>
													@endforeach
												@endif		
											</select>
										</div>
									</div>
	                           	</div>
                            </div>
							
							<div class="row" id="description_block">
								@if (!empty($descriptions) && $descriptions->count() > 0)
									@foreach ($descriptions as $desc)
										@include('admin.category.descriptions', ['data' => $desc])
									@endforeach
								@else
									@include('admin.category.descriptions')
								@endif
							</div>
                        	
	                        <div class="form-actions right">
	                            <a href="/admin/category" class="btn btn-default"> 返回行程分類列表 </a>
	                            <button class="btn green" id="data-form-btn" type="submit"> 儲存修改 </button>
	                        </div>
                    	</div>
                	</form>
            	</div>
        	</div>
    	</div>
	</div>
</div>

<div id="description_temp" style="display: none;">
	@include('admin.category.descriptions')
</div>
@endsection

@section('css_link')
	<link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endsection

@section('js_script')
    <script src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
    <script src="/assets/apps/scripts/admin/category.js"></script>
@endsection
