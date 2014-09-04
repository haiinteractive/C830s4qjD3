<?php 
$config['menus'] = array(    
                'Home'              => array('permission'=>'','url'=>base_url().'index.php?/home/','backimage'=> base_url().'files/bugmaster/img/home.png','dash_image'=>''),
                'View Tickets'      => array('permission'=>'view_ticket','url'=>base_url().'index.php?/ticket/viewticket/','backimage'=>base_url().'files/bugmaster/img/bugg.png','dash_image'=>base_url().'files/bugmaster/img/bug00.png'),
                'New Ticket'        => array('permission'=>'new_ticket','url'=>base_url().'index.php?/ticket/newticket/','backimage'=>base_url().'files/bugmaster/img/addnew.png','dash_image'=>base_url().'files/bugmaster/img/document-new.png'),
                'Time Line'        => array('permission'=>'milestones','url'=>base_url().'index.php?/ticket/milestones/','backimage'=>base_url().'files/bugmaster/img/milestone.png','dash_image'=>base_url().'files/bugmaster/img/Time.png'),
                'Manage Staff'      => array('permission'=>'admin','url'=>base_url().'index.php?/admins/','backimage'=>base_url().'files/bugmaster/img/admin.png','dash_image'=>base_url().'files/bugmaster/img/people.png'),                 
                'Manage Products'   => array('permission'=>'products','url'=>base_url().'index.php?/ticket/products/','backimage'=>base_url().'files/bugmaster/img/product.png','dash_image'=>base_url().'files/bugmaster/img/prod.png'),
                'Manage Branch'     => array('permission'=>'products_branch','url'=>base_url().'index.php?/ticket/branch/','backimage'=>base_url().'files/bugmaster/img/branch.png','dash_image'=>base_url().'files/bugmaster/img/binary-tree.png'),                
                'Site Settings'     => array('permission'=>'site_settings','url'=>base_url().'index.php?/admins/site_settings/','backimage'=>base_url().'files/bugmaster/img/settings.png','dash_image'=>base_url().'files/bugmaster/img/gear_48.png'),               
                'Change Password'   => array('permission'=>'','url'=>base_url().'index.php?/account/updatepassword/','backimage'=>base_url().'files/bugmaster/img/password.png'),
                'Reports'           => array('permission'=>'graph','url'=>base_url().'index.php?/admins/graph/','backimage'=>base_url().'files/bugmaster/img/graph.png','dash_image'=>base_url().'files/bugmaster/img/column_chart.png'),
                'Messages'          => array('permission'=>'messages','url'=>base_url().'index.php?/message/index/','backimage'=>base_url().'files/bugmaster/img/email.png','dash_image'=>base_url().'files/bugmaster/img/message3.png'),
                'Logout'            => array('permission'=>'','url'=>base_url().'index.php?/account/logout/','backimage'=>base_url().'files/bugmaster/img/signout.png'),
		); 

$config['admins_privilage_name']	    = 'admin'; 
$config['newticket_privilage_name']         = 'new_ticket';
$config['milestones_privilage_name']	    = 'milestones';
$config['products_privilage_name']	    = 'products';
$config['pbranch_privilage_name']	    = 'products_branch';
$config['sitesettings_privilage_name']	    = 'site_settings';
$config['viewticket_privilage_name']	    = 'view_ticket';
$config['graph_privilage_name']	            = 'graph';
$config['myticket_privilage_name']	    = 'my_ticket';
$config['userticket_privilage_name']	    = 'user_ticket';
$config['userticket_privilage_name']	    = 'user_ticket';
$config['messages_privilage_name']	    = 'messages';


 