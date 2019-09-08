</div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT -->

        </div>
        
        <!-- Bootstrap -->
		<script src="./public/template/vendor/bootstrap/js/bootstrap.min.js"></script>
		
		<script src="./public/template/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
		
		<script src="./public/template/scripts/klorofil-common.js"></script>

		<!-- Moment -->
		<script src="./public/js/uncompressed/moment.js"></script>

		
		<!-- Owl -->
		<script src="./public/js/owl.carousel.min.js"></script>

		<!-- Modernizr -->
		<script src="./public/js/modernizr.min.js"></script>

		<!-- Waypoint -->
		<script src="./public/js/waypoints.min.js"></script>

		<!-- ScrollTo -->
		<script src="./public/js/jquery.scrollTo.min.js"></script>

		<!-- Local Scroll -->
		<script src="./public/js/jquery.localScroll.min.js"></script>
		
		<!-- Font-Awesome -->
		<script src="./public/js/fontawesome.js"></script>
		
		<!-- Editor HTML -->
		<script src="./public/js/summernote.js"></script>
		
		<!-- Table -->
		<script src="./public/js/jquery.dataTables.min.js"></script>
                <script src="./public/js/dataTables-init.js"></script>
		
		
		
		<!-- Pop overlay -->
		<script src="./public/js/jquery.popupoverlay.min.js"></script>
		
		<!-- Simplify -->
		<script src="./public/js/simplify.js"></script>
		
		
		

<script type = "text/javascript" >
  $('#formPassword').on('submit', function() {
	   var $this = $(this);
	   console.log($this);
	   $.ajax({
	     url: 'attendees/savemypassword',
	     data: $this.serialize(),
	     type: 'POST'
		}).always(function(data) {
			alert(data.responseText);
			$("#formInModal").modal('hide');
			$('#formPassword')[0].reset();
		});
	   return false;
	});
</script>