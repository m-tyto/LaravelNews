<?php
  include "connect_db.php";

  if(isset($_GET['id'])){
    $article_id = $_GET['id'];
  }

  $url = "fulltext.php/?id=".$id;

  function add_comment($link,$id){
    $name = $_POST['name'];
    $comment_text = $_POST['comment'];
    $sql = 'INSERT INTO comments(article_id,name,comment) VALUES ("'.$id.'","'.$name.'","'.$comment_text.'");';
    $result = mysqli_query($link,$sql);
  }

  function judge(){
    if(empty($_POST['comment'])){
      $msg = "コメントを入力してください";
      return $msg;
    }
    header("Location:$url");
  }
  
  function get_article($link,$id){
    $sql = 'SELECT * FROM articles WHERE (id = '.$id.');';
    $result = mysqli_query($link,$sql);
    $article = mysqli_fetch_assoc($result);
    return $article;
  }

  function delete_comment($link){
    $comment_id = $_POST['comment_id'];
    $sql = 'DELETE FROM comments where (id = '.$comment_id.');';
    $result = mysqli_query($link,$sql);
  }

  function get_comment($link,$id){
    $sql = 'SELECT * FROM comments where(article_id = '.$id.') ORDER BY id DESC;';
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
    <?php
      $article = get_article($link,$article_id);
    ?>

    <div id="article">
      <h2 id="title"> <?php echo $article["title"]; ?> </h2>
      <p id="sentence"> <?php echo $article["sentence"]; ?> </p>
    </div>
    <hr>
    <h4>コメント</h4>
    <?php 
      if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['name'])){
          $error = judge();
          echo $error;
          if(empty($error)){
            add_comment($link,$article_id);
          }
        }
      }
      if(isset($_POST['comment_id'])){
        delete_comment($link);
      }
      ?>
      <div class="comment_form">
        <form action="" method='post' onsubmit="return add_confirm()">
          <dl>
            <dt>名前</dt>
            <dd><input type="text" name='name' value="匿名"></dd>
            <dt>コメント</dt>
            <dd><textarea name="comment" cols="30" rows="3"></textarea></dd>
          </dl>
          <div class="button"><input type="submit" value='コメントする'></div>
        </form>
      </div>
      <?php 
        $comments = get_comment($link,$article_id);
        foreach($comments as $comment){
          if(!empty($comment)){
        
      ?>
      <div class="comment">
        <p><?php echo $comment["name"] ?></p>
        <p><?php echo $comment["comment"] ?></p>

        <form action="" method="post" onsubmit="return delete_confirm()">
          <input type="hidden" name="comment_id" value="<?php echo $comment["id"] ?>">
          <div class="delete_button"><input type="submit" value="削除"></div>
        </form>
      </div>
      <hr>

      <?php
          }
        } 
      ?>

  </body>
  <script type="text/javascript" src="script.js"></script>
</html>