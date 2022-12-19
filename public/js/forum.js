
let btnAddSujet = document.getElementById('addsujet').addEventListener('click', () => {
    let icon = document.getElementById('icon');
  
    if (icon.classList.contains('bi-plus-circle-fill')) {
        icon.classList.replace('bi-plus-circle-fill','bi-dash-circle-fill');
    }else if (icon.classList.contains('bi-dash-circle-fill')) {
        icon.classList.replace('bi-dash-circle-fill','bi-plus-circle-fill');
    }
});


function changeIcon(e){
    if(e.classList.contains('fa-folder')){
        e.classList.replace('fa-folder','fa-folder-open');
    }else if(e.classList.contains('fa-folder-open')){
        e.classList.replace('fa-folder-open','fa-folder');
    }
}



