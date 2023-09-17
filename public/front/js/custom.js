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
});

function get_filter(class_name){
    var filter =[];
    $('.'+class_name+':checked').each(function(){
        filter.push($(this).val());
    });
    return filter;
}