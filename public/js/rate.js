
    const stars = document.querySelectorAll('.star-forum');
    let note = 0;

    stars.forEach((star,i) => {
        
        star.addEventListener('mouseover', function(){
            resetColor();
            this.style.color = 'red';

            let preStar = this.previousElementSibling;
            
            while(preStar){
                preStar.style.color = 'red';
                preStar = preStar.previousElementSibling;
            }
        });

        star.addEventListener('click', function(){
            note = this.dataset.value;
        })

        star.addEventListener('mouseout', function(){
            resetColor(note);
        })
    })

    function resetColor(note = 0){
        stars.forEach((star,i) => {
            if(star.dataset.value > note){
                star.style.color = 'red';
            }else{
              star.style.color = 'gold';  
            }
        })
    }