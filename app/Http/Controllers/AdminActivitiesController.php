<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminActivitiesController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "name";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = true;
			$this->button_export = true;
			$this->table = "activities";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Event","name"=>"event_id","join"=>"events,name"];
			$this->col[] = ["label"=>"Name","name"=>"name"];
			$this->col[] = ["label"=>"Image Path","name"=>"image_path","image"=>true];
			$this->col[] = ["label"=>"Activity Type","name"=>"activity_type_id","join"=>"activity_types,name"];
			$this->col[] = ["label"=>"Department","name"=>"(SELECT GROUP_CONCAT(departments.name) from activity_departments, departments WHERE activity_departments.departments_id = departments.id AND activity_departments.activities_id = activities.id  GROUP BY activities_id) as department"];
			$this->col[] = ["label"=>"Datashow","name"=>"datashow","callback_php"=>'$row->datashow == "1" ? "<span class=\"badge label-success\">Sim</span>" : "<span class=\"badge label-danger\">Não</span>"'];
			$this->col[] = ["label"=>"Laboratory","name"=>"laboratory","callback_php"=>'$row->laboratory == "1" ? "<span class=\"badge label-success\">Sim</span>" : "<span class=\"badge label-danger\">Não</span>"'];
			$this->col[] = ["label"=>"Show","name"=>"show","callback_php"=>'$row->show == "1" ? "<span class=\"badge label-success\">Sim</span>" : "<span class=\"badge label-danger\">Não</span>"'];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Event','name'=>'event_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'events,name','datatable_where'=>'events.show = 1 AND events.end > CURDATE()'];
			$this->form[] = ['label'=>'Name','name'=>'name','type'=>'text','validation'=>'required|string|min:3|max:255','width'=>'col-sm-10','placeholder'=>'Nome da Atividade'];
			$this->form[] = ['label'=>'Description','name'=>'description','type'=>'textarea','validation'=>'max:500','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Presenters','name'=>'presenters','type'=>'select2','width'=>'col-sm-10','datatable'=>'presenters,name','datatable_where'=>'presenters.show = 1', 'relationship_table'=> 'activity_presenters']; 
			$this->form[] = ['label'=>'Image Path','name'=>'image_path','type'=>'upload','validation'=>'max:200','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Activity Type','name'=>'activity_type_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'activity_types,name','datatable_where'=>'activity_types.show = 1'];
			$this->form[] = ['label'=>'Department','name'=>'department','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'departments,name','datatable_where'=>'departments.show = 1', 'relationship_table'=> 'activity_departments'];
			$this->form[] = ['label'=>'Managers','name'=>'managers','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'cms_users,name','datatable_where'=>'cms_users.id_cms_privileges in (2,3)', 'relationship_table'=> 'activity_managers']; //professor ou coordenador
						
			
			$child = [];
			$child[] = ['label'=>'Date','name'=>'date','type'=>'date','required'=>true,'width'=>'col-sm-12'];
			$child[] = ['label'=>'Start','name'=>'start','type'=>'time','required'=>true,'width'=>'col-sm-12'];
			$child[] = ['label'=>'End','name'=>'end','type'=>'time','required'=>true,'width'=>'col-sm-12'];
			$child[] = ['label'=>'Online','name'=>'online','type'=>'radio','required'=>true,'width'=>'col-sm-12','dataenum'=>'0|Não;1|Sim'];
			$child[] = ['label'=>'Link','name'=>'link','type'=>'text','min'=>'10', 'max'=>'100','width'=>'col-sm-12'];
			$child[] = ['label'=>'Room','name'=>'room_id','type'=>'datamodal','width'=>'col-sm-12','datamodal_table'=>'view_rooms','datamodal_columns'=>'room,building,place', 'datamodal_columns_alias'=> 'Room,Building,Place','datamodal_select_to'=>'id','datamodal_where'=>'view_rooms.show = 1','datamodal_size'=>'large'];
			
			$this->form[] = ['label'=>'Dates','name'=>'dates','type'=>'child','width'=>'col-sm-12','columns'=>$child,'table'=>'dates','foreign_key'=>'activity_id'];
			
			$this->form[] = ['label'=>'Certificate Template','name'=>'certificate_template_id','type'=>'datamodal','width'=>'col-sm-10','datamodal_table'=>'certificate_templates','datamodal_columns'=>'image_path,name','datamodal_size'=>'large','datamodal_where'=>'certificate_templates.show = 1','datamodal_columns_alias'=>'Image Path,Name'];
			$this->form[] = ['label'=>'Datashow','name'=>'datashow','type'=>'radio','validation'=>'required','width'=>'col-sm-10','dataenum'=>'0|No;1|Yes','help'=>'É necessário datashow para atividade?'];
			$this->form[] = ['label'=>'Laboratory','name'=>'laboratory','type'=>'radio','validation'=>'required','width'=>'col-sm-10','dataenum'=>'0|No;1|Yes','help'=>'Atividade precisa ser em laboratório?'];
			$this->form[] = ['label'=>'Extra Info','name'=>'extra_infos','type'=>'select2','width'=>'col-sm-10','datatable'=>'extra_info,name','datatable_where'=>'extra_info.show = 1', 'relationship_table'=> 'activity_extra_info','help'=>'Informações extra que deseja que os participantes respondam'];
			$this->form[] = ['label'=>'Obs','name'=>'obs','type'=>'text','validation'=>'max:200','width'=>'col-sm-10','placeholder'=>'Para outras informações e necessidades pertinentes'];
			$this->form[] = ['label'=>'Monitors','name'=>'monitors','type'=>'select2','width'=>'col-sm-10','datatable'=>'cms_users,name', 'relationship_table'=> 'activity_monitors'];
			$this->form[] = ['label'=>'Cms User Id','name'=>'cms_user_id','type'=>'hidden','validation'=>'required|integer|min:0','width'=>'col-sm-10','value' => CRUDBooster::myId()];
			$this->form[] = ['label'=>'Show','name'=>'show','type'=>'radio','validation'=>'required','width'=>'col-sm-10','dataenum'=>'0|No;1|Yes','help'=>'Exibir opção nos formulários gerais'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Event','name'=>'event_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'events,name','datatable_where'=>'events.show = 1 AND events.end > CURDATE()'];
			//$this->form[] = ['label'=>'Name','name'=>'name','type'=>'text','validation'=>'required|string|min:3|max:255','width'=>'col-sm-10','placeholder'=>'Nome da Atividade'];
			//$this->form[] = ['label'=>'Description','name'=>'description','type'=>'textarea','validation'=>'max:500','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Image Path','name'=>'image_path','type'=>'upload','validation'=>'max:200','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Activity Type','name'=>'activity_type_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'activity_types,name','datatable_where'=>'activity_types.show = 1'];
			//$this->form[] = ['label'=>'Activity Mode','name'=>'activity_mode_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'activity_modes,name','datatable_where'=>'activity_modes.show = 1'];
			//$this->form[] = ['label'=>'Certificate Template','name'=>'certificate_template_id','type'=>'datamodal','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Datashow','name'=>'datashow','type'=>'radio','validation'=>'required','width'=>'col-sm-10','dataenum'=>'0|No;1|Yes','help'=>'É necessário datashow para atividade?'];
			//$this->form[] = ['label'=>'Laboratory','name'=>'laboratory','type'=>'radio','validation'=>'required','width'=>'col-sm-10','dataenum'=>'0|No;1|Yes','help'=>'Atividade precisa ser em laboratório?'];
			//$this->form[] = ['label'=>'Obs','name'=>'obs','type'=>'text','validation'=>'max:200','width'=>'col-sm-10','placeholder'=>'Para outras informações e necessidades pertinentes'];
			//$this->form[] = ['label'=>'Cms User Id','name'=>'cms_user_id','type'=>'hidden','validation'=>'required|integer|min:0','width'=>'col-sm-10','value' => CRUDBooster::myId()];
			//$this->form[] = ['label'=>'Show','name'=>'show','type'=>'radio','validation'=>'required','width'=>'col-sm-10','dataenum'=>'0|No;1|Yes','help'=>'Exibir opção nos formulários gerais'];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
			$this->sub_module = array();
			$this->sub_module[] = ['label'=>'Tickets','path'=>'tickets','parent_columns'=>'name,description','foreign_key'=>'activity_id','button_color'=>'primary','button_icon'=>'fa fa-ticket'];
			


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();

	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();
	                

	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();



	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;


            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        $this->load_js[] = asset("/../vendor/crudbooster/assets/js/form_activities.js");
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        
	        
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	            
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }



	    //By the way, you can still create your own method in here... :) 


	}