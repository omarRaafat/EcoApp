/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Ecommerce product create Js File
*/

// ckeditor
itemid = 13;
ClassicEditor
    .create(document.querySelector('#ckeditor-classic_ar'))
    .then(function (editor) {
        editor.ui.view.editable.element.style.height = '150px';
    })
    .catch(function (error) {
        console.error(error);
    });
ClassicEditor
    .create(document.querySelector('#ckeditor-classic_en'))
    .then(function (editor) {
        editor.ui.view.editable.element.style.height = '150px';
    })
    .catch(function (error) {
        console.error(error);
    });

    ClassicEditor
    .create(document.querySelector('#ckeditor-classic_fr'))
    .then(function (editor) {
        editor.ui.view.editable.element.style.height = '150px';
    })
    .catch(function (error) {
        console.error(error);
    });
    ClassicEditor
    .create(document.querySelector('#ckeditor-classic_gr'))
    .then(function (editor) {
        editor.ui.view.editable.element.style.height = '150px';
    })
    .catch(function (error) {
        console.error(error);
    });

    ClassicEditor
    .create(document.querySelector('#ckeditor-classic_id'))
    .then(function (editor) {
        editor.ui.view.editable.element.style.height = '150px';
    })
    .catch(function (error) {
        console.error(error);
    });
// Dropzone
var productImages_ids=[];
var dropzonePreviewNode = document.querySelector("#dropzone-preview-list");
dropzonePreviewNode.itemid = "";
var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);
var dropzone = new Dropzone(".dropzone", {
    url: '/vendor/upload-image',
    method: "POST",
    previewTemplate: previewTemplate,
    previewsContainer: "#dropzone-preview",
    init: function() {
        this.on("addedfile", function(file) {
            $('button[type="submit"]').attr('disabled', true).text('يرجى الإنتظار...');
        });
        this.on("queuecomplete", function () {
            // Re-enable the submit button and change its text to 'حفظ' (Save)
            $('button[type="submit"]').attr('disabled', false).text('حفظ');
        });
    },
    success: function(file, response){
        document.getElementById("dropzone-preview-error").innerText = ""
        document.getElementById("dropzone-preview-error").style.display = "none"
        productImages_ids.push(response)
        $('#images-hidden').val(productImages_ids.toString())
        console.log(productImages_ids)
    },
    error: function (file, response) {
        file.previewElement.remove()
        document.getElementById("dropzone-preview-error").innerText = response.message
        document.getElementById("dropzone-preview-error").style.display = "block"
    },
    removedfile: function(file) {
        const deletedImages = $('#deleted-images-hidden').val().replace(/^,+/g, '').split(',');
        //add to array 
        deletedImages.push(file.id);

        file.previewElement.remove();
        $('#images-hidden').val(productImages_ids.toString())
        $('#deleted-images-hidden').val(deletedImages.toString().replace(/^,+/g, ''));    
    }

});



// Form Event
(function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // date & time
    var date = new Date().toUTCString().slice(5, 16);
    function currentTime() {
        var ampm = new Date().getHours() >= 12 ? "PM" : "AM";
        var hour =
            new Date().getHours() > 12
                ? new Date().getHours() % 12
                : new Date().getHours();
        var minute =
            new Date().getMinutes() < 10
                ? "0" + new Date().getMinutes()
                : new Date().getMinutes();
        if (hour < 10) {
            return "0" + hour + ":" + minute + " " + ampm;
        } else {
            return hour + ":" + minute + " " + ampm;
        }
    }
    setInterval(currentTime, 1000);

      // product image
      document.querySelector("#product-image-input").addEventListener("change", function () {
        var preview = document.querySelector("#product-img");
        var file = document.querySelector("#product-image-input").files[0];

        var img = new Image();
        var objectUrl = URL.createObjectURL(file)
        img.onload = function () {
            if (this.height < 800){
                document.getElementById("main-image-preview-error").innerText = 'لابد أن يكون اقل طول للصورة 800 بيكسل'
                document.getElementById("main-image-preview-error").style.display = "block"
            }
            else if(this.width < 800){
                document.getElementById("main-image-preview-error").innerText = 'لابد أن يكون اقل عرض للصورة 800 بيكسل'
                document.getElementById("main-image-preview-error").style.display = "block"

            }else {
                document.getElementById("main-image-preview-error").innerText = ""
                document.getElementById("main-image-preview-error").style.display = "none"

                var reader = new FileReader();
                reader.addEventListener("load",function () {
                    preview.src = reader.result;
                },false);
            if (file) {
                    reader.readAsDataURL(file);
            }
            }
        }
        img.src = objectUrl
    });



    // choices category input
    // var prdoctCategoryInput = new Choices('#choices-category-input', {
    //     searchEnabled: false,
    // });

    var editinputValueJson = sessionStorage.getItem('editInputValue');
    if (editinputValueJson) {
        var editinputValueJson = JSON.parse(editinputValueJson);
        document.getElementById("formAction").value = "edit";
        document.getElementById("product-id-input").value = editinputValueJson.id;
        document.getElementById("product-img").src = editinputValueJson.product.img;
        document.getElementById("product-title-input").value = editinputValueJson.product.title;
        document.getElementById("stocks-input").value = editinputValueJson.stock;
        document.getElementById("product-price-input").value = editinputValueJson.price;
        document.getElementById("orders-input").value = editinputValueJson.orders;
        // prdoctCategoryInput.setChoiceByValue(editinputValueJson.product.category);
    }


 // Loop over them and prevent submission
 Array.prototype.slice.call(forms)
 .forEach(function (form) {
     form.addEventListener('submit', function (event) {
         $('#desc-hidden').val($('.ck-editor__editable_inline').html())
         $('#desc-hiddens_ar').val($('.card-ar .ck-editor__editable_inline').html())
         $('#desc-hiddens_en').val($('.card-en .ck-editor__editable_inline').html())
         $('#desc-hiddens_fr').val($('.card-fr .ck-editor__editable_inline').html())
         $('#desc-hiddens_gr').val($('.card-gr .ck-editor__editable_inline').html())
         $('#desc-hiddens_id').val($('.card-id .ck-editor__editable_inline').html())
         if (!form.checkValidity()) {
             event.preventDefault();
             event.stopPropagation();
         } else {
             //event.preventDefault();

             itemid++;
             // var productItemID = itemid;
             // // var productTitleValue = document.getElementById("product-title-input").value;
             // var prdoctCategoryValue = prdoctCategoryInput.getValue(true);
             // var stockInputValue = document.getElementById("stocks-input").value;
             // var orderValue = document.getElementById("orders-input").value;
             // var productPriceValue = document.getElementById("product-price-input").value;
             // var productImageValue = document.getElementById("product-img").src;
             // var main_category_id=$('#main-choices-publish-status-input').val();
             // var sub_category_id=$('#sub-choices-publish-status-input').val();
             // var final_category_id=$('#final-choices-publish-status-input').val();
             // var net_weight=$('#net-weight').val()
             // var net_weight=$('#length').val()
             // var net_weight=$('#width').val()
             // var net_weight=$('#height').val()
             var form_data=$(this).serialize();
             console.log($(this).serialize())
             console.log($(this).serializeArray())
             console.log(JSON.stringify($(this).serializeArray()))
             console.log(productImages_ids)




             var formAction = document.getElementById("formAction").value;
             console.log(formAction)
             if (formAction == "add") {
                 var inputValueJson = [];
                 var newObj = {
                     //"id": productItemID,
                     // "product": {
                     //     "img": productImageValue,
                     //     "title": productTitleValue,
                     //     "category": prdoctCategoryValue
                     // },
                     // "stock": stockInputValue,
                     // "price": productPriceValue,
                     // "orders": orderValue,
                     // "rating": "--",
                     // "main_category_id":main_category_id,
                     // "sub_category_id":sub_category_id,
                     // "final_category_id":final_category_id,
                     // "image_ids":productImages_ids,
                 };
                 storeProduct(form_data);

             } else if (formAction == "edit") {
                 var editproductId = document.getElementById("product-id-input").value;
                 if (sessionStorage.getItem('editInputValue')) {
                     var editObj = {
                         "id": parseInt(editproductId),
                         "product": {
                             "img": productImageValue,
                             "title": productTitleValue,
                             "category": prdoctCategoryValue
                         },
                         "stock": stockInputValue,
                         "price": productPriceValue,
                         "orders": orderValue,
                         "rating": editinputValueJson.rating,
                     };
                     sessionStorage.setItem('editInputValue', JSON.stringify(editObj));
                 }
             } else {
                 console.log('Form Action Not Found.');
             }
             // window.location.replace("apps-ecommerce-products.html");
             return false;
         }

         form.classList.add('was-validated');

     }, false)
 })
})()


function storeProduct(data) {
    console.log(data)
    $.get('/vendor/products' + data, (response) => {

    })
}
