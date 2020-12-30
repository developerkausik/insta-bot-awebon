<script>
var KTDatatableUsers = function() {
	var loadUsers = function() {
        var datatable = $('.kt-datatable').KTDatatable({
			data: {
				type: 'remote',
				source: {
					read: {
						method: 'GET',
						url: '<?=base_url()?>/rest/admin/users/get',
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
					field: 'id',
					title: '#',
					sortable: 'asc',
					width: 30,
					type: 'number',
					selector: false,
					textAlign: 'center',
				}, {
					field: 'full_name',
					title: 'Name',
				}, {
                    field: 'email',
                    title: 'Email',
                }, {
					field: 'account_type',
					title: 'Type',
					template: function(row) {
						var status = {
							1: {'title': 'User', 'class': ' kt-badge--success'},
							2: {'title': 'Administrator', 'class': ' kt-badge--warning'},
						};
						return '<span class="kt-badge ' + status[row.account_type].class + ' kt-badge--inline kt-badge--pill">' + status[row.account_type].title + '</span>';
					},
				}, {
                    field: 'user_status',
                    title: 'Status',
                    template: function(row) {
                        var status = {
                            0: {'title': 'Active', 'class': ' kt-badge--success'},
                            1: {'title': 'Banned', 'class': ' kt-badge--danger'},
                        };
                        return '<span class="kt-badge ' + status[row.user_status].class + ' kt-badge--inline kt-badge--pill">' + status[row.user_status].title + '</span>';
                    },
                }, {
                    field: 'user_ban_reason',
                    title: 'Ban Reason',
                    template: function(row) {
                        if (row.user_ban_reason !== null) {
                            return '<h6 class="kt-font-danger"> ' + row.user_ban_reason + '</h6>';
                        }
                        return '-';
                    }
                }, {
                    field: 'user_credits',
                    title: 'Credits',
                }, {
					field: 'Actions',
					title: 'Actions',
					sortable: false,
					width: 110,
					overflow: 'visible',
					autoHide: false,
					template: function(row) {
						return '\
                            <a href="javascript:;" \
                            data-id="' + row.id + '" \
                            data-name="' + row.email + '" \
                            class="btn btn-sm btn-clean btn-icon btn-icon-sm delete-user" title="Delete User">\
                                <i class="flaticon2-trash"></i>\
                            </a>\
                            <a href="javascript:;" \
                            data-id="' + row.id + '" \
                            data-first-name="' + row.first_name + '" \
                            data-last-name="' + row.last_name + '" \
                            data-email="' + row.email + '" \
                            data-account-type="' + row.account_type + '" \
                            data-user-status="' + row.user_status + '" \
                            data-user-ban-reason="' + row.user_ban_reason + '" \
                            data-user-credits="' + row.user_credits + '" \
                            class="btn btn-sm btn-clean btn-icon btn-icon-sm edit-user" title="Edit User">\
                                <i class="flaticon2-edit"></i>\
                            </a>\
                        ';
					},
				}],

		});
        $('#newUser, #editUser, #deleteUser').on('hidden.bs.modal', function () {
            $('#editUserForm, #newUserForm, #deleteUserForm').trigger('reset');
            $('.user-ban_reason').each(function() {
                if (!$(this).hasClass('kt-hidden')) {
                    $(this).addClass('kt-hidden')
                }
            });
            datatable.reload();
        });

        // Filters
        $('#kt_form_user-type')
            .selectpicker()
            .on('change', function(e) {
                e.preventDefault();

                datatable.search($(this).val(), 'account_type');
            });
        $('#kt_form_user-status')
            .selectpicker()
            .on('change', function(e) {
                e.preventDefault();

                datatable.search($(this).val(), 'user_status');
            });
	};

	return {
		// public functions
		init: function() {
            loadUsers();
		},
	};
}();
var KTCrudUsers = function() {
    var createUser = function() {
        $('#createNewUser').on('click', function(e) {
            e.preventDefault();

            var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'}),
                error = 'Undefined Error',
                currentModal = $(this).closest('.modal'),
                currentForm = $('#newUserForm');

            loading.show();
            currentForm.ajaxSubmit({
                url: '<?=base_url()?>/rest/admin/users/create',
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
                        currentModal.modal('hide');
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
    };
    var editDeleteUser = function() {
        $('#usersDatatable').on('click', '.delete-user', function(e) {
            e.preventDefault();

            var userDeleteID = $(this).attr('data-id'),
                userDeleteName = $(this).attr('data-name');

            $('#userDeleteID').val(userDeleteID);
            $('#userDeleteName').text(userDeleteName);
            $('#deleteUser').modal('show');
        });
        $('#usersDatatable').on('click', '.edit-user', function(e) {
            e.preventDefault();

            var userEditID = $(this).attr('data-id'),
                userEditFirstName = $(this).attr('data-first-name'),
                userEditLastName = $(this).attr('data-last-name'),
                userEditEmail = $(this).attr('data-email'),
                userEditAccountType = $(this).attr('data-account-type'),
                userEditUserStatus = $(this).attr('data-user-status'),
                userEditUserBanReason = $(this).attr('data-user-ban-reason'),
                userEditUserCredits = $(this).attr('data-user-credits');

            $('#userEditID').val(userEditID);
            $('#userEditFirstName').val(userEditFirstName);
            $('#userEditLastName').val(userEditLastName);
            $('#userEditEmail').val(userEditEmail);
            $('#userEditAccountType').val(userEditAccountType);
            $('#userEditUserStatus').val(userEditUserStatus);
            if (userEditUserStatus == 1) {
                $('#userEditUserBanReason').val(userEditUserBanReason);
                $('.user-ban_reason').removeClass('kt-hidden');
            }
            $('#userEditUserCredits').val(userEditUserCredits);
            $('#editUser').modal('show');
        });
        $('#userEditUserStatus').on('change', function(e) {
            e.preventDefault();

            var userStatus = $(this).val(),
                userBanReason = $('#editUserForm .user-ban_reason');

            if (userStatus == 0) {
                if (!userBanReason.hasClass('kt-hidden')) {
                    userBanReason.addClass('kt-hidden');
                }
            } else {
                userBanReason.removeClass('kt-hidden');
            }
        });
        $('#confirmDeleteUser').on('click', function(e) {
            e.preventDefault();

            var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'}),
                error = 'Undefined Error',
                currentModal = $(this).closest('.modal'),
                currentForm = $('#deleteUserForm');

            loading.show();
            currentForm.ajaxSubmit({
                url: '<?=base_url()?>/rest/admin/users/delete',
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
                        currentModal.modal('hide');
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
        $('#confirmEditUser').on('click', function(e) {
            e.preventDefault();

            var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'}),
                error = 'Undefined Error',
                currentModal = $(this).closest('.modal'),
                currentForm = $('#editUserForm');
            loading.show();
            currentForm.ajaxSubmit({
                url: '<?=base_url()?>/rest/admin/users/edit',
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
                        currentModal.modal('hide');
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
    };

    return {
        init: function() {
            createUser();
            editDeleteUser();
        }
    };
}();

jQuery(document).ready(function() {
    KTDatatableUsers.init();
    KTCrudUsers.init();
});
</script>