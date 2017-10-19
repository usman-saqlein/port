<?php
function gavias_financial_form_contact_message_feedback_form_alter(&$form, \Drupal\Core\Form\FormStateInterface $form_state, $form_id) {
  
  // Name
  $form['name']['#weight'] = -1;
  $form['name']['#prefix'] = '<div class="contact-feedback"><div class="form-group">';
  $form['name']['#suffix'] = '</div>';
  $form['name']['#attributes']['placeholder'][] = $form['name']['#title'].'*';
  $form['name']['#attributes']['class'][] = 'form-control';
  unset($form['name']['#title']);

  // Mail
  $form['mail']['#weight'] = -2;
  $form['mail']['#prefix'] = '<div class="form-group">';
  $form['mail']['#suffix'] = '</div>';
  $form['mail']['#attributes']['placeholder'][] = $form['mail']['#title'].'*';
  $form['mail']['#attributes']['class'][] = 'form-control';
  unset($form['mail']['#title']);


  // Subject
  $form['subject']['widget'][0]['#weight'] = -3;
  $form['subject']['widget'][0]['#prefix'] = '<div class="form-group">';
  $form['subject']['widget'][0]['#suffix'] = '</div>';
  $form['subject']['widget'][0]['value']['#attributes']['class'][] = 'form-control';
  $form['subject']['widget'][0]['value']['#attributes']['placeholder'][] = $form['subject']['widget'][0]['#title'].'*';
  unset($form['subject']['widget'][0]['value']['#title']);
 
  // Message
  $form['message']['#weight'] = -5;
  $form['message']['widget'][0]['value']['#attributes']['class'][] = 'form-control';
  $form['message']['widget'][0]['value']['#attributes']['placeholder'][] = $form['message']['widget'][0]['#title'].'*';
  $form['message']['widget'][0]['#title'] = '';
  unset($form['message']['widget'][0]['value']['#title']);
  $form['message']['widget'][0]['#prefix'] = '<div class="clearfix"><div class="form-group">';
  $form['message']['widget'][0]['#suffix'] = '</div></div>';

  // Submit
  $form['actions']['#weight'] = 99;
  $form['actions']['#prefix'] = '<div class="clearfix">';
  $form['actions']['#suffix'] = '</div></div>';
  $form['actions']['submit']['#attributes']['class'][] = 'btn';
  $form['actions']['submit']['#attributes']['class'][] = 'btn-theme-submit';
  
}

function gavias_financial_form_contact_message_request_call_back_form_alter(&$form, \Drupal\Core\Form\FormStateInterface $form_state, $form_id) {
  
  
  unset($form['mail']);
  unset($form['message']);
  //print_r($form['#attributes']);
  $form['#enctype'] = 'multipart/form-data';
  
  $form['html_before']['#weight'] = -99;
  $form['html_before']['#prefix'] = '<div class="contact-request-call-back"><div class="row">';

  $form['field_contact_help']['#weight'] = -90;
  $form['field_contact_help']['#prefix'] = '<div class="col-sm-4 col-1">';
  $form['field_contact_help']['#suffix'] = '</div>';
  unset($form['field_contact_help']['widget']['#title']);
  
  // Name
  $form['name']['#weight'] = -80;
  $form['name']['#prefix'] = '<div class="col-sm-3 col-2">';
  $form['name']['#suffix'] = '</div>';
  $form['name']['#attributes']['placeholder'][] = $form['name']['#title'];
  $form['name']['#attributes']['class'][] = 'form-control';
  unset($form['name']['#title']);

  // Subject
  $form['subject']['widget'][0]['#weight'] = -70;
  $form['subject']['#attributes']['class'][] = 'col-sm-3 col-3';
  $form['subject']['widget'][0]['value']['#attributes']['placeholder'][] = t('Your Phone');
  unset($form['subject']['widget'][0]['value']['#title']);
 
  //$form['html_copy_before']['#weight'] = 10;
  //$form['html_copy_before']['#prefix'] = '<div class="col-sm-2">';

  //copy
  $form['copy']['#weight'] = 91;

  // Submit
  $form['actions']['#weight'] = 92;
  $form['actions']['#prefix'] = '<div class="col-sm-2 col-4">';
  $form['actions']['#suffix'] = '</div>';
  $form['actions']['submit']['#attributes']['class'][] = 'btn';
  $form['actions']['submit']['#attributes']['class'][] = 'btn-theme-submit';
 

  //$form['html_copy_after']['#weight'] = 98;
  //$form['html_copy_after']['#suffix'] = '</div>';

  $form['html_after']['#weight'] = 99;
  $form['html_after']['#prefix'] = '';
  $form['html_after']['#suffix'] = '</div></div>';
}