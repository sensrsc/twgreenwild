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
                            <input type="text" name="c_title" class="form-control" placeholder="請輸入相簿名稱">
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
                <i class="fa fa-user"></i>相簿列表
            </div>
            <div class="actions">
                <a class="dt-button buttons-print btn dark btn-outline" tabindex="0" href="/admin/album/add">
                    <span>新增相簿</span>
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="dataTables_wrapper no-footer">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                            <tr>
                                <th>相簿名稱(張數)</th>
                                <th>行程類型</th>
                                <th>狀態</th>
                                <th>修改時間</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($lists))
                                @foreach ($lists as $list)
                                <tr>
                                    <td class="highlight">
                                    	{{ $list['a_title'] }} ({{ $list['a_total_pic'] }})
                                    </td>
                                    <td>
                                        {{ isset($list->category->c_title)? $list->category->c_title : '' }}
                                    </td>
                                    <td>
                                        {{ isset(config('common.general_status')[$list['a_status']])? config('common.general_status')[$list['a_status']] : '' }}
                                    </td>
                                    <td>
                                        {{ $list['updated_at'] }}
                                    </td>
                                    <td>
                                        <a href="/admin/album/detail/{{ $list['a_id'] }}" class="btn btn-outline btn-circle btn-sm blue">
                                            <i class="fa fa-edit">查看/編輯</i></a>
                                        <a href="/admin/picture/index/{{ $list['a_id'] }}" class="btn btn-outline btn-circle btn-sm green">
                                            <i class="fa fa-edit">照片管理</i></a>
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
@endsection
