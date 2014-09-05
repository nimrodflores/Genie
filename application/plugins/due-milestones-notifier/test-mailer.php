<?php

require dirname(__FILE__) . '/class.send_email.php';

define('ADMIN_EMAIL', 'zen@mydebtrelease.com'); //admin or from email
define('URL', 'http://yourgenieinabottle.com'); //full url of project website  

$to = 'nimrodlflores@yahoo.com, nimrodlflores@gmail.com';
$subject = 'Tester email from genie server';
$message = 'Tester email from genie server to see if server can sen PHP mail';

$user_email = 'nimrodlflores@gmail.com';
$due_date = '2013-04-01';
$display_name = 'Nimrod Tester';
$project_name = 'Sample Project';
$milestone_name = 'Sample Milestone';
$description = 'Sample Milestone description';
$milestone_id = '1234';
$project_id = '4567';

		$email = new send_php_email();
		$email->to = $user_email;
		$email->from = 'notifier@yourgenieinabottle.com';
		$email->subject = 'Peace of Mind, LLC MILESTONE - Due Date: ' . $due_date . ' - ' . $display_name;
		$email->set_body($project_name,$display_name,$milestone_name,$description,$due_date,$milestone_id,$project_id);
		$sent = $email->send_email();
		if ($sent) {
			echo 'Notification sent to: ' . $user_email . ' for Milestone ID ' . $milestone_id . ' - ' . $milestone_name . '<br /><hr><br /><br />';
		} else {
			echo 'Notification failed for: ' . $user_email . ' for Milestone ID ' . $milestone_id . ' - ' . $milestone_name . '<br /><hr><br /><br />';
		}
		
?>