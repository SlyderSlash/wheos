let btnAddresponse = document.getElementById('add').addEventListener('click', () => {
    let icon = document.getElementById('circle');
      
    if (icon.classList.contains('bi-plus-circle-fill')) {
        icon.classList.replace('bi-plus-circle-fill','bi-dash-circle-fill');
    }else if (icon.classList.contains('bi-dash-circle-fill')){
        icon.classList.replace('bi-dash-circle-fill','bi-plus-circle-fill');
    }
});