$(document).ready(function(){
	$("#getPrice").change(function(){
		var size = $(this).val();
		var product_id = $(this).attr("product-id");
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			url:'/get-product-price',
			data:{size:size,product_id:product_id},
			type:'post',
			success:function(resp){
				
				if (resp['discount'] > 0) {
                    var finalPrice = resp['final_price'].toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                    var productPrice = resp['product_price'].toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                    
                    $(".getAttributePrice").html("<div class='price'><h4>" + finalPrice + "</h4></div><div class='original-price'><span>Original Price: </span><span>" + productPrice + "</span></div>");
                } else {
                    var finalPrice = resp['final_price'].toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                    
                    $(".getAttributePrice").html("<div class='price'><h4>" + finalPrice + "</h4></div>");
                }
                
			},error:function(){
				alert("Error");
			}
		});
	});

	// Update Cart Items Qty
	$(document).on('click','.updateCartItem',function(){
		if($(this).hasClass('plus-a')){
			// Get Qty
			var quantity = $(this).data('qty');
			// increase the qty by 1
			new_qty = parseInt(quantity) + 1;
			/*alert(new_qty);*/
		}
		if($(this).hasClass('minus-a')){
			// Get Qty
			var quantity = $(this).data('qty');
			// Check Qty is atleast 1
			if(quantity<=1){
				alert("Item quantity must be 1 or greater!");
				return false;
			}
			// increase the qty by 1
			new_qty = parseInt(quantity) - 1;
			/*alert(new_qty);*/
		}
		var cartid = $(this).data('cartid');
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			data:{cartid:cartid,qty:new_qty},
			url:'/cart/update',
			type:'post',
			success:function(resp){
				$(".totalCartItems").html(resp.totalCartItems);
				if(resp.status==false){
					alert(resp.message);
				}
				$("#appendCartItems").html(resp.view);
				$("#appendHeaderCartItems").html(resp.headerview);
			},error:function(){
				alert("Error");
			}
		});
	});

	// delete Cart Items Qty
	$(document).on('click','.deleteCartItem',function(){
		var cartid =$(this).data('cartid');
		var result = confirm("Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng ?");
		if(result){
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data:{cartid:cartid},
				url:'/cart/delete',
				type:'post',
				success:function(resp){
					$(".totalCartItems").html(resp.totalCartItems);
					$("#appendCartItems").html(resp.view);
					$("#appendHeaderCartItems").html(resp.headerview);
				},error:function(){
					alert("Error");
				}
			})
		}
		
	});

	//register form
	$("#registerForm").submit(function(){
		$(".loader").show();
		var formdata =$(this).serialize();
		$.ajax({
			url:"/user/register",
			type:"post",
			data:formdata,
			success:function(resp){
		
				if(resp.type=="error"){
					$(".loader").hide();
					$.each(resp.errors,function(i,error){
						$("#register-"+i).attr('style','color:red');
						$("#register-"+i).html(error);
					
					setTimeout(function(){
						$("#register-"+i).css({'display':'none'});
					},3000);
				});
				}else if(resp.type=="success"){
					// alert(resp.message);
					$(".loader").hide();
					$("#register-success").attr('style','color:green');
					$("#register-success").html('Đăng kí tài khoản thành công !');
		
				}
				
			},error:function(){
				alert("Error");
			}
		})
	});

	//account form
	$("#accountForm").submit(function(){
		$(".loader").show();
		var formdata =$(this).serialize();
		$.ajax({
			url:"/user/account",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$(".loader").hide();
					$.each(resp.errors,function(i,error){
						$("#account-"+i).attr('style','color:red');
						$("#account-"+i).html(error);
					setTimeout(function(){
						$("#account-"+i).css({'display':'none'});
					},3000);
				});
				}else if(resp.type=="success"){
					// alert(resp.message);
					$(".loader").hide();
					$("#account-success").attr('style','color:green');
					$("#account-success").html(resp.message);
					setTimeout(function(){
						$("#account-success").css({'display':'none'});
					},3000);
		
				}
				
			},error:function(){
				alert("Error");
			}
		})
	});

	//password form
	$("#passwordForm").submit(function(){
		$(".loader").show();
		var formdata =$(this).serialize();
		$.ajax({
			url:"/user/update-password",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$(".loader").hide();
					$.each(resp.errors,function(i,error){
						$("#password-"+i).attr('style','color:red');
						$("#password-"+i).html(error);
					setTimeout(function(){
						$("#password-"+i).css({'display':'none'});
					},3000);
				});
				}else if(resp.type=="incorrect"){
					$(".loader").hide();
						$("#password-error").attr('style','color:red');
						$("#password-error").html(resp.message);
					setTimeout(function(){
						$("#password-error").css({'display':'none'});
					},3000);
		
				}else if(resp.type=="success"){
					// alert(resp.message);
					$(".loader").hide();
					$("#password-success").attr('style','color:green');
					$("#password-success").html(resp.message);
					setTimeout(function(){
						$("#password-success").css({'display':'none'});
					},3000);
		
				}
				
			},error:function(){
				alert("Error");
			}
		})
	});

	//login form
	$("#loginForm").submit(function(){
		var formdata =$(this).serialize();
		$.ajax({
			url:"/user/login",
			type:"post",
			data:formdata,
			success:function(resp){
		
				if(resp.type=="error"){
					$.each(resp.errors,function(i,error){
						$("#login-"+i).attr('style','color:red');
						$("#login-"+i).html(error);
					
					setTimeout(function(){
						$("#login-"+i).css({'display':'none'});
					},3000);
				});
				}else if(resp.type=="incorrect"){
					// alert(resp.message);
					$("#login-error").attr('style','color:red');
					$("#login-error").html(resp.message);
				}else if(resp.type=="inactive"){
					// alert(resp.message);
					$("#login-error").attr('style','color:red');
					$("#login-error").html(resp.message);
				}else if(resp.type=="success"){
					window.location.href =resp.url;
				}
				
			},error:function(){
				alert("Error");
			}
		})
	});

		//apply coupon
		$("#ApplyCoupon").submit(function(){
			var user =$(this).attr("user");
			if(user==1){

			}else{
				alert("Vui lòng đăng nhập để áp dụng Coupon");
				return false;
			}
			var code =$("#code").val();
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type:'post',
				data:{code:code},
				url:'/apply-coupon',
				success:function(resp){
					if(resp.message!=""){
						alert(resp.message);
					}
					$(".totalCartItems").html(resp.totalCartItems);
					$("#appendCartItems").html(resp.view);
					$("#appendHeaderCartItems").html(resp.headerview);
					if(resp.couponAmount>0){
						$(".couponAmount").text(resp.couponAmount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));
					}else{
						$(".couponAmount").text("O ₫");
					}
					if(resp.grand_total>0){
						$(".grand_total").text(resp.grand_total.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));
					}
				},error:function(){
					alert("Error");
				}
			})
	});

	//edit address
	$(document).on('click','.editAddress',function(){
		var addressid = $(this).data("addressid");
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data:{addressid:addressid},
			url:'/get-delivery-address',
			type:'post',
			success:function(resp){
				$("#showdifferent").removeClass("collapse");
				$(".newAddress").hide();
				$(".deliveryText").text("Sửa địa chỉ giao hàng");
				$('[name=delivery_id]').val(resp.address['id']);
				$('[name=delivery_name]').val(resp.address['name']);
				$('[name=delivery_address]').val(resp.address['address']);
				$('[name=delivery_state]').val(resp.address['state']);
				$('[name=delivery_city]').val(resp.address['city']);
				$('[name=delivery_country]').val(resp.address['country']);
				$('[name=delivery_zipcode]').val(resp.address['zipcode']);
				$('[name=delivery_mobile]').val(resp.address['mobile']);
			},error:function(){
				alert("Error");
			}
		});
	});

	//save delivery funcion
	$(document).on('submit','#addressAddEditForm',function(){
		var formdata = $("#addressAddEditForm").serialize();
		$.ajax({
			url:'/save-delivery-address',
			type:'post',
			data:formdata,
			success:function(resp){
				$("#deliveryAddresses").html(resp.view);
				window.location.href ="checkout";
			},error:function(){
				alert("Error");
			}
		});
	})

	//remove delivery
	$(document).on('click','.removeAddress',function(){
		if(confirm("Bạn có chắc muốn xóa ?")){
			var addressid = $(this).data("addressid");
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url:'/remove-delivery-address',
				type:'post',
				data:{addressid:addressid},
				success:function(resp){
					$("#deliveryAddresses").html(resp.view);
					window.location.href ="checkout";
				},error:function(){
					alert("Error");
				}
			});
		}
	});


});



function get_filter(class_name){
    var filter =[];
    $('.'+class_name+':checked').each(function(){
        filter.push($(this).val());
    });
    return filter;
}