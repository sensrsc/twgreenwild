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
                        <span class="caption-subject font-blue-madison bold uppercase">訂單資料</span>
                    </div>
                </div>                
                <div class="portlet-body form">                    
                    <form id="data-form" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    	{{ csrf_field() }}
                        <input type="hidden" name="o_id" value="{{ isset($data->o_id)? $data->o_id : '0' }}" />
                        <input type="hidden" id="role_permission" value="{{ isset($role_permission)? $role_permission : '' }}" />
                        <div class="form-body">
                        	<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">會員帳號：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="會員帳號" class="form-control" name="account" value="{{ isset($user->u_account)? $user->u_account : '' }}" />
										</div>
									</div>
								</div>
								<div class="col-md-6">
	                            	<div class="control-label col-md-3">行程：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<select class="form-control" name="t_id">
												<option value="">請選擇</option>
												@if (isset($data->t_id))
													<option value="{{ $data->t_id }}" data-price="{{ $data->tour->t_price }}" data-dayprice="{{ $data->tour->t_weekday_price }}" data-discountprice="{{ $data->tour->t_discount_price }}" selected="selected">{{ $data->tour->t_title }}</option>
												@endif
											</select>
										</div>
									</div>
	                           	</div>
							</div>

                        	<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">日期：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="日期" class="form-control date-picker" name="apply_date" data-date-format="yyyy-mm-dd" value="{{ isset($data->apply_date)? $data->apply_date : '' }}" />
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="control-label col-md-3">人數：</div>
									<div class="col-md-9">
										<div class="col-md-6">
											<div class="input-icon right">
												<input type="number" min="0" placeholder="大人人數" class="form-control" name="adult_num" value="{{ isset($data->adult_num)? $data->adult_num : 1 }}" />
											</div>
										</div>

										<div class="col-md-6">
											<div class="input-icon right">
												<input type="number" min="0" placeholder="小孩人數" class="form-control" name="child_num" value="{{ isset($data->child_num)? $data->child_num : 0 }}" />
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">需車輛接送：</div>
									<div class="col-md-9 checkbox-list">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" id="inlineCheckbox1" name="car_need" value="1"> </label>
                                    </div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">姓名：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="姓名" class="form-control" name="apply_name" value="{{ isset($data->apply_name)? $data->apply_name : '' }}" />
										</div>
									</div>
								</div>
								<div class="col-md-6">
	                            	<div class="control-label col-md-3">性別：</div>
									<div class="col-md-9 radio-list">
										<div class="input-icon right">
											<label class="radio-inline">
                                                <input type="radio" name="apply_gender" id="optionsRadios0" value="0" {{ isset($data->apply_gender) && $data->apply_gender == 0? 'checked' : 'checked' }}> 女 </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="apply_gender" id="optionsRadios1" value="1" {{ isset($data->apply_gender) && $data->apply_gender == 1? 'checked' : '' }}> 男 </label>
										</div>
									</div>
	                           	</div>
							</div>

							<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">電話：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="電話" class="form-control" name="apply_phone" value="{{ isset($data->apply_phone)? $data->apply_phone : '' }}" />
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="control-label col-md-3">地址：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="地址" class="form-control" name="apply_address" value="{{ isset($data->apply_address)? $data->apply_address : '' }}" />
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">信箱：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="email" placeholder="信箱" class="form-control" name="apply_email" value="{{ isset($data->apply_email)? $data->apply_email : '' }}" />
										</div>
									</div>
								</div>
								
							</div>

							<div id="personal" class="hide">
								<div class="form-group">
									<div class="col-md-6">
										<div class="control-label col-md-3">身份證號：</div>
										<div class="col-md-9">
											<div class="input-icon right">
												<input type="text" placeholder="身份證號" class="form-control" name="apply_identity" value="{{ isset($data->o_detail->apply_identity)? $data->o_detail->apply_identity : '' }}" />
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="control-label col-md-3">生日：</div>
										<div class="col-md-9">
											<div class="input-icon right">
												<input type="text" placeholder="生日" class="form-control date-picker" name="apply_birthday" data-date-format="yyyy-mm-dd" value="{{ isset($data->o_detail->apply_birthday)? $data->o_detail->apply_birthday : '' }}" />
											</div>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<div class="col-md-6">
										<div class="control-label col-md-3">身高：</div>
										<div class="col-md-9">
											<div class="input-icon right">
												<input type="text" placeholder="身高" class="form-control" name="apply_height" value="{{ isset($data->o_detail->apply_height)? $data->o_detail->apply_height : '' }}" />
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="control-label col-md-3">體重：</div>
										<div class="col-md-9">
											<div class="input-icon right">
												<input type="text" placeholder="體重" class="form-control" name="apply_weight" value="{{ isset($data->o_detail->apply_weight)? $data->o_detail->apply_weight : '' }}" />
											</div>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-6">
										<div class="control-label col-md-3">腳掌：</div>
										<div class="col-md-9">
											<div class="input-icon right">
												<input type="text" placeholder="腳掌" class="form-control" name="apply_foot" value="{{ isset($data->o_detail->apply_foot)? $data->o_detail->apply_foot : '' }}" />
											</div>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-6">
										<div class="control-label col-md-3">緊急聯絡人姓名：</div>
										<div class="col-md-9">
											<div class="input-icon right">
												<input type="text" placeholder="聯絡人姓名" class="form-control" name="apply_emergency_name" value="{{ isset($data->o_detail->apply_emergency_name)? $data->o_detail->apply_emergency_name : '' }}" />
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="control-label col-md-3">緊急聯絡人電話：</div>
										<div class="col-md-9">
											<div class="input-icon right">
												<input type="text" placeholder="緊急聯絡人電話" class="form-control" name="apply_emergency_phone" value="{{ isset($data->o_detail->apply_emergency_phone)? $data->o_detail->apply_emergency_phone : '' }}" />
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">金額：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="number" placeholder="金額" class="form-control" name="total_price" value="{{ isset($data->total_price)? $data->total_price : '' }}" />
										</div>
									</div>
								</div>
	                            <div class="col-md-6">
	                            	<div class="control-label col-md-3">狀態：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<select class="form-control" name="o_status">
												<option value="">請選擇</option>
												@if (!empty(config('common.order_status')))
													@foreach (config('common.order_status') as $status => $statusTitle)
														<option value="{{ $status }}" {{ (isset($data->o_status) && $data->o_status == $status)? 'selected' : '' }}> {{ $statusTitle }} </option>
													@endforeach
												@endif		
											</select>
										</div>
									</div>
	                           	</div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="control-label col-md-2">會員備註：</div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <div class="input-icon right">
                                                    <textarea name="apply_memo" id="apply_memo"
                                                        class="form-control todo-taskbody-taskdesc" rows="8"
                                                        placeholder="內容">{{ isset($data->apply_memo) ? $data->apply_memo : '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        	
	                        <div class="form-actions right">
	                            <a href="/admin/order" class="btn btn-default"> 返回訂單列表 </a>
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
<link href="/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('js_script')
    <script src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <script src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/global/plugins/select2/js/select2.full.min.js"></script>
    <script src="/assets/apps/scripts/admin/order.js"></script>
@endsection
