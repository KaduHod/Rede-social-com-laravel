let iconesDescurtido = document.querySelectorAll('.iconeDescurtido')
let iconesCuritido = document.querySelectorAll('.iconeCurtido')


function curtir(e){
    e.classList.remove('iconeDescurtido')
    e.classList.add('iconeCurtido')
}

iconesDescurtido.forEach(e=>{
    e.addEventListener('click',curtir,false)
})
function curtir(){
    this.classList.remove('iconeDescurtido')
    this.classList.add('iconeCurtido')
    this.removeEventListener('click',curtir, false)
    this.addEventListener('click',descurtir,false)
}
function descurtir(){
    this.classList.remove('iconeCurtido')
    this.classList.add('iconeDescurtido')
    this.removeEventListener('click',descurtir, false)
    this.addEventListener('click',curtir,false)
}


let boxDescricao = document.querySelectorAll('.botaoDescrição')
boxDescricao.forEach(e=>{
    e.addEventListener('click',mostraDescricao,false)
})

function mostraDescricao(){
    
    
    pubID = this.id.replace(/([^\d])+/gim, '');
    
    let textDescription = document.getElementById(`texto${pubID}`)
    let containerDescription = document.getElementById(`containerDescription${pubID}`)
    textDescription.classList.remove('hidden')
    containerDescription.style.height = 'fit-content'
    this.removeEventListener('click',mostraDescricao,false)
    this.addEventListener('click',fecharDescricao,false) 
    this.innerHTML = 'Fechar descrição...'
}
function fecharDescricao(){
    pubID = this.id.replace(/([^\d])+/gim, '');
    let containerDescription = document.getElementById(`containerDescription${pubID}`)
    let textDescription = document.getElementById(`texto${pubID}`)
    textDescription.classList.add('hidden')
    containerDescription.style.height = '0px'
    this.removeEventListener('click',fecharDescricao,false)
    this.addEventListener('click',mostraDescricao,false)
    this.innerHTML = 'Ver descrição...'
}