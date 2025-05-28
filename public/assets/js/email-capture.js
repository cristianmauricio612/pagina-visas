/**
 * Script para capturar correos electrónicos cuando se abandonan formularios
 */
document.addEventListener("DOMContentLoaded", function() {
    // Configuración
    const MIN_EMAIL_LENGTH = 5; // Longitud mínima de un correo (a@b.c)
    const DELAY_BEFORE_SAVE = 1500; // Tiempo en ms después de que el usuario deja de escribir
    let emailTimer = null;
    let savedEmails = new Set(); // Para evitar enviar el mismo correo múltiples veces

    // Expresión regular para validar correos
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Obtener token CSRF (buscar en meta tags o en un campo hidden)
    function getCsrfToken() {
        // Buscar en campos meta
        const metaToken = document.querySelector('meta[name="csrf-token"]');
        if (metaToken) {
            return metaToken.getAttribute('content');
        }

        // Buscar en campos hidden para CSRF
        const csrfInput = document.querySelector('input[name="_csrf"], input[name="csrf_token"], input[name="csrf-token"]');
        if (csrfInput) {
            return csrfInput.value;
        }

        // Si no se encuentra, intentar obtener del cookie (esto depende de cómo tu framework maneja CSRF)
        return getCookie('csrf_token') || getCookie('XSRF-TOKEN') || '';
    }

    // Función para obtener cookie
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
        return null;
    }

    // Función para enviar el correo al servidor
    function saveEmailToServer(email, pageOrigin) {
        // Evitar guardar el mismo correo más de una vez por sesión
        if (savedEmails.has(email)) {
            return;
        }

        // Marcar como guardado para esta sesión
        savedEmails.add(email);

        // Obtener el token CSRF
        const csrfToken = getCsrfToken();

        // Enviar al servidor
        fetch('/api/guardar-correo-marketing', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,  // Incluir token CSRF en header
                'X-Requested-With': 'XMLHttpRequest'  // Marcar como petición AJAX
            },
            body: JSON.stringify({
                correo: email,
                pagina_origen: pageOrigin || window.location.pathname,
                _csrf: csrfToken  // También incluir en el cuerpo para mayor compatibilidad
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al guardar el correo');
            }
            return response.json();
        })
        .then(data => {
            console.log('Correo guardado correctamente:', data);
        })
        .catch(error => {
            console.error('Error al guardar correo:', error);
        });
    }

    // Función para validar y guardar un correo
    function processEmailField(inputElement) {
        const email = inputElement.value.trim();

        // Verificar si el email parece válido
        if (email.length >= MIN_EMAIL_LENGTH && emailRegex.test(email)) {
            // Guardar el correo después de un retraso
            clearTimeout(emailTimer);
            emailTimer = setTimeout(() => {
                saveEmailToServer(email);
            }, DELAY_BEFORE_SAVE);
        }
    }

    // Detectar campos de correo electrónico en todos los formularios
    function setupEmailCapture() {
        // Buscar todos los campos que podrían contener un email
        const possibleEmailFields = document.querySelectorAll('input[type="email"], input[name*="email"], input[name*="correo"], input[id*="email"], input[id*="correo"]');

        possibleEmailFields.forEach(field => {
            // Evitar duplicar event listeners
            if (field.dataset.emailCaptureInitialized) {
                return;
            }

            // Marcar como inicializado
            field.dataset.emailCaptureInitialized = 'true';

            // Escuchar cuando el usuario escribe
            field.addEventListener('input', function() {
                clearTimeout(emailTimer);
                emailTimer = setTimeout(() => {
                    processEmailField(this);
                }, DELAY_BEFORE_SAVE);
            });

            // Escuchar cuando el campo pierde el foco
            field.addEventListener('blur', function() {
                clearTimeout(emailTimer);
                processEmailField(this);
            });
        });
    }

    // Detectar cuando el usuario está por abandonar la página
    function setupPageLeaveCapture() {
        window.addEventListener('beforeunload', function(e) {
            // Buscar campos de correo completados pero no enviados
            const emailFields = document.querySelectorAll('input[type="email"], input[name*="email"], input[name*="correo"], input[id*="email"], input[id*="correo"]');

            emailFields.forEach(field => {
                const email = field.value.trim();
                if (email.length >= MIN_EMAIL_LENGTH && emailRegex.test(email)) {
                    // Intentar guardar inmediatamente
                    saveEmailToServer(email);
                }
            });

            // No mostrar diálogo de confirmación, solo capturar correo
            // (Ya no asignamos a e.returnValue para evitar diálogos molestos)
        });
    }

    // Inicializar la captura de correos
    setupEmailCapture();
    setupPageLeaveCapture();

    // Para formularios dinámicos, usar MutationObserver en vez de DOMNodeInserted (que está obsoleto)
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes && mutation.addedNodes.length > 0) {
                // Verificar si los nodos agregados contienen posibles campos de correo
                for (let i = 0; i < mutation.addedNodes.length; i++) {
                    const node = mutation.addedNodes[i];
                    if (node.querySelectorAll) {
                        const emailFields = node.querySelectorAll('input[type="email"], input[name*="email"], input[name*="correo"], input[id*="email"], input[id*="correo"]');
                        if (emailFields.length > 0) {
                            setTimeout(setupEmailCapture, 100);
                            break;
                        }
                    }
                }
            }
        });
    });

    // Iniciar observación
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});
