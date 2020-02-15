<script>
    $(document).ready(function () 
    {
       table = $('#withdrawal_request').DataTable({
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
             "url": "<?php echo BASE_URL?>admin/buy_usd/indexjson",
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                    },
                    "columns": [
                  {
                    "width": 60,
                    "data": "id"
                  },
                  {
                    "width": 130,
                    "data": "name"
                  },
                  {
                    "width": 160,
                    "data": "amount"
                  },
                  {
                    "width": 160,
                    "data": "address"
                  },
                  {
                    "width": 140,
                    "data": "transaction_id",
                  },
                  {
                    "width": 140,
                    "render": function ( data, type, row, meta ) {
                   	if (row.status == 'pending')
                   	{
                   		return "<span class='label label-info'>Pending</span>";
                   	}
                   	else if (row.status == 'in_progress')
                   	{
                   		return "<span class='label label-primary'>In Progress</span>";
                   	}
                    else if (row.status == 'cancel')
                    {
                      return "<span class='label label-danger'>Cancel</span>";
                    }
                    else 
                    {
                      return "<span class='label label-success'>Complete</span>";
                    }
                   }
                  },
                  {
                    "width": 150,
                    "data": "created",
                  },
                   {
                    "width": 30,
                  },
               ] ,
                 "columnDefs": [ {
                    "targets": 7,
                    "data": "download_link",
                    "orderable": false,
                    "render": function ( data, type, row, meta ) {
                      return '<a class="btn btn-sm btn-icon btn-primary" href="<?php echo BASE_URL?>admin/buy_usd/view/'+row.id+'" data-toggle="tooltip" title="View Transaction Details"><i class="fa fa-eye"></i></a>';
                    }
                } ] ,
        });
        $(".dataTables_length").addClass("col-sm-6");
        //confirmation
    });
</script>