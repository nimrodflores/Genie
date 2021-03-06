------------------------------------------------------------
 <?php echo lang('do not reply warning')."\n"; ?>
------------------------------------------------------------

<?php echo lang('new task posted', $new_task->getObjectName(), $new_task->getProject()->getName()) ?>. 

<?php
/* Send the message body unless the configuration file specifically says not to:
** to prevent sending the body of email messages add the following to config.php
** For config.php:  define('SHOW_MESSAGE_BODY', false);
*/
if ((!defined('SHOW_MESSAGE_BODY')) or (SHOW_MESSAGE_BODY == true)) {
  echo "\n----------------\n\n";
  echo $new_task->getText() . "\n\n";
  echo $new_task->getCreatedBySignature()."\n";
  echo "\n\n----------------\n\n";
}
?>

<?php echo lang('view new task') ?>:

- <?php echo str_replace('&amp;', '&', externalUrl($new_task->getViewUrl())) . "\n\n"; ?> 

<?php echo lang('company') ?>: <?php echo owner_company()->getName() . "\n"; ?> 
<?php echo lang('project') ?>: <?php echo $new_task->getProject()->getName() . "\n"; ?> 
<?php echo lang('author') ?>: <?php echo $new_task->getCreatedByDisplayName() . "\n"; ?> 

--
<?php echo externalUrl(ROOT_URL) ?>