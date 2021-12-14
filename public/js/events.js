
// Abrir box de notificação
    document.getElementById('not').addEventListener('click',abreNot())
    function abreNot(){ 
        document.getElementById('not').addEventListener('click',()=>{
            let notificationsContainer = document.getElementById('notifications')
            notificationsContainer.style.visibility = 'visible';
            notificationsContainer.style.transform = 'scale(1)';

        }) 
    }

// Fechar box de notificação
    document.getElementById('closeNotBox').addEventListener('click',fechaNot())
    function fechaNot(){
        document.getElementById('closeNotBox').addEventListener('click',()=>{
            console.log('oi')
            let notificationsContainer = document.getElementById('notifications')
            notificationsContainer.style.visibility = 'collapse';
            notificationsContainer.style.transform = 'scale(0)';
        })
    }

// Abrir box de seguindo
    document.getElementById('follows').addEventListener('click',abreFollowsBox())
    function abreFollowsBox(){
        document.getElementById('follows').addEventListener('click',()=>{
            let followsContainer = document.getElementById('followsBox')
            followsContainer.style.visibility = 'visible';
            followsContainer.style.transform = 'scale(1)';

        })
    }

// Fechar box de seguindo
    document.getElementById('closeFollowsBox').addEventListener('click',fechaFollowsBox())
    function fechaFollowsBox(){
        document.getElementById('closeFollowsBox').addEventListener('click',()=>{
            let followsContainer = document.getElementById('followsBox')
            followsContainer.style.visibility = 'collapse';
            followsContainer.style.transform = 'scale(0)';
        })
    }
    
// Abrir box de seguidores
    document.getElementById('followers').addEventListener('click',abreFollowersBox())
    function abreFollowersBox(){
        document.getElementById('followers').addEventListener('click',()=>{
            let followersContainer = document.getElementById('followersBox')
            followersContainer.style.visibility = 'visible';
            followersContainer.style.transform = 'scale(1)';

        })
    }

// Fechar box de seguidores
    document.getElementById('closeFollowersBox').addEventListener('click',fechaFollowersBox())
    function fechaFollowersBox(){
        document.getElementById('closeFollowersBox').addEventListener('click',()=>{
            let followersContainer = document.getElementById('followersBox')
            followersContainer.style.visibility = 'collapse';
            followersContainer.style.transform = 'scale(0)';
        })
    }

