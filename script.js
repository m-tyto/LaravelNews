function dialog(){
    select = confirm("記事を投稿しますか？");
    if(select == false){
      return false;
    }
  }

function add_confirm(){
    select = confirm("コメントしますか？");
    if(select == false){
        return false;
    }
}

function delete_confirm(){
    select = confirm("このコメントを削除しますか？");
    if(select == false){
        return false;
    }
    document.delete.submit();
}