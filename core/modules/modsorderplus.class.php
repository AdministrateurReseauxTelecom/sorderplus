<?php
/* Copyright (C) 2004-2017 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) ---Put here your own copyright and developer email---
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * 	\defgroup   sorderplus     Module sorderplus
 *  \brief      sorderplus module descriptor.
 *
 *  \file       htdocs/sorderplus/core/modules/modsorderplus.class.php
 *  \ingroup    sorderplus
 *  \brief      Description and activation file for module sorderplus
 */
include_once DOL_DOCUMENT_ROOT .'/core/modules/DolibarrModules.class.php';


//langue pour nom de l'onglet dans commande fournisseur
//$langs->load('stocks');


// The class name should start with a lower case mod for Dolibarr to pick it up
// so we ignore the Squiz.Classes.ValidClassName.NotCamelCaps rule.
// @codingStandardsIgnoreStart
/**
 *  Description and activation class for module sorderplus
 */
class modsorderplus extends DolibarrModules
{
	// @codingStandardsIgnoreEnd
	/**
	 * Constructor. Define names, constants, directories, boxes, permissions
	 *
	 * @param DoliDB $db Database handler
	 */
	public function __construct($db)
	{
        global $langs,$conf;

        $this->db = $db;

		// Id for module (must be unique).
		// Use here a free id (See in Home -> System information -> Dolibarr for list of used modules id).
		$this->numero = 510320;		// TODO Go on page https://wiki.dolibarr.org/index.php/List_of_modules_id to reserve id number for your module
		// Key text used to identify module (for permissions, menus, etc...)
		$this->rights_class = 'sorderplus';

		// Family can be 'crm','financial','hr','projects','products','ecm','technic','interface','other'
		// It is used to group modules by family in module setup page
		$this->family = "other";
		// Module position in the family
		$this->module_position = 500;
		// Gives the possibility to the module, to provide his own family info and position of this family (Overwrite $this->family and $this->module_position. Avoid this)
		//$this->familyinfo = array('myownfamily' => array('position' => '001', 'label' => $langs->trans("MyOwnFamily")));

		// Module label (no space allowed), used if translation string 'ModulesorderplusName' not found (MyModue is name of module).
		$this->name = preg_replace('/^mod/i','',get_class($this));
		// Module description, used if translation string 'ModulesorderplusDesc' not found (MyModue is name of module).
		$this->description = "Permet d'améliorer la ventilation en stock des commandes fournisseurs";
		// Used only if file README.md and README-LL.md not found.
		$this->descriptionlong = "sorderplusDescription (Long)";

		$this->editor_name = 'A.R.T. Guillaume Fraisse';
		$this->editor_url = 'https://www.example.com';

		// Possible values for version are: 'development', 'experimental', 'dolibarr', 'dolibarr_deprecated' or a version string like 'x.y.z'
		$this->version = '0.1';
		// Key used in llx_const table to save module status enabled/disabled (where sorderplus is value of property name of module in uppercase)
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);
		// Name of image file used for this module.
		// If file is in theme/yourtheme/img directory under name object_pictovalue.png, use this->picto='pictovalue'
		// If file is in module/img directory under name object_pictovalue.png, use this->picto='pictovalue@module'
		$this->picto='generic';

		// Defined all module parts (triggers, login, substitutions, menus, css, etc...)
		// for default path (eg: /sorderplus/core/xxxxx) (0=disable, 1=enable)
		// for specific path of parts (eg: /sorderplus/core/modules/barcode)
		// for specific css file (eg: /sorderplus/css/sorderplus.css.php)
		// $this->module_parts = array(
		                        	// 'triggers' => 1,                                 	// Set this to 1 if module has its own trigger directory (core/triggers)
									// 'login' => 0,                                    	// Set this to 1 if module has its own login method directory (core/login)
									// 'substitutions' => 1,                            	// Set this to 1 if module has its own substitution function file (core/substitutions)
									// 'menus' => 0,                                    	// Set this to 1 if module has its own menus handler directory (core/menus)
									// 'theme' => 0,                                    	// Set this to 1 if module has its own theme directory (theme)
		                        	// 'tpl' => 0,                                      	// Set this to 1 if module overwrite template dir (core/tpl)
									// 'barcode' => 0,                                  	// Set this to 1 if module has its own barcode directory (core/modules/barcode)
									// 'models' => 0,                                   	// Set this to 1 if module has its own models directory (core/modules/xxx)
									// 'css' => array('/sorderplus/css/sorderplus.css.php'),	// Set this to relative path of css file if module has its own css file
	 								// 'js' => array('/sorderplus/js/sorderplus.js.php'),          // Set this to relative path of js file if module must load a js on all pages
									// 'hooks' => array('propalcard','invoicecard') 	// Set here all hooks context managed by module. You can also set hook context 'all'
		                        // );
		
		//guits todo hooks a revoir
		// $this->module_parts = array(
									// 'hooks' => array('propalcard','ordercard','invoicecard')
									// );
		$this->module_parts = array(
									//'models' => 1,
									//'hooks' => array('interventioncard')
									);							
									
		// Data directories to create when module is enabled.
		// Example: this->dirs = array("/sorderplus/temp","/sorderplus/subdir");
		$this->dirs = array();

		// Config pages. Put here list of php page, stored into sorderplus/admin directory, to use to setup module.
		//$this->config_page_url = array("setup.php@sorderplus");

		// Dependencies
		$this->hidden = false;			// A condition to hide module
		$this->depends = array();		// List of module class names as string that must be enabled if this module is enabled
		$this->requiredby = array();	// List of module ids to disable if this one is disabled
		$this->conflictwith = array();	// List of module class names as string this module is in conflict with
		$this->phpmin = array(5,3);					// Minimum version of PHP required by module
		$this->need_dolibarr_version = array(4,0);	// Minimum version of Dolibarr required by module
		$this->langfiles = array("sorderplus@sorderplus");
		$this->warnings_activation = array();                     // Warning to show when we activate module. array('always'='text') or array('FR'='textfr','ES'='textes'...)
		$this->warnings_activation_ext = array();                 // Warning to show when we activate an external module. array('always'='text') or array('FR'='textfr','ES'='textes'...)

		// Constants
		// List of particular constants to add when module is enabled (key, 'chaine', value, desc, visible, 'current' or 'allentities', deleteonunactive)
		// Example: $this->const=array(0=>array('sorderplus_MYNEWCONST1','chaine','myvalue','This is a constant to add',1),
		//                             1=>array('sorderplus_MYNEWCONST2','chaine','myvalue','This is another constant to add',0, 'current', 1)
		// );
		$this->const = array();

		// Array to add new pages in new tabs
		// Example: $this->tabs = array('objecttype:+tabname1:Title1:mylangfile@sorderplus:$user->rights->sorderplus->read:/sorderplus/mynewtab1.php?id=__ID__',  					// To add a new tab identified by code tabname1
        //                              'objecttype:+tabname2:SUBSTITUTION_Title2:mylangfile@sorderplus:$user->rights->othermodule->read:/sorderplus/mynewtab2.php?id=__ID__',  	// To add another new tab identified by code tabname2. Label will be result of calling all substitution functions on 'Title2' key.
        //                              'objecttype:-tabname:NU:conditiontoremove');                                                     										// To remove an existing tab identified by code tabname
        // Can also be:	$this->tabs = array('data'=>'...', 'entity'=>0);
        
        $this->tabs = array(
            //'supplier_order:+sorderplus:Perso:sorderplus@sorderplus:1:/sorderplus/dispatch.php?id=__ID__',
            'supplier_order:+sorderplus:'.$langs->transnoentities('OrderDispatch').':sorderplus@sorderplus:1:/sorderplus/dispatch.php?id=__ID__',
            'supplier_order:+sorderplus:'.'Libération'.':sorderplus@sorderplus:1:/sorderplus/release.php?id=__ID__',
            'supplier_order:-dispatch'
         );

        //
		// where objecttype can be
		// 'categories_x'	  to add a tab in category view (replace 'x' by type of category (0=product, 1=supplier, 2=customer, 3=member)
		// 'contact'          to add a tab in contact view
		// 'contract'         to add a tab in contract view
		// 'group'            to add a tab in group view
		// 'intervention'     to add a tab in intervention view
		// 'invoice'          to add a tab in customer invoice view
		// 'invoice_supplier' to add a tab in supplier invoice view
		// 'member'           to add a tab in fundation member view
		// 'opensurveypoll'	  to add a tab in opensurvey poll view
		// 'order'            to add a tab in customer order view
		// 'order_supplier'   to add a tab in supplier order view
		// 'payment'		  to add a tab in payment view
		// 'payment_supplier' to add a tab in supplier payment view
		// 'product'          to add a tab in product view
		// 'propal'           to add a tab in propal view
		// 'project'          to add a tab in project view
		// 'stock'            to add a tab in stock view
		// 'thirdparty'       to add a tab in third party view
		// 'user'             to add a tab in user view
        //$this->tabs = array();

		if (! isset($conf->sorderplus) || ! isset($conf->sorderplus->enabled))
        {
        	$conf->sorderplus=new stdClass();
        	$conf->sorderplus->enabled=0;
        }

        // Dictionaries
		$this->dictionaries=array();
        /* Example:
        $this->dictionaries=array(
            'langs'=>'mylangfile@sorderplus',
            'tabname'=>array(MAIN_DB_PREFIX."table1",MAIN_DB_PREFIX."table2",MAIN_DB_PREFIX."table3"),		// List of tables we want to see into dictonnary editor
            'tablib'=>array("Table1","Table2","Table3"),													// Label of tables
            'tabsql'=>array('SELECT f.rowid as rowid, f.code, f.label, f.active FROM '.MAIN_DB_PREFIX.'table1 as f','SELECT f.rowid as rowid, f.code, f.label, f.active FROM '.MAIN_DB_PREFIX.'table2 as f','SELECT f.rowid as rowid, f.code, f.label, f.active FROM '.MAIN_DB_PREFIX.'table3 as f'),	// Request to select fields
            'tabsqlsort'=>array("label ASC","label ASC","label ASC"),																					// Sort order
            'tabfield'=>array("code,label","code,label","code,label"),																					// List of fields (result of select to show dictionary)
            'tabfieldvalue'=>array("code,label","code,label","code,label"),																				// List of fields (list of fields to edit a record)
            'tabfieldinsert'=>array("code,label","code,label","code,label"),																			// List of fields (list of fields for insert)
            'tabrowid'=>array("rowid","rowid","rowid"),																									// Name of columns with primary key (try to always name it 'rowid')
            'tabcond'=>array($conf->sorderplus->enabled,$conf->sorderplus->enabled,$conf->sorderplus->enabled)												// Condition to show each dictionary
        );
        */


        // Boxes/Widgets
		// Add here list of php file(s) stored in sorderplus/core/boxes that contains class to show a widget.
        $this->boxes = array(
        	0=>array('file'=>'sorderpluswidget1.php@sorderplus','note'=>'Widget provided by sorderplus','enabledbydefaulton'=>'Home'),
        	//1=>array('file'=>'sorderpluswidget2.php@sorderplus','note'=>'Widget provided by sorderplus'),
        	//2=>array('file'=>'sorderpluswidget3.php@sorderplus','note'=>'Widget provided by sorderplus')
        );


		// Cronjobs (List of cron jobs entries to add when module is enabled)
		$this->cronjobs = array(
			0=>array('label'=>'MyJob label', 'jobtype'=>'method', 'class'=>'/sorderplus/class/sorderplusmyjob.class.php', 'objectname'=>'sorderplusMyJob', 'method'=>'myMethod', 'parameters'=>'', 'comment'=>'Comment', 'frequency'=>2, 'unitfrequency'=>3600, 'status'=>0, 'test'=>true)
		);
		// Example: $this->cronjobs=array(0=>array('label'=>'My label', 'jobtype'=>'method', 'class'=>'/dir/class/file.class.php', 'objectname'=>'MyClass', 'method'=>'myMethod', 'parameters'=>'', 'comment'=>'Comment', 'frequency'=>2, 'unitfrequency'=>3600, 'status'=>0, 'test'=>true),
		//                                1=>array('label'=>'My label', 'jobtype'=>'command', 'command'=>'', 'parameters'=>'', 'comment'=>'Comment', 'frequency'=>1, 'unitfrequency'=>3600*24, 'status'=>0, 'test'=>true)
		// );


		// Permissions
		$this->rights = array();		// Permission array used by this module

		$r=0;
		
		
		//$this->rights[$r][0] = $this->numero + $r;	// Permission id (must not be already used)
		//$this->rights[$r][1] = 'Read objects of My Module';	// Permission label
		//$this->rights[$r][3] = 1; 					// Permission by default for new user (0/1)
		//$this->rights[$r][4] = 'read';				// In php code, permission will be checked by test if ($user->rights->sorderplus->level1->level2)
		//$this->rights[$r][5] = '';				    // In php code, permission will be checked by test if ($user->rights->sorderplus->level1->level2)
		//
		//$r++;
		//$this->rights[$r][0] = $this->numero + $r;	// Permission id (must not be already used)
		//$this->rights[$r][1] = 'Create/Update objects of My Module';	// Permission label
		//$this->rights[$r][3] = 1; 					// Permission by default for new user (0/1)
		//$this->rights[$r][4] = 'create';				// In php code, permission will be checked by test if ($user->rights->sorderplus->level1->level2)
		//$this->rights[$r][5] = '';				    // In php code, permission will be checked by test if ($user->rights->sorderplus->level1->level2)
		//
		//$r++;
		//$this->rights[$r][0] = $this->numero + $r;	// Permission id (must not be already used)
		//$this->rights[$r][1] = 'Delete objects of My Module';	// Permission label
		//$this->rights[$r][3] = 1; 					// Permission by default for new user (0/1)
		//$this->rights[$r][4] = 'delete';				// In php code, permission will be checked by test if ($user->rights->sorderplus->level1->level2)
		//$this->rights[$r][5] = '';				    // In php code, permission will be checked by test if ($user->rights->sorderplus->level1->level2)
			

		// Main menu entries
		$this->menu = array();			// List of menus to add
		$r=0;

		// Add here entries to declare new menus

		// Example to declare a new Top Menu entry and its Left menu entry:
		/* BEGIN MODULEBUILDER TOPMENU */
		//$this->menu[$r++]=array('fk_menu'=>'',			                // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
		//						'type'=>'top',			                // This is a Top menu entry
		//						'titre'=>'sorderplus',
		//						'mainmenu'=>'sorderplus',
		//						'leftmenu'=>'',
		//						'url'=>'/sorderplus/sorderplusindex.php',
		//						'langs'=>'sorderplus@sorderplus',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
		//						'position'=>1000+$r,
		//						'enabled'=>'$conf->sorderplus->enabled',	// Define condition to show or hide menu entry. Use '$conf->sorderplus->enabled' if entry must be visible if module is enabled.
		//						'perms'=>'1',			                // Use 'perms'=>'$user->rights->sorderplus->level1->level2' if you want your menu with a permission rules
		//						'target'=>'',
		//						'user'=>2);				                // 0=Menu for internal users, 1=external users, 2=both
		//
		///* END MODULEBUILDER TOPMENU */
		//
		//// Example to declare a Left Menu entry into an existing Top menu entry:
		///* BEGIN MODULEBUILDER LEFTMENU MYOBJECT
		//$this->menu[$r++]=array(	'fk_menu'=>'fk_mainmenu=sorderplus',	    // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
		//						'type'=>'left',			                // This is a Left menu entry
		//						'titre'=>'List MyObject',
		//						'mainmenu'=>'sorderplus',
		//						'leftmenu'=>'sorderplus',
		//						'url'=>'/sorderplus/myobject_list.php',
		//						'langs'=>'sorderplus@sorderplus',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
		//						'position'=>1000+$r,
		//						'enabled'=>'$conf->sorderplus->enabled',  // Define condition to show or hide menu entry. Use '$conf->sorderplus->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
		//						'perms'=>'1',			                // Use 'perms'=>'$user->rights->sorderplus->level1->level2' if you want your menu with a permission rules
		//						'target'=>'',
		//						'user'=>2);				                // 0=Menu for internal users, 1=external users, 2=both
		//$this->menu[$r++]=array(	'fk_menu'=>'fk_mainmenu=sorderplus,fk_leftmenu=sorderplus',	    // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
		//						'type'=>'left',			                // This is a Left menu entry
		//						'titre'=>'New MyObject',
		//						'mainmenu'=>'sorderplus',
		//						'leftmenu'=>'sorderplus',
		//						'url'=>'/sorderplus/myobject_page.php?action=create',
		//						'langs'=>'sorderplus@sorderplus',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
		//						'position'=>1000+$r,
		//						'enabled'=>'$conf->sorderplus->enabled',  // Define condition to show or hide menu entry. Use '$conf->sorderplus->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
		//						'perms'=>'1',			                // Use 'perms'=>'$user->rights->sorderplus->level1->level2' if you want your menu with a permission rules
		//						'target'=>'',
		//						'user'=>2);				                // 0=Menu for internal users, 1=external users, 2=both
		//END MODULEBUILDER LEFTMENU MYOBJECT */


		// Exports
		$r=1;

		// Example:
		/* BEGIN MODULEBUILDER EXPORT MYOBJECT
		$this->export_code[$r]=$this->rights_class.'_'.$r;
		$this->export_label[$r]='sorderplus';	                         // Translation key (used only if key ExportDataset_xxx_z not found)
        $this->export_enabled[$r]='1';                               // Condition to show export in list (ie: '$user->id==3'). Set to 1 to always show when module is enabled.
        $this->export_icon[$r]='generic:sorderplus';					 // Put here code of icon then string for translation key of module name
		//$this->export_permission[$r]=array(array("sorderplus","level1","level2"));
        $this->export_fields_array[$r]=array('t.rowid'=>"Id",'t.ref'=>'Ref','t.label'=>'Label','t.datec'=>"DateCreation",'t.tms'=>"DateUpdate");
		$this->export_TypeFields_array[$r]=array('t.rowid'=>'Numeric', 't.ref'=>'Text', 't.label'=>'Label', 't.datec'=>"Date", 't.tms'=>"Date");
		// $this->export_entities_array[$r]=array('t.rowid'=>"company",'s.nom'=>'company','s.address'=>'company','s.zip'=>'company','s.town'=>'company','s.fk_pays'=>'company','s.phone'=>'company','s.siren'=>'company','s.siret'=>'company','s.ape'=>'company','s.idprof4'=>'company','s.code_compta'=>'company','s.code_compta_fournisseur'=>'company','f.rowid'=>"invoice",'f.facnumber'=>"invoice",'f.datec'=>"invoice",'f.datef'=>"invoice",'f.total'=>"invoice",'f.total_ttc'=>"invoice",'f.tva'=>"invoice",'f.paye'=>"invoice",'f.fk_statut'=>'invoice','f.note'=>"invoice",'fd.rowid'=>'invoice_line','fd.description'=>"invoice_line",'fd.price'=>"invoice_line",'fd.total_ht'=>"invoice_line",'fd.total_tva'=>"invoice_line",'fd.total_ttc'=>"invoice_line",'fd.tva_tx'=>"invoice_line",'fd.qty'=>"invoice_line",'fd.date_start'=>"invoice_line",'fd.date_end'=>"invoice_line",'fd.fk_product'=>'product','p.ref'=>'product');
		// $this->export_dependencies_array[$r]=array('invoice_line'=>'fd.rowid','product'=>'fd.rowid');   // To add unique key if we ask a field of a child to avoid the DISTINCT to discard them
		// $this->export_sql_start[$r]='SELECT DISTINCT ';
		// $this->export_sql_end[$r]  =' FROM '.MAIN_DB_PREFIX.'myobject as t';
		// $this->export_sql_order[$r] .=' ORDER BY t.ref';
		// $r++;
		END MODULEBUILDER EXPORT MYOBJECT */

	}

	/**
	 *		Function called when module is enabled.
	 *		The init function add constants, boxes, permissions and menus (defined in constructor) into Dolibarr database.
	 *		It also creates data directories
	 *
     *      @param      string	$options    Options when enabling module ('', 'noboxes')
	 *      @return     int             	1 if OK, 0 if KO
	 */

	//guits todo cette fonction est a premiere vue propre a ATM, je peux peux être m'en passer
	 function init($options='')
	{
		$sql = array();
		
		define('INC_FROM_DOLIBARR',true);

		dol_include_once('/sorderplus/config.php');
		dol_include_once('/sorderplus/script/create-maj-base.php');

		$result=$this->_load_tables('/sorderplus/sql/');

		return $this->_init($sql, $options);
	}

	/**
	 * Function called when module is disabled.
	 * Remove from database constants, boxes and permissions from Dolibarr database.
	 * Data directories are not deleted
	 *
	 * @param      string	$options    Options when enabling module ('', 'noboxes')
	 * @return     int             	1 if OK, 0 if KO
	 */
	public function remove($options = '')
	{
		$sql = array();

		return $this->_remove($sql, $options);
	}

}