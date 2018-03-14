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

    public function sptoken(array $orderData)
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
            'Desc_1'            => $orderData['desc1'] ?? '',
            'Desc_2'            => $orderData['desc2'] ?? '',
            'Desc_3'            => $orderData['desc3'] ?? '',
            'Desc_4'            => $orderData['desc4'] ?? '',
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
            if ($this->checkReturn($result)){
            	return $result;
            }
            return $result;
        }

        return [];
    }

    public function checkReturn($datas)
    {
        $checkMac = $this->checkMacValue($this->hashKey, $this->hashIv, $datas);
        if (isset($datas['RtnCode']) && isset($datas['MerchantID']) && isset($datas['MerchantTradeNo'])) {
            if ($datas['RtnCode'] === '1' && $this->merchantID === $datas['MerchantID'] && $checkMac) {
                return true;
            } else if ($datas['RtnCode'] === '2' && $this->merchantID === $datas['MerchantID'] && $checkMac) {
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
        $sMacValue = '' ;
        
        if(isset($datas))
        {   
            unset($datas['CheckMacValue']);
            ksort($datas);
               
            // 組合字串
            $sMacValue = 'HashKey=' . $key ;
            foreach($datas as $key => $value)
            {
                $sMacValue .= '&' . $key . '=' . $value ;
            }
            
            $sMacValue .= '&HashIV=' . $iv ;    
            
            // URL Encode編碼     
            $sMacValue = urlencode($sMacValue); 
            
            // 轉成小寫
            $sMacValue = strtolower($sMacValue);        
            
            // 取代為與 dotNet 相符的字元
            $sMacValue = str_replace('%2d', '-', $sMacValue);
            $sMacValue = str_replace('%5f', '_', $sMacValue);
            $sMacValue = str_replace('%2e', '.', $sMacValue);
            $sMacValue = str_replace('%21', '!', $sMacValue);
            $sMacValue = str_replace('%2a', '*', $sMacValue);
            $sMacValue = str_replace('%28', '(', $sMacValue);
            $sMacValue = str_replace('%29', ')', $sMacValue);
                                
            // 編碼
            switch ($encType) {
                default:
                    $sMacValue = hash('sha256', $sMacValue);
            }

            $sMacValue = strtoupper($sMacValue);
        } 

        return $sMacValue;
    }
}
