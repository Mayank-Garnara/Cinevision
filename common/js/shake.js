function shake(shakingElement,errorElement){
    shakingElement.classList.add('error-border', 'shake-animation');
    errorElement.style.display = 'block';

    // Remove shake animation after it completes
    setTimeout(() => {
        shakingElement.classList.remove('shake-animation');
    }, 700);

}