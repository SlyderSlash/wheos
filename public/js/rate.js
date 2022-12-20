window.onload = () =>{

    const stars = document.querySelectorAll('.star');
    const note = document.querySelectorAll('#note');

    console.log(stars);

    for (star in stars) {
        star.style.color = 'red'; 
    }

    let prec = this.previousElementSibling;

    while(prec){
        prec.style.color = 'red'
        prec = prec.previousElementSibling;
    }

    for (star in stars) {
         star.addEventListener('mouseover', function(){
            this.style.color = 'red';
         })   
    }  
}