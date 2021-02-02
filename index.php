<?php
  $filename = "article.csv";
  $max = 10;

  include "connect_db.php";

  /*$insert_into = 'INSERT INTO articles(title,sentence) VALUES ("aaa","bbb");';
  $insert = mysqli_query($link,$insert_into);
  var_dump($insert);*/

  //SQLうまくいかないときに使えば良い
  /*$error = mysqli_error($link);
  var_dump($error);*/
  
  function judge(){
    if(empty($_POST['title']) || empty($_POST['sentence'])){
      $msg = "タイトル,本文は必須入力です";
      return $msg;
    }
    if(strlen($_POST['title']) > 30){
      $msg = "タイトルは30字までで入力してください";
      return $msg;
    }
    header("Location:index.php");    
    
  }

  function add_article($link) {
    $title = $_POST['title'];
    $sentence = $_POST['sentence'];
    $sql = 'INSERT INTO articles(title,sentence) VALUES ("'.$title.'","'.$sentence.'");';
    mysqli_query($link,$sql);
  }

  function paging($array,$max){
    $page_num = 1;
    if($_GET['page_num']){
      $page_num = $_GET['page_num'];
    }
    $start_num = ($page_num - 1) * $max;
    $page_array = array_slice($array, $start_num, $max);
    return $page_array;
  }

  function get_page(){
    $page_num = 1;
    if($_GET['page_num']){
      $page_num = $_GET['page_num'];
    }
    return $page_num;
  }

  function show_table($link){
    $sql = 'SELECT * FROM articles ORDER BY id DESC;';
    $result = mysqli_query($link,$sql);
    $rows = array();
    while($rows[] = mysqli_fetch_assoc($result)){

    }
    return $rows;
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
        echo judge();
        if(empty($error)){
          add_article($link);
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
      </dl> 
    </form>
    <hr>
    <?php
      $rows = show_table($link);
      $pages = paging($rows,$max);
      $page_count = count($pages);
      foreach($pages as $page){
        if(!empty($page)){
    ?>  
        <h3 class='title'><?php echo $page["title"] ?></h3>
        <P class='sentence'><?php echo $page["sentence"] ?></p>
        <div class="fulltext"><a href="fulltext.php?id=<?php echo $page["id"] ?>">記事全体を表示</a></div>
        <hr>
    <?php
        }
        
      } ?>  


    <div class="page">
      <?php
        $line = count($rows);
        $max_page = ceil($line / $max);
        $page_num = get_page();
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
