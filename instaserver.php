<?php
    $opt_search = $_POST['search'];
    $limit = $_POST['limit'];
    if($_POST['key']!=='{TOKEN}') die('TOKEN FAIL');
    
    $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
    $opt_search = strtr( $opt_search, $unwanted_array );
    
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
