<?php
// URL SHORTENER
// Please set the parameters to connect to your database in the line below:
require_once "Mobile_Detect.php";
$db = mysqli_connect("127.0.0.1", "sht", "c6b36f8b8a88180a6a42bb78f84ebe53b8", "sht");
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    exit(1);
}
//create clss to detect mobile
$detect = new Mobile_Detect;

//REDIRECTION
if(count($_REQUEST)==1 && !isset($_REQUEST['makeurl'])){
    $shorturl="https://".$_SERVER['SERVER_NAME'].mysqli_real_escape_string($db,$_SERVER['REQUEST_URI']);
    $s="select * from shorturls where shorturl='".$shorturl."' and (maxclicks=0 or totclicks<maxclicks) and (maxseconds=0 or date_add(dtcreation,interval maxseconds second)>now())";
    $x=mysqli_query($db,$s);
    if(mysqli_num_rows($x)==0)
        $rdr="https://".$_SERVER['SERVER_NAME'];
    else{
        $r=mysqli_fetch_array($x);
        if($r['mobileonly']==true && !$detect->isMobile())
            $rdr="https://".$_SERVER['SERVER_NAME'];
        else
            $rdr=$r['destinationurl'];
    }
    header("Location: ".$rdr);
    $s="update shorturls set totclicks=totclicks+1,dtlastclick=now() where id=".$r['id'];
    mysqli_query($db,$s);
    mysqli_close($db);
    exit;
    
}
//INPUT FORM
if(count($_REQUEST)==0 || (count($_REQUEST)>0 && isset($_REQUEST['makeurl'])) ){
    $longurl="";
    $maxclicks=0;
    $maxseconds=0;
    $mobileonly="No";
    if(isset($_REQUEST['longurl'])) $longurl=mysqli_real_escape_string($db,$_REQUEST['longurl']);
    if(isset($_REQUEST['maxclicks'])) $maxclicks=mysqli_real_escape_string($db,$_REQUEST['maxclicks']);
    if(isset($_REQUEST['maxseconds'])) $maxseconds=mysqli_real_escape_string($db,$_REQUEST['maxseconds']);
    if(isset($_REQUEST['mobileonly'])) $mobileonly=mysqli_real_escape_string($db,$_REQUEST['mobileonly']);
    if($_REQUEST['makeurl']!="yes"){
        echo '<img src=logo.png width=350>';
        echo "<form method=post>";
        echo '<input type="text" name="longurl" value="'.$longurl.'"size="64" maxlength="64"> Url to shorten<br>';
        echo '<input type="number" name="maxclicks" value="'.$maxclicks.'">Max clicks (0=unlimited)<br>';
        echo '<input type="number" name="maxseconds" value="'.$maxseconds.'">Duration in seconds (0=unlimited)<br>';
        echo '<input type="radio" id="onlymob" name="mobileonly" value="Yes"';
        if($mobileonly=="Yes") echo ' checked';
        echo '>';
        echo '<label for="onlymob">Mobile Only</label><br>';
        echo '<input type="radio" id="anydev" name="mobileonly" value="No"';
        if($mobileonly=="No") echo ' checked';
        echo '>';
        echo '<label for=anydev">Any Device</label><br>';
        echo '<input type="submit" name="makeurl" value="Shorten URL">';
        echo "</form>";
    }
    //generation of short url
    if(strlen($longurl)>0){
            if(substr($longurl,0,7)!="http://" && substr($longurl,0,8)!="https://")
                $longurl="http://".$longurl;
            while(1){
                $bytes=openssl_random_pseudo_bytes(32);
                $hex= substr(bin2hex($bytes),0,7);
                $shorturl="https://".$_SERVER['SERVER_NAME']."/?".$hex;
                $s="select * from shorturls where shorturl='".$shorturl."'";
                $x=mysqli_query($db,$s);
                if(mysqli_num_rows($x)>0)
                    continue;
                break;        
            }
            if($_REQUEST['makeurl']!="yes"){
                echo "<hr>";
                echo "<h2>".$shorturl."</h2>";
            }
            else
                echo $shorturl;
            $s="insert into shorturls set ";
            $s.="ipaddresscreator='".$_SERVER['REMOTE_ADDR']."',";
            $s.="maxclicks=".intval($maxclicks).",";
            $s.="maxseconds=".intval($maxseconds).",";
            $s.="mobileonly=";
            if($mobileonly=="Yes")
                $s.="true,";
            else
                $s.="false,";
            $s.="dtcreation=now(),";
            $s.="shorturl='".$shorturl."',";
            $s.="destinationurl='".$longurl."'";
            mysqli_query($db,$s);
            mysqli_close($db);
    }
    if($_REQUEST['makeurl']!="yes"){
        echo "<hr>";
        showfooter();
    }
}
//function to check if the browser is mobile originated or not
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
// function to show the footer
function showfooter(){
    echo 'This is a super fast URL shortener to generate static or temporary short urls that disappear after some time or a certain number of clicks.<br>';
    echo '<b>Application Program Interface (API):</b><BR>';
    echo 'You can integrate the URL Generation in your system by https call to https://sht.ai/?makeurl=yes) with the following parameters:<br>';
    echo '- longurl: is the long url to shorten (mandatory)<br>';
    echo '- maxclicks: the maximum number of clicks before delete the short url (optional)<br>';
    echo '- maxseconds: the number of seconds of duration (optional)<br>';
    echo '- mobileonly: (Yes/No) if set to YES only mobile device will be able to see the destination url (optional)<br>'; 
    echo "example usable from any browser:<br>https://sht.ai/?makeurl=yes&longurl=https://www.google.com&maxclicks=10<br>";
    echo "<b>Source Code:</b><br>";
    echo "The source code used to make this url shortener is freely available from:";
    echo "<a href=https://github.com/samuelelandi/Url-Shortener>https://github.com/samuelelandi/Url-Shortener</a><hr>";
    
}

?>