$(document).ready(function() {
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

    jQuery.validator.addMethod("regexp", function(value,element){
     return this.optional(element) || '/^[a-zA-Z0-9\s]+$/'.test(value);
    }, "only Allow This a-z A-Z 0-9 - Validate Word");

    $("#name").keyup(function() {
        var str = $(this).val()
        var trims = $.trim(str)
        var slug = trims.replace(/a-z A-Z 0-9 -/, '-').replace(/-+/g, '-').replace(/^-|-$/g, '')
        $("#slug").val(slug.toLowerCase())
    })

    $("#ajaxbtn").click(function(event) {
        var name = $("#name").val();
        var slug = $("#slug").val();
        var sku = $("#sku").val();
        var moq = $("#moq").val();
        var categories = $("#categories").val();
        var search_keywords = $("#search_keywords").val();
        var price = $("#price").val();
        var discount_type = $("#discount_type").val();
        var discount_value = $("#discount_value").val();

        $.post("api_insert.php", {
            name: name,
            slug: slug,
            sku: sku,
            moq: moq,
            categories: categories,
            search_keywords: search_keywords,
            price: price,
            discount_type: discount_type,
            discount_value: discount_value
        },

        function(data, status) {
            console.log('data', data);
            console.log('status', status);

            if (data[0]?.code == 200) {
                window.location.href = "ecommerce.php";
            } else if (data?.code == 202) {
                alert("please input all field !!");
            }
        });
    });
});