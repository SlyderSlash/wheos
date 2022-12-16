
let btnAddSujet = document.getElementById('addsujet');
let btnAddresponse = document.getElementById('addresponse');



btnAddSujet.addEventListener('click', () => {
let icon = document.getElementById('icon');
  
    if (icon.classList.contains('bi-plus-circle-fill')) {
        icon.classList.replace('bi-plus-circle-fill','bi-dash-circle-fill');
    }else if (icon.classList.contains('bi-dash-circle-fill')) {
        icon.classList.replace('bi-dash-circle-fill','bi-plus-circle-fill');
    }
    alert('click bouton ajouter une discussion')
});

btnAddresponse.addEventListener('click', () => {
    let icon = document.getElementById('icone');
      
 /*       if (icon.classList.contains('bi-plus-circle-fill')) {
            icon.classList.replace('bi-plus-circle-fill','bi-dash-circle-fill');
        }else{
            icon.classList.replace('bi-dash-circle-fill','bi-plus-circle-fill');
        }*/
        alert('click bouton ajouter une réponse')
    });
