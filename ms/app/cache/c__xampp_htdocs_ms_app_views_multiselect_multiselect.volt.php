<?php echo $this->getContent(); ?>
<?php
	echo "<br />";
	echo "<br />";
	echo $dato_view;
    
?>

<h3>DESDE PAGINA</h3>

<h2>Multiselect</h2>
<form action="test_submit" method="get" accept-charset="utf-8">
  <ol style="list-style: none;">        
    <li id="facebook-list" class="input-text">
      <input type="text" value="" id="facebook-demo" />
      <ul id="preadded" style="display:none">
          <li value="1">Jorge Luis Borges</li>
          <li value="2">Julio Cortazar</li>           
      </ul>
      <div id="facebook-auto">
        <div class="default">Escriba el texto aqui...</div> 
        <ul id="feed">
          
        </ul>
      </div>
    </li>
  </ol>   
</form>

<script type="text/javascript">
    $(document).ready(function() {        
      $.facebooklist('#facebook-demo', 
                     '#preadded', 
                     '#facebook-auto',
                     //{url:'/ms/public/assets/fcbk/fetched.php', cache:1}, 
                     //{url:'/ms/Multiselect/Datos', cache: 1}, 
                     {url:'/ms/Multiselect/DatosAjax', cache: 1}, 
                     //{url:'/ms/Multiselect/municipios', cache: 1}, 
                     10, 
                     {userfilter: 1, casesensetive: 1});
    });       
</script>



