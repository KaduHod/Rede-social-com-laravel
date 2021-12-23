let iconeComentarios = document.querySelectorAll('.iconeComentarios')
iconeComentarios.forEach(e=>{
    e.addEventListener('click',mostraAreaDeComentarios,false)
    
})



function mostraAreaDeComentarios(){   
    let ulComments = document.querySelector(`#ulComments${this.id}`)
    console.log(ulComments)
    ulComments.style.height = '600px'
    ulComments.style.padding = '5px'
    
    let comentarios = nodeListToArray(ulComments.childNodes)
    comentarios.forEach(e=>{
        e.style.display = 'flex'
    })
    this.removeEventListener('click', mostraAreaDeComentarios, false);
    this.addEventListener('click',fecharAreaDeComentarios,false)
}

function fecharAreaDeComentarios(){
    let ulComments = document.querySelector(`#ulComments${this.id}`)
    ulComments.style.height = '0px'
    ulComments.style.padding = '0px'
    let comentarios = nodeListToArray(ulComments.childNodes)
    comentarios.forEach(e=>{
        e.style.display = 'none'
    })
    this.removeEventListener('click',fecharAreaDeComentarios, false);
    this.addEventListener('click',mostraAreaDeComentarios,false)
}

function nodeListToArray(childNodes){
    let arrRetorno = []
    childNodes.forEach((e,index)=>{
        if(index%2 != 0) arrRetorno.push(e)
    })
    return arrRetorno
}