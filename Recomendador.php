<?php
function recomendar_user($op, &$edit, &$account, $category = NULL) {

 if ($op == 'login') {

profile_load_profile($account);

drupal_set_message("BIENVENIDO " . $account->name);

$userid = $account->uid;
$haycontenido = 0;
$max = 0;


  $sql = "SELECT COUNT(path) AS hits, path, MAX(title) AS title, AVG(timer) AS average_time, SUM(timer) AS total_time FROM {accesslog} WHERE uid = $userid GROUP BY path";
  $sql_cnt = "SELECT COUNT(DISTINCT(path)) FROM {accesslog}";

$header = array(
    array('data' => t('Hits'), 'field' => 'hits', 'sort' => 'desc'),
    array('data' => t('Page'), 'field' => 'path'),
  );

  $sql .= tablesort_sql($header);
  $result = pager_query($sql, 30, 0, $sql_cnt);

  $rows = array();

while ($account2 = db_fetch_object($result)) {

 $micadena = $account2->path;
if((stristr($micadena,'fedora/repository/') == TRUE) && 
((stristr($micadena,'islandora:') == TRUE) || (stristr($micadena,'islandora%3A') == TRUE)))
{    

if((stristr($micadena,'TN') == FALSE) && (stristr($micadena,'MEDIUM_SIZE') == FALSE)&& (stristr($micadena,'MEDIUM_SIZE') == FALSE)&& (stristr($micadena,'collection') == FALSE)&& (stristr($micadena,'Collection') == FALSE)&& (stristr($micadena,'JPG') == FALSE)&& (stristr($micadena,'lenguaje') == FALSE)&& (stristr($micadena,'ciencias') == FALSE)&& (stristr($micadena,'matematicas') == FALSE)&& (stristr($micadena,'audio_collection_ciencias') == FALSE)&& (stristr($micadena,'sp_pdf_collection_ciencias') == FALSE)&& 
(stristr($micadena,'sp_archive_collection_ciencias') == FALSE)&& 
(stristr($micadena,'sp_basic_image_collection_ciencias') == FALSE)&& 
(stristr($micadena,'video_collection_ciencias') == FALSE)&& 
(stristr($micadena,'audio_collection_lenguaje') == FALSE)&&
(stristr($micadena,'sp_pdf_collection_lenguaje') == FALSE)&& 
(stristr($micadena,'sp_archive_collection_lenguaje') == FALSE)&& 
(stristr($micadena,'sp_basic_image_collection_lenguaje') == FALSE)&& 
(stristr($micadena,'video_collection_lenguaje') == FALSE)&& 
(stristr($micadena,'audio_collection_matematicas') == FALSE)&& 
(stristr($micadena,'sp_pdf_collection_matematicas') == FALSE)&& 
(stristr($micadena,'sp_archive_collection_matematicas') == FALSE)&& 
(stristr($micadena,'sp_basic_image_collection_matematicas') == FALSE)&&   
(stristr($micadena,'video_collection_matematicas') == FALSE))
  {
   $haycontenido = 1;
   if($max < $account2->hits){
    $max = $account2->hits;
    $maxurl = $micadena;
    }
  }
}  
}

  if ($haycontenido == 0) {
  
cache_set('recomendacontenido','0');
  }else
      {

$salvavida1 = substr($maxurl,18);
$salvavida2 = strpos($salvavida1,'/');
if($salvavida2!== FALSE){
$objetomax = substr($salvavida1,0,$salvavida2);
}else{
$objetomax = $salvavida1;
}

cache_set('recomendacontenido','1');
cache_set('objetoporcontenido',$objetomax);
      }


$searchString = $account->profile_areaint;
$searchString2 = "dc.subject%253A".$searchString."%2520AND%2520dc.subject%253A".$account->profile_categoria;
 
cache_set('mibandera','3');
cache_set('banderitacontenido','1');
variable_set($recomenda,'4');//
drupal_goto("islandora/solr/search/$searchString2");
}
}
?>
