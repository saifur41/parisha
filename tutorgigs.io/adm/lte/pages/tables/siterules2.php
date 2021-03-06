<?php  
	require("config.php");
	require_once("../../../classes/SiteRules.class.php");
	
    if(empty($_SESSION['user']) || (int)$_SESSION['user']['Security'] < 90) 
    {
        header("Location: /adm/index.php");
        die("Redirecting to index.php"); 
    }
	
		// db connection
		include 'dbtutor.ini';
		
		// Connect to tutor database
		$connection = mysqli_connect($tServer, $tUser, $tPass, $tDB) or 
			die('Connection Error: ' . mysqli_connect_error() . ' User:'. $tUser);
		mysqli_select_db($connection, "$tDB");
		
		// Tally up totals
		//$ruleResult = mysqli_query($connection, "SELECT * FROM siteRules");
		//$totalRules = $result->num_rows;
					
		$siteRules = new SiteRules();
		$totalRules = $siteRules->getNumOfRules();
		$ruleResult = $siteRules->getAllRules();
		
?> 


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Site Rules | P2G Admin</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="../../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="../../css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="../../css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../../css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-black">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="../../index.php" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <img src="/img/logo80x120.png" width="40" height="60"> Admin
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-maroon">
                                   
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    
                                    <div class="pull-right">
                                        <a href="/adm/logout.php" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">                
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        
                    </div>
                    
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <? include("menu.htm"); ?>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Site Rules
                        <small>Settings</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Settings</a></li>
                        <li class="active">Site Rules</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Site Rules</h3>
                                    <!-- Rep Report -->
                                    <ul class="nav navbar-nav">
                                        <li><span class="badge"><? echo $totalRules ?></span></li>
                                    </ul>  
                                    
                                    
                                </div><!-- /.box-header --> 
                                
                                <!--<button class="btn btn-primary center-block" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus-sign" ></span> Create a New Rule</button>-->
                                                               
                                <div class="box-body table-responsive">                                
                                    <table id="example2" class="table table-responsive table-condensed table-hover">
                                    	<thead>                                                    
                                             <tr>                                                
                                                <th>Rule Name</th>
                                                <th>Value</th>
                                                <th>Notes</th>
                                                <th>Actions</th>                                                                       
                                            </tr>                                                    
                                        </thead>   
                                        <tbody>
                                            <?php	
                                                while ( $row = mysqli_fetch_array($ruleResult) ) {
                                                    $rowColor = (string)$row['IsActive'] == 1 ? '' : 'danger';
                                            ?>
                                            <tr id="r<?php echo $row['ID'] ?>" class="<?php echo $rowColor;  ?>" style="text-align:left;" >                                                 
                                                <td class="Rule"><?php echo $row['Rule'] ?></td>
                                                <td class="Value"><?php echo $row['Value'] ?></td>
                                                <td class="Notes"><?php echo $row['Notes'] ?></td>
                                                <td>
                                                    <span class="glyphicon glyphicon-edit" 
                                                    	  style="cursor: pointer;" 
                                                          title="Edit" onClick="editRule(<? echo $row['ID'] ?>)"
                                                    >
												    </span>
												</td>
                                                
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

		<!-- Button trigger modal -->
<!--        <button class="btn btn-primary btn-lg center-block" data-toggle="modal" data-target="#myModal">pop test</button> -->
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria- labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                         <h4 class="modal-title" id="myModalLabel">Edit Rule</h4>

                    </div>
                    <div class="modal-body">
                    
                    	<div class="container" style="max-width:500px">
                              <form id="rForm" name="rForm" role="form" action="adminfUpdateRule.php" method="post">
                              <input type="hidden" id="rID" name="rID" value="" >
                              	<!-- Text input-->
                                <div class="control-group">
                                  <label class="control-label" for="rRule">Rule Name</label>
                                  <div class="controls">
                                    <input id="rRule" name="rRule" type="text" placeholder="" class="form-control" required>
                                    
                                  </div>
                                </div>
                                <br/>  
                                   
                                <!-- Text input-->
                                <div class="control-group">
                                  <label class="control-label" for="rValue">Value</label>
                                  <div class="controls">
                                    <input id="rValue" name="rValue" type="text" pattern="\d*" placeholder="" class="form-control" required>
                                    
                                  </div>
                                </div>
                                <br/>  
                                 
                                <!-- Text input-->
                                <div class="control-group">
                                  <label class="control-label" for="rNotes">Notes</label>
                                  <div class="controls">
                                    <textarea id="rNotes" name="rNotes" type="" placeholder="" class="form-control" required>
                                    </textarea>
                                  </div>
                                </div>
                                <br/>   
                                <!-- Button (Double) -->
                                <div class="control-group">
                                  <label class="control-label" for="rSubmit"></label>
                                  <div class="controls">
                                    <button id="rSubmit" name="rSubmit" class="btn btn-success">Submit</button>                                    
                                  </div>
                                </div>
                                
                            </form>
                       </div>
                       
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->


        <!-- jQuery 2.0.2 -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT 
        <script src="../../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="../../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>-->
        <!-- AdminLTE App -->
        <script src="../../js/AdminLTE/app.js" type="text/javascript"></script>
        
		<script type="text/javascript">
        
        function editRule( rID ) {
			
			// Select all td that belong to the table row id
			//alert( $('td.Notes', '#r' + rID ).html() );
			$("#rID").val(rID);
			$("#rRule").val( $('td.Rule', '#r' + rID ).html() );
			$("#rValue").val( $('td.Value', '#r' + rID ).html() );
			$("#rNotes").html( $('td.Notes', '#r' + rID ).html() );					
				
			$("#myModal").modal('show');
			
        }
		
		function isNumber (o) {
			return ! isNaN (o-0);
		}
		
		$("#rValue").keyup(function(e) {
			txtVal = $(this).val();
			if( isNumber(txtVal) && txtVal.length > 2) {
				$(this).val( txtVal.substring(0,2) )
			}
		});
        
        </script>
        

    </body>
</html>