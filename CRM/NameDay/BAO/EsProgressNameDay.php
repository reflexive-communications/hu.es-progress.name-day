<?php
use CRM_NameDay_ExtensionUtil as E;

class CRM_NameDay_BAO_EsProgressNameDay extends CRM_NameDay_DAO_EsProgressNameDay {

  public function updateNameDayDate(int $contact_id,string $first_name)
  {
    // Get name day
    $results = \Civi\Api4\EsProgressNameDay::get()
      ->addSelect('name_day')
      ->addWhere('first_name', '=', $first_name)
      ->setLimit(1)
      ->execute();

    if ($results->count()>0) {
      $name_day=$results->first()['name_day'];
    } else {
      $name_day=null;
    }

    if (is_null($name_day)) {
      return;
    }

    $results = \Civi\Api4\Contact::update()
      ->addWhere('id', '=', $contact_id)
      ->addValue('es_progress_name_day.name_day', $name_day)
      ->setLimit(1)
      ->execute();
  }

  public function getTodayNameDays()
  {

  }

  public function putTagToContacts()
  {
    $today=new DateTime('now');
    $today=$today->format('m-d');

    $results = \Civi\Api4\EsProgressNameDay::get()
      ->addSelect('first_name')
      ->addWhere('name_day', '=', $today)
      ->execute();

    foreach ($results as $result) {
      $first_name=$result['first_name'];
      $contacts = \Civi\Api4\Contact::get()
        ->addSelect('id')
        ->addWhere('first_name', '=', $first_name)
        ->execute();

      foreach ($contacts as $contact) {
        var_dump($contact);
      }


    }
  }

  public function removeTagFromContacts()
  {

  }
}
