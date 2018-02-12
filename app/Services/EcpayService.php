<?php

namespace App\Services;

class EcpayService
{
	protected $client;
    private $merchantID;
    private $hashKey;
    private $hashIv;

    public function __construct()
    {
    	$this->client = new \GuzzleHttp\Client();
        $this->merchantID = env('ECPAY_MERCHANT_ID', '');
        $this->hashKey    = env('ECPAY_HASH_KEY', '');
        $this->hashIv     = env('ECPAY_HASH_IV', '');
    }

    public function test()
    {
        var_dump($this->merchantID);
        var_dump($this->hashKey);
        var_dump($this->hashIv);
    }


    public function creditToken(array $orderData)
    {
    	$url = env('ECPAY_CREDIT_URL', '');

        $postData = [
            'MerchantID'        => $this->merchantID,
            'MerchantTradeNo'   => $orderData['order_id'],
            'StoreID'           => '',
            'MerchantTradeDate' => date('Y/m/d H:i:s'),
            'PaymentType'       => 'aio',
            'TotalAmount'       => $orderData['total_amount'] ?? 0,
            'TradeDesc'         => $orderData['trade_desc'] ?? '',
            'ItemName'          => $orderData['item_name'] ?? '',
            'ReturnURL'         => $orderData['return_url'] ?? '',
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
            'PaymentInfoURL'    => $orderData['payment_info_url'] ?? '',
            // CREDIT or ALL
            'BindingCard'       => 0,
            'MerchantMemberID'  => '',
            'Redeem'            => 'N',
        ];

        $postData['CheckMacValue'] = $this->macValue($this->hashKey, $this->hashIv, $postData);

        $response = $this->client->request('POST', $url, ['form_params' => $postData]);


        if ($jsonString = $response->getBody()) {
            $result = json_decode($jsonString, true);
            if ($this->checkReturn($this->merchantID, $this->hashKey, $this->hashIv, $result)){
            	return $result;
            }
        }

        return [];
    }

    public function atm()
    {

    }

    public function checkReturn($datas)
    {
        $checkMac = $this->checkMacValue($this->hashKey, $this->hashIv, $datas);
        if (isset($datas['RtnCode']) && isset($datas['MerchantID']) && isset($datas['MerchantTradeNo']) && isset($datas['SPToken'])) {
            if ($datas['RtnCode'] === '1' && $this->merchantID === $datas['MerchantID'] && $checkMac) {
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

    public function macValue($key, $iv, $datas)
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
}
