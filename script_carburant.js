document.addEventListener('DOMContentLoaded', function() {
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
    
    // Animation des cartes de carburant
    const carburantCards = document.querySelectorAll('.carburant-card');
    
    carburantCards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 150);
    });
    
    // Simulation de recherche de stations
    const searchForm = document.querySelector('.search-box');
    
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const input = this.querySelector('input');
            const query = input.value.trim();
            
            if (query) {
                // Ici vous pourriez ajouter une vraie recherche AJAX
                alert(`Recherche des stations près de: ${query}`);
                input.value = '';
            }
        });
    }
    
    // Animation au scroll
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.avantage-item, .station-card');
        
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const screenPosition = window.innerHeight / 1.2;
            
            if(elementPosition < screenPosition) {
                element.style.opacity = '1';
                element.style.transform = 'translateX(0)';
            }
        });
    };
    
    // Écouteur d'événement pour l'animation au scroll
    window.addEventListener('scroll', animateOnScroll);
    
    // Initialiser les animations
    animateOnScroll();
});

document.addEventListener('DOMContentLoaded', function() {
    const selectButtons = document.querySelectorAll('.carburant-card .btn');
    
    selectButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const card = this.closest('.carburant-card');
            const fuelType = card.querySelector('h3').textContent;
            const priceText = card.querySelector('.prix').textContent;
            const price = parseFloat(priceText.replace(' €/L', '').replace(' €/kWh', ''));
            const quantityInput = card.querySelector('input[type="number"]');
            const quantity = quantityInput.value || 1;
            const unit = card.querySelector('.carburant-icon i').classList.contains('fa-charging-station') ? 'kWh' : 'L';
            
            const selectedService = {
                type: 'carburant',
                name: `${fuelType} (${quantity}${unit})`,
                price: price,
                quantity: quantity,
                unit: unit
            };
            
            localStorage.setItem('selectedService', JSON.stringify(selectedService));
            localStorage.setItem('quantity', quantity);
            window.location.href = 'index_paiment.html';
        });
    });
});