@extends('layouts.admin.master')

@section('content')
<div class="profile-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe theme-font hide"></i> <span
                            class="caption-subject font-blue-madison bold uppercase">最新消息資料</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form id="data-form" class="form-horizontal"
                        enctype="multipart/form-data" role="form" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="n_id"
                            value="{{ isset($data['n_id']) ? $data['n_id'] : 0 }}" />
                        <div class="form-body">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="control-label col-md-2">標題：</div>
                                    <div class="col-md-10">
                                        <div class="input-icon right">
                                            <input type="text" placeholder="標題" class="form-control" name="n_title" value="{{ isset($data['n_title'])? $data['n_title'] : '' }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="control-label col-md-2">主圖</label>
                                <div class="col-md-10">                                  
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                                        <div>
                                            <span class="btn btn-default btn-file"><span class="fileinput-new">選擇圖片</span><span class="fileinput-exists">更換圖片</span>
                                            <input type="file" name="cover"></span>
                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">移除圖片</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="control-label col-md-2">內容：</div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <div class="input-icon right">
                                                    <textarea name="n_content"
                                                        class="form-control todo-taskbody-taskdesc" rows="8"
                                                        placeholder="內容">{{ isset($data['n_content']) ? $data['n_content'] : '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label col-md-2">狀態：</label>
                                    <div class="col-md-10">
                                        <div class="radio-list">
                                            <label class="radio-inline">
                                                <input type="radio" name="n_status" id="n_status1" value="1" {{ (isset($data['n_status']) && $data['n_status'] == '1')? 'checked' : 'checked' }} > 上架 </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="n_status" id="n_status2" value="0" {{ (isset($data['n_status']) && $data['n_status'] == '0')? 'checked' : '' }}> 下架 </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-actions right">
                            <a href="/admin/news" class="btn btn-default"> 返回最新消息列表 </a>
                            <button class="btn green" id="data-form-btn" type="submit">儲存修改</button>
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
    <script src="/js/ckeditor/ckeditor.js"></script>
    <script src="/assets/apps/scripts/admin/news.js"></script>
@endsection
