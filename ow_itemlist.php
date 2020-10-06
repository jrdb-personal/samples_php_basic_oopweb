<!DOCTYPE html>
<html>
<head>
	<title>My Online Webstore</title>
	<link rel="stylesheet" type="text/css" href=css/bootstrap.css>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.js"></script>
</head>

<?php 
include_once 'ow_classes.php';
$objConn = new Connection('localhost', 'root', '', 'training_phpmysql');
$objConn->openConnection();
session_start(); 

//get user record 
$user_result = $objConn->readSingleRecord('user', $_SESSION['UserID']);
if ($user_result->num_rows ==1){
	$user = $user_result->fetch_object('User', array($_SESSION['UserID']));
}

?>
<body>

<div class="container">
<h1><label>My Online Webstore</label></h1>
</div>

<div class="container">
	<div class="row">
		<div class="container"> 
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="col-md-12">	
						<?php 
							echo "<h3> Hello ".$_SESSION['UserName']."<h3>";
						?>
					</div>

					<!--navigation bar -->
					<div class="col-md-12">
						<nav class="navbar navbar-inverse">
						  <div class="container-fluid">
						    <div class="navbar-header">
						      <a class="navbar-brand" href="#">LOGO</a>
						    </div>
						    <ul class="nav navbar-nav">
						      <li><a href="ow_home.php">Home</a></li>
						      <li class="active dropdown">
						        <a class="dropdown-toggle" data-toggle="dropdown" href="ow_itemlist.php">Products<span class="caret"></span></a>
						        <ul class="dropdown-menu">
						          <li><a href="ow_itemlist.php">View all Items</a></li>
						          <li><a href="#">Promo Items</a></li>
						          <li><a href="#">Search by Category</a></li>
						        </ul>
						      </li>
						      <li class="dropdown">
						        <a class="dropdown-toggle" data-toggle="dropdown" href="ow_transaction">Transactions<span class="caret"></span></a>
						        <ul class="dropdown-menu">
						          <li><a href="ow_itemlist.php">Track My Orders</a></li>
						          <li><a href="#">Transaction History</a></li>
						          <li><a href="#">Request Item Return</a></li>
						        </ul>
						      </li>
						      <li class="dropdown">
						        <a class="dropdown-toggle" data-toggle="dropdown" href="ow_account">My Account<span class="caret"></span></a>
						        <ul class="dropdown-menu">
						          <li><a href="ow_itemlist.php">Update My Profile</a></li>
						          <li><a href="#">Change Address</a></li>
						          <li><a href="#">Set Payment Options</a></li>
						        </ul>
						      </li>
						    </ul>
						  </div>
						</nav>
					</div>
					<!-- navigation bar -->

					<div class="col-md-12">
						<h3><label>Item List</label></h3>
					</div>

					<div class="col-md-12">	
							<table class="table table-bordered">
								<colgroup>
									<col style="width: 10%;"/>
									<col style="width: 25%;"/>
									<col style="width: 5%;"/>
									<col style="width: 15%;"/>
									<col style="width: 15%;"/>
									<col style="width: 15%;"/>
									<col style="width: 15%;"/>
								</colgroup>
								
								<thead>

                                    <tr class="tablesorter-headerRow">
										<td>Name</td>
										<td>Description</td>
										<td>Qty</td>
										<td>Price</td>
										<td>Status</td>
<?php 
										if ($user->getUserType() ==  'Admin'){
?>
											<td>EDIT</td>
											<td>DELETE</td>
<?php 
										}

										else {
?>
											<td></td>
											<td>BUY</td>		
<?php 
										}
?>

									</tr>
								<thead>
								
								<tbody>
<?php 									
									$item_result = $objConn->readAllRecords("tbm_items");
									$ctr = 0;
									if($item_result->num_rows >0)
									{
										while($items = $item_result->fetch_object('Item'))
										{
?>
											<tr>
												<td><?php echo $items->getItemName(); ?></td>
												<td><?php echo $items->getItemDesc(); ?></td>
												<td><?php echo $items->getItemQty(); ?></td>
												<td><?php echo $items->getItemPrice(); ?></td>
												<td><?php echo $items->getItemStatus(); ?></td>
<?php 
												if ($user->getUserType() ==  'Admin'){
?>			
													<td><a href="ow_item_edit.php?edt_id=<?php echo $items->getItemID(); ?>">EDIT</a></td>
													<td><a href="ow_item_update.php?del_id=<?php echo $items->getItemID(); ?>">DELETE</a></td>
<?php 
												}

												else {
?>
													<td><a href="ow_item_view.php?edt_id=<?php echo $items->getItemID(); ?>">VIEW</a></td>
													<td><a href="ow_item_buy.php?del_id=<?php echo $items->getItemID(); ?>">BUY</a></td>
<?php 
												}
?>
											</tr>
<?php
										$ctr++;
										} 
									}
									else
									{
?>
										<tr><td colspan="7">No Records Found</td></tr><?php
									}
?>
								<tr>
									<td colspan="7">
										<button class="btn"><a href="ow_item_add.php">ADD NEW</a></button>
										<button class="btn"><a href="ow_home.php">BACK</a></button>
									</td>
								</tr>
							</tbody>
		
							<tfoot>
								<tr><td colspan="7">
									Total Records: <?php echo $ctr; ?>
								</td></tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


</html>