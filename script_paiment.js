document.addEventListener("DOMContentLoaded", function () {
    const payBtn = document.querySelector(".btn");

    payBtn.addEventListener("click", function (e) {
        const cardNumber = document.getElementById("cardNumber").value.trim();
        const expiry = document.getElementById("expiryDate").value.trim();
        const cvv = document.getElementById("cvv").value.trim();
        const name = document.getElementById("cardName").value.trim();

        if (!cardNumber || !expiry || !cvv || !name) {
            e.preventDefault();
            alert("Veuillez remplir tous les champs de paiement.");
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const paymentSection = document.getElementById('paymentSection');
    paymentSection.classList.remove('hidden');
    
    const selectedService = JSON.parse(localStorage.getItem('selectedService'));
    const cart = JSON.parse(localStorage.getItem('cart'));
    
    if (selectedService) {
        displayService(selectedService);
    } else if (cart && cart.length > 0) {
        displayCart(cart);
    } else {
        displayEmpty();
    }
    
    function displayService(service) {
        document.getElementById('selectedItem').textContent = service.name;
        
        if (service.type === 'carburant') {
            const total = service.price * service.quantity;
            document.getElementById('itemPrice').textContent = 
                `${service.price.toFixed(3)} TND/${service.unit} x ${service.quantity}`;
            document.getElementById('totalPrice').textContent = `${total.toFixed(2)} TND`;
        } else {
            document.getElementById('itemPrice').textContent = `${service.price.toFixed(2)} TND`;
            document.getElementById('totalPrice').textContent = `${service.price.toFixed(2)} TND`;
        }
    }
    
    function displayCart(cart) {
        const selectedItemElement = document.getElementById('selectedItem');
        const itemPriceElement = document.getElementById('itemPrice');
        const totalPriceElement = document.getElementById('totalPrice');
        
        selectedItemElement.textContent = `${cart.length} article(s) dans le panier`;
        
        let itemsText = '';
        let total = 0;
        
        cart.forEach(item => {
            itemsText += `${item.name} - ${item.price.toFixed(2)} TND x ${item.quantity}\n`;
            total += item.price * item.quantity;
        });
        
        itemPriceElement.textContent = itemsText;
        totalPriceElement.textContent = `${total.toFixed(2)} TND`;
    }
    
    function displayEmpty() {
        document.getElementById('selectedItem').textContent = 'Aucun article sélectionné';
        document.getElementById('itemPrice').textContent = '0.00 TND';
        document.getElementById('totalPrice').textContent = '0.00 TND';
        
        // Redirection après 3 secondes
        setTimeout(() => {
            window.location.href = 'index_service.php';
        }, 3000);
    }
});