const form = document.querySelector('#form');
const firstname = document.querySelector('#firstname');
const lastname = document.querySelector('#lastname');
const email = document.querySelector('#email');
const phone = document.querySelector('#phone');

form.addEventListener('submit', (e) => {
    if (!validateInputs()) {
        e.preventDefault();
    }
});

function handleNameKeyDown(e) {
    const allowedKeys = ['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete', 'Shift', 'Control'];
    const char = e.key;
    if ( !(/[a-zA-Z. ]/.test(char)) &&
        !allowedKeys.includes(char))
     {
        e.preventDefault();
    }
}

firstname.addEventListener('keydown', handleNameKeyDown);
lastname.addEventListener('keydown', handleNameKeyDown);

phone.addEventListener('keydown', function (e) {
    const allowedKeys = ['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete'];
    if ( !(e.key >= '0' && e.key <= '9') &&
        !allowedKeys.includes(e.key))
     {
        e.preventDefault();
    }
    if (phone.value.length >= 10 && !(allowedKeys.includes(e.key))) {
        e.preventDefault();
    }
});

firstname.addEventListener('input', function () {
    this.value = this.value
        .split('')
        .filter(c => {
            let code = c.charCodeAt(0);
            return (
                (code >= 65 && code <= 90) ||
                (code >= 97 && code <= 122) ||
                code === 46 ||
                code === 32
            );
        })
        .join('');
});

lastname.addEventListener('input', function () {
    this.value = this.value
        .split('')
        .filter(c => {
            let code = c.charCodeAt(0);
            return (
                (code >= 65 && code <= 90) ||
                (code >= 97 && code <= 122) ||
                code === 46 ||
                code === 32
            );
        })
        .join('');
});

phone.addEventListener('input', function () {
    this.value = this.value
        .split('')
        .filter(c => {
            let code = c.charCodeAt(0);
            return code >= 48 && code <= 57;
        })
        .join('')
        .slice(0, 10);
});

function validateInputs() {
    const firstnameVal = firstname.value.trim();
    const lastnameVal = lastname.value.trim();
    const emailVal = email.value.trim();
    const phoneVal = phone.value.trim();
    let success = true;

    if (firstnameVal === '') {
        success = false;
        setError(firstname, 'Firstname is required');
    } else if (!/^[a-zA-Z. ]+$/.test(firstnameVal)) {
        success = false;
        setError(firstname, 'Enter only letters and "."');
    } else {
        setSuccess(firstname);
    }

    if (lastnameVal === '') {
        success = false;
        setError(lastname, 'Lastname is required');
    } else if (!/^[a-zA-Z. ]+$/.test(lastnameVal)) {
        success = false;
        setError(lastname, 'Enter only letters and "."');
    } else {
        setSuccess(lastname);
    }

    if (emailVal === '') {
        success = false;
        setError(email, 'Email is required');
    } else if (!validateEmail(emailVal)) {
        success = false;
        setError(email, 'Please enter a valid email');
    } else {
        setSuccess(email);
    }

    if (phoneVal === '') {
        success = false;
        setError(phone, 'Phone No is required');
    } else if (phoneVal.length !== 10) {
        success = false;
        setError(phone, 'Please enter exactly 10 digits');
    } else if (!phoneVal.match(/^[6-9][0-9]{9}$/)) {
        success = false;
        setError(phone, 'First digit should be between 6-9');
    } else {
        setSuccess(phone);
    }

    return success;
}

function setError(element, message) {
    const inputGroup = element.parentElement;
    const errorElement = inputGroup.querySelector('.error');
    errorElement.innerText = message;
    inputGroup.classList.add('error');
    inputGroup.classList.remove('success');
}

function setSuccess(element) {
    const inputGroup = element.parentElement;
    const errorElement = inputGroup.querySelector('.error');
    errorElement.innerText = '';
    inputGroup.classList.add('success');
    inputGroup.classList.remove('error');
}

const validateEmail = (email) => {
    return String(email)
        .toLowerCase()
        .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
};
