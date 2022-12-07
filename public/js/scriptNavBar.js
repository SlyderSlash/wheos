let menuToggle = document.querySelector('.menuTogglerre');
let navigation = document.querySelector('.navigatetionner');
menuToggle.onclick = function() {
    navigation.classList.toggle('activeer')
}

let list = document.querySelectorAll('.lister');

function activeLink() {
    list.forEach((item) =>
        item.classList.remove('activeer'));
    this.classList.add('activeer');
}
list.forEach((item) =>
    item.addEventListener('click', activeLink));