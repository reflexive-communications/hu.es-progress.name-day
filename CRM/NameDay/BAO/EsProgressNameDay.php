<?php

use Civi\Api4\Contact;
use Civi\Api4\EntityTag;
use Civi\Api4\EsProgressNameDay;
use Civi\Api4\Tag;

/**
 * CRM_NameDay_BAO_EsProgressNameDay Class
 */
class CRM_NameDay_BAO_EsProgressNameDay extends CRM_NameDay_DAO_EsProgressNameDay
{

  /**
   * Tag name
   */
  public const TAG_NAME = 'name day';

  /**
   * Tag description
   */
  public const TAG_DESCRIPTION = 'Today name day';

  /**
   * Get tag ID
   *
   * @return int Tag ID
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function getTagId(): int
  {
    // Get tag
    $result = Tag::get()
      ->addSelect('id')
      ->addWhere('name', '=', self::TAG_NAME)
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
   * Apply tag to relevant contacts
   *
   * @param int $tag_id Tag ID
   *
   * @return int
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function putTagToContacts(int $tag_id)
  {
    // Result
    $affected_contacts = 0;

    // Get contacts with name days
    $contacts = $this->getTodayNames();

    // Apply tag
    foreach ($contacts as $contact) {
      EntityTag::create()
        ->addValue('entity_id', $contact)
        ->addValue('tag_id', $tag_id)
        ->addValue('entity_table', 'civicrm_contact')
        ->execute();

      $affected_contacts++;
    }

    return $affected_contacts;
  }

  /**
   * Remove tag from contacts
   *
   * @param int $tag_id Tag ID
   *
   * @return int
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function removeTagFromContacts(int $tag_id)
  {
    $affected_contacts = 0;

    // Search contacts with tag
    $entityTags = EntityTag::get()
      ->addSelect('id')
      ->addWhere('tag_id', '=', $tag_id)
      ->addWhere('entity_table', '=', 'civicrm_contact')
      ->execute();

    // Delete each tag
    foreach ($entityTags as $entityTag) {
      EntityTag::delete()
        ->addWhere('id', '=', $entityTag['id'])
        ->execute();

      $affected_contacts++;
    }

    return $affected_contacts;
  }
}
