<?php

/*
    tweets.php : tweets list
    tweets.php?all : all tweets list (even hidden); only for admins
    tweets.php{addnew:true,author:"...",post:"..."} : add tweet, return {success:true} or {success:false,error:"..."}
    tweets.php{changevisibility:true,ID:"...",Visibility:"..."} : change visibility return {success:true,id:"...",visibility:"..."} or {success:false,error:"..."}
*/

require_once("../../script/utilities.php");
dbconnect();
if( array_key_exists('addnew',$_POST) ) {
    if( !array_key_exists('author',$_POST) || !array_key_exists('post',$_POST) ) {
        echo json_encode(['success'=> false, 'error'=> 'Errore di trasmissione: riprova.']);
        exit();
    }
    $author = php_to_db_escape($_POST['author']);
    $post = php_to_db_escape($_POST['post']);

    if( strlen($author) < 3 ) {
        echo json_encode(['success'=> false, 'error'=> 'Nome autore troppo corto.']);
        exit();
    }
    if( strlen($post) < 3 ) {
        echo json_encode(['success'=> false, 'error'=> 'Post troppo corto.']);
        exit();
    }
    
    if ( query("INSERT INTO galitweet(Author,Text) VALUES ('${author}','${post}')") ){
        echo json_encode(['success'=> true]);
        exit();
    } else {
        echo json_encode(['success'=> false, 'error'=> 'Errore di database.'.mysqli_error($db_handle)]);
        exit();
    }
}

if( array_key_exists('changevisibility',$_POST) ) {
    if( !check_if_admin() ) {
        echo json_encode(['success'=> false, 'error'=> 'User not logged']);
        exit();
    }
    if( !array_key_exists('ID',$_POST) || !array_key_exists('Visibility',$_POST) ) {
        echo json_encode(['success'=> false, 'error'=> 'Errore di trasmissione: riprova.']);
        exit();
    }
    $ID = php_to_db_escape($_POST['ID']);
    $Visibility = php_to_db_escape($_POST['Visibility']);

    if ( query("UPDATE galitweet SET Visible = ${Visibility} WHERE ID = ${ID}") ){
        echo json_encode(['success'=> true, 'id'=> $ID, 'visibility'=> $Visibility],JSON_NUMERIC_CHECK);
        exit();
    } else {
        echo json_encode(['success'=> false, 'error'=> 'Errore di database.'.mysqli_error($db_handle)]);
        exit();
    }
}

if( array_key_exists('all',$_GET)) {
    if( check_if_admin() ) {
        $result = array_from_query(query("SELECT * FROM galitweet"));
    }
    else {
        exit();
    }
}
else {
    $result = array_from_query(query("SELECT * FROM galitweet WHERE Visible = 1"));
}

foreach($result as &$item) {
    $item['Timestamp'] = (new DateTime($item['Timestamp']))->getTimestamp();
}
echo json_encode($result, JSON_NUMERIC_CHECK);
exit();
?>