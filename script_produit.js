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


document.addEventListener('DOMContentLoaded', function() {
    const cart = [];
    const addToCartButtons = document.querySelectorAll('.btn-ajouter');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const card = this.closest('.produit-card');
            const productName = card.querySelector('h3').textContent;
            const priceText = card.querySelector('.prix').textContent || 
                             card.querySelector('.prix-promo').textContent;
            const price = parseFloat(priceText.replace(' €', ''));
            
            const product = {
                name: productName,
                price: price,
                quantity: 1
            };
            
            cart.push(product);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
        });
    });
    
    function updateCartCount() {
        const cartCount = document.createElement('span');
        cartCount.className = 'cart-count';
        cartCount.textContent = cart.length;
        
        const existingCount = document.querySelector('.cart-count');
        if (existingCount) {
            existingCount.textContent = cart.length;
        } else {
            const cartIcon = document.querySelector('.fa-shopping-cart').parentNode;
            cartIcon.appendChild(cartCount);
        }
    }
    
    // Optionnel: Ajouter un bouton panier qui redirige vers le paiement
    const cartButton = document.createElement('a');
    cartButton.href = 'index_paiment.html';
    cartButton.className = 'btn';
    cartButton.innerHTML = '<i class="fas fa-shopping-cart"></i> Voir le panier';
    document.querySelector('.produits-phares .container').appendChild(cartButton);
    
    cartButton.addEventListener('click', function(e) {
        if (cart.length === 0) {
            e.preventDefault();
            alert('Votre panier est vide !');
        }
    });
});