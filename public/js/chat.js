let conversationUserWithUsers = document.querySelectorAll('.chatUsersOption')

conversationUserWithUsers.forEach(i=>{
    i.addEventListener('click',montarChatBox, false)
})

function montarChatBox(){
    document.getElementById('chatUserProfilePic').style.backgroundImage = this.children[0].style['background-image'] // boto foto do user selecionado no box
    document.getElementById('nomeUser').innerHTML = this.children[1].children[0].children[0].innerHTML // boto o nome do user no titulo
    
    botaMensagensNoTextsCoversation(this.id)  
}





followers.addEventListener('click',mudaLeftOption, false)
chats.addEventListener('click',mudaLeftOption, false)

function mudaLeftOption(){
    let followers = document.getElementById('followers')
    let chats = document.getElementById('chats')
    let boxFollowers = document.getElementById('boxFollowers')
    let boxChats = document.getElementById('boxChats')

    
    if(this.id == 'followers'){
        boxChats.classList.add('none')
        boxFollowers.classList.remove('none')
        followers.classList.remove('iconeLeftSideChat')
        followers.classList.add('white2')
        chats.classList.remove('white2')
        chats.classList.add('iconeLeftSideChat')
    }
    if(this.id == 'chats'){
        boxFollowers.classList.add('none')
        boxChats.classList.remove('none')
        chats.classList.remove('iconeLeftSideChat')
        chats.classList.add('white2')
        followers.classList.remove('white2')
        followers.classList.add('iconeLeftSideChat')
        
    }
}



function botaMensagensNoTextsCoversation(userNameDoChat){
    
    let chatEscolhido = retornaNomeTypeId(userNameDoChat)
    
    let textBox = document.querySelector('.textsCoversation')
    
    limpaChat()


    document.getElementById('chat_id').value = chatEscolhido.chat_id
    document.getElementById('guest_id').value = chatEscolhido.user_id
    




    if(userObj[chatEscolhido['userName']].mensagensDoChat.length > 0){
        userObj[chatEscolhido['userName']].mensagensDoChat.forEach(msg => {
            let novaMSG = document.createElement('li')
            novaMSG.innerHTML = msg.message
            novaMSG.classList.add('msgTextConversation','shadow')
            
            if(msg.user_id != chatEscolhido['user_id'] ){
                novaMSG.classList.add('userMSG')
            }else{
                novaMSG.classList.add('guestMSG')
            }
            textBox.appendChild(novaMSG)
        })
    }
    mudaActionFormChat(chatEscolhido)


} 
function mudaActionFormChat(chatEscolhido){
    
    let formSandMassage = document.getElementById('formSandMassage')
    if(chatEscolhido['type'] == 'chat'){
        formSandMassage.action = '/chat/postMassage'
    }else{
        formSandMassage.action = '/chat/createChat'
    }
    if(chatEscolhido['chat_id'] == ''){
        formSandMassage.action = '/chat/createChat'
    }else{
        formSandMassage.action = '/chat/postMassage'
    }
} 




function limpaChat(){
    textBox = document.querySelector('.textsCoversation')
    textBox.innerText = ''
}

function retornaNomeTypeId(string){
    obj = {
        'type': string.split('-')[0],
        'userName':string.split('-')[1],
        'user_id':string.split('-')[2],
        'chat_id':string.split('-')[3]
    }

    console.log(obj['chat-id'])
    
    if(document.getElementById(`chat-${obj['userName']}-${obj['user_id']}`)) obj['type'] = 'chat'
    if(obj['chat_id'] == undefined) obj['type'] = 'follower'

    return obj
    
}


function animacaoChatOption(){
    let optionsChat = document.querySelectorAll('.chatUsersOption') 
    optionsChat.forEach(e=>{
       e.addEventListener('click',()=>{
           tiraAnimacaoChatOption(optionsChat)
           e.classList.add('move_lado')
           console.log(e)
           console.log('---------------')
       },false)
    })
}

function tiraAnimacaoChatOption(arr){
    arr.forEach(e=>{
        e.classList.remove('move_lado')
    }) 
}   

function delimitaUltimaMensagem(){
    let ultimasMensagens = document.querySelectorAll('.ultimaMensagem')

    ultimasMensagens.forEach(e=>{
        if(e.innerHTML.length > 17){
            e.innerHTML = trocaConteudoDeUltimaMensagemMuitoLongo(e.innerHTML)
        }
        
    })
    
}
function trocaConteudoDeUltimaMensagemMuitoLongo(str){
    let strToArray = str.split("")
    let novaString = ''
    count = 0
    while(count < 18){
        novaString+= strToArray[count]
        count++
    }
    if(novaString.length < 19){
        console.log('cheguei aqui')
        novaString+= '...'
    }
    

    return novaString
}

console.log(userObj)
delimitaUltimaMensagem()
animacaoChatOption()

