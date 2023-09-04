$(document).ready(function(){
    //check admin password is correct or not correct
    $("#current_password").keyup(function(){
        var current_password = $("#current_password").val();
        //alert(current_password);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type:'post',
            url:'/admin/check-admin-password',
            data:{current_password:current_password},
            success:function(resp){
                if(resp=="false"){
                    $("#check_password").html("<font color='red'>Mật khẩu không chính xác !</font>");
                }else if(resp=="true"){
                    $("#check_password").html("<font color='green'>Mật khẩu chính xác !</font>");
                }
            },error:function(){
                alert('Error');
            }

        });
    })
});