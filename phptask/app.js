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
    if (
        !(/[a-zA-Z. ]/.test(char)) &&
        !allowedKeys.includes(char)
    ) {
        e.preventDefault();
    }
}

firstname.addEventListener('keydown', handleNameKeyDown);
lastname.addEventListener('keydown', handleNameKeyDown);

phone.addEventListener('keydown', function (e) {
    const allowedKeys = ['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete'];
    if (
        !(e.key >= '0' && e.key <= '9') &&
        !allowedKeys.includes(e.key)
    ) {
        e.preventDefault();
    }
    if (phone.value.length >= 10 && !(allowedKeys.includes(e.key))) {
        e.preventDefault();
    }
});

firstname.addEventListener('keyup', (e) => {
    console.log(`You released key: ${e.key}`);
});

lastname.addEventListener('keyup', (e) => {
    console.log(`You released key: ${e.key}`);
});

phone.addEventListener('keyup', (e) => {
    console.log(`You released key: ${e.key}`);
});
email.addEventListener('keyup', (e) => {
    console.log(`You released key: ${e.key}`);
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
const data = {
    india: {
        tamilnadu: {
            chennai: ['600001', '600002'],
            madurai: ['625001', '625002']
        },
        kerala: {
            kochi: ['682001', '682002'],
            trivandrum: ['695001', '695002']
        }
    },
    usa: {
        california: {
            la: ['90001', '90002'],
            sf: ['94101', '94102']
        },
        texas: {
            dallas: ['75201', '75202'],
            houston: ['77001', '77002']
        }
    },
    canada: {
        ontario: {
            toronto: ['M5A 1A1', 'M5B 1B1'],
            england: ['EC1A 1BB', 'EC1A 1AA']
        },
        new_south_wales: {
            london: ['2000', '2004'],
            syndey: ['2500', '2003']
        }
    }
};

const country = document.getElementById("country");
const state = document.getElementById("state");
const district = document.getElementById("district");
const pincode = document.getElementById("pincode");

country.addEventListener("change", () => {
    state.innerHTML = '<option value="">--Select State--</option>';
    district.innerHTML = '<option value="">--Select District--</option>';
    pincode.innerHTML = '<option value="">--Select Pincode--</option>';
    const selectedCountry = country.value;

    if (data[selectedCountry]) {
        Object.keys(data[selectedCountry]).forEach(st => {
            state.innerHTML += `<option value="${st}">${st}</option>`;
        });
    }
});

state.addEventListener("change", () => {
    district.innerHTML = '<option value="">--Select District--</option>';
    pincode.innerHTML = '<option value="">--Select Pincode--</option>';
    const selectedCountry = country.value;
    const selectedState = state.value;

    if (data[selectedCountry]?.[selectedState]) {
        Object.keys(data[selectedCountry][selectedState]).forEach(dist => {
            district.innerHTML += `<option value="${dist}">${dist}</option>`;
        });
    }
});

district.addEventListener("change", () => {
    pincode.innerHTML = '<option value="">--Select Pincode--</option>';
    const selectedCountry = country.value;
    const selectedState = state.value;
    const selectedDistrict = district.value;

    if (data[selectedCountry]?.[selectedState]?.[selectedDistrict]) {
        data[selectedCountry][selectedState][selectedDistrict].forEach(pin => {
            pincode.innerHTML += `<option value="${pin}">${pin}</option>`;
        });
    }
});
var x = document.getElementById("mybtn");
x.addEventListener("click", myfunction); 
    function myfunction() {
    const selectedCountry = country.value;
    const selectedState = state.value;
    const selectedDistrict = district.value;
    const selectedPincode = pincode.value;

    if (selectedCountry === "" || selectedState === "" || selectedDistrict === "" || selectedPincode === "") {
        alert("Please select all fields.");
        return false;
    } else {
       alert("Form submitted successfully!");
        return true;
    }
}
