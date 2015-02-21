<html>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<body>
<div class="container">

<?php
$rawurl = "";
$rawfname = "";
$fg = 1;
if (preg_match("/^https:\/\/www.youtube.com\/watch\?v=([a-zA-Z0-9\-\+_]*)$/",$_POST["ytubeurl"], $extdata)){
   // echo "Case 1: <br>";
    $rawurl = $extdata[0];
    $rawfname = $extdata[1];
}elseif ($_POST["ytubeurl"]!="" &&  preg_match("/^[a-zA-Z0-9\-\+_]*$/",$_POST["ytubeurl"], $extdata)){ 
   // echo "Case 2: <br>";
    $rawurl = "https://www.youtube.com/watch?v=".$extdata[0];
    $rawfname = $extdata[0];
}else { 
    //echo "Case 3: <br>";
    echo "<div class=\"alert alert-info alert-dismissable\">
       <button type=\"button\" class=\"close\" data-dismiss=\"alert\" 
             aria-hidden=\"true\">
                   &times;
                      </button>";
    echo "Invalid format! <br>";
    echo "</div>";
    $fg = 0;
}
//echo "rawurl: ".$rawurl." <br>";
//echo "rawfname: ".$rawfname." <br>" ;
if ($fg == 1){
    $url ="\" $rawfname\"";
    $template = escapeshellarg( $rawfname.".mp4");
    //echo "url: ". $url . "<br>";
    //echo "fname: ". $template."<br> ";
    if (file_exists($rawfname.".mp4")){

        echo "<h2>Download Here</h2>";
        echo "<a class=\"btn btn-info \" href=".$template.">" .$rawfname.".mp4"."</a>";
    }else{
        $string = ('youtube-dl '. ' -o ' . $template ." ". $url);
       // echo "command: ".$string . "<br>";
        $descriptorspec = array(
                0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
                1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
                2 => array("file", "log.txt", "a")// stderr is a file to write to
                );

        $process = proc_open($string, $descriptorspec, $pipes);
        //echo $process . "<br>";
        $stdout = stream_get_contents($pipes[1]);
        //echo fclose($pipes[1]) . "<br>";
        $ret = proc_close($process);
        // echo json_encode(array('status' => $ret,
        //               'url_orginal' => $url, 'output' => $stdout,
        //                             'command' => $string ));
        if (file_exists($rawfname.".mp4")){
            echo  " <h2>";
            echo "Download Here:</h2>"."<a class=\"btn btn-info\" href=".$template.">".$rawfname.".mp4"."</a>";
        }else{
            echo "<div class=\"alert alert-danger alert-dismissable\">
               <button type=\"button\" class=\"close\" data-dismiss=\"alert\" 
                     aria-hidden=\"true\"> &times; </button>";
            echo "download failed...Please check your url.";
            echo "</div>";
        }
    }
}
?>

<a class="btn btn-info btn-danger"  href="index.php">return </a>
<p> MyBlog:<a href="blog.mrlin.tk">blog.mrlin.tk</a> <br>
 Author:MrLin <br>
 E-mail:linbingchen2012@gmail.com <br> </p>
 </div>
 <!-- JavaScript placed at the end of the document so the pages load faster -->
     <!-- Optional: Include the jQuery library -->
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
             <!-- Optional: Incorporate the Bootstrap JavaScript plugins -->
                 <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</body>
</html>
