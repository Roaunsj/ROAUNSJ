<?php

function islandora_batch_ingest_islandora_tabs($content_models, $pid) {

////////AGREGADO EN LA VERSION 11.3.1///////////////////
if(!user_access('create batch process')){
    return;
  }
////////////////////////////////////////////////////////
  module_load_include('inc', 'islandora_batch_ingest', 'BatchIngest');
  $content_model_pids = array();
  $tabset = array();
  foreach ($content_models as $content_model) {
    $content_model_pids[] = $content_model->pid;
  }

  if (in_array('islandora:collectionCModel', $content_model_pids)) {
      $tabset['batch_ingest_tab'] = array(
        '#type' => 'tabpage',
        '#title' => t('Batch Ingest'),
        '#content' => drupal_get_form('batch_creation_form', $pid),
      );
  }
//drupal_set_message("pid " .$pid);


   if(
      ($pid!= "islandora:root")&&
      ($pid!= "islandora:sp_archive_collection")&&
      ($pid!= "islandora:sp_archive_collection_ciencias")&&
      ($pid!= "islandora:sp_archive_collection_lenguaje")&&
      ($pid!= "islandora:sp_archive_collection_matematicas")&&
      ($pid!= "islandora:video_collection")&&
      ($pid!= "islandora:video_collection_ciencias")&&
      ($pid!= "islandora:video_collection_lenguaje")&&
      ($pid!= "islandora:video_collection_matematicas")&&
      ($pid!= "islandora:lenguaje")&&
      ($pid!= "islandora:ciencias")&&
      ($pid!= "islandora:matematicas")    
     ){
       return $tabset;
      }  
}

function islandora_batch_ingest_perm() {
  return array(
    'create batch process',
  );
}
