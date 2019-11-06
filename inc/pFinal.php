<!--
</div>
                    </div>
                </div>
            </div>


        </div>
        

		<script src="./public/template/vendor/bootstrap/js/bootstrap.min.js"></script>
		
		<script src="./public/template/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
		
		<script src="./public/template/scripts/klorofil-common.js"></script>


		<script src="./public/js/uncompressed/moment.js"></script>

		

		<script src="./public/js/owl.carousel.min.js"></script>


		<script src="./public/js/modernizr.min.js"></script>


		<script src="./public/js/waypoints.min.js"></script>


		<script src="./public/js/jquery.scrollTo.min.js"></script>


		<script src="./public/js/jquery.localScroll.min.js"></script>
		

		<script src="./public/js/fontawesome.js"></script>
		

		<script src="./public/js/summernote.js"></script>
		

		<script src="./public/js/jquery.dataTables.min.js"></script>
                <script src="./public/js/dataTables-init.js"></script>
		
		
		

		<script src="./public/js/jquery.popupoverlay.min.js"></script>
		

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
