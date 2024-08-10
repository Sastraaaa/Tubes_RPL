$(document).ready(function () {
    let cart = [];

    $('.filter-menu').on('click', function () {
        const category = $(this).data('category');
        $('.menu-items').hide();
        $('.menu-items.' + category).show();
    });

    $('.add-to-cart').on('click', function () {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const price = $(this).data('price');
        const stok = $(this).data('stok');

        if (stok === 0) {
            alert('Stok habis');
            return;
        }

        const existingItem = cart.find(item => item.id === id);
        if (existingItem) {
            if (existingItem.qty < stok) {
                existingItem.qty++;
                existingItem.total = existingItem.qty * price;
            } else {
                alert(`Stok tersedia hanya ${stok}`);
                return;
            }
        } else {
            cart.push({
                id: id,
                name: name,
                price: price,
                qty: 1,
                total: price,
                stok: stok
            });
        }
        renderCart();
    });

    function renderCart() {
        const $cartItems = $('#cart-items');
        $cartItems.empty();
        let totalPrice = 0;

        if (cart.length === 0) {
            $cartItems.append('<tr><td colspan="6" class="text-center">Keranjang kosong</td></tr>');
        } else {
            cart.forEach((item, index) => {
                totalPrice += item.total;
                $cartItems.append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.name}</td>
                    <td>Rp ${item.price}</td>
                    <td>
                         ${item.qty}
                    </td>
                    <td>Rp ${item.total}</td>
                    <td>
                    <button class="btn btn-sm btn-secondary decrement-qty" data-id="${item.id}">-</button>
                    <button class="btn btn-sm btn-primary increment-qty" data-id="${item.id}">+</button>
                    <button class="btn btn-danger btn-sm remove-from-cart" data-id="${item.id}">Hapus
                    </button></td>
                </tr>
            `);
            });
        }

        $('#total-price').text(totalPrice);
        $('#hidden-totalbelanja').val(totalPrice);
        $('#hidden-cart').val(JSON.stringify(cart));
    }

    $(document).on('click', '.remove-from-cart', function () {
        const id = $(this).data('id');
        cart = cart.filter(item => item.id !== id);
        renderCart();
    });

    $(document).on('click', '.increment-qty', function () {
        const id = $(this).data('id');
        const item = cart.find(item => item.id === id);

        if (item.qty < item.stok) {
            item.qty++;
            item.total = item.qty * item.price;
            renderCart();
        } else {
            alert(`Stok tersedia hanya ${item.stok}`);
        }
    });

    $(document).on('click', '.decrement-qty', function () {
        const id = $(this).data('id');
        const item = cart.find(item => item.id === id);

        if (item.qty > 1) {
            item.qty--;
            item.total = item.qty * item.price;
            renderCart();
        }
    });
});