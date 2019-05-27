$(function () {
    $('.btn-search').click(function () {
        $('.head-search').toggleClass('btn-open');
        $('.head-right').toggleClass('btn-open');
        if ($('.head-search').hasClass('btn-open')) {
            $('#mod-search-searchword').focus();
        }
    });
    $(document).on('click', function (e) {
        if ($(e.target).closest(".btn-search").length === 1 || $(e.target).closest("#mod-search-searchword").length === 1) {
            e.stopPropagation();
        } else {
            $('.head-search').removeClass('btn-open');
        }
    });

    /* Cart modal */
    $('#show-head-cart').on('click', function () {
        let _this = $(this),
            url = _this.data('url'),
            action = _this.data('action');

        $.ajax({
            type: 'POST',
            url: url,
            data: { action: action },
            success: function (response) {
                let modalCart = $('#modal-cart');
                modalCart.html(response);
                modalCart.modal('show');
            }
        });
    });

    /* Add to cart modal */
    $('.add-to-cart').on('click', function () {
        $('#modal-add-cart').modal('show');
    });

    /* Select */
    $(document).ready(function() {
        $('.item-filter').select2({
            minimumResultsForSearch: -1
        });
    });
});