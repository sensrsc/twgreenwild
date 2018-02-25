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
                        <span class="caption-subject font-blue-madison bold uppercase">教練資料</span>
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
									<div class="control-label col-md-3">名字：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="名字" class="form-control" name="c_name" value="{{ isset($data['c_name'])? $data['c_name'] : '' }}" />
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="control-label col-md-3">座右銘：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="座右銘" class="form-control" name="c_motto" value="{{ isset($data['c_motto'])? $data['c_motto'] : '' }}" />
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6">
                                   <label class="control-label col-md-3">大頭照：</label>
                                   <div class="col-md-9">                                  
                                       <div class="fileinput fileinput-new" data-provides="fileinput">
                                           <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                                   @if (isset($data['c_avatar']))
                                                           <img src="/upload/coach/{{ $data['c_avatar'] }}" alt="" />
                                                   @endif
                                           </div>
                                           <div>
                                               <span class="btn btn-default btn-file"><span class="fileinput-new">選擇圖片</span><span class="fileinput-exists">更換圖片</span>
                                               <input type="file" name="c_avatar"></span>
                                               <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">移除圖片</a>
                                           </div>
                                       </div>
                                   </div>
                               </div>
								<div class="col-md-6">
									<div class="control-label col-md-3">排序：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="number" min="1" placeholder="" class="form-control" name="c_seq" value="{{ isset($data['c_seq'])? $data['c_seq'] : '' }}" />
										</div>
									</div>
								</div>
                            </div>

                            <div class="form-group">
								<div class="col-md-12">
									<div class="control-label col-md-2">專長：</div>
									<div class="col-md-10">
										<div class="input-icon right">
											<textarea placeholder="專長" class="form-control" name="c_specialty" rows="5">{{ isset($data['c_specialty'])? $data['c_specialty'] : '' }}</textarea>
										</div>
									</div>
								</div>
                            </div>

                        	
	                        <div class="form-actions right">
	                            <a href="/admin/coach" class="btn btn-default"> 返回教練列表 </a>
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
    <script src="/assets/apps/scripts/admin/coach.js"></script>
@endsection
