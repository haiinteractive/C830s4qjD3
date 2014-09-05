<?php /* Smarty version 2.6.25, created on 2014-09-05 19:33:04
         compiled from site/en/layout/header.html */ ?>

    <?php if ($this->_tpl_vars['sess']['user_id'] == ''): ?>
        <!DOCTYPE html>
        <html lang="en" class=" ">
        <head>
            <meta charset="utf-8" />
            <title>Media Sales Tracker | Explocity</title>
            <meta name="description"    content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
            <meta name="viewport"   content="width=device-width, initial-scale=1, maximum-scale=1" />
            <link rel="stylesheet" href="<?php echo $this->_tpl_vars['static_server']; ?>
assets/css/app.v1.css" type="text/css" />
            <link rel="stylesheet" href="<?php echo $this->_tpl_vars['static_server']; ?>
assets/css/validation.css" type="text/css" />
        </head>
     <?php else: ?>
        <!DOCTYPE html><html lang="en" class="app">
        <head>
        <meta charset="utf-8"/>
        <title>Media Sales Tracker | Explocity</title>
        <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <link rel="stylesheet" href="<?php echo $this->_tpl_vars['static_server']; ?>
assets/css/app.v1.css" type="text/css"/>
        <link rel="stylesheet" href="<?php echo $this->_tpl_vars['static_server']; ?>
assets/js/calendar/bootstrap_calendar.css" type="text/css"/>
      <link rel="stylesheet" type="text/css" media="all" href="<?php echo $this->_tpl_vars['static_server']; ?>
assets/css/daterangepicker-bs3.css" />

        </head>

    <?php endif; ?>
        <body class="" >

               <div class="message" style="clear:both; display:none; z-index:999; margin:0 auto !important; text-align:center; float:right;"> </div>