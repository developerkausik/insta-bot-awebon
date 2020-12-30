<script>
var KTDatatableDiscounts = function() {
	var loadDiscounts = function() {

        var datatable = $('.kt-datatable').KTDatatable({
                // datasource definition
                data: {
                    type: 'remote',
                    source: {
                        read: {
                            method: 'GET',
                            url: '<?=base_url()?>/rest/admin/discounts/get',
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
                        field: 'discount_name',
                        title: 'Discount Name',
                    }, {
                        field: 'discount_type',
                        title: 'Discount Type',
                        template: function(row) {
                            if (row.discount_type == 0) {
                                return 'Percentage';
                            } else {
                                return 'Amount';
                            }
                        }
                    }, {
                        field: 'discount_amount',
                        title: 'Discount Value',
                    }, {
                        field: 'discount_code',
                        title: 'Discount Code',
                    },{
                        field: 'discount_status',
                        title: 'Status',
                        template: function(row) {
                            var status = {
                                0: {
                                    'title': 'Disabled',
                                    'class': ' btn-label-danger'
                                },
                                1: {
                                    'title': 'Active',
                                    'class': ' btn-label-success'
                                },
                            };
                            return '<span class="btn btn-bold btn-sm btn-font-sm ' + status[row.discount_status].class + '">' + status[row.discount_status].title + '</span>';
                        }
                    }, {
                        field: 'updated_at',
                        title: 'Last Update',
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
                                data-name="' + row.discount_name + '" \
                                class="btn btn-sm btn-clean btn-icon btn-icon-sm delete-discount" title="Delete Discount">\
                                    <i class="flaticon2-trash"></i>\
                                </a>\
                                <a href="javascript:;" \
                                data-id="' + row.id + '" \
                                data-name="' + row.discount_name + '" \
                                data-type="' + row.discount_type + '" \
                                data-amount="' + row.discount_amount + '" \
                                data-status="' + row.discount_status + '" \
                                data-discount="' + row.discount_code + '"\
                                class="btn btn-sm btn-clean btn-icon btn-icon-sm edit-discount" title="Edit Discount">\
                                    <i class="flaticon2-edit"></i>\
                                </a>\
                            ';
                        },
                    }],

            });

        $('#newDiscount, #editDiscount, #deleteDiscount').on('hidden.bs.modal', function () {
            $('#newDiscountForm, #editDiscountForm, #deleteDiscountForm').trigger('reset');
            $('#createDiscountStatus').prop('checked', false);
            datatable.reload();
        });
	};

	return {
		// public functions
		init: function() {
            loadDiscounts();
		},
	};
}();
var KTCrudDicounts = function() {
    var createDiscount = function() {
        $('#createNewDiscount').on('click', function(e) {
            e.preventDefault();

            var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'}),
                error = 'Undefined Error',
                currentModal = $(this).closest('.modal'),
                currentForm = $('#newDiscountForm');

            currentForm.validate({
                rules: {
                    discount_title: {
                        required: true,
                    },
                    discount_type: {
                        required: true
                    },
                    discount_amount: {
                        required: true
                    },
                    discount_status: {
                        required: true
                    }
                }
            });

            if (!currentForm.valid()) {
                return;
            }

            loading.show();
            currentForm.ajaxSubmit({
                url: '<?=base_url()?>/rest/admin/discounts/create',
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
        });
    };
    var editDeleteDiscount = function() {
        $('#discountsDatatable').on('click', '.delete-discount', function(e) {
            e.preventDefault();

            var discountDeleteID = $(this).attr('data-id'),
                discountDeleteName = $(this).attr('data-name');

            $('#discountDeleteID').val(discountDeleteID);
            $('#discountDeleteName').text(discountDeleteName);
            $('#deleteDiscount').modal('show');
        });
        $('#discountsDatatable').on('click', '.edit-discount', function(e) {
            e.preventDefault();

            var discountEditID = $(this).attr('data-id'),
                discountEditName = $(this).attr('data-name'),
                discountEditType = $(this).attr('data-type'),
                discountEditAmount = $(this).attr('data-amount'),
                discountEditStatus = $(this).attr('data-status'),
                discountEditCode = $(this).attr('data-discount');

            $('#discountEditID').val(discountEditID);
            $('#discountEditName').val(discountEditName);
            $('#discountEditType').val(discountEditType);
            $('#discountEditAmount').val(discountEditAmount);
            $('#discountEditCode').val(discountEditCode);
            if (discountEditStatus == 1) {
                $('#discountEditStatus').prop('checked', true);
            } else {
                $('#discountEditStatus').prop('checked', false);
            }
            $('#editDiscount').modal('show');
        });
        $('#confirmDeleteDiscount').on('click', function(e) {
            e.preventDefault();

            var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'}),
                error = 'Undefined Error',
                currentModal = $(this).closest('.modal'),
                currentForm = $('#deleteDiscountForm');
            loading.show();
            currentForm.ajaxSubmit({
                url: '<?=base_url()?>/rest/admin/discounts/delete',
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
        });
        $('#confirmEditDiscount').on('click', function(e) {
            e.preventDefault();

            var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'}),
                error = 'Undefined Error',
                currentModal = $(this).closest('.modal'),
                currentForm = $('#editDiscountForm');
            loading.show();
            currentForm.ajaxSubmit({
                url: '<?=base_url()?>/rest/admin/discounts/edit',
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
        });
    };

    return {
        init: function() {
            createDiscount();
            editDeleteDiscount();
        }
    };
}();

jQuery(document).ready(function() {
    KTDatatableDiscounts.init();
    KTCrudDicounts.init();
});
</script>