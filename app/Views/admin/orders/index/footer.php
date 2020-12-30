<script>
var KTDatatableOrders = function() {
	var loadOrders = function() {

        var datatable = $('.kt-datatable').KTDatatable({
                // datasource definition
                data: {
                    type: 'remote',
                    source: {
                        read: {
                            method: 'GET',
                            url: '<?=base_url()?>/rest/admin/orders/get',
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
                        field: 'created_at',
                        title: 'Date',
                    }, {
                        field: 'user_name',
                        title: 'Customer Name',
                    }, {
                        field: 'user_email',
                        title: 'Customer Email',
                    }, {
                        field: 'plan_title',
                        title: 'Package',
                    }, {
                        field: 'plan_price',
                        title: 'Price',
                    }, {
                        field: 'transaction_id',
                        title: '# Transaction',
                    }],

            });

        $('#newPlan, #editPlan, #deletePlan').on('hidden.bs.modal', function () {
            datatable.reload();
        });
	};

	return {
		// public functions
		init: function() {
            loadOrders();
		},
	};
}();

jQuery(document).ready(function() {
    KTDatatableOrders.init();
});
</script>