<!DOCTYPE html>
<html>
<head>
<style>
#owl-demo .owl-item div{
padding:5px;
}
#owl-demo .owl-item img{
display: block;
width: 100%;
height: auto;
-webkit-border-radius: 3px;
-moz-border-radius: 3px;
border-radius: 3px;
}
</style>


<!-- Important Owl stylesheet -->
<link rel="stylesheet" href="owl-carousel/owl.carousel.css">

<!-- Default Theme -->
<link rel="stylesheet" href="owl-carousel/owl.theme.css">

<!--  jQuery 1.7+  -->
<script src="jquery-1.9.1.min.js"></script>

<!-- Include js plugin -->
<script src="assets/owl-carousel/owl.carousel.js"></script>

<script>
$(document).ready(function() {

  $("#owl-demo").owlCarousel({
    autoPlay : 3000,
    stopOnHover : true,
    navigation:true,
    paginationSpeed : 1000,
    goToFirstSpeed : 2000,
    singleItem : true,
    autoHeight : true,
    transitionStyle:"fade"
  });

});
</script>
</head>
<body>
  <div id="owl-demo" class="owl-carousel">
    <div><img src="http://placehold.it/1170x300/42bdc2/FFFFFF"></div>
    <div><img src="http://placehold.it/1170x400/42bdc2/FFFFFF"></div>
    <div><img src="http://placehold.it/1170x500/42bdc2/FFFFFF"></div>
    <div><img src="http://placehold.it/1170x200/42bdc2/FFFFFF"></div>
    <div><img src="http://placehold.it/1170x500/42bdc2/FFFFFF"></div>
    <div><img src="http://placehold.it/1170x250/42bdc2/FFFFFF"></div>
    <div><img src="http://placehold.it/1170x350/42bdc2/FFFFFF"></div>
    <div><img src="http://placehold.it/1170x300/42bdc2/FFFFFF"></div>
    <div><img src="http://placehold.it/1170x100/42bdc2/FFFFFF"></div>
    <div><img src="http://placehold.it/1170x500/42bdc2/FFFFFF"></div>
  </div>

</body>
</html>
