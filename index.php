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
      header('Content-type: application/json; charset=utf-8');
      $data = filter_input(INPUT_GET,select);
      //$select = json_encode($data);
      if ($data == true){
        posted();
        header("Location:index.php");
      }
      
    }
  }

  function posted() {
    $title = $_POST['title'];
    $sentence = $_POST['sentence'];
    $filename = "article.txt";
    $fp = fopen($filename,"a");
    fwrite($fp,"<h3>".$title."</h3>".PHP_EOL);
    fwrite($fp,"<p>".$sentence."</p>".PHP_EOL);
    fwrite($fp,"<hr>".PHP_EOL);
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
      echo $select;
     ?>
  </body>
  <script type="text/javascript" src="node_modules/jquery/dist/jquery.min.js">
  let select = false;
  function dialog(){
    select = confirm("記事を投稿しますか？");
    console.log(select);
    
    $.ajax({
      type: "POST",
      url: 'index.php',
      data: select,
      dataType: "json",
      scriptCharset: 'utf-8'
    })
  }
  </script>
</html>
