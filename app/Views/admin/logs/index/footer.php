<script>
var KTDatatableLogs = function() {
	var loadLogs = function() {

        var datatable = $('.kt-datatable').KTDatatable({
                // datasource definition
                data: {
                    type: 'remote',
                    source: {
                        read: {
                            method: 'GET',
                            url: '<?=base_url()?>/rest/admin/logs/get',
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
                        field: 'log_type',
                        title: 'Type',
                    }, {
                        field: 'log_details',
                        title: 'Details',
                        template: function(row) {
                            var returnHtml = '<ul style="margin:0;padding:0;list-style:none;">';
                            $.each(row.log_details, function(i, v) {
                                returnHtml += '<li><strong>' + i + '</strong>: ' + v + '</li>';
                            });
                            returnHtml += '</ul>';

                            return returnHtml;
                        }
                    }],

            });

        $('#logDetails').on('hidden.bs.modal', function () {
            datatable.reload();
        });
	};

	return {
		// public functions
		init: function() {
            loadLogs();
		},
	};
}();

jQuery(document).ready(function() {
    KTDatatableLogs.init();
});
</script>