<?php
    $opt_search = $_POST['search'];
    $limit = $_POST['limit'];
    if($_POST['key']!=='{TOKEN}') die('TOKEN FAIL');

    $opt_search = preg_replace('/[^\w\s]/', '', $opt_search);
    $opt_search = preg_replace('/\s+/', '', $opt_search);

    $insta_source = file_get_contents('https://www.instagram.com/explore/tags/'.trim($opt_search).'/'); // instagrame tag url
    $shards = explode('window._sharedData = ', $insta_source);
    $insta_json = explode(';</script>', $shards[1]); 
    $insta_array = json_decode($insta_json[0], TRUE);
    
    $insta_array = $insta_array['entry_data']['TagPage'][0]['tag']['media']['nodes'];
    $i = 1;
    foreach ($insta_array as $k => $insta) {
        if($i>$limit) continue;
        $array[] = array(
            'id'            =>  $insta['id'],
            'code'          =>  $insta['code'],
            'thumbnail_src' =>  $insta['thumbnail_src']
        );
        $i++;
    }
    echo json_encode($array);

?>
