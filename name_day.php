<?php

require_once 'name_day.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function name_day_civicrm_config(&$config)
{
    _name_day_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function name_day_civicrm_xmlMenu(&$files)
{
    _name_day_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function name_day_civicrm_install()
{
    _name_day_civix_civicrm_install();

    // Create custom fields
    $installer = _name_day_civix_upgrader();
    $installer->createGroup();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function name_day_civicrm_postInstall()
{
    _name_day_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function name_day_civicrm_uninstall()
{
    _name_day_civix_civicrm_uninstall();

    // Delete custom fields
    $installer = _name_day_civix_upgrader();
    $installer->removeGroup();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function name_day_civicrm_enable()
{
    _name_day_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function name_day_civicrm_disable()
{
    _name_day_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function name_day_civicrm_upgrade($op, CRM_Queue_Queue $queue = null)
{
    return _name_day_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function name_day_civicrm_managed(&$entities)
{
    _name_day_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function name_day_civicrm_caseTypes(&$caseTypes)
{
    _name_day_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function name_day_civicrm_angularModules(&$angularModules)
{
    _name_day_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function name_day_civicrm_alterSettingsFolders(&$metaDataFolders = null)
{
    _name_day_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function name_day_civicrm_entityTypes(&$entityTypes)
{
    _name_day_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_thems().
 */
function name_day_civicrm_themes(&$themes)
{
    _name_day_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 *
 * function name_day_civicrm_preProcess($formName, &$form) {
 *
 * } // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 *
 * function name_day_civicrm_navigationMenu(&$menu) {
 * _name_day_civix_insert_navigation_menu($menu, 'Mailings', array(
 * 'label' => E::ts('New subliminal message'),
 * 'name' => 'mailing_subliminal_message',
 * 'url' => 'civicrm/mailing/subliminal',
 * 'permission' => 'access CiviMail',
 * 'operator' => 'OR',
 * 'separator' => 0,
 * ));
 * _name_day_civix_navigationMenu($menu);
 * } // */

// function name_day_civicrm_post($op, $objectName, $objectId, &$objectRef) {
//   if ($op !== 'create' && $op!=='edit') {
//     return;
//   }
//
//   if ($objectName!=='Individual') {
//     return;
//   }
//   $first_name=$objectRef->first_name ?? null;
//
//   if ($first_name) {
//     name_day_update_name_day($objectId, $first_name);
//   }
// }
//
// function name_day_update_name_day(int $id, string $first_name) {
//   $bao=new CRM_NameDay_BAO_EsProgressNameDay();
//   $date=$bao->updateNameDayDate($id,$first_name);
// }
