document.addEventListener('DOMContentLoaded', function() {
    // Selección de monto
    const amountOptions = document.querySelectorAll('.amount-option');
    const montoInput = document.getElementById('monto');
    
    amountOptions.forEach(option => {
        option.addEventListener('click', function() {
            amountOptions.forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            montoInput.value = this.dataset.amount;
        });
    });
    
    // Actualizar monto seleccionado si se escribe manualmente
    montoInput.addEventListener('input', function() {
        amountOptions.forEach(opt => opt.classList.remove('selected'));
    });
    
    // Selección de tipo de donación
    const typeOptions = document.querySelectorAll('.type-option');
    const tipoDonacion = document.getElementById('tipo_donacion');
    
    typeOptions.forEach(option => {
        option.addEventListener('click', function() {
            typeOptions.forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            tipoDonacion.value = this.dataset.type;
        });
    });
    
    // Formato de número de tarjeta
    const cardNumberInput = document.querySelector('input[name="tarjeta"]');
    if (cardNumberInput) {
        cardNumberInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.match(/.{1,4}/g);
            if (value) {
                e.target.value = value.join(' ');
            }
        });
    }
    
    // Formato de fecha de expiración
    const expiryInput = document.querySelector('input[name="fecha_exp"]');
    if (expiryInput) {
        expiryInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });
    }
    
    // Validación del formulario antes de enviar
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Validar tarjeta (16 dígitos)
            const tarjeta = cardNumberInput.value.replace(/\s/g, '');
            if (tarjeta.length !== 16) {
                alert('Por favor ingresa un número de tarjeta válido (16 dígitos)');
                e.preventDefault();
                return;
            }
            
            // Validar fecha (MM/AA)
            const fecha = expiryInput.value;
            if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(fecha)) {
                alert('Por favor ingresa una fecha de expiración válida (MM/AA)');
                e.preventDefault();
                return;
            }
            
            // Validar CVV (3 dígitos)
            const cvv = document.querySelector('input[name="cvv"]').value;
            if (!/^\d{3}$/.test(cvv)) {
                alert('Por favor ingresa un CVV válido (3 dígitos)');
                e.preventDefault();
                return;
            }
            
            // Mostrar mensaje de procesamiento
            const submitBtn = document.querySelector('.donate-btn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
            }
        });
    }
});