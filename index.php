<?php

// 情報取得する路線名設定
$line_name = "山手線";
 
// Yahoo! Japan運行情報のURL
// 以下は関東地方の運行情報URL
$url = "http://transit.yahoo.co.jp/traininfo/area/4/";
 
// Yahoo! Japan運行情報ページのHTMLデータ取得
$railway_html = file_get_contents($url);
 
// 取得したHTMLデータを改行で分割して配列に格納
$railway_info = explode("\n", $railway_html);



// LED点滅パターン
$led_pat = [];
 
// 配列に入れたHTMLデータ各行を解析
for($i=0; $i<count($railway_info)-1; $i++) {
    // 情報取得する路線名文字列が含まれているかチェック
    $pos = strpos($railway_info[$i], $line_name."</a></td>");
    if ($pos !== false) {
        // 含まれていれば次の行に運行情報文字列があるので
        // 運行情報に合わせたLEDの色とパターンを格納
        // まず「平常」が含まれるかチェック
        $pos = strpos($railway_info[$i+1], "平常");
        if($pos !== false) {
            // 平常運転であればLED色は緑で点灯
            $led_pat += [ "rail_color" => "green" ];
            $led_pat += [ "rail_pat" => ["on", "on", "on"] ];
        } else {
            // 平常運転でなければ「遅延」が含まれるかチェック
            $pos = strpos($railway_info[$i+1], "遅延");
            if($pos !== false) {
                // 遅延であればLED色は黄色で点滅
                $led_pat += [ "rail_color" => "yellow" ];
                $led_pat += [ "rail_pat" => ["blink", "blink", "blink"] ];
            } else {
                // 平常運転、遅延でもなければLEDを赤点滅して警告する
                $led_pat += [ "rail_color" => "red" ];
                $led_pat += [ "rail_pat" => ["blink", "blink", "blink"] ];
            }
        }
    }
}

echo $line_name . "の運行状況LED点滅パターン</br>";
echo "LED色: " . $led_pat["rail_color"] . "</br>";
echo "LED点滅パターン:</br>";
var_dump($led_pat["rail_pat"]);

//var_dump( phpinfo() );

?>
