<form>
    <div class="form-group row">
        <label class="col-4 col-form-label">行程名稱</label>
        <div class="col-8">{{$tour['t_title']}}</div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">行程編號</label>
        <div class="col-8">{{$tour['t_id']}}</div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">訂購日期</label>
        <div class="col-8" id="group-apply-date"></div>
    </div>

    <div class="form-group row">
        <label class="col-4 col-form-label">是否需要車輛接送</label>
        <div class="col-8">
            <div class="form-check form-check-inline">
                <label for="group-transfer-yes" class="form-check-label">
                    <input class="form-check-input" type="radio" name="transfer" id="group-transfer-yes" value="">是
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label for="group-transfer-no" class="form-check-label">
                    <input checked class="form-check-input" type="radio" name="transfer" id="group-transfer-no" value="">否
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="group-name" class="col-4 col-form-label">姓名</label>
        <div class="col-8">
            <input class="form-control" type="text" value="" id="group-name">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">性別</label>
        <div class="col-8">
            <div class="form-check form-check-inline">
                <label for="group-gender_M" class="form-check-label">
                    <input class="form-check-input" type="radio" name="gender" id="group-gender_M" value="gender_M">男
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label for="group-gender_F" class="form-check-label">
                    <input class="form-check-input" type="radio" name="gender" id="group-gender_F" value="gender_F">女
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="group-tel" class="col-4 col-form-label">電話</label>
        <div class="col-8">
            <input class="form-control" type="tel" value="" id="group-tel">
        </div>
    </div>
    <div class="form-group row">
        <label for="group-address" class="col-4 col-form-label">地址</label>
        <div class="col-8">
            <input class="form-control" type="text" value="" id="group-address">
        </div>
    </div>
    <div class="form-group row">
        <label for="group-email" class="col-4 col-form-label">Email</label>
        <div class="col-8">
            <input class="form-control" type="email" value="" id="group-email">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">金額</label>
        <div class="col-8">{{$tour['t_price']}}</div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">付款方式</label>
        <div class="col-8">
            <div class="form-check form-check-inline">
                <label for="group-pay-credit" class="form-check-label">
                    <input class="form-check-input" type="radio" name="pay" id="group-pay-credit" value="">信用卡
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label for="group-pay-atm" class="form-check-label">
                    <input class="form-check-input" type="radio" name="pay" id="group-pay-atm" value="">ATM
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="group-note" class="col-4 col-form-label">備註</label>
        <div class="col-8">
            <input class="form-control" type="text" value="" id="group-note">
        </div>
    </div>
    <div class="row">
        <button type="submit" class="col-4 btn btn-primary" style="margin: 0 auto;">送出</button>
    </div>
</form>
