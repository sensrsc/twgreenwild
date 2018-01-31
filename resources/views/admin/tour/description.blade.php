<div class="form-group">
	<input type="hidden" name="td_id[]" value="{{ isset($data->td_id)? $data->td_id : '' }}" />
	@if (!empty($cd))
		<input type="hidden" name="cd_id[]" value="{{ isset($cd->cd_id)? $cd->cd_id : '' }}" />
		<div class="col-md-12">
			<div class="control-label col-md-2"> {{ isset($cd->cd_title)? $cd->cd_title : '' }}：</div>
			<div class="col-md-10">
	            <textarea name="td_content[]" class="form-control {{ isset($cd->cd_type) && $cd->cd_type == '2'? 'ckeditor' : '' }}" id="editor{{ isset($cd->cd_id)? $cd->cd_id : '' }}" rows="3"></textarea>
			</div>
		</div>
	@else
		<input type="hidden" name="cl_id[]" value="{{ isset($data->cd_id)? $data->cd_id : '' }}" />
		<div class="col-md-12">
			<div class="control-label col-md-2"> {{ isset($data->cateDesc->cd_title)? $data->cateDesc->cd_title : '' }}：</div>
			<div class="col-md-10">
	            <textarea name="td_content[]" class="form-control {{ isset($data->cateDesc->cd_type) && $data->cateDesc->cd_type == '2'? 'ckeditor' : '' }}" id="editor{{ isset($data->cateDesc->cd_id)? $data->cateDesc->cd_id : '' }}" rows="5">{{ $data->td_content }}</textarea>
			</div>
		</div>
	@endif
</div>	