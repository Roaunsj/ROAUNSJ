
<?php


/**
 *
 * @param $page
 *   Page number of results to return (in pages of 20).
 * @param $fields
 *   The fields you want returned.
 *   An array containing fields and values used to build a sql WHERE clause
 *   indicating items to retrieve.
 * @param $page_size
 *   Integer number of items to be returned.
 *   An array of integracion objects.
 *
 * @todo
 *   Evaluate the functionality here in general. Particularly around
 *     - Do we need fields at all? Should this just return full integracions?
 *     - Is there an easier syntax we can define which can make the urls
 *       for index requests more straightforward?
 */
function _integracion_resource_index($page, $fields, $parameters, $page_size) {

$contador=1;
$fields = db_escape_string($fields);
$results = array();
// need to append table prefix
  if ($fields_array = explode(',', $fields)) {
  foreach ($fields_array as &$field) {
      
     switch($contador){
        case 1:{
        if($field =='sfo'){
           $formatoobjeto='sfo'; 
          }
          else{
            $formatoobjeto=$field; 
          }   
         break;
        }
        case 2:{
        if($field =='sui'){
                  $usuarioideal='sui'; 
          }
          else{
                  $usuarioideal=$field; 
          }   
         break;
        }
   case 3:{
        if($field =='sai'){
                    $areainteres='sai'; 
          }
          else{
               $areainteres=$field;
          }   
         break;
        }
      case 4:{
        if($field =='spc'){
                 $palabrasclaves='spc'; 
          }
          else{
                  $palabrasclaves=$field;
          if(strpos($palabrasclaves,' ')!=FALSE){
           
               $palabrasclaves1=substr($palabrasclaves,0,strpos($palabrasclaves,' '));
               $palabrasclaves2=substr($palabrasclaves,strpos($palabrasclaves,' ')+1);
              }
          }   
         break;
        }
       case 5:{
         $cantobjeto=$field;
         break;
        }
      }//fin switch
      
     // $field = $primary_table . '.' . trim($field);
  $contador++;
    }//fin del for each
    

  }
module_load_include('module', 'islandora_solr_search', 'islandora_solr_search');
if(($usuarioideal!='sui')&&($areainteres!='sai')&&($palabrasclaves!='spc')){
if(strpos($palabrasclaves,' ')===FALSE){
$querylelo = "dc.subject:".$areainteres." AND dc.subject:".$usuarioideal." AND dc.description:".$palabrasclaves;
}else{
$querylelo = "dc.subject:".$areainteres." AND dc.subject:".$usuarioideal." AND dc.description:".$palabrasclaves1." AND dc.description:".$palabrasclaves2;
}
}else{//else 1
if(($usuarioideal=='sui')&&($areainteres!='sai')&&($palabrasclaves!='spc')){
if(strpos($palabrasclaves,' ')===FALSE){
$querylelo = "dc.subject:".$areainteres." AND dc.description:".$palabrasclaves;
}else{
$querylelo = "dc.subject:".$areainteres." AND dc.description:".$palabrasclaves1." AND dc.description:".$palabrasclaves2;
}
}else{//else2
if(($areainteres=='sai')&&($usuarioideal!='sui')&&($palabrasclaves!='spc')){
if(strpos($palabrasclaves,' ')===FALSE){
$querylelo = "dc.subject:".$usuarioideal." AND dc.description:".$palabrasclaves;
}else{
$querylelo = "dc.subject:".$usuarioideal." AND dc.description:".$palabrasclaves1." AND dc.description:".$palabrasclaves3;
}
}else{//else 3
if(($palabrasclaves=='spc')&&($usuarioideal!='sui')&&($areainteres!='sai')){
$querylelo = "dc.subject:".$usuarioideal." AND dc.subject:".$areainteres;
}else{//else 4
if(($areainteres=='sai')&&($usuarioideal=='sui')&&($palabrasclaves!='spc')){
if(strpos($palabrasclaves,' ')===FALSE){
$querylelo = "dc.description:".$palabrasclaves;
}else{
$querylelo = "dc.description:".$palabrasclaves1." AND dc.description:".$palabrasclaves3;
}  
    }else{//else 5
if(($areainteres!='sai')&&($usuarioideal=='sui')&&($palabrasclaves=='spc')){
$querylelo = "dc.subject:".$areainteres;    
    }else{//else 6
if(($areainteresv='sai')&&($usuarioideal!='sui')&&($palabrasclaves=='spc')){
$querylelo = "dc.subject:".$usuarioideal;    
    }    
    }
    }   
    } 
    }
  }
}
$prueba=islandora_solr_search($querylelo);
$parentesiscierre = strpos($prueba,')');
if($parentesiscierre === false){
$results[1]['url'] = 'No hay Objetos';  
$results[1]['titulo'] = 'No hay Objetos'; 
$results[1]['descripcion'] = 'No hay Objetos';  
$results[1]['explicacion'] = 'No hay Objetos';  
}else{
$porsinohaydelformatopedido = 0;
$
$posicionproximacadena=0;
$resultadodevuelto=$prueba;
for ($contadortres = 1;$contadortres <= $totalrtdos;$contadortres++){
$nuevacadena = obtenerCadenaentreCadenas($resultadodevuelto,'<li','</li>');
$posicionproximacadena=strpos($resultadodevuelto,'</li>');
$resultadodevuelto=substr($resultadodevuelto,$posicionproximacadena+5);
$pabuscarmetadatamods2 = obtenerCadenaentreCadenas($nuevacadena,'href="','"');
$traemeelxml=$pabuscarmetadatamods2.'/MODS/MODS';
$chsalidita = curl_init();
curl_setopt($chsalidita, CURLOPT_URL, 'http://localhost'.$traemeelxml);
curl_setopt($chsalidita, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($chsalidita, CURLOPT_CONNECTTIMEOUT, 200);
$traemeelxml = curl_exec($chsalidita);
curl_close($chsalidita);

$tipodeobjeto = obtenerCadenaentreCadenas($traemeelxml,'<genre>','</genre>');


                         }  
			 break;
			 }
                      } //fin switch
$tituloobjeto = obtenerCadenaentreCadenas($traemeelxml,'<title>','</title>');
if($tituloobjeto ==''){$tituloobjeto='---';}           
$descobjeto = obtenerCadenaentreCadenas($traemeelxml,'&lt;p&gt;','&lt;/p&gt;');
if($descobjeto ==''){$descobjeto='---';}  

$explicacionrecomendacion='El objeto adecuado segun el usuario y el area indicados es';

if(strcasecmp($formatoobjeto,$tipodeobjeto)==0){//
$porsinohaydelformatopedido = 1;
for ($contadordos = 0 ;$contadordos < 4;$contadordos++){
switch($contadordos){
        case 0:{
          $results[$contadortres]['url'] = $urlobjeto;  
          break;
        }
        case 1:{
        $results[$contadortres]['titulo'] = $tituloobjeto;  
          break;
        }
        case 2:{
    
        $results[$contadortres]['descripcion'] = $descobjeto;  
          break;
        }
        case 3:{
        $results[$contadortres]['explicacion'] = $explicacionrecomendacion;  
        break;
        }
      }//fin switch
     }//fin del for
    }//
    else{
      if($formatoobjeto=='sfo'){
$porsinohaydelformatopedido = 1;
for ($contadordos = 0 ;$contadordos < 4;$contadordos++){
switch($contadordos){
        case 0:{
          $results[$contadortres]['url'] = $urlobjeto;  
          break;
        }
        case 1:{
        $results[$contadortres]['titulo'] = $tituloobjeto;  
          break;
        }
        case 2:{
       
        $results[$contadortres]['descripcion'] = $descobjeto;  
          break;
        }
        case 3:{
        $results[$contadortres]['explicacion'] = $explicacionrecomendacion;  
        break;
        }
       }//fin for
      }
    }/ 
}/
}
}
