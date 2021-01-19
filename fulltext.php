<?php
  if(isset($_GET['id'])){
    $a_id = $_GET['id'];
  }

  $url = "fulltext.php/?id=".$a_id;

  function add_comment($a_id){
    $filename = "comment.csv";
    $fpr = fopen($filename,"r");
    $count = 1;
    while(($data = fgetcsv($fpr)) !== false){
      $count++;
    }
    fclose($fpr);

    $id = $count;
    $name = $_POST['name'];
    $comment_text = $_POST['comment'];
    $comment = array($id,$a_id,$name,$comment_text);
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
?>
<!DOCTYPE html>
<html>
  <head>
   <title>Laravel News</title>
  </head>
  <body>
    <?php
      $article = get_article($a_id);
    ?>

    <h2> <?php echo $article[1]; ?> </h2>
    <p> <?php echo $article[2]; ?> </p>
    <hr>
      <h4>コメント</h4>
      <?php 
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
          if(isset($_POST['name'])){
            $error = judge();
            echo $error;
            if(empty($error)){
              add_comment($a_id);
            }
          }
        }        
      ?>
      <div class="input_comment">
        <form action="" method='post' onsubmit="return add_confirm()">
          <ul>
            <li>名前<input type="text" name='name' value="匿名"></li>
            <li>コメント<input type="text" name='comment'></li>
          </ul>
          <input type="submit" value='コメントする'>
        </form>
      </div>
      <?php 
        $filename = "comment.csv";
        $fp = fopen($filename,"r");
        while(($comment = fgetcsv($fp)) !== false){
          if($comment[1] == $a_id){
        ?>
        <div class="comment">
          <p><?php echo $comment[2] ?></p>
          <p><?php echo $comment[3] ?></p>
          <a href="">コメントを削除する</a>
          <hr>
        <div>
      <?php
          }
        }
      ?>

  </body>
  <script type="text/javascript">
  function add_confirm(){
    select = confirm("コメントしますか？");
    console.log(select);
    if(select == false){
      return false;
    }
  }
  </script>
</html>