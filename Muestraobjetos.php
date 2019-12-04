
function obtenerCadenaentreCadenas($contenido,$inicio,$fin){
   $r = explode($inicio, $contenido);
   if (isset($r[1])){
       $r = explode($fin, $r[1]);
       return $r[0];
   }
   return '';
}
/**
 * Return an array of optionally paged nids baed on a set of criteria.
 *
 * An example request might look like
 *
 * http://domain/endpoint/integracion?fields=nid,vid&parameters[nid]=7&parameters[uid]=1
 *
 * This would return an array of objects with only nid and vid defined, where
 * nid = 7 and uid = 1.
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
/////////////////////////////////////////////////////////////////////////////////
/*
$fields deberia tener 'tipoformatoobjeto,usuarioideal,areainteres,palabras claves'
Ej. 'pdf,alumno,quimica,atomo.nucleo'
Caracteristicas del servicio web
1. El cliente debe llamar a la url asi>
http://repositoriounsj.no/ip.org:8080/services/integracion?fields=tipoformatoobjeto,usuarioideal,areainteres,palabrasclaves
Por ejemplo. http://repositoriounsj.no/ip.org:8080/services/integracion?fields=pdf,alumno,quimica,atomo.nucleo
2. Los campos fields nunca pueden ser vacios, en caso de que no vengan con nada se debe completar asi:
tipoformatoobjeto: sfo
usuarioideal: sui 
areainteres: sai
palabras claves: spc
3. 
*/ 
/////////////////////aca viene tu codigo lelo////////////////////////////////////
$contador=1;
$fields = db_escape_string($fields);
$results = array();
// need to append table prefix
  if ($fields_array = explode(',', $fields)) {
  foreach ($fields_array as &$field) {
      
     switch($contador){
        case 1:{
        if($field =='sfo'){
         // $results[] = 'No se informo el formato';
          $formatoobjeto='sfo'; 
          }
          else{
          //$results[] = 'El formato es: ' .$field;
          $formatoobjeto=$field; 
          }   
         break;
        }
        case 2:{
        if($field =='sui'){
         // $results[] = 'No se informo el usuario'; 
          $usuarioideal='sui'; 
          }
          else{
         // $results[] = 'El usuario es: ' .$field;
          $usuarioideal=$field; 
          }   
         break;
        }
   case 3:{
        if($field =='sai'){
          //$results[] = 'No se informo el area'; 
          $areainteres='sai'; 
          }
          else{
         // $results[] = 'El area es: ' .$field;
         $areainteres=$field;
          }   
         break;
        }
      case 4:{
        if($field =='spc'){
         // $results[] = 'No hay palabras claves'; 
        $palabrasclaves='spc'; 
          }
          else{
         // $results[] = 'Las palabras claves son: ' .$field;
         $palabrasclaves=$field;
          if(strpos($palabrasclaves,' ')!=FALSE){
              /*SE INGRESARON DOS PALABRAS CLAVES*/
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
    //$fields = implode(',', $fields_array);

  }//fin del if
/*
Ahora con las variables $formatoobjeto, $usuarioideal, $areainteres y $palabrasclaves debo
hacer la consulta pa buscar el objeto y obtener los campos $urlobjeto,$tituloobjeto,$descobjeto y $lengobjeto
Para ello la idea es armar la url y setear alguna variable unica por ejemplo
$mellamandesdeunwebservice=0;
Luego nos vamos a IslandoraSolrResults.inc y cuando esa variable sea cero armamos el codigo pa mostrar y retornar los resultados aca
*/
//////////////////CONSULTA///////////////////////////////
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
$querylelo = "dc.subject:".$usuarioideal." AND dc.description:".$palabrasclaves1." AND dc.description:".$palabrasclaves2;
}
}else{//else 3
if(($palabrasclaves=='spc')&&($usuarioideal!='sui')&&($areainteres!='sai')){
$querylelo = "dc.subject:".$usuarioideal." AND dc.subject:".$areainteres;
}else{//else 4
if(($areainteres=='sai')&&($usuarioideal=='sui')&&($palabrasclaves!='spc')){
if(strpos($palabrasclaves,' ')===FALSE){
$querylelo = "dc.description:".$palabrasclaves;
}else{
$querylelo = "dc.description:".$palabrasclaves1." AND dc.description:".$palabrasclaves2;
}  
    }else{//else 5
if(($areainteres!='sai')&&($usuarioideal=='sui')&&($palabrasclaves=='spc')){
$querylelo = "dc.subject:".$areainteres;    
    }else{//else 6
if(($areainteresv='sai')&&($usuarioideal!='sui')&&($palabrasclaves=='spc')){
$querylelo = "dc.subject:".$usuarioideal;    
    }    
    }//fin else 6 
    }//fin else 5    
    }//fin else 4  
    }//fin else 3
  }//fin else 2
}//fin else 1
$prueba=islandora_solr_search($querylelo);
$parentesiscierre = strpos($prueba,')');//Leo el primero parentesis de cierre con la cantidad de objetos encontrados 
if($parentesiscierre === false){
$results[1]['url'] = 'No hay Objetos';  
$results[1]['titulo'] = 'No hay Objetos'; 
$results[1]['descripcion'] = 'No hay Objetos';  
$results[1]['explicacion'] = 'No hay Objetos';  
}else{
$porsinohaydelformatopedido = 0;
//si entro por aca es porque si hay resultados
//////////////////////////////////////////////////////////////////////////
$totalrtdos = substr($prueba,0,$parentesiscierre);
//$totalrtdos ='<h2>Resultados de la Busqueda</h2><div id="islandora_solr_result_count">(1 - 10 de 100';
$patenerlacantidad=strpos($totalrtdos,'islandora_solr_result_count');
$minuevacadena = substr($totalrtdos,$patenerlacantidad+27,50);
$patenerlacantidad2=strpos($minuevacadena,' de ');
$totalrtdos = substr($minuevacadena,$patenerlacantidad2+4,50);
//////////////////////////////////////////////////////////////////////////
//$largocadena = strlen($totalrtdos);
//$totalrtdos = substr($totalrtdos,($largocadena-3),3);
/*
Consultamos para el caso donde la cantidad de objetos solictados es mayor a la encontrada como resultados
*/
/*if($cantobjeto>$totalrtdos){
   $cantobjeto=$totalrtdos;
   }*/
$posicionproximacadena=0;
$resultadodevuelto=$prueba;
for ($contadortres = 1;$contadortres <= $totalrtdos;$contadortres++){
//////////////////***************************//////////////////////////////////
$nuevacadena = obtenerCadenaentreCadenas($resultadodevuelto,'<li','</li>');
$posicionproximacadena=strpos($resultadodevuelto,'</li>');
$resultadodevuelto=substr($resultadodevuelto,$posicionproximacadena+5);
$pabuscarmetadatamods2 = obtenerCadenaentreCadenas($nuevacadena,'href="','"');
$traemeelxml=$pabuscarmetadatamods2.'/MODS/MODS';
/*$requestlelo = drupal_http_request('http://localhost'.$traemeelxml);
$datalelo = $requestlelo->data;***tambien funciona esto****/
//Curl call. buen link http://php.net/manual/en/function.curl-setopt.php
$chsalidita = curl_init();
curl_setopt($chsalidita, CURLOPT_URL, 'http://localhost'.$traemeelxml);
curl_setopt($chsalidita, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($chsalidita, CURLOPT_CONNECTTIMEOUT, 200);
$traemeelxml = curl_exec($chsalidita);
curl_close($chsalidita);
////////////////////////////////////////////////////////////////////////////////////////////
$tipodeobjeto = obtenerCadenaentreCadenas($traemeelxml,'<genre>','</genre>');
/////////////obtencion del url del objeto///////////////////////////////////////////////////
//busca el archivo desde el pid
switch($formatoobjeto){
			case 'jpg':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.'.$formatoobjeto;   
			 break;
			 }
			case 'png':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.jpg';   
			 break;
			 }
                        case 'gif':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.jpg';   
			 break;
			 }
                    	case 'sitio web':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.zip';   
			 break;
			 }
                    	case 'scorm':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.zip';   
			 break;
			 }
                    	case 'otros':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.zip';   
			 break;
			 }
                    	case 'ims':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.zip';   
			 break;
			 }
                    	case 'pdf':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.pdf';   
			 break;
			 }	
                    	case 'word':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.pdf';   
			 break;
			 }
                    	case 'excel':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.pdf';   
			 break;
			 }
                    	case 'ppt':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.pdf';   
			 break;
			 }
                    	case 'mp3':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.mp3';   
			 break;
			 }
                        case 'ogg':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.mp3';   
			 break;
			 }
                        case 'wav':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.mp3';   
			 break;
			 }
                    	case 'mp4':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.mp4';   
			 break;
			 }
                        case 'avi':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.mp4';   
			 break;
			 }
                        case 'mov':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.mp4';   
			 break;
			 }
                        case 'qt':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.mp4';   
			 break;
			 }
			case 'sfo':{
                        switch($tipodeobjeto){
                          case 'Scorm':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.zip';   
			 break;
			 }
                         case 'Sitio Web':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.zip';   
			 break;
			 }
                         case 'IMS':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.zip';   
			 break;
			 }
                         case 'Otros':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.zip';   
			 break;
			 }
                        case 'mp3':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.mp3';   
			 break;
			 }
                         case 'ogg':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.mp3';   
			 break;
			 }
                         case 'wav':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.mp3';   
			 break;
			 }
                    	case 'mp4':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.mp4';   
			 break;
			 }
                        case 'avi':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.mp4';   
			 break;
			 }
                        case 'mov':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.mp4';   
			 break;
			 }
                        case 'qt':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.mp4';   
			 break;
			 }
                         case 'pdf':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.pdf';   
			 break;
			 }
                        case 'word':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.pdf';   
			 break;
			 }
                         case 'excel':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.pdf';   
			 break;
			 }
                         case 'ppt':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.pdf';   
			 break;
			 }
                    	case 'jpg':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.jpg';   
			 break;
			 }
                        case 'png':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.jpg';   
			 break;
			 } 
                         case 'gif':{
$urlobjeto='http://repositoriounsj.no-ip.org:8080'.$pabuscarmetadatamods2.'/OBJ/OBJ.jpg';   
			 break;
			 }  
/*
Aca vienen los datos de las demas colecciones cuando este aprobada la ontologia, por el momento pondremos uno para cada coleccion
*/
                         }//fin switch interno a case sfo   
			 break;
			 }
                      } //fin switch
/////////////obtencion del titulo del objeto////////////////////////////////////////////////
//buscarle entre <title>y</title> de $traemeelxml
$tituloobjeto = obtenerCadenaentreCadenas($traemeelxml,'<title>','</title>');
if($tituloobjeto ==''){$tituloobjeto='---';}           
/////////////obtencion de la descripcion del objeto//////////////////////////////////////////
//buscarle entre <note>y</note> de $traemeelxml
$descobjeto = obtenerCadenaentreCadenas($traemeelxml,'&lt;p&gt;','&lt;/p&gt;');
if($descobjeto ==''){$descobjeto='---';}  
/////////////obtencion de la explicacion de la recomendacion del objeto/////////////////////
//a partir de las recomendaciones a generar, pa mas adelante
$explicacionrecomendacion='El objeto adecuado segun el usuario y el area indicados es';
//////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
if(strcasecmp($formatoobjeto,$tipodeobjeto)==0){//if pa filtrar objetos por formato
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
        //.'+'.$areainteres
        $results[$contadortres]['descripcion'] = $descobjeto;  
          break;
        }
        case 3:{
        $results[$contadortres]['explicacion'] = $explicacionrecomendacion;  
        break;
        }
      }//fin switch
     }//fin del for
    }//fin del if pa filtrar objetos por formato
    else{
      if($formatoobjeto=='sfo'){//if pa mostrar todo porque no se especifico un formato
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
        //.'+'.$areainteres
        $results[$contadortres]['descripcion'] = $descobjeto;  
          break;
        }
        case 3:{
        $results[$contadortres]['explicacion'] = $explicacionrecomendacion;  
        break;
        }
       }//fin for
      }
    }//fin del else  
}/
}
}
