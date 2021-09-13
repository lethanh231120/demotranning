$(document).ready(function () {
    var CSRF_TOKEN = $("#csrf-token").val();
    var url = window.location.href;
    $(".btn-delete").click(function (e) {
        var id = $(this).val();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger",
            },
            buttonsStyling: false,
        });
        swalWithBootstrapButtons
            .fire({
                title: "Delete !",
                text: "Are you sure you want to delete?  ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes !",
                cancelButtonText: "Exit !",
                reverseButtons: true,
            })
            .then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "delete",
                        url: `${url}/${id}`,
                        data: { _token: CSRF_TOKEN },
                        dataType: "JSON",
                        success: function (response) {
                            if (response.success === true) {
                                swalWithBootstrapButtons.fire(
                                    (text = response.text),
                                    (title = response.message),
                                    "success"
                                );

                                setTimeout(() => location.reload(), 1000);
                            } else {
                                swalWithBootstrapButtons.fire(
                                    (text = response.text),
                                    (title = response.message),
                                    "success"
                                );
                            }
                        },
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        "canceled",
                        "You have canceled deletion ",
                        "error"
                    );
                }
            });
    });
});
