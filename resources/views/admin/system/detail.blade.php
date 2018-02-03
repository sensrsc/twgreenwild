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
                        <span class="caption-subject font-blue-madison bold uppercase">系統變數資料</span>
                    </div>
                </div>                
                <div class="portlet-body form">                    
                    <form id="data-form" class="form-horizontal" role="form" method="post">
                    	{{ csrf_field() }}
                        <input type="hidden" name="sv_id" value="{{ isset($data->sv_id)? $data->sv_id : '0' }}" />
                        <input type="hidden" id="role_permission" value="{{ isset($role_permission)? $role_permission : '' }}" />
                        <div class="form-body">
                        	<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">變數說明：</div>
									<div class="col-md-10">
										<div class="input-icon right">
											<input type="text" placeholder="變數說明" class="form-control" name="sv_name" value="{{ isset($data->sv_name)? $data->sv_name : '' }}" />
										</div>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">變數名稱(key)：</div>
									<div class="col-md-10">
										<div class="input-icon right">
											<input type="text" placeholder="變數名稱(key)" class="form-control" name="sv_key" value="{{ isset($data->sv_key)? $data->sv_key : '' }}" />
										</div>
									</div>
								</div>
							</div>
							


                        	<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">變數值：</div>
									<div class="col-md-10">
								        <textarea name="sv_value" class="form-control" rows="3">{{ isset($data->sv_value)? $data->sv_value : '' }}</textarea>
									</div>
								</div>
							</div>
                        
                        <div class="form-actions right">
                            <a href="/admin/system" class="btn btn-default"> 返回系統變數列表 </a>
                            <button class="btn green" id="data-form-btn" type="submit"> 儲存修改 </button>
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
    <script src="/assets/apps/scripts/admin/system_variable.js"></script>
@endsection
