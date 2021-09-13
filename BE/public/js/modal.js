$("#modal").on("show.bs.modal", function (event) {
    let modal = $(this);
    var [img] = avatar.files;
    if (img) {
        modal
            .find("#modal-avatar")
            .attr("src", URL.createObjectURL($("#avatar")[0].files[0]));
    }
    modal.find("#modal-name").html($("#name").val());
    modal.find("#modal-sku").html($("#sku").val());
    modal.find("#modal-stock").html($("#stock").val());
    modal.find("#modal-exprired-at").html($("#exprired_at").val());
    modal
        .find("#modal-category")
        .html($("#category_id option:selected").text());
});
