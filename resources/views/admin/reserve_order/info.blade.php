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
								<div class="col-md-12">
									<div class="control-label col-md-2">預約單號：</div>
									<div class="col-md-10">
                                        <p class="form-control-static"> {{ $data->order_id }} </p>
                                    </div>
								</div>
							</div>

                        	<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">接送類型：</div>
									<div class="col-md-10">
                                        <p class="form-control-static"> {{ isset(config('common.reserve_type')[$data->cro_type])? config('common.reserve_type')[$data->cro_type] : '' }} {{ $data->cro_type == 'airport'? '（' . $data->cro_way . '）' : '' }}</p>
                                    </div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">姓名：</div>
									<div class="col-md-10">
                                        <p class="form-control-static"> {{ $data->cro_name }} </p>
                                    </div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">電話：</div>
									<div class="col-md-10">
                                        <p class="form-control-static"> {{ $data->cro_telno }} </p>
                                    </div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">地址：</div>
									<div class="col-md-10">
                                        <p class="form-control-static"> {{ $data->address }} </p>
                                    </div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">車款：</div>
									<div class="col-md-10">
                                        <p class="form-control-static"> {{ $data->cro_car_model }} </p>
                                    </div>
								</div>
							</div>

							@if ($data->cro_type == 'airport')
								@if ($data->cro_way == '去程' || $data->cro_way == '來回')
									<div class="form-group">
										<div class="col-md-12">
											<div class="control-label col-md-2">去程日期：</div>
											<div class="col-md-10">
		                                        <p class="form-control-static"> {{ $data->cro_detail->date_go }} </p>
		                                    </div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<div class="control-label col-md-2">去程時間：</div>
											<div class="col-md-10">
		                                        <p class="form-control-static"> {{ $data->cro_detail->time_go }} </p>
		                                    </div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<div class="control-label col-md-2">去程：</div>
											<div class="col-md-10">
		                                        <p class="form-control-static"> 機場 桃園國際機場 {{ $data->cro_detail->airport_go }} </p>
		                                    </div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<div class="control-label col-md-2">去程大人人數：</div>
											<div class="col-md-10">
		                                        <p class="form-control-static"> {{ $data->cro_detail->go_adult }} </p>
		                                    </div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<div class="control-label col-md-2">去程小孩人數：</div>
											<div class="col-md-10">
		                                        <p class="form-control-static"> {{ $data->cro_detail->go_children }} </p>
		                                    </div>
										</div>
									</div>
								@endif
								@if ($data->cro_way == '回程' || $data->cro_way == '來回')
									<div class="form-group">
										<div class="col-md-12">
											<div class="control-label col-md-2">回程日期：</div>
											<div class="col-md-10">
		                                        <p class="form-control-static"> {{ $data->cro_detail->date_back }} </p>
		                                    </div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<div class="control-label col-md-2">回程時間：</div>
											<div class="col-md-10">
		                                        <p class="form-control-static"> {{ $data->cro_detail->time_back }} </p>
		                                    </div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<div class="control-label col-md-2">回程：</div>
											<div class="col-md-10">
		                                        <p class="form-control-static"> 機場 桃園國際機場 {{ $data->cro_detail->airport_back }} </p>
		                                    </div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<div class="control-label col-md-2">航班：</div>
											<div class="col-md-10">
		                                        <p class="form-control-static"> {{ $data->cro_detail->flight }} </p>
		                                    </div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<div class="control-label col-md-2">回程大人人數：</div>
											<div class="col-md-10">
		                                        <p class="form-control-static"> {{ $data->cro_detail->back_adult }} </p>
		                                    </div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<div class="control-label col-md-2">回程小孩人數：</div>
											<div class="col-md-10">
		                                        <p class="form-control-static"> {{ $data->cro_detail->back_children }} </p>
		                                    </div>
										</div>
									</div>
								@endif
							@else 
								<div class="form-group">
									<div class="col-md-12">
										<div class="control-label col-md-2">日期：</div>
										<div class="col-md-10">
	                                        <p class="form-control-static"> {{ $data->cro_detail->date }} </p>
	                                    </div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12">
										<div class="control-label col-md-2">時間：</div>
										<div class="col-md-10">
	                                        <p class="form-control-static"> {{ $data->cro_detail->time }} </p>
	                                    </div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12">
										<div class="control-label col-md-2">大人人數：</div>
										<div class="col-md-10">
	                                        <p class="form-control-static"> {{ $data->cro_adult }} </p>
	                                    </div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12">
										<div class="control-label col-md-2">小孩人數：</div>
										<div class="col-md-10">
	                                        <p class="form-control-static"> {{ $data->cro_children }} </p>
	                                    </div>
									</div>
								</div>
							@endif

							<div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">價格：</div>
									<div class="col-md-10">
                                        <p class="form-control-static"> {{ $data->cro_est_fee }} </p>
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
