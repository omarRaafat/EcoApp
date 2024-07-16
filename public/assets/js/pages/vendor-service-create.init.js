document.addEventListener('DOMContentLoaded', function() {

    let editors = [
        'desc-ckeditor-classic_ar',
        'desc-ckeditor-classic_en',
        'conditions-ckeditor-classic_ar',
        'conditions-ckeditor-classic_en'
    ];

    let editorInstances = {};

    editors.forEach(function(selector) {
        let element = document.getElementById(selector);
        if (element) {
            ClassicEditor
                .create(element)
                .then(function(editor) {
                    editorInstances[selector] = editor;
                    editor.ui.view.editable.element.style.height = '150px';
                })
                .catch(function(error) {
                    console.error(error);
                });
        }
    });

    let forms = document.querySelectorAll('.needs-validation');

    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            editors.forEach(function(selector) {
                if (editorInstances[selector]) {
                    let hiddenInput = document.getElementById(selector.replace('ckeditor-classic', 'hiddens'));
                    hiddenInput.value = editorInstances[selector].getData();
                }
            });

            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    });

    // Dropzone configuration and other scripts...

    // Example Dropzone configuration
    var productImages_ids = [];
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
                $('button[type="submit"]').attr('disabled', false).text('حفظ');
            });
        },
        success: function(file, response) {
            document.getElementById("dropzone-preview-error").innerText = "";
            document.getElementById("dropzone-preview-error").style.display = "none";
            productImages_ids.push(response);
            $('#images-hidden').val(productImages_ids.toString());
        },
        error: function(file, response) {
            file.previewElement.remove();
            document.getElementById("dropzone-preview-error").innerText = response.message;
            document.getElementById("dropzone-preview-error").style.display = "block";
        },
        removedfile: function(file) {
            const deletedImages = $('#deleted-images-hidden').val().replace(/^,+/g, '').split(',');
            deletedImages.push(file.id);
            file.previewElement.remove();
            $('#images-hidden').val(productImages_ids.toString());
            $('#deleted-images-hidden').val(deletedImages.toString().replace(/^,+/g, ''));
        }
    });

    document.querySelector("#product-image-input").addEventListener("change", function () {
        var preview = document.querySelector("#product-img");
        var file = document.querySelector("#product-image-input").files[0];

        var img = new Image();
        var objectUrl = URL.createObjectURL(file);
        img.onload = function() {
            if (this.height < 800) {
                document.getElementById("main-image-preview-error").innerText = 'لابد أن يكون اقل طول للصورة 800 بيكسل';
                document.getElementById("main-image-preview-error").style.display = "block";
            } else if (this.width < 800) {
                document.getElementById("main-image-preview-error").innerText = 'لابد أن يكون اقل عرض للصورة 800 بيكسل';
                document.getElementById("main-image-preview-error").style.display = "block";
            } else {
                document.getElementById("main-image-preview-error").innerText = "";
                document.getElementById("main-image-preview-error").style.display = "none";

                var reader = new FileReader();
                reader.addEventListener("load", function() {
                    preview.src = reader.result;
                }, false);
                if (file) {
                    reader.readAsDataURL(file);
                }
            }
        };
        img.src = objectUrl;
    });

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
    }

    function storeProduct(data) {
        console.log(data);
        $.get('/vendor/services' + data, (response) => {
            console.log(response);
        });
    }
});
