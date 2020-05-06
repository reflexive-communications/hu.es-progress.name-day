-- +--------------------------------------------------------------------+
-- | Copyright CiviCRM LLC. All rights reserved.                        |
-- |                                                                    |
-- | This work is published under the GNU AGPLv3 license with some      |
-- | permitted exceptions and without any warranty. For full license    |
-- | and copyright information, see https://civicrm.org/licensing       |
-- +--------------------------------------------------------------------+
--
-- Generated from schema.tpl
-- DO NOT EDIT.  Generated by CRM_Core_CodeGen
--


-- +--------------------------------------------------------------------+
-- | Copyright CiviCRM LLC. All rights reserved.                        |
-- |                                                                    |
-- | This work is published under the GNU AGPLv3 license with some      |
-- | permitted exceptions and without any warranty. For full license    |
-- | and copyright information, see https://civicrm.org/licensing       |
-- +--------------------------------------------------------------------+
--
-- Generated from drop.tpl
-- DO NOT EDIT.  Generated by CRM_Core_CodeGen
--
-- /*******************************************************
-- *
-- * Clean up the exisiting tables
-- *
-- *******************************************************/

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS civicrm_es_progress_name_day;

SET FOREIGN_KEY_CHECKS = 1;
-- /*******************************************************
-- *
-- * Create new tables
-- *
-- *******************************************************/

-- /*******************************************************
-- *
-- * civicrm_es_progress_name_day
-- *
-- * Hungarian name days
-- *
-- *******************************************************/
CREATE TABLE civicrm_es_progress_name_day
(


  id INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Name-day ID',
  first_name VARCHAR(63) NOT NULL COMMENT 'First name',
  name_day VARCHAR(15) NOT NULL COMMENT 'Date of name day',
  PRIMARY KEY (id)


);
