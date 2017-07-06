$(document).ready(function () {
    var getUrl = window.location,
        baseUrl = getUrl.protocol + "//" + getUrl.host;

    if ($(".chosen-select").length) {
        $(".chosen-select").chosen();
    }

    if ($("input.inputmask").length) {
        $("input.inputmask").inputmask();
    }

    $(".delete-cart").on("click", function () {
        $("#delete-confirmation-modal form").attr("action", $("#delete-confirmation-modal form").attr('action').replace('cart_id', $(this).data("id")));
    });

    $(".add-to-cart").on("click", function (e) {
        e.preventDefault();
        var token = $("input[name='_token']").val();
        $.ajax({
            type: "POST",
            url: baseUrl + '/user/carts/add',
            data: {
                _token: token,
                product_id: $(this).data("product-id"),
                quantity: "1",
                ajax: "true"
            },
            success: function (msg) {
                $.notify({
                    message: "Produk berhasil ditambahkan ke keranjang belanja anda"
                }, {
                    type: "success",
                    placement: {
                        from: "bottom"
                    },
                    animate: {
                        enter: "animated fadeInRight",
                        exit: "animated fadeOutRight"
                    }
                })
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $.notify({
                    message: "Anda harus melakukan login terlebih dahulu sebelum menambahkan produk ke keranjang"
                }, {
                    type: "danger",
                    placement: {
                        from: "bottom"
                    },
                    animate: {
                        enter: "animated fadeInRight",
                        exit: "animated fadeOutRight"
                    }
                })
                console.log(XMLHttpRequest);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    })

    if ($("#table-user-voucher-list").length) {
        var voucherDatatable = $("#table-user-voucher-list").dataTable({
            autoWidth: true,
            responsive: true,
            serverSide: true,
            processing: true,
            ajax: baseUrl + '/user/vouchers/ajax',
            columnDefs: [
                {
                    orderable: false,
                    defaultContent: "<a href='#' class='btn btn-xs btn-warning update_used'><i class='fa fa-check'></i></a>",
                    targets: 5
                },
                {
                    className: "dt-center",
                    targets: [4, 5]
                },
                {
                    className: "cn-font",
                    targets: 1
                },
                {
                    visible: false,
                    targets: 0
                }
            ],
        });
    }

    $(document).on("click", "a.update_used", function (e) {
        e.preventDefault();
        var dt_row = $(this).closest("li").data("dt-row");

        if (dt_row >= 0) {
            var position = dt_row;
        } else {
            var target_row = $(this).closest("tr").get(0);
            var position = voucherDatatable.fnGetPosition(target_row);
        }
        var voucher_id = voucherDatatable.fnGetData(position)[0];
        var token = $("input[name='_token']").val();

        $.ajax({
            type: "PUT",
            url: baseUrl + '/user/vouchers/mark-used',
            data: {
                _token: token,
                voucher_id: voucher_id,
                ajax: "true"
            },
            success: function (data) {
                $.notify({
                    message: data
                }, {
                    type: "success",
                    placement: {
                        from: "bottom"
                    },
                    animate: {
                        enter: "animated fadeInRight",
                        exit: "animated fadeOutRight"
                    }
                });
                $("#table-user-voucher-list").DataTable().ajax.reload(null, false);
            },
            error: function (data) {
                $.notify({
                    message: "Telah terjadi kesalahan saat meng-update voucher"
                }, {
                    type: "danger",
                    placement: {
                        from: "bottom"
                    },
                    animate: {
                        enter: "animated fadeInRight",
                        exit: "animated fadeOutRight"
                    }
                })
            }
        });
    });

    if ($("#table-user-invoice-list").length) {
        var invoiceDatatable = $("#table-user-invoice-list").dataTable({
            autoWidth: true,
            responsive: true,
            serverSide: true,
            processing: true,
            ajax: baseUrl + '/user/orders/ajax',
            columnDefs: [
                {
                    className: "dt-right",
                    targets: 3
                },
                {
                    className: "dt-center",
                    orderable: false,
                    defaultContent: "<a href='#' class='btn btn-xs btn-warning order_detail'><i class='fa fa-search-plus'></i></a>",
                    targets: 5
                }
            ]
            //     {
            //         className: "dt-center",
            //         targets: [4, 5]
            //     },
            //     {
            //         className: "cn-font",
            //         targets: 1
            //     },
            //     {
            //         visible: false,
            //         targets: 0
            //     }
            // ],
        });
    }

    $(document).on("click", "a.order_detail", function (e) {
        e.preventDefault();
        var dt_row = $(this).closest("li").data("dt-row");

        if (dt_row >= 0) {
            var position = dt_row;
        } else {
            var target_row = $(this).closest("tr").get(0);
            var position = invoiceDatatable.fnGetPosition(target_row);
        }
        var order_id = invoiceDatatable.fnGetData(position)[2];

        window.open(baseUrl + "/user/orders/detail?order_id=" + order_id);
    });

    $(".confirm_topup").on("click", function (e) {
        e.preventDefault();
        $("#topup-confirmation-modal form").attr("action", $("#topup-confirmation-modal form").attr('action').replace('order_id', $(this).data("id")));
        $("#topup-confirmation-modal p.question").text("Anda yakin melakukan konfirmasi topup atas order: " + $(this).data("id") + " ini dengan jumlah topup sebesar: " + $(this).data("total_amount") + " ?");
    });
});