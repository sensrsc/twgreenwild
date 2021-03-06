<form action="{{ route('apply', ['id' => $id]) }}" method="POST">
    {{ csrf_field() }}                                                                               
    <div class="form-group row">
        <label class="col-4 col-form-label">行程名稱</label>
        <div class="col-8">{{$tour['t_title']}}</div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">行程編號</label>
        <div class="col-8">{{$tour['t_id']}}</div>
        <input name="t_id" value="{{$tour['t_id']}}" style="display: none;">
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">訂購日期</label>
        <div class="col-8" id="single-apply-date"></div>
        <input name="apply_date" value="" style="display: none;" id="single-apply-date-input">
    </div>
    <input name="adult_num" value="1" style="display: none;">
    <input name="child_num" value="0" style="display: none;">

    <div class="form-group row">
        <label class="col-4 col-form-label">是否需要車輛接送</label>
        <div class="col-8">
            <div class="form-check form-check-inline">
                <label for="single-transfer-yes" class="form-check-label">
                    <input class="form-check-input" type="radio" name="car_need" id="single-transfer-yes" value="">是
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label for="single-transfer-no" class="form-check-label">
                    <input checked class="form-check-input" type="radio" name="car_need" id="single-transfer-no" value="">否
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="single-name" class="col-4 col-form-label">姓名</label>
        <div class="col-8">
            <input class="form-control" type="text" name="apply_name" value="" id="single-name">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">性別</label>
        <div class="col-8">
            <div class="form-check form-check-inline">
                <label for="single-gender_M" class="form-check-label">
                    <input class="form-check-input" type="radio" name="apply_gender" id="single-gender_M" value="男">男
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label for="single-gender_F" class="form-check-label">
                    <input class="form-check-input" type="radio" name="apply_gender" id="single-gender_F" value="女">女
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="single-tel" class="col-4 col-form-label">電話</label>
        <div class="col-8">
            <input class="form-control" type="tel" value="" name="apply_phone" id="single-tel">
        </div>
    </div>
    <div class="form-group row">
        <label for="single-address" class="col-4 col-form-label">地址</label>
        <div class="col-8">
            <input class="form-control" type="text" value="" name="apply_address" id="single-address">
        </div>
    </div>
    <div class="form-group row">
        <label for="single-email" class="col-4 col-form-label">Email</label>
        <div class="col-8">
            <input class="form-control" type="email" value="" name="apply_email" id="single-email">
        </div>
    </div>
    <div class="form-group row">
        <label for="single-id" class="col-4 col-form-label">身份證號</label>
        <div class="col-8">
            <input class="form-control" type="text" value="" name="apply_identity" id="single-id">
        </div>
    </div>
    <div class="form-group row">
        <label for="single-birth" class="col-4 col-form-label">生日</label>
        <div class="col-8">
            <input class="form-control" type="date" value="" name="apply_birthday" id="single-birth">
        </div>
    </div>
    <div class="form-group row">
        <label for="single-height" class="col-4 col-form-label">身高</label>
        <div class="col-8">
            <input class="form-control" type="number" value="" name="apply_height" id="single-height">
        </div>
    </div>
    <div class="form-group row">
        <label for="single-width" class="col-4 col-form-label">體重</label>
        <div class="col-8">
            <input class="form-control" type="number" value="" name="apply_weight" id="single-width">
        </div>
    </div>
    <div class="form-group row">
        <label for="single-contact-name" class="col-4 col-form-label">緊急聯絡人姓名</label>
        <div class="col-8">
            <input class="form-control" type="text" value="" name="apply_emergency_name" id="single-contact-name">
        </div>
    </div>
    <div class="form-group row">
        <label for="single-contact-tel" class="col-4 col-form-label">緊急聯絡人電話</label>
        <div class="col-8">
            <input class="form-control" type="tel" value="" name="apply_emergency_phone" id="single-contact-tel">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">金額</label>
        <div class="col-8">{{$tour['t_price']}}</div>
        <input name="total_price" value="0" style="display: none;">
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">付款方式</label>
        <div class="col-8">
            <div class="form-check form-check-inline">
                <label for="single-pay-credit" class="form-check-label">
                    <input class="form-check-input" type="radio" name="payment_type" id="single-pay-credit" value="信用卡">信用卡
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label for="single-pay-atm" class="form-check-label">
                    <input class="form-check-input" type="radio" name="payment_type" id="single-pay-atm" value="ATM">ATM
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="single-note" class="col-4 col-form-label">備註</label>
        <div class="col-8">
            <input class="form-control" type="text" value="" name="apply_memo" id="single-note">
        </div>
    </div>
    <div class="row">
        <button type="submit" class="col-4 btn btn-primary" style="margin: 0 auto;">送出</button>
    </div>
</form>
