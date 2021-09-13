$(document).ready(function () {
    $("#frmProduct").validate({
        rules: {
            name: {
                required: true,
                maxlength: 255,
            },
            user_id: {
                required: true,
            },
            sku: {
                required: true,
                regexSku: true,
                rangelength: [10, 20],
            },
            stock: {
                required: true,
                number: true,
                range: [0, 10000],
            },
            price: {
                required: true,
            },
            exprired_at: {
                required: true,
            },
            category_id: {
                required: true,
            },
            avatar: {
                required: true,
                extension: "jpg|jpeg|png",
            },
        },
        messages: {
            name: {
                required: "Bạn chưa nhập tên sản phẩm",
                maxlength: "Tên sản phẩm không được quá 255 ký tự",
            },
            user_id: {
                required: "Bạn chưa nhập user id",
            },
            sku: {
                required: "Bạn chưa nhập trường sku",
                rangelength: "Trường sku tối thiểu 10 ký tự , tối đa 20 ký tự",
            },
            stock: {
                required: "Bạn chưa nhập stock",
                number: "Trường stock phải là số",
                range: "Trường stock phải lớn hơn 0 và nhỏ hơn 10000",
            },
            price: {
                required: "Bạn chưa nhập price",
            },
            exprired_at: {
                required: "Bạn chưa nhập ngày hết hạn",
            },
            category_id: {
                required: "Bạn chưa nhập trường category_id",
            },
            avatar: {
                required: "Bạn chưa chọn ảnh",
                extension: "Định dạng nhận là jpg,pnd,jpeg",
            },
        },
    });
});
