<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="refresh" content="30" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>高田馬場の運行情報・天気</title>
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW,NOARCHIVE" />
<!--ビューポート設定-->
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<head>
<style type="text/css">
html {
        height: 100%;
}
body {	/* 表示領域のサイズ */
        width:   470px;
        height:  800px;
        margin:  0;
        padding: 0;
        border:  1px solid black;
}
table {width: 100%; table-layout: fixed;}
td, th {
    padding: 0px;
}
.entry-content {
  text-align:center; /* 文字を中央に */
}
img {margin-left: 10px;}
.entry-content h1{
  font-size:400%; /* 文字サイズ大き目 */
  font-weight:bold; /* 文字を太文字に */
  text-align:center; /* 文字を中央に */
  color:#000000; /* 文字の色を黒に */
  //background-color:#ffffcc; /* 背景色を薄いクリーム色に */
  //padding:0px 0 0 0px; /* 余白の調整 */
}
.box{  
      width:100%;  
      height:13%;
      display: flex;
      align-items: center;
      justify-content: center;
}  
.box0{  
      background-color:#006600;  
      width:100%;  
      height:100%;  
}
.box1{  
      background-color:#0000CD;  
      color: #ffffff;
      width:100%;  
      height:100%;  
      bottom: 0;
      line-height: 1.4;
      font-size: 45px;
      font-family: "メイリオ";
      text-indent: 0.5em;
      letter-spacing: 0px;
}
.box2 {	/* 本日の天気画像 */
        margin: 15px 0px 0px 5px;
        float: left;
        width: 34%;
        height: 40%;
        //border:  1px solid blue;
}
.box2 img {	/* 本日の天気画像 */
        margin: auto;
        //border:  1px solid red;
}
.box3 {	/* 本日の日付 */
        margin: 30px 15px 0px 0px;
        //margin: 15px 15px 0px 0px;
        float: right;
        width: 60%;
        //height: 40%;
        //border:  1px solid green;
}
.box4 {	/* 明日以降の日付天気 */
        margin: 190px 4px 0px 4px;
        float: bottom;
        height: 36%;
        //border:  1px solid blue;
}
.box4 img {margin-left: 0px;}
.content1 { /* 本日の日付 */
        text-align: right;
        //white-space: nowrap;
        //vertical-align: bottom;
        line-height: 2.5;
        font-size: 30px;
        //font-size: 35px;
        font-family: "メイリオ";
}
.content2 { /* 本日の気温 */
        text-align: right;
        white-space: nowrap;
        //vertical-align: top;
        font-size: 35px;
        font-family: "メイリオ";
}
.content3 { /* 明日以降日付 */
        text-align: center;
        font-size: 18px;
        font-family: "メイリオ";
}
#traffic {
        width:   470px;
        height:  400px;
        margin:  0;
        padding: 0;
        //border:  1px solid black;
}
#weather {
        width:   470px;
        height:  400px;
        margin:  0;
        padding: 0;
        //border:  1px solid black;
}
</style>
<body>

<?php

/******************************/
/* 高田馬場周辺の列車運行情報 */
/******************************/

// 情報取得する路線名設定
$line_name = ["山手線","東京メトロ東西線","東京メトロ副都心線","西武新宿線"];
 
// JRだけではないため　Yahoo! Japan運行情報 より取得する
// Yahoo! Japan運行情報のURL
// 以下は関東地方の運行情報URL
$url = "http://transit.yahoo.co.jp/traininfo/area/4/";
// ローカル環境でのデバッグ用
//$url = "http://localhost/signage/traffic.txt";

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
            $led_pat[] =  "<img src=heijou20180403.png width='75%'>" ;
	    //$return_pat0[] = $railway_info[$i+1];
            //$return_pat0[] = $railway_info[$i+2];
            break;
        } else {
            // 平常運転でなければ「遅延」が含まれるかチェック
            $pos = strpos($railway_info[$i+1], "遅延");
            if($pos !== false) {
                // 遅延
                //$led_pat += [ "rail_state" => "▲" ];
                $led_pat[] = "<img src=chien-242px-56px-ff7f00-F105.png width='75%'>" ;
                $return_pat0[] = $railway_info[$i+1];
                $return_pat0[] = $railway_info[$i+2];
                 break;
            } else {
                // 平常運転、遅延でもない場合
                //$led_pat += [ "rail_state" => "×" ];
                //$led_pat += [ "rail_state" => $railway_info[$i+1] ];
                //$led_pat += [ "rail_state_detail" => $railway_info[$i+2] ];
                $led_pat[] = "<img src=info-279px-57px-4da6ff-F105.png width='75%'>" ;
                $return_pat0[] = $railway_info[$i+1];
                $return_pat0[] = $railway_info[$i+2];
                 break;
            }
        }
    }
}
}

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
<div id="traffic">
  <div class="box"> 
    <div class="box0">
      <img src=unkoujouhou-240px-46px-ffffff-F105.png width="50%">
    </div> 
  </div> 
 
  <table>
   <tr height=40px>
    <td width="10%"><img src=yamanote20180403.png width="100%"></td>
    <td width="50%"><img src=yamanote-226px-51px-000000-F105.png width="50%"></td>
    <td class="entry-content" width="40%">$led_pat[0]</td>
   </tr>
   <tr height=40px>
    <td width="10%"><img src=touzaisen20180403.png width="100%"></td>
    <td width="50%"><img src=touzaisen-226px-73px-000000-F105.png width="100%"></td>
    <td class="entry-content" width="40%">$led_pat[1]</td>
   </tr>
   <tr height=40px>
    <td width="10%"><img src=fukutosinsen20180403.png width="100%"></td>
    <td width="50%"><img src=fukutoshinsen-226px-73px-000000-F105.png width="100%"></td>
    <td class="entry-content" width="40%">$led_pat[2]</td>
   </tr>
   <tr height=40px>
    <td width="10%"><img src=seibusinjukusen20180403.png width="100%"></td>
    <td width="55%"><img src=seibusinjukusen-228px-43px-000000-F105.png width="55%"></td>
    <td class="entry-content" width="40%">$led_pat[3]</td>
   </tr>
  </table> 
</div>
eof;

  //<table>
  // <tr height=30px><td bgcolor="#006600"><img src=unkoujouhou-240px-46px-ffffff-F105.png width="40%"></td></tr>
  //</table>
   //<tr><td bgcolor="#00ff00"><font size="7" color="#ffffff">運行情報</font></td>
   //<tr><td bgcolor="#80c241" width="10%"></td><td width="70%"><h1>$line_name[0]</h1></td><td class="entry-content" width="20%"><h1>$led_pat[0]</h1></td></tr>
   //<tr><td bgcolor="#009bbf"></td><td><h1>$line_name[1]</h1></td><td class="entry-content"><h1>$led_pat[1]</h1></td></tr>
   //<tr><td bgcolor="#9c5e31"></td><td><h1>$line_name[2]</h1></td><td class="entry-content"><h1>$led_pat[2]</h1></td></tr>

	
  //遅延情報は文字が途中で切れてしまっているため、サイネージで表示した場合、恰好悪いので表示させない

//var_dump($led_pat["rail_pat"]);
//var_dump( phpinfo() );

/************/
/* 天気情報 */
/************/

// 日時を取得する
$timestamp =  date( "Y年m月d日 H時i分s秒 現在" ) ;
// 秒を取得する
$min_work = (int)date("s");
// 30以上は英語、30未満は日本語
if ($min_work > 30) {
	$lang_set = 1;
} else {
	$lang_set = 0;
}
// タイトル文字を設定
if ($lang_set === 1) {
    $title = " Weather";
} else {
    $title = " 天 気";  
}

// Yahoo!天気の情報を取得する
$weather_url = "https://rss-weather.yahoo.co.jp/rss/days/4410.xml";
// ローカル環境でのデバッグ用
//$weather_url = "http://localhost/signage/4410.xml";

$weather_html = file_get_contents($weather_url);

$weather_info = explode("<item>", $weather_html);

// 取得結果の配列初期化
$date_pat = [];
$weather_pat = [];
$weather_img = [];
$temper_pat = [];

// 取得結果を配列へ格納
for($i=1; $i<count($weather_info)-1; $i++) {
    $pos1 = strpos($weather_info[$i], "東京（東京）");	// "東京（東京）"のある行を取り出す
    if ($pos1 !== false) {
        $weather_work = explode(" ", $weather_info[$i]);	// スペース区切りで文字列を取り出す
        $date_pat[] = $weather_work[1];
        $weather_pat[] = $weather_work[4];
        $temper_pat[] = $weather_work[6];
        // 天気画像の選択
        switch ($weather_work[4]) {
            case "晴れ":
                $weather_img[] = "<img src=hare.png";
                break;
            case "晴時々曇":
                $weather_img[] = "<img src=hare_tokidoki_kumori.png";
                break;
            case "晴時々雨":
                $weather_img[] = "<img src=hare_tokidoki_ame.png";
                break;
            case "晴時々雪":
                $weather_img[] = "<img src=hare_tokidoki_yuki.png";
                break;
            case "晴後曇":
                $weather_img[] = "<img src=hare_nochi_kumori.png";
                break;
            case "晴後雨":
                $weather_img[] = "<img src=hare_nochi_ame.png";
                break;
            case "晴後雪":
                $weather_img[] = "<img src=hare_nochi_yuki.png";
                break;
            case "曇り":
                $weather_img[] = "<img src=kumori.png";
                break;
            case "曇時々晴":
                $weather_img[] = "<img src=kumori_tokidoki_hare.png";
                break;
            case "曇時々雨":
                $weather_img[] = "<img src=kumori_tokidoki_ame.png";
                break;
            case "曇時々雪":
                $weather_img[] = "<img src=kumori_tokidoki_yuki.png";
                break;
            case "曇後晴":
                $weather_img[] = "<img src=kumori_nochi_hare.png";
                break;
            case "曇後雨":
                $weather_img[] = "<img src=kumori_nochi_ame.png";
                break;
            case "曇後雪":
                $weather_img[] = "<img src=kumori_nochi_yuki.png";
                break;
            case "雨":
                $weather_img[] = "<img src=ame.png";
                break;
            case "雨時々晴":
                $weather_img[] = "<img src=ame_tokidoki_hare.png";
                break;
            case "雨時々曇":
                $weather_img[] = "<img src=ame_tokidoki_kumori.png";
                break;
            case "雨時々雪":
                $weather_img[] = "<img src=ame_tokidoki_yuki.png";
                break;
            case "暴風雨":
                $weather_img[] = "<img src=bouhu_u.png";
                break;
            case "雨後晴":
                $weather_img[] = "<img src=ame_nochi_hare.png";
                break;
            case "雨後曇":
                $weather_img[] = "<img src=ame_nochi_kumori.png";
                break;
            case "雨後雪":
                $weather_img[] = "<img src=ame_nochi_yuki.png";
                break;
            case "雪":
                $weather_img[] = "<img src=yuki.png";
                break;
            case "雪時々晴":
                $weather_img[] = "<img src=yuki_tokidoki_hare.png";
                break;
            case "雪時々曇":
                $weather_img[] = "<img src=yuki_tokidoki_kumori.png";
                break;
            case "雪時々雨":
                $weather_img[] = "<img src=yuki_tokidoki_ame.png";
                break;
            case "暴風雪":
                $weather_img[] = "<img src=bouhu_setsu.png";
                break;
            case "雪後晴":
                $weather_img[] = "<img src=yuki_nochi_hare.png";
                break;
            case "雪後曇":
                $weather_img[] = "<img src=yuki_nochi_kumori.png";
                break;
            case "雪後雨":
                $weather_img[] = "<img src=yuki_nochi_ame.png";
                break;
        }
    }
}
$weather_img[0] = $weather_img[0]." width='100%'>";
$weather_img[1] = $weather_img[1]." width='100%'>";
$weather_img[2] = $weather_img[2]." width='100%'>";
$weather_img[3] = $weather_img[3]." width='100%'>";
$weather_img[4] = $weather_img[4]." width='100%'>";

$date = new DateTime();
//$date = new DateTime('2018-09-12');
if ($lang_set === 1) {	// 英語の日付曜日を設定
    $date_pat[0] = $date->format("l,M d");
    //$date_pat[0] = $date->format("l,F d");
    //$date_pat[0] = str_replace(",", ",<br>",$date_pat[0]);
    $date_pat[1] = $date->modify('+1 day')->format("D,M d");
    $date_pat[2] = $date->modify('+1 day')->format("D,M d");
    $date_pat[3] = $date->modify('+1 day')->format("D,M d");
    $date_pat[4] = $date->modify('+1 day')->format("D,M d");
} else {	// 本日の日付の前に月を表示
    $date_pat[0] = date('n月').$date_pat[0];
    //$date_pat[0] = date('n月').$date_pat[0]."<br><br>";
}

/* 表示する変数の内容
$date_pat[0]		// 当日日時曜日
$weather_pat[0]		// 当日天気文字（非表示）
$weather_img[0]		// 当日天気画像
$temper_pat[0]		// 当日気温
$date_pat[1]		// １日後日時曜日
$weather_pat[1]		// １日後天気文字（非表示）
$weather_img[1]		// １日後天気画像
$date_pat[2]		// ２日後日時曜日
$weather_pat[2]		// ２日後天気文字（非表示）
$weather_img[2]		// ２日後天気画像
$date_pat[3]		// ３日後日時曜日
$weather_pat[3]		// ３日後天気文字（非表示）
$weather_img[3]		// ３日後天気画像
$date_pat[4]		// ４日後日時曜日
$weather_pat[4]		// ４日後天気文字（非表示）
$weather_img[4]		// ４日後天気画像
*/

print<<<eof
<div id="weather">
<div class="box">
<div class="box1">
$title
</div>
</div>

<div class="box2">
$weather_img[0]
</div>

<div class="box3">
<div class="content1">$date_pat[0]</div>
<div class="content2">$temper_pat[0]</div>
</div>

<div class="box4">
<table>
<tr class="content3">
  <td>$date_pat[1]</td>
  <td>$date_pat[2]</td>
  <td>$date_pat[3]</td>
  <td>$date_pat[4]</td>
</tr>
<tr>
  <td>$weather_img[1]</td>
  <td>$weather_img[2]</td>
  <td>$weather_img[3]</td>
  <td>$weather_img[4]</td>
</tr>
</table>
</div>
</div>

eof;
?>

</div>
</body>
</html>
