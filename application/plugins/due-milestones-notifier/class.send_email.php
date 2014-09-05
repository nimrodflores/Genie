<?php
class send_php_email {
	private $headers = false;	
	public $subject = false;
	public $body = false;
	public $from = false;
	public $to = false;
	public $cc = false;
	public $bcc = false;
	public $nl = "\r\n";

	/*
	 create headers for the email
	 */
	private function set_headers(){
		$this->headers  = 'From: ' . $this->from . $this->nl;
		
		if( $this->cc !== false )$this->headers .= 'CC: ' . $this->cc .  $this->nl;
		if( $this->bcc !== false )$this->headers .= 'BCC: ' . $this->cc .  $this->nl;
		
		$this->headers .= 'MIME-Version: 1.0' . $this->nl;
		$this->headers .= 'Content-Type: text/HTML; charset=ISO-8859-1' . $this->nl;
	}
	
	/*
	 create body template for the email.
	 */
	public function set_body($project_name,$display_name,$milestone_name,$description,$due_date,$milestone_id,$project_id){
		$mail_message =''.
'<html>
<style>
p{font-family:\'Arial, Helvetica, sans-serif\';font-size:12pt;margin:10px 0;}
p.fivepx{margin-top:5px;}
p.twentypx{margin-top:20px;}
.border{border-bottom:1px solid #DDDDDD;padding-bottom:10px;}
span{font-size:14pt;font-weight:bold;}
a{text-decoration:none;}
a.box{text-decoration:none;background-color:#DDDDDD;border:5px solid #DDDDDD;}
.margin{margin:30px 0;}
.gray{color:#666}
</style>

<p class=\'border\'>You have a project MILESTONE ';

$datetime1 = $due_date;
echo 'Due date is: ' . $datetime1 . '<br />';

$datetime2 = date("Y-m-d");
echo 'Date today is: ' . $datetime2. '<br />';

$diff = strtotime($datetime1) - strtotime($datetime2);
//$years = floor($diff / (365*60*60*24));
//$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
$days = floor($diff / (60*60*24));

echo 'Interval is: ' . $days . ' days<br />';

if ($days >= 1) {
	$mail_message .= 'due within ' . $days . ' day(s) ';
} else if ($days == 0) {
	$mail_message .= 'due today ';
} else if ($days < 0) {
	$mail_message .= abs($days) . ' day(s) overdue ';
}
$mail_message .= 'that is still open:</p>';

if($project_name){
	$mail_message .= '<p>Project: <span>'. $project_name. '</span></p>';
}

if($display_name){
	$mail_message .= '<p>Assigned to: <span>' . $display_name . '</span></p>';
}

if($milestone_name){
	$mail_message .= '<p>Milestone: <span>' . $milestone_name . '</span></p>';
}

if($description){
	$mail_message .= '<p>Description: <span>' . $description . '</span></p>';
}

$mail_message .= '<p class=\'border\'>Due Date: <span>' . str_replace("00:00:00", "", $due_date) . '</span></p>
<p class="twentypx"><a class=\'box\' href="' . URL . '/index.php?c=milestone&a=complete&id=' . $milestone_id . '&active_project=' . $project_id . '">Click to mark this milestone as completed</a> (you must login first)</p>

<p class=\'fivepx\'><a class=\'box\' href=\'' . URL . '/index.php?c=milestone&a=view&id=' . $milestone_id . '&active_project=' . $project_id . '\'>View this milestone</a></p>
<p class="margin"><a class="gray" href=\'' . URL . '\'>' . URL . '</a></p>
<p class="margin gray">Date Sent: ' . date('l, F d, Y - H:i') . '</p>
</html>';

		$this->body = $mail_message;

	}
/*
	public function set_body($fields, $template){
		ob_start();
		require 'templates/' . $template . '.php';
		$mail_message = ob_get_contents();
		ob_end_clean();

		$this->body = $mail_message;
	}
*/


	/*
	 email Functionality to submit and reuse
	 */
	public function send_email() {
		$this->set_headers();
		$status = mail($this->to, $this->subject, $this->body, $this->headers);

		if( $status )return true;
		else return false;
	}
	
	public function print_email_contents() {
		echo 'To: ' . $this->to . '<br />';
		echo 'Headers: ' . $this->headers . '<br />';
		echo 'Subject: ' . $this->subject . '<br />';
		echo 'Body: ' . $this->body . '<br /><br /><hr><br />';

		$status = true;
		
		if ($status == true ){
			return true;
		} else {
			return false;
		}
	}
	
	
}

