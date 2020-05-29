function checkFields() {
    const emailInput = document.getElementsByName('mail');
    const email2Input = document.getElementsByName('confMail');
    const passwordInput = document.getElementsByName('password');
    const password2Input = document.getElementsByName('confPassword');

    //verif same mails
    if (sameMail(emailInput[0].value, email2Input[0].value)) {
        emailInput[0].style.borderColor = "lightgrey";
        email2Input[0].style.borderColor = "lightgrey";

        //verif same passwords
        if (samePassword(password2Input[0].value, passwordInput[0].value)) {
            passwordInput[0].style.borderColor = "lightgrey";
            password2Input[0].style.borderColor = "lightgrey";

            //verif mail is correct
            if (checkMail(emailInput[0].value)) {

                //verif password is correct
                if (checkPassword(passwordInput[0].value)) {
                    return true;
                } else {
                    passwordInput[0].style.borderColor = "red";
                    password2Input[0].style.borderColor = "red";
                }
            } else {
                emailInput[0].style.borderColor = "red";
                email2Input[0].style.borderColor = "red";
            }
        } else {
            passwordInput[0].style.borderColor = "red";
            password2Input[0].style.borderColor = "red";
        }
    } else {
        emailInput[0].style.borderColor = "red";
        email2Input[0].style.borderColor = "red";
    }

    return false;
}


//functions mail verif
function sameMail(email, email2) {
    return (email[0] === email2[0]);
}

function checkMail(email) {
    const mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    return email.value.match(mailformat);
}


//functions password verif
function samePassword(password, password2) {
    return (password[0] === password2[0]);
}

function countAscii(str, from, to) {
    let count = 0;
    for (let i = 0; i < str.length; i++) {
        const ascii = str.charCodeAt(i);
        if (ascii >= from && ascii <= to) {
            count++;
        }
    }
    return count;
}

function countNumbers(str) {
    return countAscii(str, 48, 57);
}

function countUpper(str) {
    return countAscii(str, 65, 90);
}

function countLower(str) {
    return countAscii(str, 97, 122);
}

function checkPassword(password) {
    return countUpper(password) >= 1
        && countLower(password) >= 5
        && countNumbers(password) >= 2;
}
