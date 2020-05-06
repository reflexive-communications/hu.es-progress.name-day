<?php

/**
 * EsProgressNameDay.create API specification (optional).
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/api-architecture/
 */
function _civicrm_api3_es_progress_name_day_create_spec(&$spec)
{
  // $spec['some_parameter']['api.required'] = 1;
}

/**
 * EsProgressNameDay.create API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 */
function civicrm_api3_es_progress_name_day_create($params)
{
  return _civicrm_api3_basic_create(_civicrm_api3_get_BAO(__FUNCTION__), $params, EsProgressNameDay);
}

/**
 * EsProgressNameDay.delete API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws \API_Exception
 * @throws \CiviCRM_API3_Exception
 * @throws \Civi\API\Exception\UnauthorizedException
 */
function civicrm_api3_es_progress_name_day_delete($params)
{
  return _civicrm_api3_basic_delete(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * EsProgressNameDay.get API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 */
function civicrm_api3_es_progress_name_day_get($params)
{
  return _civicrm_api3_basic_get(_civicrm_api3_get_BAO(__FUNCTION__), $params, false, EsProgressNameDay);
}
