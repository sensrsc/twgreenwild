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
                            value="{{ isset($data->n_id)? $data->n_id : 0 }}" />
                        <div class="form-body">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="control-label col-md-3">標題：</div>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <input type="text" placeholder="標題" class="form-control" name="n_subject" value="{{ isset($data->n_subject)? $data->n_subject : '' }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label col-md-3">狀態：</label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="n_status">
                                            <option value="">請選擇</option>
                                            @if (!empty(config('common.general_status')))
                                                @foreach (config('common.general_status') as $status => $statusTitle)
                                                    <option value="{{ $status }}" {{ (isset($data->n_status) && $data->n_status == $status)? 'selected' : '' }}> {{ $statusTitle }} </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <label class="control-label col-md-3">置頂：</label>
                                    <div class="col-md-9">
                                        <div class="radio-list">
                                            <label class="radio-inline">
                                                <input type="radio" name="n_top" id="n_top1" value="1" {{ (isset($data->n_top) && $data->n_top == '1')? 'checked' : 'checked' }} > 置頂 </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="n_top" id="n_top2" value="2" {{ (isset($data->n_top) && $data->n_top == '2')? 'checked' : '' }}> 不置頂 </label>
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
                                                    <textarea name="n_content" id="n_content"
                                                        class="form-control todo-taskbody-taskdesc" rows="8"
                                                        placeholder="內容">{{ isset($data->n_content) ? $data->n_content : '' }}</textarea>
                                                </div>
                                            </div>
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
