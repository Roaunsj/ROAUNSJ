<?php
   */
  function displayResults($solrQueryProcessor, $title = "Resultados de la Busqueda", $output = '') {

    $apacheSolrResult = $solrQueryProcessor->solrResult;
    $total = (int) $apacheSolrResult->response->numFound;
    $end = min(($solrQueryProcessor->solrLimit + $solrQueryProcessor->solrStart), $total);

// drupal_set_message("El valor de la variable es " . variable_get($recomenda,'2'));

$recomenda2 = variable_get($recomenda,'2');
global $user;
$mibandera = cache_get('mibandera');
$mibandera = $mibandera->data;
$mibanderitacontenido = cache_get('banderitacontenido');
$mibanderitacontenido = $mibanderitacontenido->data;
$mibanderitacontenido2 = cache_get('banderitacontenido2');
$mibanderitacontenido2 = $mibanderitacontenido2->data;
//la variable $total tiene la cantidad de objetos devueltos en la busqueda
//drupal_set_message("total " . $total);
////////////////////////////RECOMENDACIONES POR CONTENIDO////////////////
if($mibanderitacontenido2 == 7)
{
cache_set('banderitacontenido2','6');
/////////////////////////////******************//////////////////////
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
         // drupal_set_message("$keys[0]  $body");
        }
      }
     // drupal_set_message($highlight->$keys[0]);
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
      }//fin del for each chico 
}//fin del for each grande
////////////////////////////*******************//////////////////////
if($tit!=''){ 
 $tit = l($tit, 'fedora/repository/' . htmlspecialchars($piddelobjetito2,ENT_QUOTES,'utf-8'));  
 drupal_set_message("Este objeto por contenido. le puede gustar: " .$tit);
             }
             else{
 drupal_set_message("Este objeto por contenido. le puede gustar: " .$tit ." - " .$l);
                  }
drupal_goto("front");
}//fin del else if todos es igual a cero
}//fin del if banderita contenido2
if($mibanderitacontenido == 2)
{
//drupal_set_message("A buscar los datos del objeto");
//drupal_set_message("El valor de total es: " .$total);
cache_set('banderitacontenido','1');
/////////////////////////////******************//////////////////////
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
         // drupal_set_message("$keys[0]  $body");
        }
      }
     // drupal_set_message($highlight->$keys[0]);
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
   //drupal_set_message("Field contenido vale: " .$field);     
   
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
      }//fin del for each chico 
}//fin del for each grande
////////////////////////////*******************//////////////////////
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
}//fin del else if total es igual a cero 
} //fin recomenda icones por contenido
/////////////////////////////////////////////////////////////////////////
profile_load_profile($user);

if($recomenda2 == 4)
{
variable_set($recomenda,'3');//incicializamos la variable para que no entre por aca
if ($total === 0){
   if ($mibandera == 3){
//aca deberiamos buscar por el or
$searchString4 = "dc.subject%253A".$user->profile_areaint."%2520OR%    2520dc.subject%253A".$user->profile_categoria;

cache_set('mibandera','5');
variable_set($recomenda,'4');
drupal_goto("islandora/solr/search/$searchString4");      
    } 
     else
         {
          drupal_set_message("No hay recomendaciones segun su perfil");
          variable_set($recomenda,'3');
          //drupal_goto("front"); 
          } 
    } 
     else
         {
          //aca mostramos el mejor resultado en el pop up
          //drupal_set_message("Si hay recomendaciones");
////////////////////////////////////////CODIGO PA MOSTRAR RTDOS//////////////
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
         // drupal_set_message("$keys[0]  $body");
        }
      }
      //drupal_set_message($highlight->$keys[0]);
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
        
       /*if($field == 'title')
        {
        drupal_set_message("el titulo es " .$field);   
        drupal_set_message("el valor de doc es " .$value);   
        }*/
        
        if ($field == 'dc.title') {
        $tit = $value;
        }

        if ($field == 'PID') {
          $l = l($value, 'fedora/repository/' . htmlspecialchars($value, ENT_QUOTES, 'utf-8'));
          $rows[$row][] = $l;
          $piddelobjetito = $value;  
         //drupal_set_message("el campo value es " .$value); 
        }
        else {
          $rows[$row][] = $value;
        }
        $row++;
      }//fin del for each chico
      
       if($bandera1 == 1)
        {
        //drupal_set_message("el campo value es " .$value); 
        //drupal_set_message("La cantidad es" .$bandera2);
         if($tit!=''){ 
 $tit = l($tit, 'fedora/repository/' . htmlspecialchars($piddelobjetito, ENT_QUOTES,'utf-8'));  
    drupal_set_message("Este objeto demograf. le puede gustar: " .$tit);
             }else{
        drupal_set_message("Este objeto demograf. le puede gustar: " .$tit ." - " .$l);
                  }
 
        $bandera1 = 2;   
        }
            
    }//fin del for each grande
///////////////////////////////////////////////////////////////////
  }   
//////////////////////////ESPACIO PARA EL FILTRADO POR CONTENIDO////////
$bandecontenido = cache_get('recomendacontenido');
$bandecontenido = $bandecontenido->data;
if($bandecontenido == 1){
   $objetopopular = cache_get('objetoporcontenido');  
   $objetopopular = $objetopopular->data;
   //drupal_set_message("Si hay recomendaciones por contenido. El objeto popular es " .$objetopopular);
    cache_set('banderitacontenido','2');
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
////////////////////////////////////////////////////////////////////////

}else
    {
    // Check for empty resultset
    if ($total === 0) {
      $output = "<h2>Resultados de la Busqueda</h2>";
      $output .= "<div>Disculpe, su busqueda no retorno ningun resultado.</div>";
      return $output;
    }

    // Initialize drupal-style pager
    islandora_solr_search_pager_init($total, $solrQueryProcessor->solrLimit);

    // Get secondary display profiles
    $secondary_display_profiles = module_invoke_all('islandora_solr_secondary_display');
    // How about this for an expected return?
    // return array(
    // 'machine-name' = array(
    //   'name' => 'Human Readable Name',
    //   'module' => 'module_name',
    //   'file' => 'FileName.inc',
    //   'class' => 'ClassName',
    //   'function' => 'function_name',
    //   'description' => 'A description of the display profile',
    //   'logo' => 'Some text, some <html>, an <img>, etc used to link to this output,
    // );
    // check if
    // if the islandora_solr_search admin form has never been saved, then
    // the variable 'islandora_solr_secondary_display' won't be set yet.
    $secondary_array = variable_get('islandora_solr_secondary_display', array());

