$( document ).ready(function() {
    $("#product_form").validate({
    	rules: {
    		name: {
    			required: true
    		},

    		slug: {
    			required: true,
    			// regexp: true
    		},
    		
    		sku: {
    			required: true
    		},
    		
    		moq: {
    			required: true
    		},
    		
    		categories: {
    			required: true
    		},
    		
    		search_keywords: {
    			required: true
    		},
    		
    		price: {
    			required: true
    		},
    		
    		discount_type: {
    			required: true
    		},

    		discount_value: {
    			required: true
    		},
    	},

    	messages: {

    		name: {
    			required: "please input this Name field"
    		},

    		slug: {
    			required: "please input this Slug field",
    		},
    		
    		sku: {
    			required: "please input this Sku field"
    		},
    		
    		moq: {
 	   			required: "please input this Moq field"
    		},
    		
    		categories: {
    			required: "please input this Categories field"
    		},
    		
    		search_keywords: {
    			required: "please input this Search Keywords field"
    		},
    		
    		price: {
    			required: "please input this Price field"
    		},
    		
    		discount_type: {
    			required: "please input this Discount Type field"
    		},

    		discount_value: {
    			required: "please input this Discount Value field"
    		},
    	} 
    })

    // jQuery.validator.addMethod("regexp", function(value,element){
    // 	return this.optional(element) || '/^[a-zA-Z0-9\s]+$/'.test(value);
    // }, "only Allow This a-z A-Z 0-9 - Validate Word");

    $("#name").keyup(function(){
    	var str = $(this).val()
    	var trims = $.trim(str)
    	var slug = trims.replace(/a-z A-Z 0-9 -/, '-').replace(/-+/g, '-').replace(/^-|-$/g, '')
    	$("#slug").val(slug.toLowerCase())
    })

    
let ajaxbtn = document.getElementById('ajaxbtn');
ajaxbtn.addEventListener('click', buttonClickHandler)

function buttonClickHandler() {
    const xhr = new XMLHttpRequest();

    xhr.open('POST', 'api_insert.php', true);
    xhr.getResponseHeader('Content-type', 'application/json');

    xhr.onprogress = function(){
        console.log('On progress');
    }
    xhr.onload = function () {
        if(this.status === 200){

            console.log(this.responseText)
        }
        else{
            console.log("Some error occured")
        }
    }

    // send the request
    params = 'api_insert.php';
    xhr.send(params);
    console.log("We are done!");
}

});


