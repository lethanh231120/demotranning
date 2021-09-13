$(document).ready(function () {
    $("#frmCatogory").validate({
        rules: {
            name: {
                required: true,
                maxlength: 255,
            },
        },
        messages: {
            name: {
                required: "Vui lòng nhập tên danh mục",
                maxlength: "Trường email không quá 255 ký tự",
            },
        },
    });
});
