<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" href="mangog.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <title>ManGo</title>

<style>
#custom-search-input{
  padding: 3px;
  border: solid 1px #E4E4E4;
  border-radius: 6px;
  background-color: #fff;
}

#custom-search-input input{
  border: 0;
  box-shadow: none;
}

#custom-search-input button{
  margin: 2px 0 0 0;
  background: none;
  box-shadow: none;
  border: 0;
  color: #666666;
  padding: 0 8px 0 10px;
  border-left: solid 1px #ccc;
}

#custom-search-input button:hover{
  border: 0;
  box-shadow: none;
  border-left: solid 1px #ccc;
}

#custom-search-input .glyphicon-search{
  font-size: 23px;
}

</style>


<script>
$(function(){
$('#search').keyup(function(){
 var current_query = $('#search').val();
 if (current_query !== "") {
   $(".list-group li").hide();
   $(".list-group li").each(function(){
     var current_keyword = $(this).text();
     if (current_keyword.indexOf(current_query) >=0) {
       $(this).show();
     };
   });
 } else {
   $(".list-group li").show();
 };
});
});
</script>


<!-- Include js plugin -->

<link href="js/jquery-ui.min.css" rel="stylesheet">
<script src="js/jquery-ui.min.js"> </script>
<script src="js/jquery.form.min.js"> </script>
<script src="js/jquery.blockUI.js"> </script>


<body>

	<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Click here for list</button>

  <div class="container">
    <div class="row">
      <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">

        <br><br><br><br><br><br>
          <br><br><br><br><br><br>
          
			<div class="modal-dialog modal-lg">
				<div class="modal-content">

					<div id="custom-search-input">
						<div class="input-group col-md-12">
							<input id="search" type="text" class="form-control input-lg" placeholder="Search" />
							<span class="input-group-btn">
								<button class="btn btn-info btn-lg" type="button">
									<i class="glyphicon glyphicon-search"></i>
								</button>
							</span>


						<ul class="list-group">

						</ul>


				</div>
			</div>
		</div>
	</div>
</div>



</body>
</html>
