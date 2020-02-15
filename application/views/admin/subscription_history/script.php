<script>
$(document).ready(function () 
{
    table = $('#sub_history').DataTable({
        "bStateSave": true,
        "fnStateSave": function (oSettings, oData) {
        localStorage.setItem('offersDataTables', JSON.stringify(oData));
        },
        "fnStateLoad": function (oSettings) {
        return JSON.parse(localStorage.getItem('offersDataTables'));
        },
        "lengthMenu": [[10, 25, 50,100], [10, 25, 50,100]],
        "processing": true,
        "serverSide": true,
        "pagingType": "full_numbers",
        "ajax":{
            "url": "<?php echo BASE_URL?>admin/Subscription/history_indexjson",
            "dataType": "json",
            "type": "POST",
            "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                },
        "columns": [
            {
                "width": 140,
                "data": "name" 
            },
            {
                "width": 100,
                "data": "plan_name" 
            },
            {
                "width": 220,
                "render": function ( data, type, row, meta ) {
                      return row.plan_description.substring(0,100);
                }
            },
            {
                "width": 140,
                "data": "plan_price" 
            },
            {
                "width": 180,
                "render": function ( data, type, row, meta ) {
                     if (row.payment_mode == 'using_bpoints')
                     {
                         return '<span class="label label-success">Using bPoints</span>';
                     }
                     else
                     {
                        return '<span class="label label-info">Pay Online</span>';
                     }
                }
            },
            {
                "width": 70,
                "data": "address" 
            },
            {
                "width": 120,
                "data": "status" 
            },
            {
                "width": 200,
                "data": "start_date" 
            },
            {
                "width": 200,
                "data": "end_date" 
            },
        ] 
        });
        $(".dataTables_length").addClass("col-sm-6");
});
</script>