<script>
    function getReceipaint(id) {
        emptyddl('receipient_id');
        $("#receipient_id").append('<option value="">-লোড হচ্ছে-</option>');
        if(id != ''){
            $.ajax({
                url:'{{ route('report/getRecipaint') }}',
                type: "post",
                data: {'id':id, '_token':$('meta[name=csrf-token]').attr("content")},
                dataType: "html",
                success: function(data){
                    let users = JSON.parse(data)
                    if (users.length == 0){
                        emptyddl('receipient_id');
                        none('receipient_id');
                    }else{
                        emptyddl('receipient_id');
                        $("#receipient_id").append('<option value="">-সব-</option>');
                        $.each(users, function (i, user) {
                            $("#receipient_id").append('<option value="' + user.user_id + '">' + user.name + '</option>');
                        });
                    }
                },
                error: function (ex) {
                    emptyddl('receipient_id');
                    none('receipient_id');
                    alert('গ্রুপ পুনরুদ্ধার করতে ব্যর্থ হয়েছে : ' + ex);
                }
            });
        }else{
            emptyddl('receipient_id');
            none('receipient_id');
        }
    }

    function getForwardUser(id) {
        emptyddl('forward');
        $("#forward").append('<option value="">-লোড হচ্ছে-</option>');
        if(id != ''){
            $.ajax({
                url:'{{ route('report/getForwardUser') }}',
                type: "post",
                data: {'id':id, '_token':$('meta[name=csrf-token]').attr("content")},
                dataType: "html",
                success: function(data){
                    let users = JSON.parse(data)
                    if (users.length == 0){
                        emptyddl('forward');
                        none('forward');
                    }else{
                        emptyddl('forward');
                        $("#forward").append('<option value="">-সব-</option>');
                        $.each(users, function (i, user) {
                            $("#forward").append('<option value="' + user.permitted_user_id + '">' + user.name + '</option>');
                        });
                    }
                },
                error: function (ex) {
                    emptyddl('forward');
                    none('forward');
                    alert('গ্রুপ পুনরুদ্ধার করতে ব্যর্থ হয়েছে : ' + ex);
                }
            });
        }else{
            emptyddl('forward');
            none('forward');
        }
    }

    function getUserInfo(value, designation, address) {
        if(value != ''){
            $.ajax({
                url:'{{ route('user/Info') }}',
                type: "post",
                data: {'id':value, '_token':$('meta[name=csrf-token]').attr("content")},
                dataType: "html",
                success: function(data){
                    let user = JSON.parse(data)
                    $('#'+designation).val(user.designation);
                    $('#'+address).val(user.address);
                },
                error: function (ex) {
                    alert('গ্রুপ পুনরুদ্ধার করতে ব্যর্থ হয়েছে: ' + ex);
                }
            });
        }else{
            $('#'+designation).val('');
            $('#'+address).val('');
        }
    }

    function emptyddl(id) {
        $("#"+id).empty();
    }

    function none(id) {
        $("#" + id).append('<option value="">-নাই-</option>');
    }
</script>
