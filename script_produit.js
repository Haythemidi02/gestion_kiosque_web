document.addEventListener('DOMContentLoaded', function() {
    // Animation des cartes de catégories au chargement
    const categorieCards = document.querySelectorAll('.categorie-card');
    
    categorieCards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 150);
    });
    
    // Fonctionnalité de filtrage (exemple basique)
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    if(filterButtons.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Enlever la classe active de tous les boutons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // Ajouter la classe active au bouton cliqué
                this.classList.add('active');
                
                // Ici vous pourriez ajouter la logique pour filtrer les produits
                // Par exemple :
                // const category = this.dataset.category;
                // filterProducts(category);
            });
        });
    }
    
    // Animation au scroll
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.produit-card, .avantage-item');
        
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const screenPosition = window.innerHeight / 1.2;
            
            if(elementPosition < screenPosition) {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }
        });
    };
    
    // Écouteur d'événement pour l'animation au scroll
    window.addEventListener('scroll', animateOnScroll);
    
    // Initialiser les animations
    animateOnScroll();
});

// Ajoutez cette partie à la fin du fichier existant

// Fonctionnalité FAQ
const faqItems = document.querySelectorAll('.faq-item');
    
faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');
    
    question.addEventListener('click', () => {
        // Fermer tous les autres items
        faqItems.forEach(otherItem => {
            if (otherItem !== item) {
                otherItem.classList.remove('active');
                otherItem.querySelector('.faq-answer').style.display = 'none';
            }
        });
        
        // Basculer l'item actuel
        item.classList.toggle('active');
        const answer = item.querySelector('.faq-answer');
        
        if (item.classList.contains('active')) {
            answer.style.display = 'block';
        } else {
            answer.style.display = 'none';
        }
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

    // Recharger les données du panier au chargement de la page
    if (cart.length > 0) {
        updateCartBadge();
    }

    document.querySelectorAll(".btn-ajouter").forEach(button => {
        button.addEventListener("click", () => {
            const productId = button.getAttribute("data-product-id");
            const productName = button.getAttribute("data-product-name");
            const productPrice = parseFloat(button.getAttribute("data-product-price"));
            addToCart(productId, productName, productPrice);
        });
    });

    updateCartBadge();
});