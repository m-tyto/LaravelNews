<?php
  $filename = "article.csv";
  $max = 10;

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

  function add_article($filename) {
    $fpr = fopen($filename, "r");
    $count = 1;
    while(($data = fgetcsv($fpr)) !== false){
      $count++;
    }

    fclose($fpr);
    $id = $count;
    $title = $_POST['title'];
    $sentence = $_POST['sentence'];
    $article = array($id, $title, $sentence);
    $fpa = fopen($filename, "a");
    fputcsv($fpa, $article);
    fclose($fpa);
  }

  function paging($filename, $max){
    $fp = fopen($filename,"r");
    $count = 1;
    $file_array = array();
    while(($file_array[] = fgetcsv($fp)) !== false){
      $count++;
    }
    fclose($fp);
    $file_array = array_reverse($file_array);
    $now = 1;
    if($_GET['page_num']){
      $now = $_GET['page_num'];
    }
    $start_num = ($now - 1) * $max;
    $page_array = array_slice($file_array, $start_num, $max);
    return $page_array;
  }

  function get_page(){
    $now = 1;
    if($_GET['page_num']){
      $now = $_GET['page_num'];
    }
    return $now;
  }

?>

<!DOCTYPE html>
<html>
  <head>
   <title>Laravel News</title>
   <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1>Laravel News</h1> 
    <h2 class="post">記事投稿</h2>
    <?php
      if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $error = judge();
        echo $error;
       if(empty($error)){
         add_article($filename);
       }
      }   
    ?> 
    <form action="index.php" method="post" onsubmit="return dialog()">
      <dl class="form">
        <dt>タイトル</dt>
        <dd><input type="text" name="title"></dd>
        <dt>本文</dt>
        <dd><textarea name="sentence" cols="50" rows="10"></textarea></dd>
        <div class="button"><input type="submit" value="投稿"> </div>
      </ul> 
    </form>
    <hr>
    <?php
      $page = paging($filename,$max);
      $page_count = count($page);
      $i = 0;
      while($i < $page_count){
        if(!empty($page[$i])){
    ?>  
        <h3 class='title'><?php echo $page[$i][1] ?></h3>
        <P class='sentence'><?php echo $page[$i][2] ?></p>
        <div class="fulltext"><a href="fulltext.php?id=<?php echo $page[$i][0] ?>">記事全体を表示</a></div>
        <hr>
    <?php
        }
        $i++;
      } ?>  


    <div class="page">
      <?php
        $line = count(file($filename));
        $max_page = ceil($line / $max);
        $now = get_page();
        for($i = 1; $i <= $max_page; $i++){
      ?>
        <div class="page"><a href="index.php?page_num=<?php echo $i ?>"><?php echo $i ?></a></div>


      <?php    
        }
      ?>
    </div>
  </body>
  <script type="text/javascript" src="script.js"></script>
</html>
