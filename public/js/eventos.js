
var statusBox = {
    'Notificação':false,
    'Follows': false,
    'Followers':false
}

// Abrir box de notificação
    document.getElementById('not').addEventListener('click',abreNot())
    function abreNot(){ 
        document.getElementById('not').addEventListener('click',()=>{
            let notificationsContainer = document.getElementById('notifications')
            notificationsContainer.style.visibility = 'visible';
            notificationsContainer.style.transform = 'scale(1)';
            statusBox.Notificação = true 
            console.log(statusBox) 
            fechaBoxAbertas('Notificação')
            
        }) 
        
    }

// Fechar box de notificação
    document.getElementById('closeNotBox').addEventListener('click',fechaNot())
    function fechaNot(){
        document.getElementById('closeNotBox').addEventListener('click',()=>{
            let notificationsContainer = document.getElementById('notifications')
            notificationsContainer.style.visibility = 'collapse';
            notificationsContainer.style.transform = 'scale(0)';
            statusBox.Notificação = false
             
        })
        
    }
    function fechaNoti(){
        let notificationsContainer = document.getElementById('notifications')
            notificationsContainer.style.visibility = 'collapse';
            notificationsContainer.style.transform = 'scale(0)';
            statusBox.Notificação = false
            
    }

// Abrir box de seguindo
    document.getElementById('follows').addEventListener('click',abreFollowsBox())
    function abreFollowsBox(){
        document.getElementById('follows').addEventListener('click',()=>{
            let followsContainer = document.getElementById('followsBox')
            followsContainer.style.visibility = 'visible';
            followsContainer.style.transform = 'scale(1)';
            statusBox.Follows = true 
            console.log(statusBox) 
            fechaBoxAbertas('Follows')

        })
        
    }

// Fechar box de seguindo
    document.getElementById('closeFollowsBox').addEventListener('click',fechaFollowsBox())
    function fechaFollowsBox(){
        document.getElementById('closeFollowsBox').addEventListener('click',()=>{
            let followsContainer = document.getElementById('followsBox')
            followsContainer.style.visibility = 'collapse';
            followsContainer.style.transform = 'scale(0)';
            statusBox.Follows = false 
            console.log(statusBox)
        })
         
    }
    
    function fechaFollowsBox2(){
        let followsContainer = document.getElementById('followsBox')
            followsContainer.style.visibility = 'collapse';
            followsContainer.style.transform = 'scale(0)';
            statusBox.Follows = false 
    }
    
// Abrir box de seguidores
    document.getElementById('followers').addEventListener('click',abreFollowersBox())
    function abreFollowersBox(){
        document.getElementById('followers').addEventListener('click',()=>{
            let followersContainer = document.getElementById('followersBox')
            followersContainer.style.visibility = 'visible';
            followersContainer.style.transform = 'scale(1)';
            statusBox.Followers = true 
            console.log(statusBox) 
            fechaBoxAbertas('Followers')

        })
        
    }

// Fechar box de seguidores
    document.getElementById('closeFollowersBox').addEventListener('click',fechaFollowersBox())
    function fechaFollowersBox(){
        document.getElementById('closeFollowersBox').addEventListener('click',()=>{
            let followersContainer = document.getElementById('followersBox')
            followersContainer.style.visibility = 'collapse';
            followersContainer.style.transform = 'scale(0)';
            statusBox.Followers = false
            console.log(statusBox)
        })
    }

    function fechaFollowersBox2(){
        let followersContainer = document.getElementById('followersBox')
            followersContainer.style.visibility = 'collapse';
            followersContainer.style.transform = 'scale(0)';
            statusBox.Followers = false
    }

    function fechaBoxAbertas(tipoBox){
        for(tipoBoxStautsBox in statusBox){
            if(tipoBoxStautsBox != tipoBox){
                console.log(statusBox[tipoBoxStautsBox])
                switch (tipoBoxStautsBox){
                    
                    case 'Notificação':
                        
                        if(statusBox[tipoBoxStautsBox]== true){
                            fechaNoti()
                            statusBox[tipoBoxStautsBox] = false
                            console.log('fechando' + tipoBoxStautsBox)
                        }
                        break;
                    case 'Follows':
                        if(statusBox[tipoBoxStautsBox]== true){
                            fechaFollowsBox2()
                            statusBox[tipoBoxStautsBox] = false
                            console.log('fechando' + tipoBoxStautsBox)
                        }
                        break;
                    case 'Followers':
                        if(statusBox[tipoBoxStautsBox]== true){
                            fechaFollowersBox2()
                            statusBox[tipoBoxStautsBox] = false
                            console.log('fechando' + tipoBoxStautsBox)
                        }
                        break;
                }
            }
        }
        
    }

    





