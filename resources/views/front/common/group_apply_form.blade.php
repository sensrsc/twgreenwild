<form action="activity/apply" method="POST">
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
        <div class="col-8" id="group-apply-date"></div>
        <input name="apply_date" value="" style="display: none;" id="group-apply-date-input">
    </div>

    <div class="form-group row">
        <label for="group-adult" class="col-4 col-form-label">大人</label>
        <div class="col-8">
            <select class="form-control" name="adult_num" id="group-adult">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="group-child" class="col-4 col-form-label">小孩</label>
        <div class="col-8">
            <select class="form-control" name="child_num" id="group-child">
                <option>0</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-4 col-form-label">是否需要車輛接送</label>
        <div class="col-8">
            <div class="form-check form-check-inline">
                <label for="group-transfer-yes" class="form-check-label">
                    <input class="form-check-input" type="radio" name="car_need" id="group-transfer-yes" value="">是
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label for="group-transfer-no" class="form-check-label">
                    <input checked class="form-check-input" type="radio" name="car_need" id="group-transfer-no" value="">否
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="group-name" class="col-4 col-form-label">姓名</label>
        <div class="col-8">
            <input class="form-control" type="text" name="apply_name" value="" id="group-name">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-4 col-form-label">性別</label>
        <div class="col-8">
            <div class="form-check form-check-inline">
                <label for="group-gender_M" class="form-check-label">
                    <input class="form-check-input" type="radio" name="apply_gender" id="group-gender_M" value="男">男
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label for="group-gender_F" class="form-check-label">
                    <input class="form-check-input" type="radio" name="apply_gender" id="group-gender_F" value="女">女
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="group-tel" class="col-4 col-form-label">電話</label>
        <div class="col-8">
            <input class="form-control" type="tel" value="" name="apply_phone" id="group-tel">
        </div>
    </div>
    <div class="form-group row">
        <label for="group-address" class="col-4 col-form-label">地址</label>
        <div class="col-8">
            <input class="form-control" type="text" value="" name="apply_address" id="group-address">
        </div>
    </div>
    <div class="form-group row">
        <label for="group-email" class="col-4 col-form-label">Email</label>
        <div class="col-8">
            <input class="form-control" type="email" value="" name="apply_email" id="group-email">
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
                <label for="group-pay-credit" class="form-check-label">
                    <input class="form-check-input" type="radio" name="payment_type" id="group-pay-credit" value="">信用卡
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label for="group-pay-atm" class="form-check-label">
                    <input class="form-check-input" type="radio" name="payment_type" id="group-pay-atm" value="">ATM
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="group-note" class="col-4 col-form-label">備註</label>
        <div class="col-8">
            <input class="form-control" type="text" value="" name="apply_memo" id="group-note">
        </div>
    </div>
    <div class="row">
        <button type="submit" class="col-4 btn btn-primary" style="margin: 0 auto;">送出</button>
    </div>
</form>
