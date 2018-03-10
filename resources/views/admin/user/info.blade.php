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
                        <span class="caption-subject font-blue-madison bold uppercase">會員資料</span>
                    </div>
                </div>                
                <div class="portlet-body form">                    
                    <form id="data-form" class="form-horizontal" role="form" method="post">
                        <input type="hidden" name="cro_id" value="{{ isset($data->cro_id)? $data->cro_id : '0' }}" />
                        <input type="hidden" id="role_permission" value="{{ isset($role_permission)? $role_permission : '' }}" />
                        <div class="form-body">

                        	<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">帳號：</div>
									<div class="col-md-10">
                                        <p class="form-control-static"> {{ $data->u_account }} </p>
                                    </div>
								</div>
							</div>

                        	<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">姓名：</div>
									<div class="col-md-10">
                                        <p class="form-control-static"> {{ $data->u_name }} </p>
                                    </div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">電話：</div>
									<div class="col-md-10">
                                        <p class="form-control-static"> {{ $data->u_phone }} </p>
                                    </div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">姓別：</div>
									<div class="col-md-10">
                                        <p class="form-control-static"> {{ $data->u_gender }} </p>
                                    </div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">生日：</div>
									<div class="col-md-10">
                                        <p class="form-control-static"> {{ $data->u_birthday }} </p>
                                    </div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">身高：</div>
									<div class="col-md-10">
                                        <p class="form-control-static"> {{ $data->u_height }} </p>
                                    </div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">體重：</div>
									<div class="col-md-10">
                                        <p class="form-control-static"> {{ $data->u_weight }} </p>
                                    </div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">腳掌長：</div>
									<div class="col-md-10">
                                        <p class="form-control-static"> {{ $data->u_foot }} </p>
                                    </div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">緊急聯絡人姓名：</div>
									<div class="col-md-10">
                                        <p class="form-control-static"> {{ $data->u_emergency_name }} </p>
                                    </div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">緊急聯絡人電話：</div>
									<div class="col-md-10">
                                        <p class="form-control-static"> {{ $data->u_emergency_phone }} </p>
                                    </div>
								</div>
							</div>

	                        <div class="form-actions right">
	                            <a href="/admin/user" class="btn btn-default"> 返回會員資料列表 </a>
	                            <!-- <button class="btn green" id="data-form-btn" type="submit"> 儲存修改 </button> -->
	                        </div>
	                    </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

