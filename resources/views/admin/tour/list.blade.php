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
                        <label class="col-md-1 control-label">名稱</label>
                        <div class="col-md-2">
                            <input type="text" name="t_name" class="form-control" placeholder="請輸入行程名稱">
                        </div>

                        <label class="col-md-1 control-label">分類</label>
                        <div class="col-md-2">
                            <select id="country" name="c_id" class="form-control country">
                                <option value="">請選擇</option>
                                @if (isset($categorys))
                                    @foreach ($categorys as $category)
                                        <option value="{{ $category->c_id }}">{{ $category->c_title }}</option>
                                    @endforeach
                                @endif
                            </select>
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
                <i class="fa fa-user"></i>行程列表
            </div>
            <div class="actions">
                <a class="dt-button buttons-print btn dark btn-outline" tabindex="0" href="/admin/tour/add">
                    <span>新增行程</span>
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="dataTables_wrapper no-footer">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                            <tr>
                                <th>行程名稱</th>
                                <th>類型</th>
                                <th>狀態</th>
                                <th>金額</th>
                                <th>修改時間</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($lists))
                                @foreach ($lists as $list)
                                <tr>
                                    <td class="highlight">
                                    	{{ $list['t_title'] }}
                                    </td>
                                    <td>
                                        {{ isset($list->category->c_title)? $list->category->c_title : '' }}
                                    </td>
                                    <td>
                                        {{ isset(config('common.general_status')[$list['t_status']])? config('common.general_status')[$list['t_status']] : '' }}
                                    </td>
                                    <td>
                                        {{ $list['t_price'] }}
                                    </td>
                                    <td>
                                        {{ $list['updated_at'] }}
                                    </td>
                                    <td>
                                        <a href="/admin/tour/detail/{{ $list['t_id'] }}" class="btn btn-outline btn-circle btn-sm blue">
                                            <i class="fa fa-edit">查看/編輯</i></a>
                                        <!-- <a href="#" data-id="{{ $list['t_id'] }}" class="btn btn-outline btn-circle btn-sm red del_btn">
                                            <i class="fa fa-edit">刪除</i></a> -->
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
                    <input type="hidden" name="a_id" id="a_id" value="">
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
