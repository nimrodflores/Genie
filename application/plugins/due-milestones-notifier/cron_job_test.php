<?php


  require_once ('../../../config/config.php'); //main config file of projectpier

  define('LOG_ERRORS', true); //set to false if you do not have direct access to a command line shell from php such as large shared environments

  define('URL', 'http://yourgenieinabottle.com'); //full url of project website

  define('ADMIN_EMAIL', 'zen@mydebtrelease.com'); //admin or from email 

  define('DAYS', 5); //days to notify of upcomming tasks

	

	require dirname(__FILE__) . '/class.send_email.php';

	$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die (mysql_error()); //change this to match your server

	$db = mysql_select_db(DB_NAME, $link);

	

	//helper function

	function getQuery($query, $n = false){

		$r = mysql_query($query) or error_log("MYSQL Error! - " . $query . " - " . mysql_error(), 0);

		if( is_bool($r) || mysql_num_rows($r) < 1 )return false;

		if( $n == true )$data = mysql_fetch_assoc($r);

		else $data = $r;

		return $data;

	}



##################################################################

############### GET CURRENT MILESTONES DUE #######################

##################################################################



	//gets current tasks, task list names and id - could also get project name here too if we want

	$query = "SELECT * FROM `pp_project_milestones`" . 

				"WHERE due_date < ADDDATE(CURDATE(), " . DAYS . ") AND completed_by_id = 0 " . "AND assigned_to_user_id = 39 " . //and completed_by_id = 0 

				"ORDER by assigned_to_user_id, due_date";



	$data = getQuery($query);

	

	$item_no = 1;
	while( $values = mysql_fetch_assoc($data) ){		

		echo 'Item no: ' . $item_no .'<br />';
		$item_no++;
		
		$milestone_id = $values['id'];
		echo 'Milestone ID: ' . $milestone_id . '<br />';

		$milestone_name = $values['name'];
		echo 'Milestone name: ' . $milestone_name . '<br />';

		$description = $values['description'];
		echo 'Milestone description: ' . $description . '<br />';

		$assigned_user = $values['assigned_to_user_id'];

		if ($assigned_user == 0) {
			$assigned_user = 'No user assigned';
		}
		echo 'Assigned to user id: ' . $assigned_user . '<br />';

		$project_id = $values['project_id'];
		echo 'Project ID: ' .$project_id . '<br />';

		$due_date = $values['due_date'];
		$due_date = str_replace("00:00:00", "", $due_date );
		echo 'Due date: ' . $due_date . '<br />';

		$user = getQuery("SELECT `email`, `username` FROM `pp_users` WHERE `id` = '" . $assigned_user . "'");
		$userdata = mysql_fetch_assoc($user);

		if (!$userdata) {
			$user_email = ADMIN_EMAIL;
			$display_name = 'No user assigned';
		} else {
			$user_email = $userdata['email'];
			$display_name = $userdata['username'];
		}
		echo 'User email: ' .  $user_email . '<br />';
		echo 'Display Name: ' . $display_name . '<br />';

		$project = getQuery("SELECT `name` FROM `pp_projects` WHERE id = '" . $project_id . "'");
		$project_r = mysql_fetch_assoc($project);
		$project_name = $project_r['name'];
		echo 'Project Name: ' . $project_name . '<br />*************************************************************<br />';

		

/*

		//need to uniform the variables passed to the set_body function to inject into templates
		$template_fields = array_merge($project_name, $display_name, $user_email, $values);

*/

		
		$email = new send_php_email();

		$email->to = $user_email;

		$email->from = 'Genie System Notifier <notifier@yourgenieinabottle.com>';

		$email->subject = 'Peace of Mind, LLC MILESTONE - Due Date: ' . $due_date . ' - ' . $display_name;

		$email->set_body($project_name,$display_name,$milestone_name,$description,$due_date,$milestone_id,$project_id);

		$sent = $email->send_email();

		if ($sent) {

			echo 'Notification sent to: ' . $user_email . ' for Milestone ID ' . $milestone_id . ' - ' . $milestone_name . '<br /><hr><br /><br />';

		} else {

			echo 'Notification failed for: ' . $user_email . ' for Milestone ID ' . $milestone_id . ' - ' . $milestone_name . '<br /><hr><br /><br />';

		}

		

//		$sent = $email->print_email_contents();



		if($sent == false && LOG_ERRORS)file_put_contents( dirname(__FILE__) . '/project_email_errors.log', "Email failed to " . $user['email'] . " : " . $user['email'] . " - Task ID=" . $values['id'], FILE_APPEND );
		
		

	}



