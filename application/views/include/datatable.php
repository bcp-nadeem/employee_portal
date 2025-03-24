<script>
    function initializeDataTable(tableId, ajaxUrl, columns, searchableColumns = [0]) {
    return $(`#${tableId}`).DataTable({
        "processing": false,
        "serverSide": false,
        "ajax": {
            "url": ajaxUrl,
            "type": "POST"
        },
        "columns": columns,
        "order": [[0, 'asc']],
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        "ordering": true, // Enable ordering/sorting
        "language": {
            "search": "Search:",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "emptyTable": "No records found",
            "zeroRecords": "No matching records found",
            "processing": "Loading..."
        },
        "columnDefs": [{
            "targets": 'no-sort',
            "orderable": false
        }],
        "initComplete": function () {
            // Add CSS to make sort icons visible
            $(this).find('thead th').css({
                'position': 'relative',
                'padding-right': '20px'
            });

            var headerRow = $('<tr class="filter-row"></tr>');
            var api = this.api();
            
            // Rest of your initComplete code...
            
            // Add filter header row
            api.columns().every(function (index) {
                var column = this;
                var columnSettings = columns[index];
                var cell = $('<td></td>').appendTo(headerRow);
                
                // Skip if column is marked as non-filterable
                if (columnSettings.filterable === false) {
                    return;
                }
                
                if (searchableColumns.includes(index)) {
                    // Text search input
                    $('<input type="text" class="form-control form-control-sm" placeholder="Search ' + columnSettings.title + '">')
                        .appendTo(cell)
                        .on('keyup change clear', function() {
                            if (column.search() !== this.value) {
                                column.search(this.value).draw();
                            }
                        });
                } else if (columnSettings.filterType === 'date') {
                    // Date range filter
                    var dateInput = $('<input type="date" class="form-control form-control-sm">')
                        .appendTo(cell)
                        .on('change', function() {
                            column.search(this.value).draw();
                        });
                } else if (columnSettings.filterType === 'select2') {
                    // Select2 dropdown
                    var select = $('<select class="form-select form-select-sm select2-filter"><option value="">All</option></select>')
                        .appendTo(cell)
                        .on('change', function() {
                            var val = $(this).val();
                            column.search(val ? val : '', true, false).draw();
                        });
                    
                    // Populate unique values
                    var options = [];
                    column.data().unique().sort().each(function(d) {
                        if (d && d.toString().trim() !== '') {
                            options.push(d);
                        }
                    });
                    
                    options.forEach(function(option) {
                        select.append(new Option(option, option));
                    });
                    
                    // Initialize Select2
                    select.select2({
                        width: '100%',
                        placeholder: 'Select ' + columnSettings.title
                    });
                } else {
                    // Standard dropdown
                    var select = $('<select class="form-select form-select-sm"><option value="">All</option></select>')
                        .appendTo(cell)
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? '^'+val+'$' : '', true, false).draw();
                        });
                    
                    column.data().unique().sort().each(function(d) {
                        if (d && d.toString().trim() !== '') {
                            select.append('<option value="' + d + '">' + d + '</option>');
                        }
                    });
                }
            });
            
            $(api.table().header()).after(headerRow);
        }
    });
}

// Usage Example for Employee Table
// $(document).ready(function() {
// const employeeColumns = [
//     { "data": 0, "title": "Employee Name", "filterType": "text" },
//     { "data": 1, "title": "Email", "filterType": "select" },
//     { "data": 2, "title": "Level", "filterType": "select" }, 
//     { "data": 3, "title": "Designation", "filterType": "select" },
//     { "data": 4, "title": "Date", "filterType": "date" },
//     { "data": 5, "title": "Status", "filterType": "select" },
//     { "data": 6, "title": "Actions", "orderable": false, "filterable": false }
// ];

const employeeTable = initializeDataTable(
    '<?php echo $table_name; ?>', 
    '<?php echo base_url($function_url); ?>', 
    <?php echo json_encode($columns);?>,
    [0] // Only Employee Name will have text search
);
// Section Table

// $(document).ready(function() {
// const employeeColumns = [
//     { "data": 0, "title": "Section Name", "filterType": "text" },
//     { "data": 1, "title": "Spectrum", "filterType": "select" },
//     { "data": 2, "title": "Post Date", "filterType": "select" },
//     { "data": 3, "title": "Last Changes", "filterType": "select" },
//     { "data": 4, "title": "Actions", "orderable": false, "filterable": false }
// ];

// const employeeTable = initializeDataTable(
//     'section_table', 
//     '<?php //echo base_url('admin/AM_Controller/getSectionRecords'); ?>', 
//     employeeColumns,
//     [0] // Only Employee Name will have text search
// );


    // Add custom styling for the filters
    $('head').append(`
        <style>
            .dataTables_wrapper .filter-row {
                background-color: #f8f9fa;
            }
            .dataTables_wrapper .filter-row input,
            .dataTables_wrapper .filter-row select {
                width: 100%;
                padding: 4px;
                margin-top: 5px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }
            .dataTables_wrapper .filter-row td {
                padding: 8px;
            }
            .dataTables_wrapper thead th {
                position: relative;
                padding-right: 20px !important;
            }
            .dataTables_wrapper thead .sorting:before,
            .dataTables_wrapper thead .sorting:after,
            .dataTables_wrapper thead .sorting_asc:before,
            .dataTables_wrapper thead .sorting_desc:after {
                position: absolute;
                right: 5px;
                opacity: 0.5;
            }
        </style>
    `);


</script>
</body>
</html>