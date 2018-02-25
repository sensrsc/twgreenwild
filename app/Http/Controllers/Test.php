<?php

namespace App\Http\Controllers;

use App\Services\EcpayService;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Storage;

class Test extends Controller
{
    //
    protected $service;

    public function __construct(EcpayService $service)
    {
        $this->service = $service;
    }

    public function paytest()
    {
        $returnUrl      = url('ecpay/returnurl');
        $paymentInfoUrl = url('ecpay/infourl');

        $orderData = [
            'order_id'         => 'green' . time(),
            'total_amount'     => 1000,
            'trade_desc'       => '綠葉戶外-訂單交易測試',
            'item_name'        => '登山半日遊 1800 x 3',
            'return_url'       => $returnUrl,
            'payment_info_url' => $paymentInfoUrl,
        ];

        // $result = $this->service->sptoken($orderData);
        // var_dump($result);

        try {
            $result = $this->service->sptoken($orderData);
            var_dump($result);
        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }


        /*
    $checkMacVlaue = '';

    $postData = [
    'MerchantID'        => $merchantID,
    'MerchantTradeNo'   => $orderID,
    'StoreID'           => '',
    'MerchantTradeDate' => date('Y/m/d H:i:s'),
    'PaymentType'       => 'aio',
    'TotalAmount'       => $totalAmount,
    'TradeDesc'         => $tradeDesc,
    'ItemName'          => $itemName,
    'ReturnURL'         => $returnUrl,
    'ChoosePayment'     => 'ALL',
    'NeedExtraPaidInfo' => 'N',
    'PlatformID'        => '',
    'InvoiceMark'       => 'N',
    'HoldTradeAMT'      => '0',
    'CustomField1'      => '',
    'CustomField2'      => '',
    'CustomField3'      => '',
    'CustomField4'      => '',
    'EncryptType'       => 1,
    // ATM or ALL
    'ExpireDate'        => 3,
    // CVS or ALL
    'StoreExpireDate'   => 7,
    'Desc_1'            => '',
    'Desc_2'            => '',
    'Desc_3'            => '',
    'Desc_4'            => '',
    'PaymentInfoURL'    => $paymentInfoUrl,
    // CREDIT or ALL
    'BindingCard'       => 0,
    'MerchantMemberID'  => '',
    'Redeem'            => 'N',
    // 'CreditInstallment' => '3,6,12,18,24',
    ];

    $postData['CheckMacValue'] = $this->macValue($hashKey, $hashIv, $postData);

    var_dump($postData);


    $response = $client->request('POST', $url, ['form_params' => $postData]);

    if ($jsonString = $response->getBody()) {
    $result = json_decode($jsonString, true);
    var_dump($result);
    }
     */
    }

    public function payview()
    {
        return view('test');
    }

    public function atm()
    {
        $client = new \GuzzleHttp\Client();

        $url        = 'https://payment-stage.ecpay.com.tw/SP/CreateTrade';
        $merchantID = '2000132';
        $hashKey    = '5294y06JbISpM5x9';
        $hashIv     = 'v77hoKGq4kWxNNIS';
        $orderID = time();
        $totalAmount   = 1000;
        $tradeDesc     = '綠葉戶外-訂單交易測試';
        $itemName      = '登山半日遊 1800 x 3';
        $choosePayment = 'ATM:';

        $checkMacVlaue     = '';
        $returnUrl         = url('test/returnurl');
        $paymentInfoUrl    = url('test/infourl');
        $clientBackUrl     = url('/');
        $paymentInfoUrl    = url('test/paymentinfourl');
        $clientRedirectUrl = url('test/clientredirecturl');

        $postData = [
            'MerchantID'        => $merchantID,
            'MerchantTradeNo'   => $orderID,
            'StoreID'           => '',
            'MerchantTradeDate' => date('Y/m/d H:i:s'),
            'PaymentType'       => 'aio',
            'TotalAmount'       => $totalAmount,
            'TradeDesc'         => $tradeDesc,
            'ItemName'          => $itemName,
            'ReturnURL'         => $returnUrl,
            'ChoosePayment'     => $choosePayment,
            'ClientBackURL'     => $clientBackUrl,
            'ItemURL'           => '',
            'Remark'            => '',
            'ChooseSubPayment'  => '',
            'OrderResultURL'    => '',
            'NeedExtraPaidInfo' => 'N',
            'DeviceSource'      => '',
            'IgnorePayment'     => '',
            'PlatformID'        => '',
            'InvoiceMark'       => 'N',
            'HoldTradeAMT'      => '0',
            'CustomField1'      => '',
            'CustomField2'      => '',
            'CustomField3'      => '',
            'CustomField4'      => '',
            'EncryptType'       => 1,
            // ATM or ALL
            'ExpireDate'        => 3,
            'PaymentInfoURL'    => $paymentInfoUrl,
            'ClientRedirectURL' => $clientRedirectUrl,
        ];
    }

    public function paycredit()
    {
        $returnUrl      = url('ecpay/returnurl');
        $paymentInfoUrl = url('ecpay/infourl');

        $orderData = [
            'order_id'         => time(),
            'total_amount'     => 1000,
            'trade_desc'       => '綠葉戶外-訂單交易測試',
            'item_name'        => '登山半日遊 1800 x 3',
            'return_url'       => $returnUrl,
            'payment_info_url' => $paymentInfoUrl,
        ];
        $result   = $this->service->sptoken($orderData);
        $type     = 'CREDIT';
        $typeName = '信用卡';
        var_dump($orderData);
        var_dump($result);
        return view('test', compact('result', 'type', 'typeName'));
    }

    public function payatm()
    {
        $returnUrl      = url('ecpay/returnurl');
        $paymentInfoUrl = url('ecpay/infourl');

        $orderData = [
            'order_id'         => time(),
            'total_amount'     => 1000,
            'trade_desc'       => '綠葉戶外-訂單交易測試',
            'item_name'        => '登山半日遊 1800 x 3',
            'return_url'       => $returnUrl,
            'payment_info_url' => $paymentInfoUrl,
        ];
        $result   = $this->service->sptoken($orderData);
        $type     = 'ATM';
        $typeName = 'ATM';
        var_dump($orderData);
        var_dump($result);
        return view('test', compact('result', 'type', 'typeName'));
    }

    public function returnurl(Request $request)
    {
        $posts = $request->input();

        $fileName = $posts['MerchantTradeNo'] ?? time();
        
        $returnOk = $this->service->checkReturn($posts);
        if ($returnOk) {
            $posts['check_return_data'] = $returnOk;
            echo '1|OK';
        } else {
            $post['other'] = 'in other';
            echo $posts['RtnCode'] . '|' . $posts['RtnMsg'];
        }

        Storage::disk('local')->put('return_' . $fileName . '.txt', json_encode($posts));
    }

    public function infourl(Request $request)
    {
        $posts = $request->input();

        $fileName = $posts['MerchantTradeNo'] ?? time();
        
        $returnOk = $this->service->checkReturn($posts);
        if ($returnOk) {
            $posts['check_info_data'] = $returnOk;
            echo '1|OK';
        } else {
            $post['other'] = 'in info other';
            echo $posts['RtnCode'] . '|' . $posts['RtnMsg'];
        }

        Storage::disk('local')->put('info_' . $fileName . '.txt', json_encode($posts));
    }

    protected function test()
    {
        $key = '5294y06JbISpM5x9';
        $iv = 'v77hoKGq4kWxNNIS';
        $merchantID = '2000132';


        echo '<pre>';

        $str = '{"CustomField1":null,"CustomField2":null,"CustomField3":null,"CustomField4":null,"MerchantID":"2000132","MerchantTradeNo":"1518504406","PaymentDate":"2018\/02\/13 14:47:21","PaymentType":"Credit_CreditCard","PaymentTypeChargeFee":"1","RtnCode":"1","RtnMsg":"\u4ea4\u6613\u6210\u529f","SimulatePaid":"0","StoreID":null,"TradeAmt":"1000","TradeDate":"2018\/02\/13 14:46:46","TradeNo":"1802131446462585","CheckMacValue":"7E8231A11C5D58F120DD5E1D4849E33067B16EA5038645A4B96BC8C7986ECAAF"}';
        // $str = '{"BankCode":"822","ExpireDate":"2018\/02\/16","MerchantID":"2000132","MerchantTradeNo":"1518505680","PaymentType":"ATM_CHINATRUST","RtnCode":"2","RtnMsg":"Get VirtualAccount Succeeded","TradeAmt":"1000","TradeDate":"2018\/02\/13 15:08:06","TradeNo":"1802131508002613","vAccount":"9829480477210522","StoreID":null,"CustomField1":null,"CustomField2":null,"CustomField3":null,"CustomField4":null,"CheckMacValue":"32CCCE5CF1E17D12F19EA9915270C02AD6AF1DF900BF62A89BAE95ACDD031A0A"}';

        $datas = json_decode($str, true);
        var_dump($datas);


        $returnOK = $this->service->checkReturn($datas);
        var_dump($returnOK);
        
        // $isWrite = Storage::disk('local')->put('file.txt', 'Contents');
        // var_dump($isWrite);
    }

    public function checkmac()
    {
        $merchantID = '2000132';
        $hashKey    = '5294y06JbISpM5x9';
        $hashIv     = 'v77hoKGq4kWxNNIS';
        $returnData = [
            'RtnCode'         => '1',
            'RtnMsg'          => '成功',
            'SPToken'         => '43A2E899A4B24F8A9CE6D544DBB074ED',
            'MerchantID'      => '2000132',
            'MerchantTradeNo' => '1518056912',
            'CheckMacValue'   => 'F2EA760687080D172027A83BB3A6095E998BEC61CFADF8D9FED0B1F39ED35250',
        ];

        $isOk = $this->checkMacValue($hashKey, $hashIv, $returnData);
        var_dump($isOk);
        $returnOk = $this->checkReturn($merchantID, $hashKey, $hashIv, $returnData);
        var_dump($returnOk);
        if ($returnOk) {
            echo '1|OK';
        }
    }

    private function macValue($key, $iv, $datas)
    {
        ksort($datas);

        $queryString = urldecode(http_build_query($datas));
        $valueStr    = strtolower(urlencode('HashKey=' . $key . '&' . $queryString . '&HashIV=' . $iv));

        // $valueStr = str_replace('%2d', '-', $valueStr);
        // $valueStr = str_replace('%5f', '_', $valueStr);
        // $valueStr = str_replace('%2e', '.', $valueStr);
        // $valueStr = str_replace('%21', '!', $valueStr);
        // $valueStr = str_replace('%2a', '*', $valueStr);
        // $valueStr = str_replace('%28', '(', $valueStr);
        // $valueStr = str_replace('%29', ')', $valueStr);
        // $valueStr = str_replace('%20', ' ', $valueStr);
        // $valueStr = str_replace('%40', '@', $valueStr);
        // $valueStr = str_replace('%23', '#', $valueStr);
        // $valueStr = str_replace('%24', '$', $valueStr);
        // $valueStr = str_replace('%25', '%', $valueStr);
        // $valueStr = str_replace('%5e', '^', $valueStr);
        // $valueStr = str_replace('%26', '&', $valueStr);
        // $valueStr = str_replace('%3d', '=', $valueStr);
        // $valueStr = str_replace('%2b', '+', $valueStr);
        // $valueStr = str_replace('%3b', ';', $valueStr);
        // $valueStr = str_replace('%3f', '?', $valueStr);
        // $valueStr = str_replace('%2f', '/', $valueStr);
        // $valueStr = str_replace('%5c', '\\', $valueStr);
        // $valueStr = str_replace('%3e', '>', $valueStr);
        // $valueStr = str_replace('%3c', '<', $valueStr);
        // $valueStr = str_replace('%60', '`', $valueStr);
        // $valueStr = str_replace('%5b', '[', $valueStr);
        // $valueStr = str_replace('%5d', ']', $valueStr);
        // $valueStr = str_replace('%7b', '{', $valueStr);
        // $valueStr = str_replace('%7d', '}', $valueStr);
        // $valueStr = str_replace('%3a', ':', $valueStr);
        // $valueStr = str_replace('%27', '\'', $valueStr);
        // $valueStr = str_replace('%22', '"', $valueStr);
        // $valueStr = str_replace('%2c', ',', $valueStr);
        // $valueStr = str_replace('%7c', '|', $valueStr);

        $macValue = strtoupper(hash('sha256', $valueStr));

        return $macValue;
    }

    public function checkReturn($merchantID, $key, $iv, $datas)
    {
        $checkMac = $this->checkMacValue($key, $iv, $datas);
        if (isset($datas['RtnCode']) && isset($datas['MerchantID']) && isset($datas['MerchantTradeNo']) && isset($datas['SPToken'])) {
            if ($datas['RtnCode'] === '1' && $merchantID === $datas['MerchantID'] && $checkMac) {
                return true;
            }
        }
        return false;
    }

    public function checkMacValue($key, $iv, $datas)
    {
        $returnMacValue = $datas['CheckMacValue'] ?? '';
        if ($returnMacValue) {
            unset($datas['CheckMacValue']);
            $macValue = $this->macValue($key, $iv, $datas);
            if ($macValue == $returnMacValue) {
                return true;
            }
        }
        return false;
    }
}
