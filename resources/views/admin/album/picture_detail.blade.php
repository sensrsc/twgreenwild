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
                        <span class="caption-subject font-blue-madison bold uppercase">相片資料</span>
                    </div>
                </div>                
                <div class="portlet-body form">                    
                    <form id="data-form" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    	{{ csrf_field() }}
                    	<input type="hidden" name="ap_id" value="{{ isset($data['ap_id'])? $data['ap_id'] : '0' }}" />
                        <input type="hidden" name="a_id" value="{{ $album->a_id }}" />
                        <input type="hidden" id="role_permission" value="{{ isset($role_permission)? $role_permission : '' }}" />
                        <div class="form-body">

                        	<div class="form-group">
                        		<!-- <div class="col-md-6">
	                                <label class="control-label col-md-3">相片：</label>
	                                <div class="col-md-9">                                  
	                                    <div class="fileinput fileinput-new" data-provides="fileinput">
	                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
	                                        	@if (isset($data['ap_image']))
	                                        		<img src="/upload/picture/{{ $album->a_id }}/{{ $data['ap_image'] }}" alt="" />
	                                        	@endif
	                                        </div>
	                                        <div>
	                                            <span class="btn btn-default btn-file"><span class="fileinput-new">選擇圖片</span><span class="fileinput-exists">更換圖片</span>
	                                            <input type="file" name="ap_image"></span>
	                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">移除圖片</a>
	                                        </div>
	                                    </div>
	                                </div>
                            	</div> -->
								<!-- <div class="col-md-6">
									<div class="control-label col-md-3">相片說明：</div>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" placeholder="相片說明" class="form-control" name="ap_description" value="{{ isset($data['ap_description'])? $data['ap_description'] : '' }}" />
										</div>
									</div>
								</div> -->
							</div>
							<div class="form-group">
								@include('admin.album.multi_fileupload')
							</div>

                        	
	                        <div class="form-actions right">
	                            <a href="/admin/picture/index/{{ $album->a_id }}" class="btn btn-default"> 返回相片列表 </a>
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

@section('css_link')
	<!-- <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" /> -->
	
	<link href="/assets/global/plugins/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" type="text/css" />
@endsection

@section('js_script')
    <script src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <!-- <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script> -->

    <script src="/assets/global/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-file-upload/js/vendor/tmpl.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-file-upload/js/vendor/load-image.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-image.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-audio.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-video.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-validate.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript"></script>


    <script src="/assets/apps/scripts/admin/album_picture.js"></script>
@endsection
