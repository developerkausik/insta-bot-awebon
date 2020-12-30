<script>
$(document).ready(function(){
	 $('#confirmEditUser').on('click', function(e) {
		e.preventDefault();
		var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'}),
		error = 'Undefined Error',
		currentForm = $('#editUserForm');

		loading.show();
		currentForm.ajaxSubmit({
			url: '<?=base_url()?>/rest/user/profile/profile/updateprofile',
			type:'POST',
			error: function(response, status, xhr, $form) {
				if (response.responseJSON) {
					error = response.responseJSON.error;
				}

				swal.fire({
					"title": "",
					"text":  error,
					"type": "error",
					"buttonStyling": false,
					"confirmButtonClass": "btn btn-brand btn-sm btn-bold"
				});
				loading.hide();
			},
			success: function(response, status, xhr, $form) {
				if (response.Status) {
					swal.fire({
						"title": "",
						"text": response.Message,
						"type": "success",
						"confirmButtonClass": "btn btn-secondary"
					}).then(function(){
					   window.location.reload();
					});
				} else {
					swal.fire({
						"title": "",
						"text": response.Message,
						"type": "error",
						"confirmButtonClass": "btn btn-secondary"
					});
				}
				loading.hide();
			}
		});
	 });
	
	$('#uploadPicture').on('click', function(e) {
		e.preventDefault();
		$('#profile_picture').click();
	});
	
	$('#profile_picture').on('change', function(e) {
		e.preventDefault();
		readURL(this);
		
		var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'}),
		error = 'Undefined Error',
		currentForm = $('#editProfilePictureForm');

		loading.show();
		currentForm.ajaxSubmit({
			url: '<?=base_url()?>/rest/user/profile/profile/updateprofilepicture',
			type:'POST',
			error: function(response, status, xhr, $form) {
				if (response.responseJSON) {
					error = response.responseJSON.error;
				}

				swal.fire({
					"title": "",
					"text":  error,
					"type": "error",
					"buttonStyling": false,
					"confirmButtonClass": "btn btn-brand btn-sm btn-bold"
				});
				loading.hide();
			},
			success: function(response, status, xhr, $form) {
				if (response.Status) {
					swal.fire({
						"title": "",
						"text": response.Message,
						"type": "success",
						"confirmButtonClass": "btn btn-secondary"
					});
				} else {
					swal.fire({
						"title": "",
						"text": response.Message,
						"type": "error",
						"confirmButtonClass": "btn btn-secondary"
					});
				}
				loading.hide();
			}
		});
	});
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#profileImagePreview, .prof_picture').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
</script>
<style type="text/css">
	.img-content{
		padding: 20px;
		text-align: center;
		width: 100%;
	}
	.img-content img{
		max-width: 150px;
	}
	.img-content h4{
		padding-top: 1.5rem;
	}
</style>