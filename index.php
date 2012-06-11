<?php 
session_start();
$token = md5(uniqid(rand(), TRUE));
$_SESSION['token'] = $token;
$_SESSION['token_time'] = time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>PAAJAF FOUNDATION - REGISTER ORGANIZATION</title>
<!-- Le styles -->
<link rel="stylesheet" href="css/bootstrap.css" />
<link rel="stylesheet" href="css/forms.css" />
</head>
<body>
	<div class="container">
		<div id="form2_header">
			<h1>PAAJAF FOUNDATION - REGISTER ORGANIZATION</h1>
		</div>
		<?php 
		if(isset($_SESSION['message']) && !empty($_SESSION['message'])) {
			?>
			<div class="alert alert-error"><?php echo $_SESSION['message'];?></div>
			<?php 
			unset($_SESSION['message']);
		}
		?>
		<?php 
		if(isset($_SESSION['error']) && !empty($_SESSION['error'])) {
			?>
			<div class="alert alert-error"><?php echo $_SESSION['error'];?></div>
			<?php 
			unset($_SESSION['error']);
		}
		?>
		<form method='POST' action='doStep1.php' class='form-inline' id='form1' name='form1'>
			<input type="hidden" name="token" value="<?php echo $token; ?>" />
			<div class='row-fluid'>
				<label for='title' class='span5 pagination-right'><strong>Title of organization :&nbsp;</strong></label>
				<input placeholder='Title' type="text" name="title" id="title"
					class='span4' />
			</div>
			<div class='row-fluid'>
        <label for='photo' class='span5 pagination-right'><strong>Upload logo :&nbsp;</strong></label>
        <input type="file" name="photo" id="photo" />
      </div>
      <div class='row-fluid'>
        <label for='summary' class='span5 pagination-right'><strong>Summary :&nbsp;</strong></label>
        <textarea name="summary" id="summary" class='span4' style='height: 80px; margin: 0px 0px 4px 0px;'></textarea>
      </div>
      <div class='row-fluid'>
        <label for='day' class='span5 pagination-right'><strong>Founded date :&nbsp;</strong></label>
        <input placeholder='DD' type="text" name="day" id="day" class='span1' style='float: left; margin-right: 4px;' />
        <input placeholder='MM' type="text" name="month" id="month" class='span1' style='float: left; margin-right: 4px;' />
        <input placeholder='YYYY' type="text" name="year" id="year" class='span1' style='float: left;' />
      </div>
      <div class='row-fluid'>
        <label for='employee' class='span5 pagination-right'><strong>Employee :&nbsp;</strong></label>
        <input placeholder='Title' type="text" name="employee" id="employee"
          class='span4' />
      </div>
      <div class='row-fluid'>
        <label for='volunteer' class='span5 pagination-right'><strong>Volunteer :&nbsp;</strong></label>
        <input placeholder='Title' type="text" name="volunteer" id="volunteer"
          class='span4' />
      </div>
      <div class='row-fluid'>
        <label for='address' class='span5 pagination-right'><strong>Address :&nbsp;</strong></label>
        <textarea name="address" id="address" class='span4' style='height: 80px; margin: 0px 0px 4px 0px;'></textarea>
      </div>
      <div class='row-fluid'>
        <label for='website' class='span5 pagination-right'><strong>Website URL :&nbsp;</strong></label>
        <input placeholder='Total funding goal' type="text" name="website" id="website"
          class='span4' />
      </div>
      <div class='row-fluid'>
        <label for='director' class='span5 pagination-right'><strong>Executive Director :&nbsp;</strong></label>
        <textarea name="director" id="director" class='span4' style='height: 40px; margin: 0px 0px 4px 0px;'></textarea>
      </div>
      <div class='row-fluid'>
        <label for='management' class='span5 pagination-right'><strong>Management Team :&nbsp;</strong></label>
        <textarea name="management" id="management" class='span4' style='height: 80px; margin: 0px 0px 4px 0px;'></textarea>
      </div>
      <div class='row-fluid'>
        <label for='board' class='span5 pagination-right'><strong>Board Director :&nbsp;</strong></label>
        <textarea name="board" id="board" class='span4' style='height: 80px; margin: 0px 0px 4px 0px;'></textarea>
      </div>
      <div class='row-fluid'>
        <label for='missions' class='span5 pagination-right'><strong>Missions :&nbsp;</strong></label>
        <textarea name="missions" id="missions" class='span4' style='height: 80px; margin: 0px 0px 4px 0px;'></textarea>
      </div>
      <div class='row-fluid'>
        <label for='programs' class='span5 pagination-right'><strong>Programs :&nbsp;</strong></label>
        <textarea name="programs" id="programs" class='span4' style='height: 80px; margin: 0px 0px 4px 0px;'></textarea>
      </div>
      <hr/>
      <div class='row-fluid'>
        <label for='title2' class='span5 pagination-right'><strong>TITLE :&nbsp;</strong></label>
        <input placeholder='TITLE' type="text" name="title2" id="title2"
          class='span4' />
      </div>
      <div class='row-fluid'>
        <label for='report' class='span5 pagination-right'><strong>REPORT MESSAGE :&nbsp;</strong></label>
        <textarea name="report" id="report" class='span4' style='height: 80px; margin: 0px 0px 4px 0px;'></textarea>
      </div>
      <div class='row-fluid'>
        <div class='span5'></div><div class=''><button type='submit' class='btn' style='margin: 0px;'>Submit</button></div>
      </div>
		</form>
	</div>
<script type="text/javascript" src="js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
$("#form1").validate({
	rules: {
		title: "required",
		summary: "required",
		day: {
			required: true,
			minlength: 1
		},
		month: {
			required: true,
			minlength: 1
		},
		year: {
			required: true,
			minlength: 1
		},
		employee: "required", 
		volunteer: "required", 
		address: "required"
	},
	messages: {
		title: "Please enter your organization title",
		summary: "Please enter your organization summary",
		day: {
			required: "Please enter a day",
			minlength: "Day must consist of at least 2 numbers"
		},
		month: {
			required: "Please enter a month",
			minlength: "Month must consist of at least 2 numbers"
		},
		year: {
			required: "Please enter a year",
			minlength: "Year must consist of at least 2 numbers"
		},
		employee: "Please enter the name of an employee of your organization",
		volunteer: "Please enter the name of the volunteer of your organization",
		address: "Please enter the address of your organization"
	}
});
</script>
</body>
</html>