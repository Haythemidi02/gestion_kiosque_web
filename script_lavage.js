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
            window.location.href = 'index_paiment.html';
        });
    });
});