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
                    <form id="data-form" class="form-horizontal" role="form" method="post">
                    	{{ csrf_field() }}
                        <input type="hidden" name="t_id" value="{{ isset($data->t_id)? $data->t_id : '0' }}" />
                        <input type="hidden" id="role_permission" value="{{ isset($role_permission)? $role_permission : '' }}" />
                        <div class="form-body">
                        	<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">行程名稱：</div>
									<div class="col-md-9">
										<p class="form-control-static">
											{{ isset($data->t_title)? $data->t_title : '' }}
										</p>
									</div>
								</div>
							</div>

                            <div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-4">不接單開始日：</div>
									<div class="col-md-8">
										<div class="input-icon right">
											<input class="form-control form-control-inline input-medium date-picker" data-date-format="yyyy-mm-dd" name="not_accept_start" size="16" type="text" value="{{ isset($data->not_accept_start)? $data->not_accept_start : '' }}" />
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="control-label col-md-4">不接單結束日：</div>
									<div class="col-md-8">
										<div class="input-icon right">
											<input class="form-control form-control-inline input-medium date-picker" data-date-format="yyyy-mm-dd" name="not_accept_end" size="16" type="text" value="{{ isset($data->not_accept_end)? $data->not_accept_end : '' }}" />
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">不接單原因：</div>
									<div class="col-md-10">
							            <textarea name="not_accept_reason" class="form-control" rows="3">{{ isset($data->not_accept_reason)? $data->not_accept_reason : '' }}</textarea>
									</div>
								</div>
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


@section('css_link')
<link href="/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('js_script')
    <script src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <script src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/apps/scripts/admin/tour_notaccept_date.js"></script>
@endsection
