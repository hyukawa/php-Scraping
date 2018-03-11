<?php

// 情報取得する路線名設定
$line_name = ["江ノ島電鉄線","山手線","東京メトロ東西線","東京メトロ副都心線"];
 
// Yahoo! Japan運行情報のURL
// 以下は関東地方の運行情報URL
$url = "http://transit.yahoo.co.jp/traininfo/area/4/";
 
// Yahoo! Japan運行情報ページのHTMLデータ取得
$railway_html = file_get_contents($url);
 
// 取得したHTMLデータを改行で分割して配列に格納
$railway_info = explode("\n", $railway_html);

// 取得結果を配列へ格納
$return0_pat = [];
$return1_pat = [];


for($j=0; $j<count($line_name)-1; $j++) {
// 配列に入れたHTMLデータ各行を解析
for($i=0; $i<count($railway_info)-1; $i++) {
    // 情報取得する路線名文字列が含まれているかチェック
    $pos = strpos($railway_info[$i], $line_name[$j]."</a></td>");
    if ($pos !== false) {
        // 含まれていれば次の行に運行情報文字列があるので
        // 運行情報に合わせたLEDの色とパターンを格納
        // まず「平常」が含まれるかチェック
        $pos = strpos($railway_info[$i+1], "平常");
        if($pos !== false) {
            // 平常運転であればLED色は緑で点灯
            //$led_pat += [ "rail_state" => "○" ];
            $led_pat += [ "rail_state" => $railway_info[$i+1] ];
            $led_pat += [ "rail_state_detail" => $railway_info[$i+2] ];
        } else {
            // 平常運転でなければ「遅延」が含まれるかチェック
            $pos = strpos($railway_info[$i+1], "遅延");
            if($pos !== false) {
                // 遅延であればLED色は黄色で点滅
                //$led_pat += [ "rail_state" => "▲" ];
                $return$j_pat += [ "rail_state" => $railway_info[$i+1] ]];
                $return$j_pat += [ "rail_state_detail" => $railway_info[$i+2] ]];
                 break;
            } else {
                // 平常運転、遅延でもなければLEDを赤点滅して警告する
                //$led_pat += [ "rail_state" => "×" ];
                $led_pat += [ "rail_state" => $railway_info[$i+1] ];
                $led_pat += [ "rail_state_detail" => $railway_info[$i+2] ];
            }
        }
    }
}
 break;
}

echo "路線： " . $line_name[0] . "</br>";
echo "運行状況： " . $return0_pat["rail_state"] . "</br>";
echo "遅延情報： " . $return0_pat["rail_state_detail"] . "</br>";
  //遅延情報は文字が途中で切れてしまっているため、サイネージで表示した場合、恰好悪いので表示させない

//var_dump($led_pat["rail_pat"]);
//var_dump( phpinfo() );

?>
