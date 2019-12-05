<?php

/**
 * batch creation form submit
 * @global user $user
 * @param array $form
 * @param array $form_state
 * @param array $content_models
 */
function batch_creation_form2(&$form_state, $collection_pid,$link=0) {
//drupal_set_message("link ".$link);
  module_load_include('inc', 'fedora_repository', 'api/fedora_utils');
  module_load_include('inc', 'fedora_repository', 'CollectionPolicy');
  $policy = CollectionPolicy::loadFromCollection($collection_pid, TRUE);
  if (!$policy) {
    $form['titlebox'] = array(
      '#type' => 'item',
      '#value' => t("This collection is missing a Collection Policy"),
    );

    return $form;
  }

  $content_models = $policy->getContentModels();

  $cm_options = array();
  $name_mappings = array();
  foreach ($content_models as $content_model) {
    if ($content_model->pid != "islandora:collectionCModel") {
      $cm_options[$content_model->pid] = $content_model->name;
      $name_mappings[] = $content_model->pid . '^' . $content_model->pid_namespace;
    }
  }

  $mappings = implode('~~~', $name_mappings);
  $form['#attributes']['enctype'] = 'multipart/form-data';

  $form['titlebox'] = array(
    '#type' => 'item',
    '#value' => t("Descargar objeto SCORM"),
  );

  $form['collection_pid'] = array(
    '#type' => 'hidden',
    '#value' => $collection_pid,
  );
  $form['namespace_mappings'] = array(
    '#type' => 'hidden',
    '#value' => $mappings,
  );
  $form['submit'] = array(
    '#type' => 'button',
    //'#method' => 'get',
    '#onclick' => "'location.href='.$link.'",
    '#value' => t('Descargar ')
  );
  return($form);
}
