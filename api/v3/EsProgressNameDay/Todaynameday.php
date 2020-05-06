<?php

/**
 * EsProgressNameDay.Todaynameday API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/api-architecture/
 */
function _civicrm_api3_es_progress_name_day_Todaynameday_spec(&$spec)
{
}

/**
 * EsProgressNameDay.Todaynameday API
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 * @throws \CiviCRM_API3_Exception
 * @see civicrm_api3_create_success
 *
 */
function civicrm_api3_es_progress_name_day_Todaynameday($params)
{
  $bao = new CRM_NameDay_BAO_EsProgressNameDay();

  // Get tag ID
  $tag_id = $bao->getTagId();

  // Remove tags from contacts (from last run)
  $removed = $bao->removeTagFromContacts($tag_id);

  // Put tags to new contacts
  $new = $bao->putTagToContacts($tag_id);

  $return_values = [
    'removed contacts' => $removed,
    'today name day contacts' => $new,
  ];

  return civicrm_api3_create_success($return_values, $params, 'EsProgressNameDay', 'Todaynameday');
}
