<?php
require_once("../../script/utilities.php");
if( array_key_exists('addnew',$_POST) ) {
    if( !array_key_exists('author',$_POST) || !array_key_exists('post',$_POST) ) {
        echo json_encode(['success'=> false, 'error'=> 'Errore di trasmissione: riprova.']);
        exit();
    }
    $author = $_POST['author'];
    $post = $_POST['post'];
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


?>