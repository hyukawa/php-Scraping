<?php

echo "山手線の運行状況\n";
echo "正常\n";

// 情報取得する路線名設定
$line_name = "山手線";
 
// Yahoo! Japan運行情報のURL
// 以下は関東地方の運行情報URL
$url = "http://transit.yahoo.co.jp/traininfo/area/4/";
 
// Yahoo! Japan運行情報ページのHTMLデータ取得
$railway_html = file_get_contents($url);
 
// 取得したHTMLデータを改行で分割して配列に格納
$railway_info = explode("\n", $railway_html);

var_dump( phpinfo() );

?>
