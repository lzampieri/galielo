<?php
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

$result = array_from_query(query("SELECT * FROM galitweet WHERE Visible = 1"));
foreach($result as &$item) {
    $item['Timestamp'] = (new DateTime($item['Timestamp']))->getTimestamp();
}
echo json_encode($result, JSON_NUMERIC_CHECK);
exit();
?>