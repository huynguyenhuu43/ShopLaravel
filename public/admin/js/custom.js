$(document).ready(function(){
//call database
    $('#sections').DataTable();
    $('#categories').DataTable();
    $('#brands').DataTable();
    $('#products').DataTable();
   $(".nav-item").removeClass("active");
   $(".nav-link").removeClass("active");
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
    //update admin status
    $(document).on("click",".updateAdminStatus",function(){
        var status = $(this).children("i").attr("status");
        var admin_id =$(this).attr("admin_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: 'post',
            url: '/admin/update-admin-status',
            data: { status:status,admin_id: admin_id },
            success: function (resp) {
                //alert(resp);
                if(resp['status']==0){
                    $("#admin-"+admin_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }else if(resp['status']==1){
                    $("#admin-"+admin_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");
            }
        });
    });
    
    //update sections status
    $(document).on("click",".updateSectionStatus",function(){
        var status = $(this).children("i").attr("status");
        var section_id =$(this).attr("section_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: 'post',
            url: '/admin/update-section-status',
            data: { status:status,section_id: section_id },
            success: function (resp) {
                //alert(resp);
                if(resp['status']==0){
                    $("#section-"+section_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }else if(resp['status']==1){
                    $("#section-"+section_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");
            }
        });
    });

    //update category status
    $(document).on("click",".updateCategoryStatus",function(){
        var status = $(this).children("i").attr("status");
        var category_id =$(this).attr("category_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: 'post',
            url: '/admin/update-category-status',
            data: { status:status,category_id: category_id },
            success: function (resp) {
                //alert(resp);
                if(resp['status']==0){
                    $("#category-"+category_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }else if(resp['status']==1){
                    $("#category-"+category_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");
            }
        });
    });

    //update brand status
    $(document).on("click",".updateBrandStatus",function(){
        var status = $(this).children("i").attr("status");
        var brand_id =$(this).attr("brand_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: 'post',
            url: '/admin/update-brand-status',
            data: { status:status,brand_id:brand_id },
            success: function (resp) {
                //alert(resp);
                if(resp['status']==0){
                    $("#brand-"+brand_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }else if(resp['status']==1){
                    $("#brand-"+brand_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");
            }
        });
    });

    //update Product status
    $(document).on("click",".updateProductStatus",function(){
        var status = $(this).children("i").attr("status");
        var product_id =$(this).attr("product_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: 'post',
            url: '/admin/update-product-status',
            data: { status:status,product_id:product_id },
            success: function (resp) {
                //alert(resp);
                if(resp['status']==0){
                    $("#product-"+product_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }else if(resp['status']==1){
                    $("#product-"+product_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");
            }
        });
    });
   
    //confirm delete
    $(".confirmDelete").click(function(){
        var module =$(this).attr('module');
        var moduleid =$(this).attr('moduleid');
        Swal.fire({
            title: 'Bạn chắc chứ?',
            text: "Bạn không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Vâng, xóa nó!'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Xóa!',
                'Thành phần đã được xóa.',
                'Thành công'
              )
              window.location = "/admin/delete-"+module+"/"+moduleid;
            }
          })
    })

    //append category level
    $("#section_id").change (function(){
            var section_id = $(this).val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
            type:'get',
            url:'/admin/append-categories-level',
            data:{section_id:section_id},
            success: function(resp) {
                $("#appendCategoriesLevel").html(resp);
            }, error:function(){
            alert("Error");
            }
        })
    });
    
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><div style="height:10px;"></div><input type="text" name="size[]" placeholder="Size" style="width: 100px;" />&nbsp;<input type="text" name="sku[]" placeholder="SKU" style="width: 100px;" />&nbsp;<input type="text" name="price[]" placeholder="Giá" style="width: 100px;" />&nbsp;<input type="text" name="stock[]" placeholder="Stock" style="width: 100px;" />&nbsp;<a href="javascript:void(0);" class="remove_button">Xóa</a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    // Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increase field counter
            $(wrapper).append(fieldHTML); //Add field html
        }else{
            alert('A maximum of '+maxField+' fields are allowed to be added. ');
        }
    });
    
    // Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrease field counter
    });
});