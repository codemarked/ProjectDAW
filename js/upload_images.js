jQuery(document).ready(function () {
    ImgUpload();
});

function ImgUpload() {
    var imgWrap = "";
    var imgArray = [];
    const fileLimit = 10485760;
    const allowed = ["jpg", "png"];
    
    $(".upload__inputfile").each(function () {
        $(this).on("change", function (e) {
            imgWrap = $(this).closest(".upload__box").find(".upload__img-wrap");
            var maxLength = $(this).attr("data-max_length");

            var files = e.target.files;
            var filesArr = Array.prototype.slice.call(files);
            var iterator = 0;
            filesArr.forEach(function (f, index) {
                if (!f.type.match("image.*")){
                    return;
                }
                var extension = f.name.split('.').pop();
                if (!allowed.includes(extension)) {
                    alert("You may only upload png or jpg files!");
                    return false;
                }
                if (imgArray.length >= maxLength) {
                    alert("The maximum amount of pictures has been reached!");
                    return false;
                }
                var len = 0;
                for (var i = 0; i < imgArray.length; i++)
                    if (imgArray[i] !== undefined) 
                        len++;
                if (len >= maxLength) {
                    alert("The maximum amount of pictures has been reached!");
                    return false;
                }
                if (f.size >= fileLimit) {
                    alert("File size of " + f.name + " is too large!");
                    return false;
                }
                imgArray.push(f);
                var reader = new FileReader();
                reader.onload = function (e) {
                    var html =
                        "<div class='upload__img-box'><div style='background-image: url(" +
                        e.target.result +
                        ")' data-number='" +
                        $(".upload__img-close").length +
                        "' data-file='" +
                        f.name +
                        "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                    imgWrap.append(html);
                    console.log("added image " + f.name);
                    iterator++;
                };
                reader.readAsDataURL(f);
            });
        });
    });
    
    $("body").on("click", ".upload__img-close", function (e) {
        var file = $(this).parent().data("file");
        let i = 0;
        for (i = 0; i < imgArray.length; i++) {
            if (imgArray[i].name === file) {
                imgArray.splice(i, 1);
                break;
            }
        }
        $(this).parent().parent().remove();
        return true;
    });
    
    $("body").on("click", ".submit", function (e) {
        if (imgArray.length < 1)
            return false;
    });
}