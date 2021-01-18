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
    $filename = "article.csv";
    $fpr = fopen($filename,"r");
    $count = 1;
    while(($data = fgetcsv($fpr)) !== false){
      $count++;
    }

    fclose($fpr);
    $id = $count;
    $title = $_POST['title'];
    $sentence = $_POST['sentence'];
    $article = array($id,$title,$sentence);
    $fpa = fopen($filename,"a");
    fputcsv($fpa,$article);
    fclose($fpa);
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
        $filename = "article.csv";
        $fp = fopen($filename,"r");
        while(($data = fgetcsv($fp)) !== false){ 
    ?>
          
          <h3 class='title'><?php echo $data[1]?></h3>
          <P class='sentence'><?php echo $data[2] ?></p>
          <a href="fulltext.php/?id=<?php echo $data[0] ?>">記事全体を表示</a>
          <hr>
          
          <?php
        }?>
    
  </body>
  <script type="text/javascript">
  function dialog(){
    select = confirm("記事を投稿しますか？");
    console.log(select);
    if(select == false){
      return false;
    }
  }
  </script>
</html>
