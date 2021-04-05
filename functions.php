<?php
$_debug = true;
$_report = false;
$_show_msg = true;
$mantis_project = 65;

function create_slug($str){

      // remove non letter or digits
    $str = preg_replace('/[^A-Za-z0-9-]+/', '-', $str);

    // lowercase
    $str = strtolower($str);

    return $str;
}

function queryclean($var, $param = '') {

    $acceptable_string_values = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789 -_?!.,|@:/=&$");

    if (is_array($var)) {
        foreach ($var as $i => $v) {
            $var[queryclean($i)] = queryclean($v);
        }
    } else {
        if (is_numeric($var)) {
            return $var;
        } elseif (is_string($var)) {

            $aux = str_split($var);

            return implode(array_intersect($aux, $acceptable_string_values));
        }
    }
}

function generate_random_str($str_num = 3){
  $char_set = "abcdefghijklmnopqrstuvwxyz";
  $char_set_len = strlen($char_set);
  $random_str = "";
  for($i = 0; $i < $str_num; $i++){
    $random_str .= $char_set[rand(0, $char_set_len - 1)];
  }

  return $random_str;
}

function rrmdir($src) {
    $dir = opendir($src);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            $full = $src . '/' . $file;
            if ( is_dir($full) ) {
                rrmdir($full);
            }
            else {
                unlink($full);
            }
        }
    }
    closedir($dir);
    rmdir($src);
}

function flush_buffers(){ 
    ob_end_flush();
    ob_flush();
    flush();
    ob_start();
}

function get($_param) {
    $_rq = $_REQUEST;

    if ($_param == "brandid" && $_GET["id"] != "") {
        $_rq["brandid"] = $_GET["id"];
    }
    if ($_param == "brandid" && $_GET["brand"] != "") {
        $_rq["brandid"] = $_GET["brand"];
    }
    $ret = trim(@$_rq[$_param]);

    return queryclean($ret, $_param);
}

function clean($var, $param = '') {
//  return preg_replace('/[^a-z0-9]/i','_',$var);
    $acceptable_string_values = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_ ");

    if (is_array($var)) {
        foreach ($var as $i => $v) {
            $var[clean($i)] = clean($v);
        }
    } else {
        if (is_numeric($var)) {
            return $var;
        } elseif (is_string($var)) {

            $aux = str_split($var);

            return implode(array_intersect($aux, $acceptable_string_values));
        }
    }
}

function mysqli_fetch_full_result_array($result) {
    $table_result = array();
    $r = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $arr_row = array();
        $c = 0;
        while ($c < mysqli_num_fields($result)) {
            $col = mysqli_fetch_field($result);
            $arr_row[$col->name] = trim(stripslashes($row[$col->name]));
            $c++;
        }
        $table_result[$r] = $arr_row;
        $r++;
    }
    return $table_result;
}

function sql($sql, $con = "") {
    global $dbh;
    if (!$con) {
        $con = $dbh;
    }
    $result = mysqli_query($con, $sql); // or oops(mysql_error());
    if ($result) {
        $arr_table_result = array();
        while($_arr_table_result = mysqli_fetch_assoc($result)){
            $arr_table_result[] = $_arr_table_result;
        }
        mysqli_free_result($result);
    }

    return $arr_table_result;
}

function sql_new($sql, $con = ""){
    global $dbh;
    if (!$con) {
        $con = $dbh;
    }
    $result = mysqli_query($sql, $con); // or oops(mysql_error());
    
    if ($result) {
        $arr_table_result = array();
        while($_arr_table_result = mysqli_fetch_assoc($result)){
            $arr_table_result[] = $_arr_table_result;
        }
        mysqli_free_result($result);
    }

    return $arr_table_result;   
}

function mysqli_query_custom($query, $con = "") {
    global $dbh;
    if (!$con) {
        $con = $dbh;
    }
    // log the query somewhere for debugging purpose
    //return mysql_query($query, $con) or print($query . "<hr>" . mysql_error());
    return mysqli_query($con, $query);
}

function insert($table, $data, $con = "") {
    global $dbh;
    if (!$con) {
        $con = $dbh;
    }
    $sets = array();
    $data = _insert($data);

    foreach ($data as $k => $v) {
        $sets[] = "$k=\"" . mysqli_real_escape_string($con, $v) . "\"";
    }
    $q = "INSERT INTO " . $table . " SET " . implode(", ", $sets);
    $data = "";
    mysqli_query_custom($q, $con);
    return mysqli_insert_id($con);
}

function update($table, $where, $data, $asIs = "", $con = "") {
    global $dbh;
    if (!$con) {
        $con = $dbh;
    }
    $sets = array();
  $data = _update($data);
    foreach ($data as $k => $v) {
        if ($asIs) {
            $sets[] = "`$k`=" . $v . "";
        } else {
            $sets[] = "`$k`=\"" . mysqli_real_escape_string($con, $v) . "\"";
        }
    }
    $q = "UPDATE `" . $table . "` SET " . implode(", ", $sets) . " WHERE $where";
    $data = "";
    return mysqli_query_custom($q, $con);
}

function insertorupdate($table, $data, $where, $asIs = "", $con) {
    global $dbh;
    $sets = array();

    $count = array_shift(sql("select count(*) as counts from `{$table}` where {$where}"));
    if ($count['counts'] == 0) {
        $action = "INSERT INTO ";
        $data = _insert($data);
    } else {
        $action = "UPDATE ";
        $data = _update($data);
    }


    foreach ($data as $k => $v) {
        if ($asIs) {
            $sets[] = "`$k`=" . $v . "";
        } else {
            $sets[] = "`$k`=\"" . mysqli_real_escape_string($con, $v) . "\"";
        }
    }

    $q = $action . "`" . $table . "` SET " . implode(", ", $sets);
    if ($action == "UPDATE ") {
        $q.=" WHERE $where";
    }
    return mysqli_query_custom($q, $con);
}

function delete($table, $whr, $con = "") {
    global $dbh;
    if (!$con) {
        $con = $dbh;
    }
    $q = "delete from {$table} where $whr";
    return mysqli_query_custom($q, $con);
}

function getPageName() {
    
}

function decode($string, $key) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    $j = 0;
    $hash = "";
    for ($i = 0; $i < $strLen; $i+=2) {
        $ordStr = hexdec(base_convert(strrev(substr($string, $i, 2)), 36, 16));
        if ($j == $keyLen) {
            $j = 0;
        }
        $ordKey = ord(substr($key, $j, 1));
        $j++;
        $hash .= chr($ordStr - $ordKey);
    }
    return $hash;
}

function encode($string, $key) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    $j = 0;
    $hash = "";
    for ($i = 0; $i < $strLen; $i++) {
        $ordStr = ord(substr($string, $i, 1));
        if ($j == $keyLen) {
            $j = 0;
        }
        $ordKey = ord(substr($key, $j, 1));
        $j++;
        $hash .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
    }
    return $hash;
}

function formatcurrency($_amount, $curr = "$") {
    return $curr . " " . number_format($_amount, 2);
}

function doReferesh($url = "", $secure = "false") {
    global $siteurl, $ssl_siteurl;
    if ($secure) {
        echo '<meta http-equiv="refresh" content="0;url=' . $ssl_siteurl . $url . '">';
        die;
    } else {
        echo '<meta http-equiv="refresh" content="0;url=' . $siteurl . $url . '">';
        die;
    }
    exit;
}

function setSession($key, $val) {
    $_SESSION[$key] = $val;
    return;
}

function getSession($key) {
    return @$_SESSION[$key];
}

function setMessage($_msg, $type = '') {
    setSession('msg', $_msg);
    setSession('type', $type);
    return;
}

function getMessage() {
    $ret='';
    if(isset($_SESSION['type']))
    {      
        if(getSession('type') == 'error') {
            $ret = "<div class='alert'>
                    <span class='closebtn' onclick=" . "this.parentElement.style.display='none';>&times;</span>" .
                    getSession('msg') . "</div>";
        } else if (getSession('type') == 'success') {
            $ret = "<div class='alert success'>
                    <span class='closebtn' onclick=" . "this.parentElement.style.display='none';>&times;</span>" .
                    getSession('msg') . "</div>";
        }
    }
    setSession('msg', '');
    setSession('type', '');
    return $ret;
}

function oops($msg = '') {
    global $_debug, $_report, $mantis_project, $_show_msg;

    //////////////////////////////////////////////
    //        Config variable starts    //
    //////////////////////////////////////////////
    $bt = array_reverse(debug_backtrace());
    $_error = $bt[0]['file'] . " (function: " . $bt[0]['function'] . ")";
    $errno = "Line: " . $bt[0]['line'];
    $error = ("<br /><br />Backtrace (most recent call last):<br /><br />\n");
    $page = curPageURL();

    for ($i = 0; $i <= count($bt) - 1; $i++) {
        if (!isset($bt[$i]["file"]))
            $error.=("[PHP core called function]<br />");
        else
            $error.=("File: " . $bt[$i]["file"] . "<br />");

        if (isset($bt[$i]["line"])) {
            $error.=("&nbsp;&nbsp;&nbsp;&nbsp;line " . $bt[$i]["line"] . "<br />");
        }
        $error.=("&nbsp;&nbsp;&nbsp;&nbsp;function called: " . $bt[$i]["function"]);

        if ($bt[$i]["args"]) {
            $error.=("<br />&nbsp;&nbsp;&nbsp;&nbsp;args: ");
            for ($j = 0; $j <= count($bt[$i]["args"]) - 1; $j++) {
                if (is_array($bt[$i]["args"][$j])) {
                    //print_r($bt[$i]["args"][$j]);
                } else
                    $error.=($bt[$i]["args"][$j]);

                if ($j != count($bt[$i]["args"]) - 1)
                    $error.=(", ");
            }
        }
        $error.=("<br /><br />");
    }
    $data['username'] = "sawan";
    $data['password'] = "saswan123";
    $data['return'] = "index.php";
    $data['submit'] = "Login";
    $project['project_id'] = $mantis_project;
    $bug['m_id'] = "0";
    $bug['project_id'] = $mantis_project;
    $bug['max_file_size'] = "5000000";
    $bug['category_id'] = "2";
    $bug['summary'] = $errno . ": " . $_error;
    $bug['description'] = "URL: " . $page . $error;

    $_errorhtml = "";
    $_errorhtml .=' <table align="center" border="1" cellspacing="0" style="background:white;color:black;width:80%;">';
    $_errorhtml .=' <tr><th colspan=2>Database Error</th></tr>';
    $_errorhtml .=' <tr><td align="right" valign="top">Message:</td><td>' . $bug['summary'] . '</td></tr>';
    if (strlen($error) > 0) {
        $_errorhtml .= '<tr><td align="right" valign="top" nowrap>MySQL Error:</td><td>' . $bug['description'] . '</td></tr>';
    }
    $_errorhtml .=' <tr><td align="right">Date:</td><td>' . date("l, F j, Y \a\\t g:i:s A") . '</td></tr>';
    $_errorhtml .=' <tr><td align="right">Script:</td><td><a href="' . @$_SERVER['REQUEST_URI'] . '">' . @$_SERVER['REQUEST_URI'] . '</a></td></tr>';
    if (strlen(@$_SERVER['HTTP_REFERER']) > 0) {
        $_errorhtml .= '<tr><td align="right">Referer:</td><td><a href="' . @$_SERVER['HTTP_REFERER'] . '">' . @$_SERVER['HTTP_REFERER'] . '</a></td></tr>';
    }
    $_errorhtml .=' </table>';
    if ($_debug) {
        echo $_errorhtml;
    }
    if ($_report) {
        if ($_show_msg) {
            echo "<div id='_error_'><center><h1>Sorry! There was an error, please wait while system is reporting the error to us...";
        }
        flush();

        //////////////////////////////////////////////
        //        Config variable ends    //
        //////////////////////////////////////////////

        curl("http://bugs.thirdeyeinc.co.in/login.php", $data);
        curl("http://bugs.thirdeyeinc.co.in/set_project.php", $project);

        $get_token = curl("http://bugs.thirdeyeinc.co.in/bug_report_page.php");
        $token = explode("bug_report_token", $get_token);
        $token = explode("\"", $token[1]);
        $token = trim($token[2]);

        $bug['bug_report_token'] = $token;
        curl("http://bugs.thirdeyeinc.co.in/bug_report.php", $bug);

        if ($_show_msg) {
            echo "Done</h1></center></div>";
        }
    }
    die;
}

function curPageURL() {
    $pageURL = 'http';
    if (@$_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

function sentenceNormalizer($sentence_split) {
    $sentence_split = preg_replace(array('/[!]+/', '/[?]+/', '/[.]+/'), array('!', '?', '.'), $sentence_split);

    $textbad = preg_split("/(\!|\.|\?|\n)/", $sentence_split, -1, PREG_SPLIT_DELIM_CAPTURE);
    $newtext = array();
    $count = sizeof($textbad);

    foreach ($textbad as $key => $string) {
        if (!empty($string)) {
            $text = trim($string, ' ');
            $size = strlen($text);

            if ($size > 1) {
                $newtext[] = ucfirst(strtolower($text));
            } elseif ($size == 1) {
                $newtext[] = ($text == "\n") ? $text : $text . ' ';
            }
        }
    }

    return implode($newtext);
}

function backup_tables($tables = '*') {
    global $dbh;

    //get all of the tables
    if ($tables == '*') {
        $tables = array();
        $result = mysqli_query($con, 'SHOW TABLES', $dbh);
        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }
    } else {
        $tables = is_array($tables) ? $tables : explode(',', $tables);
    }
    //cycle through
    foreach ($tables as $table) {
        $result = mysqli_query($con, 'SELECT * FROM ' . $table, $dbh);
        $num_fields = mysqli_num_fields($result);

        $return.= 'DROP TABLE ' . $table . ';';
        $row2 = mysqli_fetch_row(mysqli_query($con, 'SHOW CREATE TABLE ' . $table, $dbh));
        $return.= $row2[1] . ";";

        for ($i = 0; $i < $num_fields; $i++) {
            while ($row = mysqli_fetch_row($result)) {
                $return.= 'INSERT INTO ' . $table . ' VALUES(';
                for ($j = 0; $j < $num_fields; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = ereg_replace("\n", "\\n", $row[$j]);
                    if (isset($row[$j])) {
                        $return.= '"' . $row[$j] . '"';
                    } else {
                        $return.= '""';
                    }
                    if ($j < ($num_fields - 1)) {
                        $return.= ',';
                    }
                }
                $return.= ");";
            }
        }
        $return.="\n\n\n";
    }

    //save file
    $filename = 'db-backup-' . time() . '-' . (md5(implode(',', $tables))) . '.sql';
    $handle = fopen($filename, 'w+');
    fwrite($handle, $return);
    fclose($handle);
    return $filename;
}

// audit fields functions

function _insert(array $data) {

    if (is_array($data)) {
        if (!array_key_exists('audit_created_by', $data)) {
            $data['audit_created_by'] = getSession('username');
        }
        if (!array_key_exists('audit_created_date', $data)) {
            $data['audit_created_date'] = date('Y-m-d H:i:s');
        }
        if (!array_key_exists('audit_ip', $data)) {
            $data['audit_ip'] = $_SERVER['REMOTE_ADDR'];
        }
    }

    return $data;
}

function _update(array $data) {

    if (is_array($data)) {
        if (!array_key_exists('audit_update_by', $data)) {
            $data['audit_updated_by'] = getSession('username');
        }
        if (!array_key_exists('audit_updated_date', $data)) {
            $data['audit_updated_date'] = date('Y-m-d H:i:s');
        }
        if (!array_key_exists('audit_ip', $data)) {
            $data['audit_ip'] = $_SERVER['REMOTE_ADDR'];
        }
    }

    return $data;
}

function email($doseto, $dosefrom, $dosesubject, $dosebody, $dosereplyto) {
    $smtphost = "192.168.0.11";
    $smtpusername = "";
    $smtppassword = "";
    $smtpport = "25";
    $smtpauth = "0";

    $htmlemails = true;
    $debugmode = 0;
    /* if(!isset($_SESSION["dosentmails"])) {
      $_SESSION["dosentmails"] = array();
      }
      if(!in_array(md5($doseto.$dosesubject.$dosebody),$_SESSION["dosentmails"])) { */
    if (file_exists('./class.phpmailer.php')) {
        include_once('./class.phpmailer.php');
        $mail = new PHPMailer();
        //$mail->SetLanguage('en', './includes/');
        $mail->IsSMTP();
        if (@$debugmode)
            $mail->SMTPDebug = 2;
        $mail->Host = $smtphost;
        $mail->SMTPAuth = $smtpauth;
        $mail->Username = $smtpusername;
        $mail->Password = $smtppassword;
        $mail->Port = $smtpport;
        $mail->From = $dosefrom;
        $mail->FromName = $dosefrom;
        $doseto = explode(",", $doseto);
        foreach ($doseto as $doto) {
            $mail->AddAddress($doto);
        }
        if ($dosereplyto != '') {
            $mail->AddReplyTo($dosereplyto);
        } else {
            $mail->AddReplyTo($dosefrom);
        }
        // $mail->WordWrap = 50;
        $mail->IsHTML(TRUE);
        $mail->Subject = $dosesubject;
        $mail->Body = $dosebody;
        // $mail->AltBody = "Plain Text";
        if (!$mail->Send() && @$debugmode)
            echo 'Failed to send mail: ' . $mail->ErrorInfo;
    }else {
        if (@$customheaders == '') {
            $headers = "MIME-Version: 1.0\n";
            $headers .= "From: %from% <%from%>\n";
            if ($dosereplyto != '')
                $headers .= "Reply-To: %replyto% <%replyto%>\n";
            if (@$htmlemails == TRUE)
                $headers .= 'Content-type: text/html; charset=utf-8\n';
            else
                $headers .= 'Content-type: text/plain; charset=utf-8';
        } else
            $headers = $customheaders;
        $headers = str_replace('%from%', $dosefrom, $headers);
        $headers = str_replace('%to%', $doseto, $headers);
        if ($dosereplyto) {
            $headers = str_replace('%replyto%', $dosereplyto, $headers);
        } else {
            $headers = str_replace('%replyto%', $dosefrom, $headers);
        }
        $emailflags = str_replace('%from%', $dosefrom, @$emailflags);
        if (@$debugmode == TRUE)
            mail($doseto, $dosesubject, $dosebody, $headers, $emailflags);
        else
            @mail($doseto, $dosesubject, $dosebody, $headers, $emailflags);
    }

    //  $_SESSION["dosentmails"][] = md5($doseto.$dosebody);
    //}
}

function print_a($data) {
    $_head = "";
    $_data = "";
    if ($data) {
        $cols = array_keys($data[0]);
        foreach ($cols as $c) {
            $_head .= "<td><b>" . $c . "</b></td>";
        }

        foreach ($data as $d) {
            $_data .="<tr>";
            foreach ($cols as $_c) {
                $_data .= "<td>" . $d[$_c] . "</td>";
            }
            $_data.="</tr>";
        }
        echo "Total records found " . count($data) . "<table border=1><tr>" . $_head . "</tr>" . $_data . "</table>";
    }
}

function explodem($delimiters, $string) {

    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return $launch;
}

function curl($url, $pData = "") {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "cj.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cj.txt");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $pData);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

/*
  1. just call ajaxinit(); anywhere on the page so that jquery can be loaded and ajax function can be written
  2. example usage:
  <input type="button" onclick="ajax('ajax2.php','ajaxresultt','key1=value1&key2=value2')" value="press meeeee">
  <div id="ajaxresultt"></div>
 */

function ajaxinit() {
    global $jquery;
    if ($jquery) {
        return false;
    }
    $jquery = file_get_contents("http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js");
    $function = 'function ajax(e,n,r){if(r){t="POST"}else{t="GET"}_request="request"+Math.floor(Math.random()*999+1);_request=$.ajax({url:e,type:t,crossDomain:"true",dataType:"html",data:r,timeout:5e3,beforeSend:function(e){$("#"+n).html("loading")}});_request.done(function(e){$("#"+n).html(e)});_request.fail(function(e,t){$("#"+n).html("<pre>Request failed: "+t+"</pre>")})}';

    $functions = '    
  function ajax(u,divid,params) {
      if(params){ t = "POST"; }else{ t = "GET"; }
      _request = "request"+Math.floor((Math.random()*999)+1);
        _request = $.ajax({
            url: u,
            type: t,
            crossDomain: "true",
            dataType: "html",
            data : params,
            timeout: 5000,
            beforeSend: function( xhr ) {
          $("#"+divid).html("loading");    
        }
        });
        _request.done(function(msg) {
            $("#"+divid).html(msg);          
        });
 
        _request.fail(function(jqXHR, textStatus) {
          $("#"+divid).html("<pre>Request failed: " + textStatus + "</pre>");          
        });
    }';

    echo '<script type="text/javascript">' . $jquery . $function . '</script>';
}

function d($d) {
    echo '<pre>';
    print_r($d);
    echo '</pre>';
}

// Function to Copy folders and files       
function rcopy($src, $dst) {
    if (file_exists ( $dst ))
        rrmdir ( $dst );
    if (is_dir ( $src )) {
        mkdir ( $dst );
        $files = scandir ( $src );
        foreach ( $files as $file )
            if ($file != "." && $file != "..")
                rcopy ( "$src/$file", "$dst/$file" );
    } else if (file_exists ( $src ))
        copy ( $src, $dst );
}

function array_switch_keys($_data){
    $new_data = array();
    //change array keys
    foreach ($_data as $outerKey=>$idata) {
        foreach ($idata as $innerKey=>$innerdata) {
            $new_data[$innerKey][$outerKey] = $innerdata;
        }
    }
    return $new_data;
}

function pagination($total, $offset, $limit, $page, $link='', $link_param=""){
        $pages = ceil($total / $limit);
        $start = $offset + 1;
        $first = false;
        $last = false;
        $display_last_pages = false;
        $first_pages_list = array();
        $last_pages_list = array();
        $page_to_be_displaied = array();
        $add_right_dots = false;
        if($page==$pages){
            $last = true;   
        }
        if($page==1){
            $first = true;
            $higher = 3;
            if($pages<$higher){
                $higher = $pages;
            }
            for($count = 1; $count <= $higher; $count++ ){
                array_push($page_to_be_displaied, $count);
            }
        }
        elseif($pages<=3){
            $higher = 3;
            if($pages<$higher){
                $higher = $pages;
            }
            if($page==$pages){
                $last = true;   
            }
            for($count = 1; $count <= $higher; $count++ ){
                array_push($page_to_be_displaied, $count);
            }   
        }
        if($pages>3){
            //first numbers
            $higher = 3;
            if($page==4){
                $higher = 4;    
            }
            elseif($page>4&&($pages-3)>=$page){
                array_push($last_pages_list, $page);
            }
            if($page>1){
                for($count = 1; $count <= $higher; $count++ ){
                    array_push($page_to_be_displaied, $count);
                }
            }
            //last numbers
            if($pages==4&&$page!=4){
                array_push($last_pages_list, 4);
            }
            elseif($pages==5){
                if($page!=4){
                    array_push($last_pages_list, 4);
                }
                array_push($last_pages_list, 5);
            }
            elseif($pages==6){
                if($page!=4){
                    array_push($last_pages_list, 4);
                }
                array_push($last_pages_list, 5);
                array_push($last_pages_list, 6);
            }
            elseif($pages>6){
                $display_last_pages = true;
                if(($pages-$page)>3&&$page>4){
                    array_push($last_pages_list, '...');
                }
                for($count = $pages-2; $count <= $pages; $count++){
                    array_push($last_pages_list, $count);
                }
            }
        }
        $back = $page-1;
        $next = $page+1;
        $back_link = $link.''.$back;
        $next_link = $link.''.$next;
        $page_avail = false;
        if(strpos($link, '{{page}}')){
            $page_avail = true;
            $back_link = str_replace('{{page}}', $back, $link);
            $next_link = str_replace('{{page}}', $next, $link);
        }
        if($total>$limit){
            $response = '<nav aria-label="Brands navigation" class="pagination-nav">
                        <ul class="pagination">';
            if(!$first){
                $response .= '      <li class="page-item"><a class="page-link" href="'.$back_link.'">&lt; &nbsp; Back</a></li>';
            }
            else{
                $response .= '      <li class="page-item"><a class="page-link">&lt; &nbsp; Back</a></li>';  
            }
            foreach($page_to_be_displaied as $value){
                $response .= '      <li class="page-item '.($value==$page?'active':'').'"><a class="page-link" href="'.($page_avail?str_replace('{{page}}', $value, $link):($link.''.$value)).'">'.$value.'</a></li>';
            }
            if($display_last_pages){
                $response .= '<li class="page-item">&nbsp;...&nbsp;</li>';
            }
            if(count($last_pages_list)>0){
                foreach($last_pages_list as $value){
                    if($value=='...'){
                        $response .= '<li class="page-item">&nbsp;...&nbsp;</li>';
                    }
                    else{
                        $response .= '      <li class="page-item '.($value==$page?'active':'').'"><a class="page-link" href="'.($page_avail?str_replace('{{page}}', $value, $link):($link.''.$value)).'">'.$value.'</a></li>';
                    }
                }
            }
            if(!$last){
                $response .= '      <li class="page-item"><a class="page-link" href="'.$next_link.'">Next  &nbsp; &gt;</a></li>';
            }
            else{
                $response .= '      <li class="page-item"><a class="page-link">Next  &nbsp; &gt;</a></li>'; 
            }
            $response .= '  </ul>
                        </nav>';    
        }
        else{
            $response = '';
        }
        return $response;
    }
?>