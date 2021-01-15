<?php
  function judge(){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      if(empty($_POST['title']) || empty($_POST['sentence'])){
        $msg = "タイトル,本文のは必須入力です";
        return $msg;
      }
      if(strlen($_POST['title']) > 30){
        $msg = "タイトルは30字までで入力してください";
        return $msg;
      }
      header("Location:index.php");
      
      
    }
  }

  function posted() {
    $title = $_POST['title'];
    $sentence = $_POST['sentence'];
    $filename = "article.txt";
    $fp = fopen($filename,"a");
    fwrite($fp,"<div>".PHP_EOL);
    fwrite($fp,"<h3>".$title."</h3>".PHP_EOL);
    fwrite($fp,"<p>".$sentence."</p>".PHP_EOL);
    fwrite($fp,"<a href='comment.php''>"."全文を表示する"."</a>".PHP_EOL);
    fwrite($fp,"<hr>".PHP_EOL);
    fwrite($fp,"</div>".PHP_EOL);

    function count(){
      $filename = "index.php";
      $fp = fopen($filename,"r");
      $count = substr_count($fp,"全文を表示する");
      return $count;
    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
   <title>Laravel News</title>
  </head>
  <body>
    <h1>Laravel News</h1> 
    <h2>記事投稿</h2>
    <?php 
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $error = judge();
        echo $error;
       if(empty($error)){
         posted();
       }
    }
    ?>
    <form action="index.php" method="post" onsubmit="return dialog()">
      <ul>
      <li>タイトル：<input type="text" name="title"></li>
      <li>本文：<input type="text" name="sentence"></li>
      <input type="submit" value="投稿">
      </ul> 
    </form>
    <?php
      include "article.txt";
     ?>
  </body>
  <script type="text/javascript" src="node_modules/jquery/dist/jquery.min.js">
  function dialog(){
    select = confirm("記事を投稿しますか？");
    console.log(select);
    if(select == false){
      return false;
    }
  }
  </script>
</html>
