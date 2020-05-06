<?php

use Civi\Api4\Tag;

/**
 * Collection of upgrade steps.
 */
class CRM_NameDay_Upgrader extends CRM_NameDay_Upgrader_Base
{

  /**
   * Create new tag
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function createTag()
  {
    // Get Tag ID
    $bao = new CRM_NameDay_BAO_EsProgressNameDay();
    $tag_id = $bao->getTagId();

    // Tag ID valid --> Tag already exist
    if ($tag_id != 0) {
      return;
    }

    // Tag not exist --> create
    Tag::create()
      ->addValue('name', CRM_NameDay_BAO_EsProgressNameDay::TAG_NAME)
      ->addValue('description', CRM_NameDay_BAO_EsProgressNameDay::TAG_DESCRIPTION)
      ->addValue('is_selectable', true)
      ->addValue(
        'used_for',
        [
          'civicrm_contact',
        ]
      )
      ->execute();
  }

  /**
   * Remove tag
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function removeTag()
  {
    Tag::delete()
      ->addWhere('name', '=', CRM_NameDay_BAO_EsProgressNameDay::TAG_NAME)
      ->setLimit(1)
      ->execute();
  }
}
