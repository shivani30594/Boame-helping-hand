<script>
    $(document).ready(function () 
    {
      var table = $('#joining_tabel').DataTable({
            "lengthMenu": [[10, 25, 50,100], [10, 25, 50,100]],
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "ajax":{
             "url": "<?php echo BASE_URL?>member/report/joingindexjson",
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
              },
              "columns": [
                  {
                    "width": 60,
                    "data" : "id",
                    "targets" : 0
                  },
                  {
                    "width": 120,
                    "data": "Profile",
                    "render": function (data,type,row,meta) {
                     return "<img src='"+row.picture+"' class='thumb' />";
                    }
                  },
                  {
                    "width": 200,
                    "data": "first_name",
                    "render": function (data,type,row,meta) {
                     return row.first_name + ' ' + row.last_name;
                    }
                  },
                  {
                    "width": 100,
                    "data": "gender",
                    "render": function (data,type,row,meta) {
                     return row.gender == 'Y' ? 'Female' : 'Male';
                    }
                  },
                  {
                    "width": 220,
                    "data": "email"
                  },
                  {
                    "data": "is_active",
                    "width": 100,
                     "render": function (data,type,row,meta) {
                      return row.is_active == 'Y' ? "<span class='label label-success'>Active</span>" : "<span class='label label-danger'>Inactive</span>";
                    }
                  },
                  {
                    "width": 180,
                    "data": "created",
                    "type": "date",
                    "format": "MM/DD/YYYY",
                  }
               ] 
        });
        table.on('order.dt search.dt', function () {
           table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
               cell.innerHTML = i + 1;
           });
        }).draw();

        $(".dataTables_length").addClass("col-sm-6");

    });
</script>