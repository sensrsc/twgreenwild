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
                        <span class="caption-subject font-blue-madison bold uppercase">首頁輪播資料</span>
                    </div>
                </div>                
                <div class="portlet-body form">                    
                    <form id="data-form" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    	{{ csrf_field() }}
                        <input type="hidden" name="is_id" value="{{ isset($data->is_id)? $data->is_id : '0' }}" />
                        <input type="hidden" id="role_permission" value="{{ isset($role_permission)? $role_permission : '' }}" />
                        <div class="form-body">
                        	<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">名稱：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="名稱" class="form-control" name="is_title" value="{{ isset($data->is_title)? $data->is_title : '' }}" />
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="control-label col-md-3">輪播連結：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="輪播連結" class="form-control" name="is_link" value="{{ isset($data->is_link)? $data->is_link : '' }}" />
										</div>
									</div>
								</div>
							</div>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="control-label col-md-3">開始日：</div>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <input class="form-control form-control-inline date-picker" data-date-format="yyyy-mm-dd" name="is_start" size="16" type="text" value="{{ isset($data->is_start)? $data->is_start : '' }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="control-label col-md-3">結束日：</div>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <input class="form-control form-control-inline date-picker" data-date-format="yyyy-mm-dd" name="is_end" size="16" type="text" value="{{ isset($data->is_end)? $data->is_end : '' }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>

							<div class="form-group">
								<div class="col-md-6">
                                   <label class="control-label col-md-3">輪播圖：</label>
                                   <div class="col-md-9">                                  
                                       <div class="fileinput fileinput-new" data-provides="fileinput">
                                           <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                                   @if (isset($data->is_file))
                                                        <img src="{{ $data->picturePath }}" alt="" />
                                                   @endif
                                           </div>
                                           <div>
                                               <span class="btn btn-default btn-file"><span class="fileinput-new">選擇圖片</span><span class="fileinput-exists">更換圖片</span>
                                               <input type="file" name="is_file"></span>
                                               <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">移除圖片</a>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                            </div>
                        	
	                        <div class="form-actions right">
	                            <a href="/admin/slide" class="btn btn-default"> 返回首頁輪播列表 </a>
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
<link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
<link href="/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('js_script')
    <script src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
    <script src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/apps/scripts/admin/slide.js"></script>
@endsection
