@extends('layouts.admin.master')

@section('content')

<div class="col-md-12 portlet">
    <div class="portlet box green">

        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i>資料查詢</div>
            <div class="tools">
                <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                <!-- <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a> -->
                <a href="javascript:;" class="reload" data-original-title="" title=""> </a>                
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-1 control-label">名稱：</label>
                        <div class="col-md-2">
                            <input type="text" name="is_title" class="form-control" placeholder="請輸入名稱">
                        </div>
                    </div>
                </div>
                <div class="form-actions right">
                    <button type="submit" class="btn green">查詢</button>
                </div>
            </form>
        </div>

    </div>
</div>

<div class="col-md-12 portlet light">    
    
    <div class="portlet light portlet-fit ">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-user"></i>首頁輪播列表
            </div>
            <div class="actions">
                <a class="dt-button buttons-print btn dark btn-outline" tabindex="0" href="/admin/slide/add">
                    <span>新增首頁輪播</span>
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="dataTables_wrapper no-footer">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                            <tr>
                                <th>名稱</th>
                                <th>輪播圖</th>
                                <th>開始日期</th>
                                <th>結束日期</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($lists))
                                @foreach ($lists as $list)
                                <tr>
                                    <td class="highlight">
                                    	{{ $list->is_title }}
                                    </td>
                                    <td>
                                        <img src="{{ $list->picturePath }}" width="120px" />
                                    </td>
                                    <td>
                                        {{ $list->is_start }}
                                    </td>
                                    <td>
                                        {{ $list->is_end }}
                                    </td>
                                    <td>
                                        <a href="/admin/slide/detail/{{ $list->is_id }}" class="btn btn-outline btn-circle btn-sm blue">
                                            <i class="fa fa-edit">查看/編輯</i></a>
                                        <a href="#" data-id="{{ $list->is_id }}" class="btn btn-outline btn-circle btn-sm red del_btn">
                                            <i class="fa fa-edit">刪除</i></a>
                                    </td>                                    
                                </tr>
                                @endforeach
                            @endif
                        </tbody>                        
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-5 col-sm-5">
                        <div class="dataTables_info" id="sample_editable_1_info" role="status" aria-live="polite"></div>
                    </div>
                    <div class="col-md-7 col-sm-7">
                        <div class="dataTables_paginate paging_bootstrap_number" id="sample_editable_1_paginate">
                            <ul class="pagination" style="visibility: visible;">
                                {{ !empty($lists)? $lists->render() : '' }}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>

<div class="modal fade" id="basic_modal" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">確認</h4>
            </div>
            <div class="modal-body" id="modal_body"></div>
            <div class="modal-footer">
                <form method="post" id="modal_form" class="form-horizontal" role="form">
                    {{ csrf_field() }}
                    <input type="hidden" name="is_id" id="is_id" value="">
                </form>
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">關閉</button>
                <button type="button" id="delete_btn" class="btn red">刪除</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection

@section('js_script')
    <script src="/assets/apps/scripts/admin/slide_list.js"></script>
@endsection
