@extends('layouts.main')

@section('title','Crud')
@section('content')

<div class="" id='pubContainerMain'>
    <h1>Criar publicação</h1>
    <form action="/storePub"  class="form-control" style="padding: 20px" method="post" enctype='multipart/form-data'>
        @csrf
        <img class="card" id="cardImagePreview">
        
        <div class="form-group">
            <label for="image"><h4>Upload da imagem da publicação</h4></label> <br>
            <input type="file" name='image' value="" id='pubImage' class="form-control-file">
        </div>
        <div class="form-group">
            <label for="description"><h4>Descrição</h4></label>
            <textarea name="description" class="form-control pubInput" id="pubDescription" cols="30" rows="5"></textarea>
        </div>
        <div class="form-group">
            <label for="Tags"><h4>#Tags</h4></label>
            <input type="text" class="form-control pubInput" name="tags" id="pubTags">
        </div>
        <div class="form-group">
            <label style="margin-bottom:10px"><h4>Marque alguem na publicação</h4> Clique <kbd>Enter</kbd> para adicionar ou clique na opção que aparecer!</label>
            <input type="text" list="list-users" style="margin-top:15px;width: 100%;border:1px solid solid #e7e7e7"   
            
                placeholder=''
                class='form-control flexdatalist'
                data-min-length='1'
                multiple='multiple'
                list='list-users'
                name="usuariosLinkados">
            <datalist id="list-users"  >
                @foreach($followers as $follower)
                    <option class='follows_name' value="{{$follower->id}}">{{$follower->name}}</option>
                @endforeach
            </datalist>
            
        </div>  
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="privado" value="0" id="flexRadioDefault1">
                <label class="form-check-label" for="flexRadioDefault1">
                  Público
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="privado" value="1" id="flexRadioDefault2" checked>
                <label class="form-check-label" for="flexRadioDefault2">
                    Privado
                </label>
              </div>
        </div>
        <div class="form-group">
            <button type="submit"  class="btn btn-dark">Publicar</button>
            <input class="btn btn-secondary" type="reset" value="Reset">
        </div>
        
    </form>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js">
        
    </script>
    <script>
        $(function(){
            $('#pubImage').change(function(){
                const file = $(this)[0].files[0]
                console.log(file)
                document.getElementById('cardImagePreview').setAttribute('style','height:300px; width:100%; border:1px solid solid #e7e7e7')
                const fileReader = new FileReader()
                console.log('oi')
                fileReader.onloadend = function(){
                    $('#cardImagePreview').attr(`src`,fileReader.result)
                }
                fileReader.readAsDataURL(file)
            })
        })
        $('.flexdatalist').flexdatalist({
            minLength: 1
        });
        
    </script>
</div>
    

    
@endsection