<script>
var KTDatatablePlans = function() {
	var loadPlans = function() {

        var datatable = $('.kt-datatable').KTDatatable({
                // datasource definition
                data: {
                    type: 'remote',
                    source: {
                        read: {
                            method: 'GET',
                            url: '<?=base_url()?>/rest/admin/plans/get',
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
                        field: 'plan_title',
                        title: 'Title',
                    }, {
                        field: 'plan_description',
                        title: 'Description',
                    }, {
                        field: 'plan_credits',
                        title: 'Credits',
                    }, {
                        field: 'plan_price',
                        title: 'Price',
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
                                data-name="' + row.plan_title + '" \
                                class="btn btn-sm btn-clean btn-icon btn-icon-sm delete-plan" title="Delete Plan">\
                                    <i class="flaticon2-trash"></i>\
                                </a>\
                                <a href="javascript:;" \
                                data-id="' + row.id + '" \
                                data-name="' + row.plan_title + '" \
                                data-description="' + row.plan_description + '" \
                                data-price="' + row.plan_price + '" \
                                data-credits="' + row.plan_credits + '" \
                                class="btn btn-sm btn-clean btn-icon btn-icon-sm edit-plan" title="Edit Plan">\
                                    <i class="flaticon2-edit"></i>\
                                </a>\
                            ';
                        },
                    }],

            });

        $('#newPlan, #editPlan, #deletePlan').on('hidden.bs.modal', function () {
            datatable.reload();
        });
	};

	return {
		// public functions
		init: function() {
            loadPlans();
		},
	};
}();
var KTCrudPlans = function() {
    var createPlan = function() {
        $('#createNewPlan').on('click', function(e) {
            e.preventDefault();

            var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'}),
                error = 'Undefined Error',
                currentModal = $(this).closest('.modal'),
                currentForm = $('#newPlanForm');

            currentForm.validate({
                rules: {
                    plan_title: {
                        required: true,
                    },
                    plan_description: {
                        required: true
                    },
                    plan_price: {
                        required: true
                    },
                    plan_credits: {
                        required: true
                    }
                }
            });

            if (!currentForm.valid()) {
                return;
            }

            loading.show();
            currentForm.ajaxSubmit({
                url: '<?=base_url()?>/rest/admin/plans/create',
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
    var editDeletePlan = function() {
        $('#plansDatatable').on('click', '.delete-plan', function(e) {
            e.preventDefault();

            var planDeleteID = $(this).attr('data-id'),
                planDeleteName = $(this).attr('data-name');

            $('#planDeleteID').val(planDeleteID);
            $('#planDeleteName').text(planDeleteName);
            $('#deletePlan').modal('show');
        });
        $('#plansDatatable').on('click', '.edit-plan', function(e) {
            e.preventDefault();

            var planEditID = $(this).attr('data-id'),
                planEditName = $(this).attr('data-name'),
                planEditDescription = $(this).attr('data-description'),
                planEditPrice = $(this).attr('data-price'),
                planEditCredits = $(this).attr('data-credits');

            $('#planEditID').val(planEditID);
            $('#planEditName').val(planEditName);
            $('#planEditDescription').val(planEditDescription);
            $('#planEditPrice').val(planEditPrice);
            $('#planEditCredits').val(planEditCredits);
            $('#editPlan').modal('show');
        });
        $('#confirmDeletePlan').on('click', function(e) {
            e.preventDefault();

            var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'}),
                error = 'Undefined Error',
                currentModal = $(this).closest('.modal'),
                currentForm = $('#deletePlanForm');
            loading.show();
            currentForm.ajaxSubmit({
                url: '<?=base_url()?>/rest/admin/plans/delete',
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
        $('#confirmEditPlan').on('click', function(e) {
            e.preventDefault();

            var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'}),
                error = 'Undefined Error',
                currentModal = $(this).closest('.modal'),
                currentForm = $('#editPlanForm');
            loading.show();
            currentForm.ajaxSubmit({
                url: '<?=base_url()?>/rest/admin/plans/edit',
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
            createPlan();
            editDeletePlan();
        }
    };
}();

jQuery(document).ready(function() {
    KTDatatablePlans.init();
    KTCrudPlans.init();
});
</script>