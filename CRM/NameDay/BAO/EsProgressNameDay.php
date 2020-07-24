<?php

use Civi\Api4\Contact;
use Civi\Api4\EsProgressNameDay;
use Civi\Api4\Group;
use Civi\Api4\GroupContact;

/**
 * CRM_NameDay_BAO_EsProgressNameDay Class
 */
class CRM_NameDay_BAO_EsProgressNameDay extends CRM_NameDay_DAO_EsProgressNameDay
{
  /**
   * Group name
   */
  public const GROUP_NAME = 'name day';

  /**
   * Group title
   */
  public const GROUP_TITLE = 'Today name day';

  /**
   * Group description
   */
  public const GROUP_DESC = 'Contacts with name day today';

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
   * Get group members count
   *
   * @param int $group_id Group ID
   *
   * @return int
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function getGroupMembersCount(int $group_id)
  {
    $result = GroupContact::get()
      ->addSelect('id')
      ->addWhere('group_id', '=', $group_id)
      ->addWhere('status', '=', 'Added')
      ->execute();

    return $result->count();
  }

  /**
   * Get contact status in group
   *
   * @param int $contact_id Contact ID
   * @param int $group_id Group ID
   *
   * @return mixed
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function getContactGroupStatus(int $contact_id, int $group_id)
  {
    $result = GroupContact::get()
      ->addSelect('status')
      ->addWhere('contact_id', '=', $contact_id)
      ->addWhere('group_id', '=', $group_id)
      ->setLimit(1)
      ->execute();

    return $result->first()['status'];
  }

  /**
   * Get contacts who has name day today
   *
   * @return array Contact IDs
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  protected function getTodayNames()
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
      // Check contact status
      $status = $this->getContactGroupStatus($contact, $group_id);

      switch ($status) {
        case 'Removed':
          // GroupContact already exist --> Set contact status to added
          GroupContact::update()
            ->addWhere('group_id', '=', $group_id)
            ->addWhere('contact_id', '=', $contact)
            ->addValue('status', 'Added')
            ->execute();
          break;

        case 'Added':
          // Contact already added --> don't do anything (this should not happen)
          break;

        default:
          // API v4: for some reason this call sometimes not work
          // Create GroupContact
          // GroupContact::create()
          //   ->addValue('group_id', $group_id)
          //   ->addValue('contact_id', $contact)
          //   ->addValue('status', 'Added')
          //   ->execute();

          // API v3: it works reliably
          $result = civicrm_api3('GroupContact', 'create', [
            'group_id' => self::GROUP_NAME,
            'contact_id' => $contact,
            'status' => "Added",
          ]);
          break;
      }
      $affected_contacts++;
    }

    return $affected_contacts;
  }

  /**
   * Remove contacts from group
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
    // No contacts in group
    if ($this->getGroupMembersCount($group_id) == 0) {
      return;
    }

    $results = GroupContact::update()
      ->addWhere('group_id', '=', $group_id)
      ->addWhere('status', '=', 'Added')
      ->addValue('status', 'Removed')
      ->execute();

    return $results->count();
  }
}
