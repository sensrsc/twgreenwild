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
                        <span class="caption-subject font-blue-madison bold uppercase">管理者資料</span>
                    </div>
                </div>                
                <div class="portlet-body form">                    
                    <form id="data-form" class="form-horizontal" role="form" method="post">
                    	{{ csrf_field() }}
                        <input type="hidden" name="a_id" value="{{ isset($data['a_id'])? $data['a_id'] : '0' }}" />
                        <input type="hidden" id="role_permission" value="{{ isset($role_permission)? $role_permission : '' }}" />
                        <div class="form-body">
                        	<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">帳號：</div>
									<div class="col-md-10">
										<div class="input-icon right">
											<input type="text" placeholder="帳號" class="form-control" name="a_account" value="{{ isset($data['a_account'])? $data['a_account'] : '' }}" />
										</div>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">密碼：</div>
									<div class="col-md-10">
										<div class="input-icon right">
											<input type="password" placeholder="密碼" class="form-control" name="a_password" id="a_password" autocomplete="off" />
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">確認密碼：</div>
									<div class="col-md-10">
										<div class="input-icon right">
											<input type="password" placeholder="確認密碼" class="form-control" name="re_password" id="re_password"  autocomplete="off" />
										</div>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">暱稱：</div>
									<div class="col-md-10">
										<div class="input-icon right">
											<input type="text" placeholder="暱稱" class="form-control" name="a_name" value="{{ isset($data['a_name'])? $data['a_name'] : '' }}" />
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">Email：</div>
									<div class="col-md-10">
										<div class="input-icon right">
											<input type="text" placeholder="Email" class="form-control" name="a_email" value="{{ isset($data['a_email'])? $data['a_email'] : '' }}" />
										</div>
									</div>
								</div>
							</div>
                        	<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">狀態：</div>
									<div class="col-md-10">
										<div class="input-icon right">
											<select class="form-control" name="a_status">
												<option value="">請選擇</option>
												@if (!empty($adminStatus))
													@foreach ($adminStatus as $status => $status_title)
														<option value="{{ $status }}" {{ (isset($data['a_status']) && $data['a_status'] == $status)? 'selected' : '' }}> {{ $status_title }} </option>
													@endforeach
												@endif		
											</select>
										</div>
									</div>
								</div>
							</div>
                        
                        <div class="form-actions right">
                            <a href="" class="btn btn-default"> 返回管理者列表 </a>
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
    <script src="/assets/apps/scripts/admin/admin.js"></script>
@endsection
