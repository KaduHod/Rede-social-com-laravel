@extends('layouts.main')

@section('title','Crud')
@section('content')
<div style="
display:flex;
flex-direction:column;
align-items:center;
width:100%;
">
  <div class="tituloEditUserContainer" style="display: flex;heigth:fit-content;">
    <a href="/editUser/{{Auth::user()->id}}"> <h1>Editar perfil</h1></a> <h1>Customizar layout</h1>
  </div>
      <form class="formColors" class='form-group' action="/editLayoutStore" method="post">
          @csrf
          <div class="grupo_de_cores">
              <div class="" id="colorHeader">
                  <h5>Cor do corpo do cabeçalho</h5>
                  <div class="radio " >
                    <label class="orange  colorLabel">
                      <input type="radio"  name="Cor_de_header_perfil"  value="orange">
      
                    </label>
                  </div>
                  <div class="radio">
                    <label class="black colorLabel">
                      <input type="radio" name="Cor_de_header_perfil"  value="black">
                    </label>
                  </div>
                  <div class="radio">
                    <label class="white  colorLabel">
                      <input type="radio" name="Cor_de_header_perfil"   value="white">
                    </label>
                  </div>
              </div>
              <div id="colorFooter">
                  <h5>Cor do corpo do rodapé</h5>
                  <div class="radio">
                    <label class="orange  colorLabel">
                      <input type="radio" name="Cor_de_footer_corpo"  value="orange">
      
                    </label>
                  </div>
                  <div class="radio">
                    <label class="black colorLabel">
                      <input type="radio" name="Cor_de_footer_corpo"  value="black">
                    </label>
                  </div>
                  <div class="radio">
                    <label class="white  colorLabel">
                      <input type="radio" name="Cor_de_footer_corpo"   value="white">
                    </label>
                  </div>
              </div>
              <div id="colorBanner">
                  <h5>Cor do corpo da dashboard</h5>
                  <div class="radio">
                    <label class="orange  colorLabel">
                      <input type="radio" name="Cor_de_fundo_perfil"  value="orange">
      
                    </label>
                  </div>
                  <div class="radio">
                    <label class="black colorLabel">
                      <input type="radio" name="Cor_de_fundo_perfil"  value="black">
                    </label>
                  </div>
                  <div class="radio">
                    <label class="white  colorLabel">
                      <input type="radio" name="Cor_de_fundo_perfil"   value="white">
                    </label>
                  </div>
              </div>
              <div id="colorBody">
                  <h5>Cor do corpo perfil</h5>
                  <div class="radio">
                    <label class="orange  colorLabel">
                      <input type="radio" name="Cor_de_fundo_corpo"  value="orange">
      
                    </label>
                  </div>
                  <div class="radio">
                    <label class="black colorLabel">
                      <input type="radio" name="Cor_de_fundo_corpo"  value="black">
                    </label>
                  </div>
                  <div class="radio">
                    <label class="white  colorLabel">
                      <input type="radio" name="Cor_de_fundo_corpo"   value="white">
                    </label>
                  </div>
              </div>
          </div>
  
          <button type="submit" class="btn btn-dark">Submit</button>

</div>


@endsection