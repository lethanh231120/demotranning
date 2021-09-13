$(document).ready(function () {
    $("#frmUser").validate({
        rules: {
            email: {
                required: true,
                email: true,
                maxlength: 100,
            },
            user_name: {
                required: true,
            },
            birthday: {
                required: true,
                date: true,
            },
            first_name: {
                required: true,
                maxlength: 50,
            },
            last_name: {
                required: true,
                maxlength: 50,
            },
            password: {
                required: true,
            },
            status: {
                required: true,
            },
            province_id: {
                required: true,
            },
            district_id: {
                required: true,
            },
            commune_id: {
                required: true,
            },
            address: {
                required: true,
            },
            // avatar: {
            //     required: true,
            // },
        },
        messages: {
            email: {
                required: "Vui lòng nhập email",
                email: "Trường này định dạng phải là email",
                maxlength: "Trường email không quá 100 ký tự",
            },
            user_name: {
                required: "Vui lòng nhập use name",
            },
            birthday: {
                required: "Vui lòng nhập ngày sinh",
                date: "Ngày sinh phải là kiểu date",
            },
            first_name: {
                required: "Vui lòng nhập first name",
                maxlength: "First name không quá 50 ký tự",
            },
            last_name: {
                required: "Vui lòng nhập last name",
                maxlength: "last name không quá 50 ký tự",
            },
            password: {
                required: "Bạn chưa nhập password",
            },
            status: {
                required: "Bạn chưa nhập status",
            },
            province_id: {
                required: "Bạn chưa nhập tỉnh",
            },
            district_id: {
                required: "Bạn chưa nhập huyện",
            },
            commune_id: {
                required: "Bạn chưa nhập xa, phường",
            },
            address: {
                required: "Bạn chưa nhập địa chỉ",
            },
            // avatar: {
            //     required: "Bạn chưa chọn ảnh",
            // },
        },
    });
});
