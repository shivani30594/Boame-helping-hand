<script>
    $(document).ready(function () 
    {
        $.fn.dataTable.ext.errMode = 'none';
        credited_point_history();
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        var currentTab = $(e.target).text(); // get current tab
        switch (currentTab)   {
           case 'Credited Points' :   //do nothing
              credited_point_history();
              break ;
           case 'Debited Points' :
              debited_point_history();
              break ;
           default: //do nothing 
        };
       }) ; 

      $('#transfer_points_form').validate({
        rules: {
            referral_code : { 
                required :true,
            },
            points : { 
                required :true
            }
        },
        messages: {
            referral_code : {
               required : 'Please enter valid referral code',
            },
            points : {
               required : 'Please choose valid amount',
            }
        }
    });

         $(document).on('change', '#referral_code', function() {
           $.ajax({
            url: "<?php echo BASE_URL?>member/transfer/check_referral_code",
            method: 'post',
            dataType: 'json',
            data: {referral_code : $("#referral_code").val()},
            success: function(response){
              if(response == 0)
              {
                $("#referral_code_error").show();
                $("#referral_code_error_another").hide();
                $("#referral_code").val('');
                $("#referral_code").focus();
              }
              else if(response == 2)
              {
                $("#referral_code_error").hide();
                $("#referral_code_error_another").show();
                $("#referral_code").val('');
                $("#referral_code").focus();
              }
              else
              {
               $("#referral_code_error").hide(); 
              $("#referral_code_error_another").hide();
              }
            }
          });
        });

    });

function credited_point_history()
{
   table1 = $('#credited_points').DataTable({
            "order" : [[1, "desc"]],
            "destroy": true,
           // "bStateSave": true,
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
             "url": "<?php echo BASE_URL?>member/transfer/indexjson",
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
                    "width": 160,
                    "render": function ( data, type, row, meta ) {
                      return row.first_name + ' ' + row.last_name;
                    }
                  },
                   {
                    "width": 160,
                    "data": "transferred_points"
                  },
                  {
                    "width": 160,
                    "render": function ( data, type, row, meta ) {
                      if (row.type == 'ghs')
                      {
                        className = "label-info";
                      }else if(row.type == 'usd')
                      {
                        className = 'label-warning';
                      }
                      else{
                        className = 'label-success';
                      }
                      return "<span class='label " +className+"'>"+(row.type).toUpperCase()+"</span>";
                    }

                  },
                  {
                    "width": 170,
                    "data" : "transfer_date"
                  },
               ] ,
        });
}

function debited_point_history()
{
   table = $('#debited_points').DataTable({
            "order" : [[3, "desc"]],
            "destroy": true,
            //"bStateSave": true,
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
             "url": "<?php echo BASE_URL?>member/transfer/indexjsondebited",
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                    },
            "columns": [
                  {
                    "width": 60,
                    "data": "id",
                  },
                  {
                    "width": 160,
                    "render": function ( data, type, row, meta ) {
                      return row.first_name + ' ' + row.last_name;
                    }
                  },
                   {
                    "width": 160,
                    "data": "transferred_points"
                  },
                  {
                    "width": 160,
                    "render": function ( data, type, row, meta ) {
                      if (row.type == 'ghs')
                      {
                        className = "label-info";
                      }else if(row.type == 'usd')
                      {
                        className = 'label-warning';
                      }
                      else{
                        className = 'label-success';
                      }
                      return "<span class='label " +className+"'>"+(row.type).toUpperCase()+"</span>";
                    }
                  },
                  {
                    "width": 170,
                    "data" : "transfer_date"
                  },
               ] ,
        });
}
</script>