alertify.defaults = {
    notifier:{
        delay:5,
        position:'top-right',
    },
};


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

$('.container-recalculate').on('click', '.btn-recalculate', function () {
    let _this = $(this),
        operator = _this.data('operator');

    let parent = _this.parent().parent(),
        quantityInput = parent.find("input[name='quantity']"),
        quantity = parseInt(quantityInput.val());

    if ('-' === operator) {
        if (quantity > 1) {
            quantityInput.val(--quantity)
        }
    } else if ('+' === operator) {
        quantityInput.val(++quantity)
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

/* Show modal price */
$('.addtocart-area').on('click', '.show-modal-price', function () {

    let _this = $(this),
        item_id = _this.data('id'),
        game_id = _this.data('game'),
        url = _this.data('url'),
        action = _this.data('action'),
        quantity = $("#product-"+item_id).val();

    $.ajax({
        type: 'POST',
        url: url,
        data: { action: action, item_id: item_id, game_id: game_id, quantity: quantity },
        success: function (response) {
            let modalPrice = $('#modal-add-cart');
            modalPrice.html(response);
            modalPrice.modal('show');
        }
    });
});

/* Add item to cart */
$('.container-add-cart').on('click','.add-to-cart', function () {
    let _this = $(this),
        item_id = _this.data('id'),
        product_type = _this.data('product-type'),
        url = _this.data('url'),
        action = _this.data('action'),
        quantity = _this.data('quantity');

    $.ajax({
        type: 'POST',
        url: url,
        data: { action: action, item_id: item_id, product_type: product_type, quantity: quantity },
        success: function (response) {
            if (200 === response.code) {
                let countItemInCart = $('#show-head-cart');
                countItemInCart.find('.total-product').html(response.count);
                alertify.success('Item successfully added to cart');
            } else {
                alertify.error('Error adding item to cart');
            }
        }
    });
});

/* Select */
$(document).ready(function() {
    $('.item-filter').select2({
        minimumResultsForSearch: -1
    });

    $('.filter-category').select2();
});

$('.filter-game').on('select2:select', function (e) {
    let _this = $(this),
        url = _this.data('url'),
        category = $('.filter-category').val(),
        game = e.params.data.id,
        filter = {game: game, category: category};

    getAjaxProduct(url, filter);
});

$('.filter-category').on('select2:select', function (e) {
    let _this = $(this),
        url = _this.data('url'),
        category = e.params.data.id,
        game = $('.filter-game').val(),
        filter = {category: category, game: game};

    getAjaxProduct(url, filter);
});

let getAjaxProduct = function (url, filter) {
    $.ajax({
        type: 'POST',
        url: url,
        data: filter,
        success: function (response) {
            let container = $('#container-product');
            container.html(response);
        }
    });
};