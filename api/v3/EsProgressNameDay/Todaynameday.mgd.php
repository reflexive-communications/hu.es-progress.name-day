<?php
// This file declares a managed database record of type "Job".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
return [
    0 =>
        [
            'name' => 'Cron:EsProgressNameDay.Todaynameday',
            'entity' => 'Job',
            'params' =>
                [
                    'version' => 3,
                    'name' => 'Update name day',
                    'description' => 'Update today name day contacts',
                    'run_frequency' => 'Daily',
                    'api_entity' => 'EsProgressNameDay',
                    'api_action' => 'Todaynameday',
                    'parameters' => '',
                ],
        ],
];
