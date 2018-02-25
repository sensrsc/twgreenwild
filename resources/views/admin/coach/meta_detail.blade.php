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
                        <span class="caption-subject font-blue-madison bold uppercase">{{ $coach->c_name . config('common.coach_meta_types')[$type] }}資料</span>
                    </div>
                </div>                
                <div class="portlet-body form">                    
                    <form id="data-form" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    	{{ csrf_field() }}
                        <input type="hidden" name="cm_id" value="{{ isset($data['cm_id'])? $data['cm_id'] : '0' }}" />
                        <input type="hidden" name="cm_cid" value="{{ $coach->c_id }}" />
                        <input type="hidden" name="cm_type" value="{{ $type }}" />
                        <input type="hidden" id="role_permission" value="{{ isset($role_permission)? $role_permission : '' }}" />
                        <div class="form-body">
                        	<div class="form-group">
								<div class="col-md-6">
									<div class="control-label col-md-3">名稱：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="名稱" class="form-control" name="cm_name" value="{{ isset($data['cm_name'])? $data['cm_name'] : '' }}" />
										</div>
									</div>
								</div>
                                @if ($type == 2)
                                <div class="col-md-6">
                                   <label class="control-label col-md-3">證照：</label>
                                   <div class="col-md-9">                                  
                                       <div class="fileinput fileinput-new" data-provides="fileinput">
                                           <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                                   @if (isset($data['cm_picture']))
                                                           <img src="/upload/coach/license/{{ $data['cm_picture'] }}" alt="" />
                                                   @endif
                                           </div>
                                           <div>
                                               <span class="btn btn-default btn-file"><span class="fileinput-new">選擇圖片</span><span class="fileinput-exists">更換圖片</span>
                                               <input type="file" name="cm_picture"></span>
                                               <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">移除圖片</a>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               @endif
							</div>
                        	
	                        <div class="form-actions right">
	                            <a href="/admin/coachmeta/index/{{ $type }}/{{ $coach->c_id }}" class="btn btn-default"> 返回{{ config('common.coach_meta_types')[$type] }}列表 </a>
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
@endsection

@section('js_script')
    <script src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
    <script src="/assets/apps/scripts/admin/coach_meta.js"></script>
@endsection
