<?php
namespace App\Libraries;

use Session;

class Captcha
{
    protected $session;

    public function __construct()
    {
        
    }

    public function generate($length = 6, $height = 30, $width = 120)
    {
        $img_height = $height; // 圖形高度
        $img_width  = $width; // 圖形寬度
        $mass       = 50; // 雜點的數量，數字愈大愈不容易辨識
        $sessino_second = 120; // session存在的秒數

        $word = $this->rand_string(6);
        // session(['captcha_word' => $word]);
        session()->put('captcha_word', $word);
        
        // 創造圖片，定義圖形和文字顏色
        Header("Content-type: image/PNG");
        srand((double) microtime() * 1000000);
        $im    = imagecreate($img_width, $img_height);
        $black = ImageColorAllocate($im, 0, 0, 0); // (0,0,0)文字為黑色
        $white = ImageColorAllocate ($im, 255, 255, 255); 
        $gray  = ImageColorAllocate($im, 200, 200, 200); // (200,200,200)背景是灰色
        imagefill($im, 0, 0, $gray);

        // 隨機給予兩條虛線，起干擾作用
        $style = array($black, $black, $black, $black, $black, $gray, $gray, $gray, $gray, $gray);
        imagesetstyle($im, $style);
        $y1 = rand(0, $img_height);
        $y2 = rand(0, $img_height);
        $y3 = rand(0, $img_height);
        $y4 = rand(0, $img_height);
        imageline($im, 0, $y1, $img_width, $y3, IMG_COLOR_STYLED);
        imageline($im, 0, $y2, $img_width, $y4, IMG_COLOR_STYLED);

        // 在圖形產上黑點，起干擾作用;
        for ($i = 0; $i < $mass; $i++) {
            imagesetpixel($im, rand(0, $img_width), rand(0, $img_height), $black);
        }

        // 將數字隨機顯示在圖形上,文字的位置都按一定波動範圍隨機生成
        // $strx = rand(3, 8);
        // for ($i = 0; $i < $length; $i++) {
        //     $strpos = rand(1, 8);
        //     imagestring($im, 5, $strx, $strpos, substr($word, $i, 1), $black);
        //     $strx += rand(8, 14);
        // }

        $ttf_path = $_SERVER['DOCUMENT_ROOT'].'/assets/apps/font/CONSOLA.TTF';        

        ImageTTFText ($im, 20, 0, 10, 20, $black, $ttf_path, $word);

        ImagePNG($im);
        ImageDestroy($im);
    }

    public function rand_string($length)
    {
        $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
