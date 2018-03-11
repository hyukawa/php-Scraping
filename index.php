<?php

// 情報取得する路線名設定
$line_name = ["山手線","東京メトロ東西線","東京メトロ副都心線"];
 
// Yahoo! Japan運行情報のURL
// 以下は関東地方の運行情報URL
$url = "http://transit.yahoo.co.jp/traininfo/area/4/";
 
// Yahoo! Japan運行情報ページのHTMLデータ取得
$railway_html = file_get_contents($url);
 
// 取得したHTMLデータを改行で分割して配列に格納
$railway_info = explode("\n", $railway_html);

// 取得結果を配列へ格納
$led_pat = [];
$return_pat0 = [];


for($j=0; $j<count($line_name); $j++) {
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
            //$led_pat += [ "rail_state" => $railway_info[$i+1] ];
            //$led_pat += [ "rail_state_detail" => $railway_info[$i+2] ];
            $led_pat[] =  "○" ;
            //$return_pat0[] = $railway_info[$i+1];
            //$return_pat0[] = $railway_info[$i+2];
            break;
        } else {
            // 平常運転でなければ「遅延」が含まれるかチェック
            $pos = strpos($railway_info[$i+1], "遅延");
            if($pos !== false) {
                // 遅延であればLED色は黄色で点滅
                //$led_pat += [ "rail_state" => "▲" ];
                $led_pat[] = "▲" ;
                $return_pat0[] = $railway_info[$i+1];
                $return_pat0[] = $railway_info[$i+2];
                 break;
            } else {
                // 平常運転、遅延でもなければLEDを赤点滅して警告する
                //$led_pat += [ "rail_state" => "×" ];
                //$led_pat += [ "rail_state" => $railway_info[$i+1] ];
                //$led_pat += [ "rail_state_detail" => $railway_info[$i+2] ];
                $led_pat[] = "×" ;
                $return_pat0[] = $railway_info[$i+1];
                $return_pat0[] = $railway_info[$i+2];
                 break;
            }
        }
    }
}
}

echo '路線： ' . $line_name[0] . '</br>';
echo '運行状況： ' . $return_pat0[0] . '</br>';
echo '遅延情報： ' . $return_pat0[1] . '</br>';

echo '路線： ' . $line_name[1] . '</br>';
echo '運行状況： ' . $return_pat0[2] . '</br>';
echo '遅延情報： ' . $return_pat0[3] . '</br>';

echo '路線： ' . $line_name[2] . '</br>';
echo '運行状況： ' . $return_pat0[4] . '</br>';
echo '遅延情報： ' . $return_pat0[5] . '</br>';

print<<<eof
  <table>
   <tr><th>路線</th><td>$line_name[0]</td><td>$led_pat[0]</td></tr>
   <tr><th>画像</th><td>$line_name[1]</td><td>$led_pat[1]</td></tr>
  <table>
eof;

  //遅延情報は文字が途中で切れてしまっているため、サイネージで表示した場合、恰好悪いので表示させない

//var_dump($led_pat["rail_pat"]);
//var_dump( phpinfo() );

?>
