<?php

use Civi\Api4\Group;
use Civi\Api4\OptionValue;
use CRM_NameDay_BAO_EsProgressNameDay as BAO;

/**
 * Collection of upgrade steps.
 */
class CRM_NameDay_Upgrader extends CRM_NameDay_Upgrader_Base
{
  /**
   * Get Mailing list option value
   *
   * @return mixed
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function getMailingListOptionValue()
  {
    $result = OptionValue::get()
      ->addSelect('value')
      ->addWhere('name', '=', 'Mailing list')
      ->setLimit(1)
      ->execute();

    return $result->first()['value'];
  }

  /**
   * Create new group
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function createGroup()
  {
    // Get Group ID
    $bao = new BAO();
    $group_id = $bao->getGroupId();

    // Group ID valid --> Group already exist
    if ($group_id != 0) {
      return;
    }

    // Get Mailing list option value
    $mailing_list_option = $this->getMailingListOptionValue();

    // Create group
    Group::create()
      ->addValue('title', BAO::GROUP_TITLE)
      ->addValue('name', BAO::GROUP_NAME)
      ->addValue('description', BAO::GROUP_DESC)
      ->addValue('source', CRM_NameDay_ExtensionUtil::LONG_NAME)
      ->addValue('visibility', 'User and User Admin Only')
      ->addValue(
        'group_type',
        [
          $mailing_list_option,
        ]
      )
      ->execute();
  }

  /**
   * Remove group
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function removeGroup()
  {
    // Get Group ID
    $bao = new BAO();
    $group_id = $bao->getGroupId();

    // Group ID not valid --> Group already deleted
    if ($group_id === 0) {
      return;
    }

    // Delete group
    Group::delete()
      ->addWhere('id', '=', $group_id)
      ->setLimit(1)
      ->execute();
  }
}
