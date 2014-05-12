<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Teacher extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}

	public function teacher_output($output = null)
	{
		$this->load->view('view_template.php',$output);
	}
	public function index()
	{
		//$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output();
	}

	/*
	<a href='<?php echo site_url('teacher/student_management')?>'>学生管理</a> | 
        <a href='<?php echo site_url('teacher/activity_management')?>'>课程管理</a> |
        <a href='<?php echo site_url('teacher/lesson_management')?>'>期次管理</a> |
        <a href='<?php echo site_url('teacher/news_management')?>'>通知管理</a> |
        <a href='<?php echo site_url('teacher/comments_management')?>'>留言管理</a> | 
        <a href='<?php echo site_url('teacher/lesorder_management')?>'>选课管理</a>
	*/
	public function student_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('student_table');
			
			//table header.
			$crud->display_as('stuid','学号[stuid]');
			$crud->display_as('stupass','密码[stupass]');
			$crud->display_as('stuname','姓名[stuname]');
			$crud->display_as('year','年级[year]');
			$crud->display_as('photo','头像[photo]');
			
			//required field.
			$crud->required_fields('stuid','stupass','stuname','year','photo');
			
			//column callback
			$crud->callback_add_field('photo',array($this,'stuPhotoAddCallback'));
			
			
			$output = $crud->render();
			$this->teacher_output($output);
		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	function stuPhotoAddCallback()
	{
		return "<input type='text' name='photo' value='http://www.gradunion.cn/photos/student.png' >";
	}
	
	
	public function activity_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('activity_table');
			
			//table header.
			$crud->display_as('title','标题[title]');
			$crud->display_as('desc','详细信息[desc]');
			$crud->display_as('utime','更新时间[utime]');
			$crud->display_as('state','状态[state]');
			
			//required field.
			$crud->required_fields('title','desc','utime','state');
			
			//column callback
			$crud->callback_add_field('state',array($this,'actStateAddCallback'));
			$crud->callback_edit_field('state',array($this,'actStateEditCallback'));
			$crud->callback_add_field('desc',array($this,'actDescAddCallback'));
			$crud->callback_edit_field('desc',array($this,'actDescEditCallback'));
			$crud->callback_add_field('utime',array($this,'actUtimeAddCallback'));
			$crud->callback_edit_field('utime',array($this,'actUtimeEditCallback'));
			
			
			$output = $crud->render();
			$this->teacher_output($output);
		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	function actStateAddCallback()
	{
		return "<select name='state'><option value='1'>开放</option><option value='0'>关闭</option></select>";
	}
	function actStateEditCallback($value, $primary_key)
	{
		if( $value==1 )
			return "<select name='state'><option value='1' selected='selected'>开放</option><option value='0'>关闭</option></select>";
		else
			return "<select name='state'><option value='1'>开放</option><option value='0' selected='selected'>关闭</option></select>";
	}
	function actDescAddCallback()
	{
		return "<textarea rows='5' cols='20' name='desc'>详细信息如时间、地点、年级等.</textarea>";
	}
	function actDescEditCallback($value, $primary_key)
	{
		return "<textarea rows='5' cols='20' name='desc'>".$value."</textarea>";
	}
	function actUtimeAddCallback()
	{
		return "<input type='text' name='utime' value='".time()."' >此项为更新时间，请使用自动生成数据，不要修改。";
	}
	function actUtimeEditCallback($value, $primary_key)
	{
		return "<input type='text' name='utime' value='".time()."' >此项为更新时间，请使用自动生成数据，不要修改。";
	}
	
	
	public function lesson_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('lesson_table');
			
			//relations with other tables.
			$crud->set_relation('actserial','activity_table','title');
			
			
			//table header.
			$crud->display_as('actserial','课程分类[actserial]');
			$crud->display_as('title','标题[title]');
			$crud->display_as('desc','详细信息[desc]');
			$crud->display_as('utime','更新时间[utime]');
			$crud->display_as('state','状态[state]');
			$crud->display_as('maxnum','最大人数[maxnum]');
			
			//required field.
			$crud->required_fields('actserial','title','desc','utime','state','maxnum');
			
			//column callback
			$crud->callback_add_field('state',array($this,'actStateAddCallback'));
			$crud->callback_edit_field('state',array($this,'actStateEditCallback'));
			$crud->callback_add_field('desc',array($this,'actDescAddCallback'));
			$crud->callback_edit_field('desc',array($this,'actDescEditCallback'));
			$crud->callback_add_field('utime',array($this,'actUtimeAddCallback'));
			$crud->callback_edit_field('utime',array($this,'actUtimeEditCallback'));
			
			
			$output = $crud->render();
			$this->teacher_output($output);
		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	public function news_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('news_table');
			
			//relations with other tables.
			$crud->set_relation('byadminserial','admin_table','adminname');
			
			//table header.
			$crud->display_as('byadminserial','管理员[byadminserial]');
			$crud->display_as('message','通知[message]');
			$crud->display_as('utime','更新时间[utime]');
			$crud->display_as('ontop','置顶[ontop]');
			
			//required field.
			$crud->required_fields('byadminserial','message','utime');
			
			//column callback
			$crud->callback_add_field('ontop',array($this,'newsOntopAddCallback'));
			$crud->callback_edit_field('ontop',array($this,'newsOntopEditCallback'));
			$crud->callback_add_field('message',array($this,'newsMessageAddCallback'));
			$crud->callback_edit_field('message',array($this,'newsMessageEditCallback'));
			$crud->callback_add_field('utime',array($this,'actUtimeAddCallback'));
			$crud->callback_edit_field('utime',array($this,'actUtimeEditCallback'));
			$crud->callback_before_insert(array($this,'checking_ontop_code'));
			$crud->callback_before_update(array($this,'checking_ontop_code'));
			
			
			$output = $crud->render();
			$this->teacher_output($output);
		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	function newsOntopAddCallback()
	{
		return "<input type='checkbox' name='ontop' value='1'>";
	}
	function newsOntopEditCallback($value, $primary_key)
	{
		if( $value==1 )
			return "<input type='checkbox' name='ontop' checked='checked' value='1' >";
		else
			return "<input type='checkbox' name='ontop' value='1' >";
	}
	function newsMessageAddCallback()
	{
		return "<textarea rows='5' cols='20' name='message'>详细信息.</textarea>";
	}
	function newsMessageEditCallback($value, $primary_key)
	{
		return "<textarea rows='5' cols='20' name='message'>".$value."</textarea>";
	}
	function checking_ontop_code($post_array)
	{
		if(empty($post_array['ontop']))
		{
			$post_array['ontop'] = 0;
		}
		return $post_array;
	}
	
	
	public function comments_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('comments_table');
			
			//relations with other tables.
			$crud->set_relation('bystuserial','student_table','stuname');
			
			//table header.
			$crud->display_as('bystuserial','学生学号[bystuserial]');
			$crud->display_as('message','评论[message]');
			$crud->display_as('utime','更新时间[utime]');
			$crud->display_as('replyserial','回复的评论序号[replyserial]');
			
			//required field.
			$crud->required_fields('bystuserial','message','utime');
			
			//column callback
			$crud->callback_add_field('message',array($this,'newsMessageAddCallback'));
			$crud->callback_edit_field('message',array($this,'newsMessageEditCallback'));
			$crud->callback_add_field('utime',array($this,'actUtimeAddCallback'));
			$crud->callback_edit_field('utime',array($this,'actUtimeEditCallback'));
			
			$output = $crud->render();
			$this->teacher_output($output);
		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	public function c2_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('c2_table');
			
			//relations with other tables.
			$crud->set_relation('stuserial','student_table','stuname');
			
			//table header.
			$crud->display_as('replyserial','回复的评论序号[replyserial]');
			$crud->display_as('stuserial','学生学号[stuserial]');
			$crud->display_as('message','评论[message]');
			$crud->display_as('utime','更新时间[utime]');
			
			
			//required field.
			$crud->required_fields('replyserial','stuserial','message','utime');
			
			//column callback
			$crud->callback_add_field('message',array($this,'newsMessageAddCallback'));
			$crud->callback_edit_field('message',array($this,'newsMessageEditCallback'));
			$crud->callback_add_field('utime',array($this,'actUtimeAddCallback'));
			$crud->callback_edit_field('utime',array($this,'actUtimeEditCallback'));
			
			$output = $crud->render();
			$this->teacher_output($output);
		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	public function lesorder_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('lesorder_table');
			
			//relations with other tables.
			$crud->set_relation('lesserial','lesson_table','title');
			$crud->set_relation('stuserial','student_table','stuname');
			
			//table header.
			$crud->display_as('lesserial','课程期次[lesserial]');
			$crud->display_as('stuserial','学生学号[stuserial]');
			$crud->display_as('utime','更新时间[utime]');
			
			//required field.
			$crud->required_fields('lesserial','stuserial','utime');
			
			//column callback
			$crud->callback_add_field('utime',array($this,'actUtimeAddCallback'));
			$crud->callback_edit_field('utime',array($this,'actUtimeEditCallback'));
			
						
			$output = $crud->render();
			$this->teacher_output($output);
		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	public function admin_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('admin_table');
			
			//relations with other tables.
			
			//table header.
			$crud->display_as('adminid','管理员账号');
			$crud->display_as('adminpass','管理员密码');
			$crud->display_as('adminname','管理员名称');
			$crud->display_as('photo','头像');
				
			//required field.
			$crud->required_fields('adminid','adminpass','adminname','photo');
			
			//column callback
			$crud->callback_add_field('photo',array($this,'adminPhotoAddCallback'));
			
			
			$output = $crud->render();
			$this->teacher_output($output);
		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	function adminPhotoAddCallback()
	{
		return "<input type='text' name='photo' value='http://www.gradunion.cn/photos/teacher.png' >";
	}
	public function stufile_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('stufile_table');
			
			//relations with other tables.
			$crud->set_relation('stuserial','student_table','stuname');
			
			//table header.
			$crud->display_as('url','文件路径[url]');
			$crud->display_as('stuserial','学生学号[stuserial]');
			$crud->display_as('utime','更新时间[utime]');
			
			//required field.
			$crud->required_fields('url','stuserial','utime','title');
			
			//column callback
			$crud->callback_add_field('utime',array($this,'actUtimeAddCallback'));
			$crud->callback_edit_field('utime',array($this,'actUtimeEditCallback'));
			
						
			$output = $crud->render();
			$this->teacher_output($output);
		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}





	
	
	





	public function offices()
	{
		$output = $this->grocery_crud->render();

		$this->_example_output($output);
	}

	/*
	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}
	*/

	public function offices_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('offices');
			$crud->set_subject('Office');
			$crud->required_fields('city');
			$crud->columns('city','country','phone','addressLine1','postalCode');

			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	public function employees_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('employees');
			$crud->set_relation('officeCode','offices','city');
			$crud->display_as('officeCode','Office City');
			$crud->set_subject('Employee');

			$crud->required_fields('lastName');

			$crud->set_field_upload('file_url','assets/uploads/files');

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function customers_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('customers');
			$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
			$crud->display_as('salesRepEmployeeNumber','from Employeer')
				 ->display_as('customerName','Name')
				 ->display_as('contactLastName','Last Name');
			$crud->set_subject('Customer');
			$crud->set_relation('salesRepEmployeeNumber','employees','lastName');

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function orders_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_relation('customerNumber','customers','{contactLastName} {contactFirstName}');
			$crud->display_as('customerNumber','Customer');
			$crud->set_table('orders');
			$crud->set_subject('Order');
			$crud->unset_add();
			$crud->unset_delete();

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function products_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('products');
			$crud->set_subject('Product');
			$crud->unset_columns('productDescription');
			$crud->callback_column('buyPrice',array($this,'valueToEuro'));

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function valueToEuro($value, $row)
	{
		return $value.' &euro;';
	}

	public function film_management()
	{
		$crud = new grocery_CRUD();

		$crud->set_table('film');
		$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
		$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
		$crud->unset_columns('special_features','description','actors');

		$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');

		$output = $crud->render();

		$this->_example_output($output);
	}

	public function film_management_twitter_bootstrap()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('twitter-bootstrap');
			$crud->set_table('film');
			$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
			$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
			$crud->unset_columns('special_features','description','actors');

			$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');

			$output = $crud->render();
			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	function multigrids()
	{
		$this->config->load('grocery_crud');
		$this->config->set_item('grocery_crud_dialog_forms',true);
		$this->config->set_item('grocery_crud_default_per_page',10);

		$output1 = $this->offices_management2();

		$output2 = $this->employees_management2();

		$output3 = $this->customers_management2();

		$js_files = $output1->js_files + $output2->js_files + $output3->js_files;
		$css_files = $output1->css_files + $output2->css_files + $output3->css_files;
		$output = "<h1>List 1</h1>".$output1->output."<h1>List 2</h1>".$output2->output."<h1>List 3</h1>".$output3->output;

		$this->_example_output((object)array(
				'js_files' => $js_files,
				'css_files' => $css_files,
				'output'	=> $output
		));
	}

	public function offices_management2()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('offices');
		$crud->set_subject('Office');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

	public function employees_management2()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('employees');
		$crud->set_relation('officeCode','offices','city');
		$crud->display_as('officeCode','Office City');
		$crud->set_subject('Employee');

		$crud->required_fields('lastName');

		$crud->set_field_upload('file_url','assets/uploads/files');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

	public function customers_management2()
	{

		$crud = new grocery_CRUD();

		$crud->set_table('customers');
		$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
		$crud->display_as('salesRepEmployeeNumber','from Employeer')
			 ->display_as('customerName','Name')
			 ->display_as('contactLastName','Last Name');
		$crud->set_subject('Customer');
		$crud->set_relation('salesRepEmployeeNumber','employees','lastName');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

}