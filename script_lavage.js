document.querySelectorAll('.faq-question').forEach(question => {
    question.addEventListener('click', () => {
        const faqItem = question.parentElement;
        const answer = question.nextElementSibling;

        faqItem.classList.toggle('active');

        if (faqItem.classList.contains('active')) {
            answer.style.display = 'block';
        } else {
            answer.style.display = 'none';
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const reserveButtons = document.querySelectorAll('.formule-card .btn');
    
    reserveButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const card = this.closest('.formule-card');
            const formuleName = card.querySelector('h3').textContent;
            const priceText = card.querySelector('.price').textContent;
            const price = parseFloat(priceText.replace(' €', ''));
            
            const selectedService = {
                type: 'lavage',
                name: formuleName,
                price: price
            };
            
            localStorage.setItem('selectedService', JSON.stringify(selectedService));
        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const cartBadge = document.getElementById("cart-badge");

    function updateCartBadge() {
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartBadge.textContent = totalItems;
    }

    function addToCart(productId, productName, productPrice) {
        const existingProduct = cart.find(item => item.id === productId);
        if (existingProduct) {
            existingProduct.quantity += 1;
        } else {
            cart.push({ id: productId, name: productName, price: productPrice, quantity: 1 });
        }
        localStorage.setItem("cart", JSON.stringify(cart));
        updateCartBadge();
    }

    document.querySelectorAll(".btn[data-name][data-price]").forEach(button => {
        button.addEventListener("click", () => {
            const productName = button.getAttribute("data-name");
            const productPrice = parseFloat(button.getAttribute("data-price"));
            const productId = `lavage-${productName.replace(/\s+/g, '-').toLowerCase()}`;
            addToCart(productId, productName, productPrice);
        });
    });

    updateCartBadge();
});

document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.btn[data-name][data-price]');
    buttons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const name = button.getAttribute('data-name');
            const price = button.getAttribute('data-price');
            addToCart(name, price);
        });
    });

    function addToCart(name, price) {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.push({ name, price });
        localStorage.setItem('cart', JSON.stringify(cart));
        alert(`${name} a été ajouté au panier pour ${price} €.`);
    }
});