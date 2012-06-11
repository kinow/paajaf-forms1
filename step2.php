<?php 
session_start();
$token = md5(uniqid(rand(), TRUE));
$_SESSION['token'] = $token;
$_SESSION['token_time'] = time();

if(!isset($_SESSION['organization'])) {
	$_SESSION['error'] = 'Missing organization';
	header('Location: index.php');
}
$organization_id = $_SESSION['organization'];

require_once 'php-activerecord/ActiveRecord.php';
require_once 'model/organizations.php';
require_once 'model/locations.php';
require_once 'model/categories.php';
require_once 'model/projects.php';

ActiveRecord\Config::initialize(function($cfg)
{
	$cfg->set_model_directory('model');
	$cfg->set_connections(array('development' =>
			'mysql://root:admin@localhost/paajaf_forms'));
});

$locations = Locations::all();
$categories = Categories::all();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>PAAJAF FOUNDATION - CREATE PROJECT</title>

<!-- Le styles -->
<link rel="stylesheet" href="css/bootstrap.css" />
<link rel="stylesheet" href="css/forms.css" />
</head>
<body>

	<div class="container">
		<div id="form1_header">
			<h1>PAAJAF FOUNDATION - CREATE PROJECT</h1>
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
		<form method='POST' action='doStep2.php' class='form-inline' name='form2' id='form2'>
			<input type="hidden" name="token" value="<?php echo $token; ?>" />
			<input type='hidden' name='organization' value='<?php echo $organization_id; ?>' />
			<div class='row-fluid'>
				<label for='title' class='span5 pagination-right'><strong>Title :&nbsp;</strong></label>
				<input placeholder='Title' type="text" name="title" id="title"
					class='span4' />
			</div>
			<div class='row-fluid'>
        <label for='location' class='span5 pagination-right'><strong>Location :&nbsp;</strong></label>
        <select name="location" id="location" class='span4'>
          <option>-- Select --</option>
          <?php 
          foreach($locations as $location) {
          	echo "<option value ='$location->id'>$location->description</option>";
          }
          ?>
        </select>
      </div>
      <div class='row-fluid'>
        <label for='category' class='span5 pagination-right'><strong>Category :&nbsp;</strong></label>
        <select name="category" id="category" class='span4'>
          <option>-- Select --</option>
          <?php 
          foreach($categories as $category) {
          	echo "<option value ='$category->id'>$category->description</option>";
          }
          ?>
        </select>
      </div>
      <div class='row-fluid'>
        <label for='summary' class='span5 pagination-right'><strong>Summary :&nbsp;</strong></label>
        <textarea name="summary" id="summary" class='span4' style='height: 80px; margin: 0px 0px 4px 0px;'></textarea>
      </div>
      <div class='row-fluid'>
        <label for='question1' class='span5 pagination-right'><strong>What is the issue problem or challenge? :&nbsp;</strong></label>
        <textarea name="question1" id="question1" class='span4' style='height: 80px; margin: 0px 0px 4px 0px;'></textarea>
      </div>
      <div class='row-fluid'>
        <label for='question2' class='span5 pagination-right'><strong>How will this problem solve the problem? :&nbsp;</strong></label>
        <textarea name="question2" id="question2" class='span4' style='height: 80px; margin: 0px 0px 4px 0px;'></textarea>
      </div>
      <div class='row-fluid'>
        <label for='long_term' class='span5 pagination-right'><strong>Potential long term impacts :&nbsp;</strong></label>
        <textarea name="long_term" id="long_term" class='span4' style='height: 80px; margin: 0px 0px 4px 0px;'></textarea>
      </div>
      <div class='row-fluid'>
        <label for='message' class='span5 pagination-right'><strong>Project message :&nbsp;</strong></label>
        <textarea name="message" id="message" class='span4' style='height: 80px; margin: 0px 0px 4px 0px;'></textarea>
      </div>
      <div class='row-fluid'>
        <label for='funding' class='span5 pagination-right'><strong>Total funding goal :&nbsp;</strong></label>
        <input placeholder='Total funding goal' type="text" name="funding" id="funding"
          class='span4' />
      </div>
      <div class='row-fluid'>
        <label for='photo' class='span5 pagination-right'><strong>Upload project photo :&nbsp;</strong></label>
        <input type="file" name="photo" id="photo" />
      </div>
      <div class='row-fluid'>
        <label for='photo_title' class='span5 pagination-right'><strong>Title of the photo :&nbsp;</strong></label>
        <input placeholder='Title of the photo' type="text" name="photo_title" id="photo_title"
          class='span4' /><span style='color: #7c804c; font-weight: bold; margin-left: 120px;'><i class='icon-plus'></i>Add more photos</span>
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
$("#form2").validate({
	rules: {
		title: "required",
		location_id: {
			required: true, 
			number: true
		},
		category_id: {
			required: true, 
			number: true
		},
		summary: "required",
		question1: "required",
		question2: "required",
		long_term: "required", 
		message: "required", 
		funding: {
			required: true, 
			number: true
		}
	},
	messages: {
		title: "Please enter your organization title",
		summary: "Please enter your organization summary",
		location_id: {
			required: "Please select a location",
			number: "Location identification must be numeric"
		},
		category_id: {
			required: "Please select a category",
			number: "Category identification must be numeric"
		},
		summary: "Please enter a summary",
		question1: "Please enter a issue or problem",
		question2: "Please enter how your project will help",
		long_term: "Please enter the long term impacts",  
		message: "Please enter a message",
		funding: {
			required: "Please enter the funding goal",
			number: "Funding goal must be numeric"
		} 
	}
});
</script>
</body>
</html>