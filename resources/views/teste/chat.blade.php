
<style>
    *{
        margin: 0px;
        
    }
    #container{
        display: flex;
        width: 90vw;
        height: 80vh;
        margin: 40px auto auto auto;
        background-color: rgb(202, 202, 202);
    }
    #left{
        width: 30%;
        height: 100%;
        border: 1px solid rgb(111, 0, 255);
    }
    #leftOptions{
        width: 100%;
        height: 8%;
        padding: 0;
        margin: 0;
        border: 1px solid white;
        list-style: none;
        display: flex;
        justify-content: space-around;
    }
    #leftOptions li:hover{
        color: red;
    }
    #leftOptionsContainer{
        display: flex;
        width: 100%;
        height: 91%;
        overflow-x: hidden;
    }
    .option{
        width: 100%;
        height: 100%;
    }
    .none{
        display: none;
    }
    .red{
        background-color: red;
    }
    .green{
        background-color: green;
    }
    .translate{
        transform: translateX(-150%);
    }
    #right{
        width: 70%;
        height: 100%;
        border: 1px solid rgba(255, 0, 0, 0);
    }
    
</style>



<div id="container">
    <div id="left">
        <ul id="leftOptions">
            <li id="conversas">
                conversas
            </li>
            <li id="followers">
                followers  
            </li>
        </ul>
        <div id="leftOptionsContainer">
            <div id="boxFollowers" class="option red none">
                <ul>
                    <li>
                        follower
                    </li>
                    <li>
                        follower
                    </li>
                    <li>
                        follower
                    </li>
                    <li>
                        follower
                    </li>
                    <li>
                        follower
                    </li>
                </ul>
            </div>
            <div id="boxConversas" class="option green">
                <ul>
                    <li>
                        conversa
                    </li>
                    <li>
                        conversa
                    </li>
                    <li>
                        conversa
                    </li>
                    <li>
                        conversa
                    </li>
                    <li>
                        conversa
                    </li>
                </ul>
            </div>
        </div>

    </div>
    <div id="right">

    </div>

    <script>
        let followers = document.getElementById('followers')
        let conversas = document.getElementById('conversas')
        let boxFollowers = document.getElementById('boxFollowers')
        let boxConversas = document.getElementById('boxConversas')

        followers.addEventListener('click',mudaLeftOtion, false)
        conversas.addEventListener('click',mudaLeftOtion, false)

        function mudaLeftOtion(){
            if(this.id == 'followers'){
                boxConversas.classList.add('none')
                boxFollowers.classList.remove('none')
            }
            if(this.id == 'conversas'){
                boxFollowers.classList.add('none')
                boxConversas.classList.remove('none')
            }
        }
    </script>
</div>