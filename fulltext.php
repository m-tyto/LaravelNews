<?php
  if(isset($_GET['id'])){
    $id = $_GET['id'];
  }

  $url = "fulltext.php/?id=".$id;

  function add_comment($id){
    $filename = "comment.csv";
    $fpr = fopen($filename,"r");
    $count = 1;
    while(($data = fgetcsv($fpr)) !== false){
      $count++;
    }
    fclose($fpr);

    $c_id = $count;
    $name = $_POST['name'];
    $comment_text = $_POST['comment'];
    $comment = array($c_id,$id, $name,$comment_text);
    $fpa = fopen($filename,"a");
    fputcsv($fpa,$comment);
    fclose($fpa);
  }

  function judge(){
    if(empty($_POST['comment'])){
      $msg = "コメントを入力してください";
      return $msg;
    }
    header("Location:$url");
  }
  
  function get_article($id){
    $filename = "article.csv";
    $fp = fopen($filename,"r");
    while(($data = fgetcsv($fp)) !== false){
      if($data[0] === $id){
        return $data;
        break;
      }
    }
  }

  function delete_comment(){
    $filename = "comment.csv";
    $c_id = $_POST['c_id'];
    $fp = fopen($filename,"r");
    $line = 0;
    while(($data = fgetcsv($fp)) !== false){
      if($c_id == $data[0]){
        fclose($fp);
        break;
      }
      $line++;
    }
    $file_array = file($filename);
    unset($file_array[$line]);
    file_put_contents($filename, $file_array);
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
      $article = get_article($id);
    ?>

    <div id="article">
      <h2 id="title"> <?php echo $article[1]; ?> </h2>
      <p id="sentence"> <?php echo $article[2]; ?> </p>
    </div>
    <hr>
    <h4>コメント</h4>
    <?php 
      if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['name'])){
          $error = judge();
          echo $error;
          if(empty($error)){
            add_comment($id);
          }
        }
      }
      if(isset($_POST['c_id'])){
        delete_comment();
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
        $filename = "comment.csv";
        $fp = fopen($filename,"r");
        while(($comment = fgetcsv($fp)) !== false){
          if($comment[1] == $id){
      ?>
      <div class="comment">
        <p><?php echo $comment[2] ?></p>
        <p><?php echo $comment[3] ?></p>

        <form action="" method="post" onsubmit="return delete_confirm()">
          <input type="hidden" name="c_id" value="<?php echo $comment[0] ?>">
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