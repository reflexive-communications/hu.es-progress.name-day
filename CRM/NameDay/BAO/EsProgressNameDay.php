<?php

use Civi\Api4\Contact;
use Civi\Api4\EntityTag;
use Civi\Api4\EsProgressNameDay;
use Civi\Api4\Group;
use Civi\Api4\GroupContact;
use Civi\Api4\Tag;

/**
 * CRM_NameDay_BAO_EsProgressNameDay Class
 */
class CRM_NameDay_BAO_EsProgressNameDay extends CRM_NameDay_DAO_EsProgressNameDay
{
  public const GROUP_NAME='name day';

  public const GROUP_TITLE='Today name day';

  public const GROUP_DESC='Contacts with name day today';

  /**
   * Get group ID
   *
   * @return int Group ID
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function getGroupId(): int
  {
    // Get group
    $result = Group::get()
      ->addSelect('id')
      ->addWhere('name', '=', self::GROUP_NAME)
      ->setLimit(1)
      ->execute();

    // Validate result
    if ($result->count() == 1) {
      return $result->first()['id'];
    } else {
      return 0;
    }
  }

  /**
   * Get contacts who has name day today
   *
   * @return array Contact IDs
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function getTodayNames()
  {
    // Results
    $name_day_contacts = [];

    // Get today & format
    $today = new DateTime('now');
    $today = $today->format('m-d');

    // Names today
    $names = EsProgressNameDay::get()
      ->addSelect('first_name')
      ->addWhere('name_day', '=', $today)
      ->execute();

    foreach ($names as $name) {
      // Search contacts with given first name
      $contacts = Contact::get()
        ->addSelect('id')
        ->addWhere('first_name', '=', $name['first_name'])
        ->execute();

      // Put contact IDs
      foreach ($contacts as $contact) {
        $name_day_contacts[] = $contact['id'];
      }
    }

    return $name_day_contacts;
  }

  /**
   * Add relevant contacts into group
   *
   * @param int $group_id Group ID
   *
   * @return int
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function addContactsToGroup(int $group_id)
  {
    // Result
    $affected_contacts = 0;

    // Get contacts with name days
    $contacts = $this->getTodayNames();

    // Add contacts to group
    foreach ($contacts as $contact) {
      GroupContact::create()
        ->addValue('group_id', $group_id)
        ->addValue('contact_id', $contact)
        ->addValue('status', 'Added')
        ->execute();

      $affected_contacts++;
    }

    return $affected_contacts;
  }

  /**
   * Remove tag from contacts
   *
   * @param int $group_id Group ID
   *
   * @return int
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function removeContactsFromGroup(int $group_id)
  {
    $affected_contacts = 0;

    GroupContact::update()
      ->addWhere('group_id', '=', $group_id)
      ->addWhere('status', '=', 'Added')
      ->addValue('status', 'Removed')
      ->execute();

    return $affected_contacts;
  }
}
