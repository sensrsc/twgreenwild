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
                        <span class="caption-subject font-blue-madison bold uppercase">預約叫車資料</span>
                    </div>
                </div>                
                <div class="portlet-body form">                    
                    <form id="data-form" class="form-horizontal" role="form" method="post">
                    	{{ csrf_field() }}
                        <input type="hidden" name="cro_id" value="{{ isset($data->cro_id)? $data->cro_id : '0' }}" />
                        <input type="hidden" id="role_permission" value="{{ isset($role_permission)? $role_permission : '' }}" />
                        <div class="form-body">
                        	<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-4">接送類型：</div>
									<div class="col-md-8">
                                        <p class="form-control-static"> {{ $data->cro_type }} </p>
                                    </div>
								</div>
								<div class="col-md-6">
									<div class="control-label col-md-4">車型：</div>
									<div class="col-md-8">
                                        <p class="form-control-static"> {{ $data->cro_car_model }} </p>
                                    </div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-4">縣市：</div>
									<div class="col-md-8">
                                        <p class="form-control-static"> {{ $data->cro_city }} </p>
                                    </div>
								</div>
								<div class="col-md-6">
									<div class="control-label col-md-4">行政區：</div>
									<div class="col-md-8">
                                        <p class="form-control-static"> {{ $data->cro_district }} </p>
                                    </div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-4">大人人數：</div>
									<div class="col-md-8">
                                        <p class="form-control-static"> {{ $data->cro_adult }} </p>
                                    </div>
								</div>
								<div class="col-md-6">
									<div class="control-label col-md-4">小孩人數：</div>
									<div class="col-md-8">
                                        <p class="form-control-static"> {{ $data->cro_children }} </p>
                                    </div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-4">預約者姓名：</div>
									<div class="col-md-8">
                                        <p class="form-control-static"> {{ $data->cro_name }} </p>
                                    </div>
								</div>
								<div class="col-md-6">
									<div class="control-label col-md-4">預約者電話：</div>
									<div class="col-md-8">
                                        <p class="form-control-static"> {{ $data->cro_telno }} </p>
                                    </div>
								</div>
							</div>




							
                        
	                        <div class="form-actions right">
	                            <a href="/admin/reserveorder" class="btn btn-default"> 返回預約叫車列表 </a>
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

@section('js_script')
    <script src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <script src="/assets/apps/scripts/admin/admin.js"></script>
@endsection
