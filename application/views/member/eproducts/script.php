<script>
    $(document).ready(function () 
    {
       $('#activate_referal_plan').validate({
          rules: {
              referral_code : { 
                  required :true
              }
          },
          messages: {
              referral_code : {
                 required : 'Please enter Referral Code',
              }
          }
      });
      
       table = $('#eproducts').DataTable({
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
             "url": "<?php echo BASE_URL?>member/eproducts/indexjson",
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                    },
            "columns": [
                  {
                    "width": 400,
                    "data": "product_name" 
                  },
                  {
                    "width": 200,
                    "data": "product_type" 
                  },
                  {

                  "data": "download_link",
                    "render": function ( data, type, row, meta ) {
                      return '<a target="_blank" href="'+data+'" style="color: #428bca;">'+data+'</a>';
                    }
                
                  }
               ] 
        });
        $(".dataTables_length").addClass("col-sm-6");

    });
</script>