<script>
$(document).ready(function(){
	 $('#changeEmail').on('click', function(e) {
		e.preventDefault();
		var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'}),
		error = 'Undefined Error',
		currentForm = $('#changeEmailForm');

		loading.show();
		currentForm.ajaxSubmit({
			url: '<?=base_url()?>/rest/user/profile/profile/updateemail',
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
		currentForm.trigger("reset");
	 });
	<?php if(isset($errorMsg) && $errorMsg != ""){?>
	swal.fire({
		"title": "",
		"text": "Sorry!! Email verification failed",
		"type": "error",
		"confirmButtonClass": "btn btn-secondary"
	});
	<?php }elseif(isset($successMsg) && $successMsg != ""){?>
	swal.fire({
		"title": "",
		"text": "Your email has ben successfully updated!!",
		"type": "success",
		"confirmButtonClass": "btn btn-secondary"
	});
	<?php } ?>
});
</script>