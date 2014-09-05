<?php 

  // Set page title and set crumbs to index
  set_page_title('Peace Of Mind, LLC - Links');
  dashboard_tabbed_navigation(DASHBOARD_TAB_POM_LINKS);
  dashboard_crumbs('Peace Of Mind, LLC Links');
  
//  if (Project::canAdd(logged_user())) {
//    add_page_action(lang('add project'), get_url('project', 'add'));
//  } // if
  
  add_stylesheet_to_page('dashboard/my_tasks.css');

?>
<div id="myTasks">
  <div class="block">
    <div class="header"><h2><a href="http://mydebtrelease.com" target="_blank">MyDebtRelease.com</a></h2></div>
  </div>
  <div class="block">
    <div class="header"><h2><a href="http://clientvideos.mydebtrelease.com/" target="_blank">Client Videos</a></h2></div>
  </div>
  <div class="block">
    <div class="header"><h2><a href="http://passiveincomexpert.com" target="_blank">Cashflow Opportunity</a></h2></div>
  </div>
  <div class="block">
    <div class="header"><h2><a href="http://mydebtrelease.com/affiliates" target="_blank">Affiliate Signup</a></h2></div>
  </div>
  <div class="block">
    <div class="header"><h2><a href="http://salesforce.mydebtrelease.com/" target="_blank">Peace of Mind CRM</a></h2></div>
  </div>
</div><!-- end #myTasks -->