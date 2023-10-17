$(document).ready(function(){
//call database
    $('#sections').DataTable();
    $('#categories').DataTable();
    $('#brands').DataTable();
    $('#products').DataTable();
    $('#banners').DataTable();
    $('#filters').DataTable();
    $('#coupons').DataTable();
    $('#users').DataTable();
    $('#pages').DataTable();
    $('#orders').DataTable();
    $('#ratings').DataTable();

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

    //update banner status
    $(document).on("click",".updateBannerStatus",function(){
        var status = $(this).children("i").attr("status");
        var banner_id =$(this).attr("banner_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: 'post',
            url: '/admin/update-banner-status',
            data: { status:status,banner_id: banner_id },
            success: function (resp) {
                //alert(resp);
                if(resp['status']==0){
                    $("#banner-"+banner_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }else if(resp['status']==1){
                    $("#banner-"+banner_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
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

    //update rating status
    $(document).on("click",".updateRatingStatus",function(){
        var status = $(this).children("i").attr("status");
        var rating_id =$(this).attr("rating_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: 'post',
            url: '/admin/update-rating-status',
            data: { status:status,rating_id:rating_id },
            success: function (resp) {
                //alert(resp);
                if(resp['status']==0){
                    $("#rating-"+rating_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }else if(resp['status']==1){
                    $("#rating-"+rating_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");
            }
        });
    });

    //update user status
    $(document).on("click",".updateUserStatus",function(){
        var status = $(this).children("i").attr("status");
        var user_id =$(this).attr("user_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: 'post',
            url: '/admin/update-user-status',
            data: { status:status,user_id:user_id },
            success: function (resp) {
                //alert(resp);
                if(resp['status']==0){
                    $("#user-"+user_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }else if(resp['status']==1){
                    $("#user-"+user_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
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

    //update Coupon status
    $(document).on("click",".updateCouponStatus",function(){
        var status = $(this).children("i").attr("status");
        var coupon_id =$(this).attr("coupon_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: 'post',
            url: '/admin/update-coupon-status',
            data: { status:status,coupon_id:coupon_id },
            success: function (resp) {
                //alert(resp);
                if(resp['status']==0){
                    $("#coupon-"+coupon_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }else if(resp['status']==1){
                    $("#coupon-"+coupon_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");
            }
        });
    });

    //update filter status
    $(document).on("click",".updateFilterStatus",function(){
        var status = $(this).children("i").attr("status");
        var filter_id =$(this).attr("filter_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: 'post',
            url: '/admin/update-filter-status',
            data: { status:status,filter_id:filter_id },
            success: function (resp) {
                //alert(resp);
                if(resp['status']==0){
                    $("#filter-"+filter_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }else if(resp['status']==1){
                    $("#filter-"+filter_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");
            }
        });
    });

    //update filter-values status
    $(document).on("click",".updateFilterValueStatus",function(){
        var status = $(this).children("i").attr("status");
        var filter_id =$(this).attr("filter_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: 'post',
            url: '/admin/update-filter-value-status',
            data: { status:status,filter_id:filter_id },
            success: function (resp) {
                //alert(resp);
                if(resp['status']==0){
                    $("#filter-"+filter_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }else if(resp['status']==1){
                    $("#filter-"+filter_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");
            }
        });
    });

    //update attribute status
    $(document).on("click",".updateAttributeStatus",function(){
        var status = $(this).children("i").attr("status");
        var attribute_id =$(this).attr("attribute_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: 'post',
            url: '/admin/update-attribute-status',
            data: { status:status,attribute_id:attribute_id },
            success: function (resp) {
                //alert(resp);
                if(resp['status']==0){
                    $("#attribute-"+attribute_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }else if(resp['status']==1){
                    $("#attribute-"+attribute_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");
            }
        });
    });

    //update image status
    $(document).on("click",".updateImageStatus",function(){
        var status = $(this).children("i").attr("status");
        var image_id =$(this).attr("image_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: 'post',
            url: '/admin/update-image-status',
            data: { status:status,image_id:image_id },
            success: function (resp) {
                //alert(resp);
                if(resp['status']==0){
                    $("#image-"+image_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }else if(resp['status']==1){
                    $("#image-"+image_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");
            }
        });
    });
   
    //confirm delete
    $(document).on("click",".confirmDelete",function(){
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

    //show filter on selection
    $("#category_id").on('change',function(){
        var category_id =$(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type:'post',
            url:'category-filters',
            data:{category_id:category_id},
            success:function(resp){
                $(".loadFilters").html(resp.view);
            }
        });
    });

    //show hide coupon feild
    $("#ManualCoupon").click(function(){
        $("#couponField").show();
    });
    $("#AutomaticCoupon").click(function(){
        $("#couponField").hide();
    });

    //show dvvc va mvd
    $("#courier_name").hide();
    $("#tracking_number").hide();
    $("#order_status").on("change",function(){
        if(this.value=="Shipped"){
            $("#courier_name").show();
            $("#tracking_number").show();
        }else{
            $("#courier_name").hide();
            $("#tracking_number").hide();
        }
    });

    

    
});