------------------------------------------------------------
<?php echo lang('do not reply warning')."\n"; ?>
------------------------------------------------------------

<?php echo lang('new message posted', $new_message->getTitle(), $new_message->getProject()->getName()) ?>. 

<?php
/* Send the message body unless the configuration file specifically says not to:
** to prevent sending the body of email messages add the following to config.php
** For config.php:  define('SHOW_MESSAGE_BODY', false);
*/
if ((!defined('SHOW_MESSAGE_BODY')) or (SHOW_MESSAGE_BODY == true)) {
  echo "\n----------------\n";
  echo $new_message->getText() . "\n\n";
  echo $new_message->getCreatedBySignature()."\n";
  echo "\n\n----------------\n\n";
}
?>

<?php echo lang('view new message') ?>:

- <?php echo str_replace('&amp;', '&', externalUrl($new_message->getViewUrl())) . "\n\n"; ?> 

<?php echo lang('company') ?>: <?php echo owner_company()->getName() . "\n"; ?> 
<?php echo lang('project') ?>: <?php echo $new_message->getProject()->getName() . "\n"; ?> 
<?php echo lang('author') ?>: <?php echo $new_message->getCreatedByDisplayName() . "\n"; ?> 

--
<?php echo externalUrl(ROOT_URL) ?>