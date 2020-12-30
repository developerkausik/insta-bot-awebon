<script>
var KTAccountsDatatable = function() {
	// Private functions

	// basic demo
	var loadAccounts = function() {

	var datatable = $('.kt-datatable').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						method: 'GET',
						url: '<?=base_url()?>/rest/admin/accounts/get',
						headers: {'x-my-custokt-header': 'some value', 'x-test-header': 'the value'},
						map: function(raw) {
							// sample data mapping
							var dataSet = raw;
							if (typeof raw.data !== 'undefined') {
								dataSet = raw.data;
							}
							return dataSet;
						},
					},
				},
				pageSize: 10,
				serverPaging: false,
				serverFiltering: false,
				serverSorting: false,
			},

			// layout definition
			layout: {
				scroll: false,
				footer: false,
			},

			// column sorting
			sortable: true,

			pagination: true,

			search: {
				input: $('#generalSearch'),
			},

			// columns definition
			columns: [
				{
					field: 'RecordID',
					title: '#',
					sortable: 'asc',
					width: 30,
					type: 'number',
					selector: false,
					textAlign: 'center',
				}, {
					field: 'account_username',
					title: 'Username',
				}, {
					field: 'created_at',
					title: 'Added Date',
					type: 'date',
					format: 'MM/DD/YYYY',
				}, {
					field: 'account_status',
					title: 'Status',
					// callback function support for column rendering
					template: function(row) {
						var status = {
							0: {'title': 'Not Verified', 'class': ' kt-badge--warning'},
							1: {'title': 'Captcha', 'class': ' kt-badge--info'},
							2: {'title': 'Verified', 'class': ' kt-badge--success'},
                            3: {'title': 'Failed', 'class': ' kt-badge--danger'},
						};
						return '<span class="kt-badge ' + status[row.account_status].class + ' kt-badge--inline kt-badge--pill">' + status[row.account_status].title + '</span>';
					},
				}, {
                    field: 'account_fail_reason',
                    title: 'Failed Reason',
                    template: function(row) {
                        if (row.account_fail_reason !== null) {
                            return '<h6 class="kt-font-danger"> ' + row.account_fail_reason + '</h6>';
                        }
                        return '';
                    }
                }, {
					field: 'Actions',
					title: 'Actions',
					sortable: false,
					width: 110,
					overflow: 'visible',
					autoHide: false,
					template: function(row) {
						return '\
                            <a href="javascript:;" data-id="'+row.RecordID+'" class="btn btn-sm btn-clean btn-icon btn-icon-sm delete-account" title="Delete Account">\
                                <i class="flaticon2-trash"></i>\
                            </a>\
                            <a href="javascript:;" data-id="'+row.RecordID+'" class="btn btn-sm btn-clean btn-icon btn-icon-sm verify-account" title="Verify Account">\
                                <i class="flaticon2-check-mark"></i>\
                            </a>\
                        ';
					},
				}],

		});

	$('#ajax_data')
        .on('click', '.delete-account', function(e) {
            e.preventDefault();
            var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'}),
                error = 'Undefined Error',
                accID = $(this).attr('data-id');

            loading.show();
            $(this).ajaxSubmit({
                url: '<?=base_url()?>/rest/admin/accounts/delete',
                data: {
                    'account_id':	accID
                },
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
                        location.reload();
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
        })
        .on('click', '.verify-account', function(e) {
            e.preventDefault();

            var accID = $(this).attr('data-id');

            $('#selectedAccoundId').val(accID);
            $('#verifyAccount').modal('show');
        });

    $('#kt_form_status').on('change', function() {
      datatable.search($(this).val().toLowerCase(), 'Status');
    });

    $('#kt_form_type').on('change', function() {
      datatable.search($(this).val().toLowerCase(), 'Type');
    });

    $('#verifyIgAccount').on('click', function (e) {
            e.preventDefault();

            var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'}),
                error = 'Undefined Error',
                form = $(this).closest('form');

            loading.show();
            form.ajaxSubmit({
                error: function (response, status, xhr, $form) {
                    if (response.responseJSON) {
                        error = response.responseJSON.error;
                    }

                    swal.fire({
                        "title": "",
                        "text": error,
                        "type": "error",
                        "buttonStyling": false,
                        "confirmButtonClass": "btn btn-brand btn-sm btn-bold"
                    });
                    loading.hide();
                },
                success: function (response, status, xhr, $form) {
                    if (response.Status) {
                        swal.fire({
                            "title": "",
                            "text": response.Message,
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                        location.reload();
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

	};

	return {
		// public functions
		init: function() {
			loadAccounts();
		},
	};
}();
var KTUppy = function () {
	const XHRUpload = Uppy.XHRUpload;
	const ProgressBar = Uppy.ProgressBar;
	const StatusBar = Uppy.StatusBar;
	const FileInput = Uppy.FileInput;
	const Informer = Uppy.Informer;

	var initFileImport = function(){
		var id = '#kt_uppy_3';
	
		var uppyDrag = Uppy.Core({ 
			autoProceed: true,
			restrictions: {
				maxFileSize: 1000000, // 1mb
				maxNumberOfFiles: 5,
				minNumberOfFiles: 1,
				allowedFileTypes: ['*/*']
			} 
		});
	
		uppyDrag.use(Uppy.DragDrop, { target: id + ' .kt-uppy__drag' });  
		uppyDrag.use(ProgressBar, { 
			target: id + ' .kt-uppy__progress',
			hideUploadButton: false,
			hideAfterFinish: false 
		});      
		uppyDrag.use(Informer, { target: id + ' .kt-uppy__informer'  });
		uppyDrag.use(XHRUpload, { 
			endpoint: '<?=base_url()?>/rest/admin/accounts/upload',
			fieldName: 'file'
		});

		uppyDrag.on('upload-success', function(file, response) {
		    if (response.body.Status) {
                swal.fire({
                    "title": "",
                    "text": "Accounts has been imported",
                    "type": "success",
                    "confirmButtonClass": "btn btn-secondary"
                });
                location.reload();
            } else {
                swal.fire({
                    "title": "",
                    "html": response.body.Message,
                    "type": "error",
                    "confirmButtonClass": "btn btn-secondary"
                });
            }
		});
	
		$(document).on('click', id + ' .kt-uppy__thumbnails .kt-uppy__remove-thumbnail', function(){
			var imageId = $(this).attr('data-id');
			uppyDrag.removeFile(imageId);					
			$(id + ' .kt-uppy__thumbnail-container[data-id="'+imageId+'"').remove();
		});			
	}

	return {
		// public functions
		init: function() {
			initFileImport();
		}
	};
}();

jQuery(document).ready(function() {
	KTAccountsDatatable.init();
	KTUppy.init();
});
</script>