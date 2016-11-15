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
