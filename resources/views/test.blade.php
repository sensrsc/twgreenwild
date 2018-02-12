
<body>
<script
  src="http://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>

<script src="https://payment-stage.ecpay.com.tw/Scripts/SP/ECPayPayment_1.0.0.js"
 data-MerchantID="2000132"
 data-SPToken="{{ isset($result['SPToken'])? $result['SPToken'] : '' }}"
 data-PaymentType="{{ isset($type)? $type : 'CREDIT' }}"
 data-PaymentName="{{ isset($typeName)? $typeName : '信用卡' }}"
 data-CustomerBtn="0" >
</script>

<div>
    11111
</div>
</body>