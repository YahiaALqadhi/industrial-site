import intlTelInput from 'intl-tel-input';

export function initPhoneInputs() {
    const inputs = document.querySelectorAll('.phone-input');

    if (!inputs.length) return;

    inputs.forEach((input) => {
        const iti = intlTelInput(input, {
            initialCountry: 'auto',
            separateDialCode: true,
            nationalMode: false,
            autoHideDialCode: false,

            geoIpLookup: (callback) => {
                fetch('https://ipapi.co/json')
                    .then(res => res.json())
                    .then(data => callback(data.country_code))
                    .catch(() => callback('us'));
            },

            utilsScript:
                'https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js',
        });
        const dropdown = document.querySelector('.iti__country-list');

if (dropdown) {
    dropdown.setAttribute('data-lenis-prevent', '');
}

        // نخزن الرقم الكامل قبل الإرسال
        const form = input.closest('form');
        if (!form) return;

        form.addEventListener('submit', () => {
            input.value = iti.getNumber();
        });
    });
}