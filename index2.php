<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>高田馬場周辺の列車運行情報</title>
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW,NOARCHIVE" />
<!--ビューポート設定-->
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<head>
<style type="text/css">
.box11{
    background-color:#80c241;
    float:left;
    width:10%;
    height:20%;
}
.box21{
    background-color:#009bbf;
    float:left;
    width:10%;
    height:20%;
}
.box31{
    background-color:#9c5e31;
    float:left;
    width:10%;
    height:20%;
}
.box2{
    float:left;
    width:45%;
} 
.box3{
    float:left;
    width:45%;
}
.box_in{
    max-width:300px;
    margin:10px;
}
.box_in p img{
    width:100%;
    height:auto;
}
</style>
<body>

<?php

// 情報取得する路線名設定
$line_name = ["山手線","東京メトロ東西線","東京メトロ副都心線"];
 
// JRだけではないため　Yahoo! Japan運行情報 より取得する
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
        // 運行情報に合わせたイメージファイルをセット
        // まず「平常」が含まれるかチェック
        $pos = strpos($railway_info[$i+1], "平常");
        if($pos !== false) {
            // 平常運転
            //$led_pat += [ "rail_state" => "○" ];
            //$led_pat += [ "rail_state" => $rail//way_info[$i+1] ];
            //$led_pat += [ "rail_state_detail" => $railway_info[$i+2] ];
            $led_pat[] =  "<img src=/heijou-290px-56px-00b300-F105.png>" ;
	    //$return_pat0[] = $railway_info[$i+1];
            //$return_pat0[] = $railway_info[$i+2];
            break;
        } else {
            // 平常運転でなければ「遅延」が含まれるかチェック
            $pos = strpos($railway_info[$i+1], "遅延");
            if($pos !== false) {
                // 遅延
                //$led_pat += [ "rail_state" => "▲" ];
                $led_pat[] = "<img src=/chien-242px-56px-ff7f00-F105.png>" ;
                $return_pat0[] = $railway_info[$i+1];
                $return_pat0[] = $railway_info[$i+2];
                 break;
            } else {
                // 平常運転、遅延でもない場合
                //$led_pat += [ "rail_state" => "×" ];
                //$led_pat += [ "rail_state" => $railway_info[$i+1] ];
                //$led_pat += [ "rail_state_detail" => $railway_info[$i+2] ];
                $led_pat[] = "<img src=/info-279px-57px-4da6ff-F105.png>" ;
                $return_pat0[] = $railway_info[$i+1];
                $return_pat0[] = $railway_info[$i+2];
                 break;
            }
        }
    }
}
}
//for debug
//echo '路線： ' . $line_name[0] . '</br>';
//echo '運行状況： ' . $return_pat0[0] . '</br>';
//echo '遅延情報： ' . $return_pat0[1] . '</br>';
//echo '路線： ' . $line_name[1] . '</br>';
//echo '運行状況： ' . $return_pat0[2] . '</br>';
//echo '遅延情報： ' . $return_pat0[3] . '</br>';
//echo '路線： ' . $line_name[2] . '</br>';
//echo '運行状況： ' . $return_pat0[4] . '</br>';
//echo '遅延情報： ' . $return_pat0[5] . '</br>';


print<<<eof
  <div class="box11">
    <div class="box_in">
    	<p></p>
    </div>
  </div>
  <div class="box2">
    <div class="box_in">
    	<p><img src=/yamanote-226px-73px-000000-F105.png></p>
    </div>
  </div>
  <div class="box3">
    <div class="box_in">
   	<p>$led_pat[0]</p>
    </div>
  </div>
  <div class="box21">
    <div class="box_in">
    	<p></p>
    </div>
  </div>
  <div class="box2">
    <div class="box_in">
    	<p><img src=/touzaisen-226px-73px-000000-F105.png></p>
    </div>
  </div>
  <div class="box3">
    <div class="box_in">
    	<p>$led_pat[0]</p>
    </div>
  </div>
  <div class="box31">
    <div class="box_in">
    	<p></p>
    </div>
  </div>
  <div class="box2">
    <div class="box_in">
    	<p><img src=/fukutoshinsen-226px-73px-000000-F105.png></p>
    </div>
  </div>
  <div class="box3">
    <div class="box_in">
    	<p>$led_pat[0]</p>
    </div>
  </div>
eof;
//for debug
   //<tr><td bgcolor="#00ff00"><font size="7" color="#ffffff">運行情報</font></td>
   //<tr><td bgcolor="#80c241" width="10%"></td><td width="70%"><h1>$line_name[0]</h1></td><td class="entry-content" width="20%"><h1>$led_pat[0]</h1></td></tr>
   //<tr><td bgcolor="#009bbf"></td><td><h1>$line_name[1]</h1></td><td class="entry-content"><h1>$led_pat[1]</h1></td></tr>
   //<tr><td bgcolor="#9c5e31"></td><td><h1>$line_name[2]</h1></td><td class="entry-content"><h1>$led_pat[2]</h1></td></tr>
	
//for debug
   //var_dump($led_pat["rail_pat"]);
   //var_dump( phpinfo() );

?>

</body>
</html>
