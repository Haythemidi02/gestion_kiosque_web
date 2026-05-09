document.addEventListener('DOMContentLoaded', () => {
    const chatbot = document.getElementById('chatbot');
    const toggle = document.getElementById('chatbotToggle');
    const close = document.getElementById('chatbotClose');
    const form = document.getElementById('chatbotForm');
    const input = document.getElementById('chatbotInput');
    const messages = document.getElementById('chatbotMessages');
    const quickActions = document.querySelectorAll('[data-chatbot-prompt]');
    const history = [];

    if (!chatbot || !toggle || !close || !form || !input || !messages) {
        return;
    }

    const addMessage = (role, text, loading = false) => {
        const message = document.createElement('div');
        message.className = `chatbot-message ${role}${loading ? ' loading' : ''}`;
        message.textContent = text;
        messages.appendChild(message);
        messages.scrollTop = messages.scrollHeight;
        return message;
    };

    const setOpen = (isOpen) => {
        chatbot.classList.toggle('open', isOpen);
        if (isOpen) {
            input.focus();
        }
    };

    const askAssistant = async (text) => {
        const question = text.trim();
        if (!question) {
            return;
        }

        addMessage('user', question);
        history.push({ role: 'user', content: question });
        input.value = '';
        input.disabled = true;
        const loading = addMessage('bot', 'Je cherche la meilleure orientation...', true);

        try {
            const response = await fetch('../core/chatbot.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    message: question,
                    history: history.slice(-8)
                })
            });
            const data = await response.json();

            loading.classList.remove('loading');
            loading.textContent = data.reply || 'Je ne peux pas repondre pour le moment.';
            history.push({ role: 'assistant', content: loading.textContent });
        } catch (error) {
            loading.classList.remove('loading');
            loading.textContent = 'Le service assistant est indisponible. Essayez la page Services ou contactez la station au +216 27 312 507.';
        } finally {
            input.disabled = false;
            input.focus();
        }
    };

    toggle.addEventListener('click', () => setOpen(true));
    close.addEventListener('click', () => setOpen(false));

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        askAssistant(input.value);
    });

    quickActions.forEach((button) => {
        button.addEventListener('click', () => {
            setOpen(true);
            askAssistant(button.dataset.chatbotPrompt || '');
        });
    });
});
