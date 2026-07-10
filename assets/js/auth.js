function togglePassword(id) {

    let field = document.getElementById(id);

    if (field.type === "password") {

        field.type = "text";

    } else {

        field.type = "password";

    }
}

function checkPasswordStrength(id, outputId) {

    let password =
        document.getElementById(id).value;

    let output =
        document.getElementById(outputId);

    if (password.length < 6) {

        output.innerHTML =
            '<span class="text-danger">Weak</span>';

    }
    else if (password.length < 10) {

        output.innerHTML =
            '<span class="text-warning">Medium</span>';

    }
    else {

        output.innerHTML =
            '<span class="text-success">Strong</span>';

    }
}