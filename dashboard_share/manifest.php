<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

$manifest = array (
  'built_in_version' => '7.7.0.0',
  'acceptable_sugar_versions' =>
  array (
    0 => '',
  ),
  'acceptable_sugar_flavors' =>
  array (
    0 => 'ENT',
    1 => 'ULT',
  ),
  'readme' => '',
  'key' => 'raw',
  'author' => '',
  'description' => '',
  'icon' => '',
  'is_uninstallable' => true,
  'name' => 'Sharable Dashboards',
  'published_date' => '2016-11-09 17:43:07',
  'type' => 'module',
  'version' => time(),
  'remove_tables' => 'prompt',
);


$installdefs = array (
  'copy' =>
	array (
	     0 =>
			array (
			  'from' => '<basepath>/custom/Extension/application/Ext/Language/en_us.dashlet_share.php',
			  'to' => 'custom/Extension/application/Ext/Language/en_us.dashlet_share.php',
			),
		  1 =>
			array (
			  'from' => '<basepath>/custom/Extension/application/Ext/EntryPointRegistry/customEntryPoint.php',
			  'to' => 'custom/Extension/application/Ext/EntryPointRegistry/customEntryPoint.php',
			),
		  2 =>
			array (
			  'from' => '<basepath>/custom/modules/Home/clients/base/views/dashboard-headerpane/dashboard-headerpane.php',
			  'to' => 'custom/modules/Home/clients/base/views/dashboard-headerpane/dashboard-headerpane.php',
			),
		  3 =>
			array (
			  'from' => '<basepath>/custom/clients/base/views/dashboard-headerpane/dashboard-headerpane.php',
			  'to' => 'custom/clients/base/views/dashboard-headerpane/dashboard-headerpane.php',
			),
		  4 =>
			array (
			  'from' => '<basepath>/custom/clients/base/views/dashboard-headerpane/dashboard-headerpane.js',
			  'to' => 'custom/clients/base/views/dashboard-headerpane/dashboard-headerpane.js',
			),
		  5 =>
			array (
			  'from' => '<basepath>/custom/clients/base/views/dashboard-share-config/dashboard-share-config.js',
			  'to' => 'custom/clients/base/views/dashboard-share-config/dashboard-share-config.js',
			),
		  6 =>
			array (
			  'from' => '<basepath>/custom/clients/base/views/dashboard-share-config/dashboard-share-config.hbs',
			  'to' => 'custom/clients/base/views/dashboard-share-config/dashboard-share-config.hbs',
			),
		  7 =>
			array (
			  'from' => '<basepath>/custom/clients/base/views/dashlet-toolbar/dashlet-toolbar.php',
			  'to' => 'custom/clients/base/views/dashlet-toolbar/dashlet-toolbar.php',
			),
		  8 =>
			array (
			  'from' => '<basepath>/custom/clients/base/views/dashlet-toolbar/dashlet-toolbar.js',
			  'to' => 'custom/clients/base/views/dashlet-toolbar/dashlet-toolbar.js',
			),
		  9 =>
			array (
			  'from' => '<basepath>/custom/clients/base/layouts/dashboard-share-config/dashboard-share-config.php',
			  'to' => 'custom/clients/base/layouts/dashboard-share-config/dashboard-share-config.php',
			),
		  10 =>
			array (
			  'from' => '<basepath>/custom/clients/base/api/CustomDashboadShareApi.php',
			  'to' => 'custom/clients/base/api/CustomDashboadShareApi.php',
			),
		  11 =>
			array (
			  'from' => '<basepath>/custom/customEntryPoint.php',
			  'to' => 'custom/customEntryPoint.php',
			),
  ),
);

