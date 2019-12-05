<?php
   */
  function displayResults($solrQueryProcessor, $title = "Resultados de la Busqueda", $output = '') {

    $apacheSolrResult = $solrQueryProcessor->solrResult;
    $total = (int) $apacheSolrResult->response->numFound;
    $end = min(($solrQueryProcessor->solrLimit + $solrQueryProcessor->solrStart), $total);


$recomenda2 = variable_get($recomenda,'2');
global $user;
$mibandera = cache_get('mibandera');
$mibandera = $mibandera->data;
$mibanderitacontenido = cache_get('banderitacontenido');
$mibanderitacontenido = $mibanderitacontenido->data;
$mibanderitacontenido2 = cache_get('banderitacontenido2');
$mibanderitacontenido2 = $mibanderitacontenido2->data;

if($mibanderitacontenido2 == 7)
{
cache_set('banderitacontenido2','6');

if($total == 0){
    drupal_set_message("No hay un objeto similar a recomendar");
    drupal_goto("front");
    }else{
    $items = array();
    $type = "ol";
    $title = NULL;
    $results = $solrQueryProcessor->solrResult;
    $recordStart = $results->response->start;
    $limitResults = variable_get('islandora_solr_search_limit_result_fields', 0);
    $highlights = $results->highlighting;
    foreach ($highlights as $highlight) {
      $fields = get_object_vars($highlight);
      $keys = array_keys($fields);
      if (count($keys) > 0) {
        foreach ($highlight->$keys[0] as $body) {
        
        }
      }
    
    }
global $base_url;
    if (empty($results)) {
      return "no results";
    }

    foreach ($results->response->docs as $doc) {
      
      $rows = array();
      $row = 0;
      $bandera2++;  
      foreach ($doc as $field => $value) {
   
        if ($limitResults && empty($this->resultFieldArray[$field])) {
          continue;
        }
   
        $translated_field_name = isset($this->allSubsArray[$field]) ? $this->allSubsArray[$field] : $field;
        $rows[$row][] = array(
          'data' => $translated_field_name,
          'header' => TRUE,
        );
        if (is_array($value)) {
          $value = implode(", ", $value);
        }
        
   
        if ($field == 'dc.title') {
        $tit = $value;
        }

        if ($field == 'PID') {
          $l = l($value, 'fedora/repository/' . htmlspecialchars($value, ENT_QUOTES, 'utf-8'));
          $rows[$row][] = $l;
          $piddelobjetito2 = $value; 
        }
        else {
          $rows[$row][] = $value;
        }
        $row++;
      }
}

if($tit!=''){ 
 $tit = l($tit, 'fedora/repository/' . htmlspecialchars($piddelobjetito2,ENT_QUOTES,'utf-8'));  
 drupal_set_message("Este objeto por contenido. le puede gustar: " .$tit);
             }
             else{
 drupal_set_message("Este objeto por contenido. le puede gustar: " .$tit ." - " .$l);
                  }
drupal_goto("front");
}
}
if($mibanderitacontenido == 2)
{

if($total == 0){
    drupal_set_message("el objeto mas visto ya no existe");
    drupal_goto("front");
    }else{
    $items = array();
    $type = "ol";
    $title = NULL;
    $results = $solrQueryProcessor->solrResult;
    $recordStart = $results->response->start;
    $limitResults = variable_get('islandora_solr_search_limit_result_fields', 0);
    $highlights = $results->highlighting;
    foreach ($highlights as $highlight) {
      $fields = get_object_vars($highlight);
      $keys = array_keys($fields);
      if (count($keys) > 0) {
        foreach ($highlight->$keys[0] as $body) {
         
        }
      }

    }
global $base_url;
    if (empty($results)) {
      return "no results";
    }

    foreach ($results->response->docs as $doc) {
      
      $rows = array();
      $row = 0;
      $bandera2++;  
      foreach ($doc as $field => $value) {
   
        if ($limitResults && empty($this->resultFieldArray[$field])) {
          continue;
        }
   
        $translated_field_name = isset($this->allSubsArray[$field]) ? $this->allSubsArray[$field] : $field;
        $rows[$row][] = array(
          'data' => $translated_field_name,
          'header' => TRUE,
        );
        if (is_array($value)) {
          $value = implode(", ", $value);
        }
    
   
        if ($field == 'dc.subject') {
        $sub = $value;
        }

        if ($field == 'PID') {
          $l = l($value, 'fedora/repository/' . htmlspecialchars($value, ENT_QUOTES, 'utf-8'));
          $rows[$row][] = $l;
        }
        else {
          $rows[$row][] = $value;
        }
        $row++;
      }
}
if(
(preg_match("/Todas/",$sub))||
(preg_match("/Matematicas/",$sub))||
(preg_match("/Matemáticas/",$sub))||
(preg_match("/Ciencias Naturales/",$sub))||
(preg_match("/Ciencias Sociales/",$sub))||
(preg_match("/Ciencias Tecnologicas/",$sub))||
(preg_match("/Educativo/",$sub))||
(preg_match("/Empresarial/",$sub))||
(preg_match("/ONG/",$sub))||
(preg_match("/Otro/",$sub))
)
{
$urlporcontenido = "dc.subject%253A".$sub;
cache_set('banderitacontenido2','7');
drupal_goto("islandora/solr/search/$urlporcontenido"); 

   }
         else 
            {
      drupal_set_message("El objeto popular no tiene Área Interes cargada");
      drupal_goto("front");
            }
}
} 
profile_load_profile($user);

if($recomenda2 == 4)
{
variable_set($recomenda,'3');
if ($total === 0){
   if ($mibandera == 3){

$searchString4 = "dc.subject%253A".$user->profile_areaint."%2520OR%    2520dc.subject%253A".$user->profile_categoria;

cache_set('mibandera','5');
variable_set($recomenda,'4');
drupal_goto("islandora/solr/search/$searchString4");      
    } 
     else
         {
          drupal_set_message("No hay recomendaciones segun su perfil");
          variable_set($recomenda,'3');
          
          } 
    } 
     else
         {
          
$items = array();
    $type = "ol";
    $bandera1 = 1;
    $bandera2 = 0;
    $bandera3 = 1;
    $title = NULL;
    $results = $solrQueryProcessor->solrResult;
    $recordStart = $results->response->start;
    $limitResults = variable_get('islandora_solr_search_limit_result_fields', 0);
    $highlights = $results->highlighting;
    foreach ($highlights as $highlight) {
      $fields = get_object_vars($highlight);
      $keys = array_keys($fields);
      if (count($keys) > 0) {
        foreach ($highlight->$keys[0] as $body) {
      
        }
      }
      
    }
global $base_url;
    if (empty($results)) {
      return "no results";
    }

    foreach ($results->response->docs as $doc) {
      
      $rows = array();
      $row = 0;
      $bandera2++;  
      foreach ($doc as $field => $value) {

        if ($limitResults && empty($this->resultFieldArray[$field])) {
          continue;
        }

        $translated_field_name = isset($this->allSubsArray[$field]) ? $this->allSubsArray[$field] : $field;
        $rows[$row][] = array(
          'data' => $translated_field_name,
          'header' => TRUE,
        );
        if (is_array($value)) {
          $value = implode(", ", $value);
        }
        
    
        if ($field == 'dc.title') {
        $tit = $value;
        }

        if ($field == 'PID') {
          $l = l($value, 'fedora/repository/' . htmlspecialchars($value, ENT_QUOTES, 'utf-8'));
          $rows[$row][] = $l;
          $piddelobjetito = $value;  
         
        }
        else {
          $rows[$row][] = $value;
        }
        $row++;
      }
      
       if($bandera1 == 1)
        {
       
         if($tit!=''){ 
 $tit = l($tit, 'fedora/repository/' . htmlspecialchars($piddelobjetito, ENT_QUOTES,'utf-8'));  
    drupal_set_message("Este objeto demograf. le puede gustar: " .$tit);
             }else{
        drupal_set_message("Este objeto demograf. le puede gustar: " .$tit ." - " .$l);
                  }
 
        $bandera1 = 2;   
        }
            
    }
  }   

$bandecontenido = cache_get('recomendacontenido');
$bandecontenido = $bandecontenido->data;
if($bandecontenido == 1){
   $objetopopular = cache_get('objetoporcontenido');  
   $objetopopular = $objetopopular->data;
   
    cache_set('truepositivo','2');
$quieroelpid = substr($objetopopular,10);
$cadenita = "PID%253Aislandora%255C%253A".$quieroelpid;
//drupal_set_message("La cadena a ir es" .$cadenita);
drupal_goto("islandora/solr/search/$cadenita");
//drupal_goto("front"); 
     }else
        {
        drupal_set_message("NO hay recomendaciones por contenido disponibles");
        drupal_goto("front"); 
        }

}else
    {
 
    if ($total === 0) {
      $output = "<h2>Resultados de la Busqueda</h2>";
      $output .= "<div>Disculpe, su búsqueda no retorno ningún resultado.</div>";
      return $output;
    }


    islandora_solr_search_pager_init($total, $solrQueryProcessor->solrLimit);


    $secondary_display_profiles = module_invoke_all('islandora_solr_secondary_display');
    
    $secondary_array = variable_get('islandora_solr_secondary_display', array());
}
}

