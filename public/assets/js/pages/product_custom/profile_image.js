// Profile Foreground Img
if (document.querySelector("#profile-img-file-input")) {
    document.querySelector("#profile-img-file-input").addEventListener("change", function () {
        var preview = document.querySelector(".user-profile-image");
        var file = document.querySelector(".profile-img-file-input").files[0];
        var reader = new FileReader();
        reader.addEventListener(
            "load",
            function () {
                preview.src = reader.result;
            },
            false
        );
        if (file) {
            reader.readAsDataURL(file);
        }
    });
}

function showImage(inputId,previewClass)
{
    document.querySelector("#"+inputId).addEventListener("change", function () {
        var preview = document.querySelector("."+previewClass);
        var file = document.querySelector("."+inputId).files[0];
        var reader = new FileReader();
        reader.addEventListener(
            "load",
            function () {
                preview.src = reader.result;
            },
            false
        );
        if (file) {
            reader.readAsDataURL(file);
        }
    });
}