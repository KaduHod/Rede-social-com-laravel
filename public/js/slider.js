    let previous = document.getElementById('previous')
    let next = document.getElementById('next')
    let slider = document.getElementById('backgroundArea')
        
    next.addEventListener('click', previousSlide, false)
    previous.addEventListener('click', nextSlide, false)
    
    function retornaNSlider(){
        let string = slider.style['background-image'].split('/')[3].split('')[0]
        return string
    }
    pos = parseInt(retornaNSlider())

    function nextSlide(){
        if (pos == 4){
            pos = 1
            slider.style.backgroundImage = `url("/img/slider/${pos}.jpg")`
        }else {
            pos = pos + 1
            console.log(pos)
            slider.style.backgroundImage = `url("/img/slider/${pos}.jpg")`
        }
        console.log(slider)
    }

    function previousSlide(){
        if (pos <= 1){
            pos = 4
            slider.style.backgroundImage = `url("/img/slider/${pos}.jpg")`
        }else{
            pos = pos - 1
            console.log(pos)
            slider.style.backgroundImage = `url("/img/slider/${pos}.jpg")`
        }
        
    }