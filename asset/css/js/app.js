import '../css/app.scss';
import Swal from 'sweetalert2'

document.addEventListener('DOMContentLoaded', async () => {
    new App();
});

class App {
    /**
     * @type {HTMLElement}
     */
    body;
    /**
     * @type {HTMLButtonElement}
     */
    safeDepositBoxBtn;

    /**
     * @type {HTMLButtonElement}
     */
    registerBtn;

    /**
     * @type {HTMLButtonElement}
     */
    changeBackgroundColorBtn;

    constructor() {
        this.body = document.body;
        this.safeDepositBoxBtn = document.querySelector('.safeDepositBoxBtn');
        this.registerBtn = document.querySelector('.registerBtn');
        this.changeBackgroundColorBtn = document.querySelector('.changeBackgroundColorBtn');

        this.safeDepositBoxBtn.addEventListener('click', async () => {
            await this.openSafeDepositBox();
        });

        this.registerBtn.addEventListener('click', async () => {
            await this.register();
        });

        this.changeBackgroundColorBtn.addEventListener('click', async () => {
            this.body.style.backgroundColor = await this.changeBackgroundColor()
        });
    }

    async openSafeDepositBox() {
        const {value: password} = await Swal.fire({
            title: 'Ouverture du coffre-fort',
            confirmButtonText: 'Ouvrir',
            input: 'password',
            inputLabel: 'Mot de passe',
            inputPlaceholder: 'Entre le mot de passe du coffre-fort',
            inputAttributes: {
                minLength: 3,
                maxlength: 10,
                autocapitalize: 'off',
                autocorrect: 'off',
                required: true
            },
            validationMessage: 'Le mot de passe doit contenir entre 3 et 10 caractères !'
        });

        if (!password) {
            return;
        }

        const formData = new FormData();
        formData.append('password', password);

        const response = await fetch('/safe-deposit-box', {
            body: formData,
            method: 'POST'
        });

        const data = await response.json();

        if (data.result) {
            await Swal.fire({
                title: 'Félicitations',
                text: 'Le coffre est ouvert !',
                icon: 'success',
                confirmButtonColor: 'green'
            });
        } else {
            await Swal.fire({
                title: 'Erreur',
                text: "Ce n'est pas le bon mot de passe !",
                icon: 'error',
                confirmButtonColor: 'red'
            });
        }
    }

    async register() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        await Toast.fire({
            icon: 'success',
            title: 'Inscription réussie'
        })
    }

    async changeBackgroundColor() {
        const {value: color} = await Swal.fire({
            template: '#bg-color-template',
            inputAttributes: {
                minLength: 4,
                maxlength: 7,
                required: true
            },
            validationMessage: "Il ne s'agit pas d'une couleur hexadecimal !"
        });

        return color;
    }
}