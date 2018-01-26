<div class="form-group">
	<input type="hidden" name="cd_id[]" value="{{ isset($data['cd_id'])? $data['cd_id'] : '' }}" />
	<div class="col-md-6">
		<!-- <div class="control-label col-md-2">&nbsp;</div> -->
		<div class="col-md-12">
			<div class="input-icon right">
				<input type="text" placeholder="分類說明名稱" class="form-control" name="cd_title[]" value="{{ isset($data['cd_title'])? $data['cd_title'] : '' }}" />
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<!-- <div class="control-label col-md-2">&nbsp;</div> -->
		<div class="col-md-12">
			<select id="country" name="cd_type[]" class="form-control country">
            	@foreach (config('common.description_types') as $value => $name)
            		<option value="{{ $value }}" {{ isset($data['cd_type']) && $data['cd_type'] == $value ? 'selected' : '' }}>{{ $name }}</option>
            	@endforeach
            </select>
		</div>
	</div>
</div>