<?php

use Civi\Api4\CustomField;
use Civi\Api4\CustomGroup;
use CRM_NameDay_ExtensionUtil as E;

/**
 * Collection of upgrade steps.
 */
class CRM_NameDay_Upgrader extends CRM_NameDay_Upgrader_Base {

  /**
   * Custom group name
   */
  public const CUSTOM_GROUP_NAME='es_progress_name_day';

  public function createTag()
  {

  }

  public function removeTag()
  {

  }

  /**
   * Create custom name day field
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function createNameDayField()
  {
    // Create custom group
    CustomGroup::create()
      ->addValue('name', self::CUSTOM_GROUP_NAME)
      ->addValue('title', 'Name Day')
      ->addValue('extends', 'Individual')
      ->addValue('style', 'Inline')
      ->execute();

    // Get id
    $id=$this->getCustomGroupID();

    // Create custom field
    CustomField::create()
      ->addValue('custom_group_id', $id)
      ->addValue('label', 'name day')
      ->addValue('html_type', 'Select Date')
      ->addValue('data_type', 'Date')
      ->addValue('is_searchable', TRUE)
      ->addValue('date_format', 'mm/dd')
      ->execute();
  }

  /**
   * Get custom group id
   *
   * @return mixed
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function getCustomGroupID()
  {
    $result = CustomGroup::get()
      ->addSelect('id')
      ->addWhere('name', '=', self::CUSTOM_GROUP_NAME)
      ->setLimit(1)
      ->execute();

    return $result->first()['id'];
  }

  /**
   * Drops custom table
   *
   * @param int $id Custom group id
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  protected function dropCustomTable(int $id)
  {
    // Get table name
    $results = CustomGroup::get()
      ->addSelect('table_name')
      ->addWhere('id', '=', $id)
      ->setLimit(1)
      ->execute();

    $table_name=$results->first()['table_name'];

    // Drop table
    CRM_Core_DAO::executeQuery("DROP TABLE `${table_name}`");
  }

  /**
   * Delete custom field
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function deleteCustomFields()
  {
    // Get custom group id
    $id=$this->getCustomGroupID();

    // Drop table
    $this->dropCustomTable($id);

    // Delete custom field
    CustomField::delete()
      ->addWhere('custom_group_id', '=', $id)
      ->setLimit(25)
      ->execute();

    // Delete custom group
    CustomGroup::delete()
      ->addWhere('id', '=', $id)
      ->setLimit(25)
      ->execute();
  }
}
