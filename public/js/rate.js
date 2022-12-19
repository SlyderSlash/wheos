window.onload = () =>{

    const stars = document.querySelectorAll('.star');
    const note = document.querySelectorAll('#note');

    console.log(stars);

    for (const star in stars) {
        star.style.color = 'gold'; 
    }

    let prec = this.previousElementSibling;

    while(prec){
        prec.style.color = 'red'
        prec = prec.previousElementSibling;
    }

    for (const star in stars) {
         star.addEventListener('mouseover', function(){
            this.style.color = 'red';
         })   
    }  
}