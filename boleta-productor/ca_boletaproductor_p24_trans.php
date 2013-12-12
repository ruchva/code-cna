<?php require_once $_SERVER["DOCUMENT_ROOT"]."/ine_ca/connections/dbca.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/ine_ca/class/ca_boletaproductordb.php"; ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
   
}
/*$MM_authorizedUsers = "'.$row_permisos[acceso_usr].'";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) {
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False;

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username.
  // Therefore, we know that a user is NOT logged in if that Session variable is blank.
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login.
    // Parse the strings into arrays.
    $arrUsers = Explode(",", $strUsers);
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "/ine_ca/nopermiso.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  $_SESSION['MM_UbigacionGeografica'] = NULL;
  $_SESSION['MM_NumeroFolio']=NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
  unset($_SESSION['MM_UbigacionGeografica']);
  unset($_SESSION['MM_NumeroFolio']);
  $direccion=$_SERVER["DOCUMENT_ROOT"]."/ine_ca/cerrar.php";
  $logoutGoTo ="/ine_ca/cerrar.php";
//    $logoutGoTo ="/ine_ca/cerrar.php";;
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}*/
?>
<!DOCTYPE html>
<meta charset="UTF-8">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Boleta Productor</title>
<script language="JavaScript">
    function A(e,t){
        var k=null;
        (e.keyCode) ? k=e.keyCode : k=e.which;
        if(k==13) (!t) ? B() : t.focus();
    }
    function B(){
        document.forms[0].submit();
        return true;
    }
</script>
<script type="text/javascript">
    function ActivarCampoOtroTema(otrotema){
        var contenedor = document.getElementById(otrotema);
        contenedor.style.display = "block";
        return true; 
    }
</script>
<script type="text/javascript">
    function DesactivarCampoOtroTema(otrotema){
        var contenedor = document.getElementById(otrotema);
        contenedor.style.display = "none";
        return true;
    }
</script>
<script type="text/javascript">
    function enviar(form,boton){
        form.botPress.value = boton;
        form.submit();
    }
</script>
<script type="text/javascript">
    function verificarEntrada(control){
        if (control.value=='0' || control.value=='_' || control.value=='__' || control.value=='' || control.value=='_______' || control.value=='__-_')    
        {
                control.focus();
           alert('Debe ingresar dato');
        }
    }
</script>
<script type="text/javascript">
    function selecciona_value(objInput) {
        var valor_input = objInput.value;
        var longitud = valor_input.length;

        if (objInput.setSelectionRange) {
            objInput.focus();
            objInput.setSelectionRange (0, longitud);
        }
        else if (objInput.createTextRange) {
            var range = objInput.createTextRange() ;
            range.collapse(true);
            range.moveEnd('character', longitud);
            range.moveStart('character', 0);
            range.select();
        }
    }
</script>
<script type="text/javascript" src="/ine_ca/Scripts/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/ine_ca/Scripts/jquery.maskedinput.js"></script>
<script type="text/javascript" src="/ine_ca/Scripts/jquery.alphanumeric.js"></script> 
<script type="text/javascript">
jQuery(function($){

$("#txtnum_brig").mask("99");
$("#txtnum_empa").mask("9");
$("#txtnum_seg").mask("9");
$("#txtnum_control").mask("9999");

});	
</script>

<script type="text/javascript">
function mayuscula(campo){
    $(campo).keyup(function() {
        $(this).val($(this).val().toUpperCase());
    });
}
$(document).ready(function(){	
    mayuscula("input.novecientos_px"); 	
    mayuscula("input.trecientos_px");
    mayuscula("input.quinientos_px"); 	
});
</script>
<!-- Estilos Boleta -->
<style type="text/css">
	.text-box{            
		width: 100px;
		background-color: #CFE;		
	}  
	.quinientos_px{
		width: 500px;
		background-color: #CFE;
	}  
	.novecientos_px{
		width: 900px;
		background-color: #CFE;
	}        
	.cuarenta_px{
		width: 40px;
		background-color: #CFE;
		margin-right: 0px;
	}
	.trecientos_px{
		width: 300px;
		background-color: #CFE;
	}
	#titulo{
		margin: 0;
		padding: 0;
		position: absolute;
		font-family:Georgia, "Times New Roman", Times, serif;
		color:#1B6806;		
	}	
	input:focus{
		background-color:#C4F45D;
		font-size: 11pt;		
	}
	.fuente{
		font-size: 10pt;
		font-family:"Trebuchet MS", Times, serif;
	}
	#correlativo{
		float: left;
	}
		
</style> 
<!-- InstanceEndEditable -->
<style type="text/css">
<!--
body {
	background-color: #0000FF;
}
.menubarmodulo {
	font-family: "Comic Sans MS";
	font-size: 12px;
	font-style: normal;
	font-weight: bold;
	color: #000000;
}
.Estilo2 {
	font-family: "Comic Sans MS";
	font-size: 25px;
	font-style: italic;
	font-weight: bold;
	color: #000000;
}

-->
</style>
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable --><!-- InstanceParam name="region1" type="boolean" value="true" -->
<!--<link href="../css/formatos.css" rel="stylesheet" type="text/css" />-->
<!--<link href="../css/a4.css" rel="stylesheet" type="text/css" />-->
<link href="../../css/formato.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
/*if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}*/

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Idaladm'])) {
  $colname_Recordset1 = $_SESSION['MM_Idaladm'];
}
////mysql_select_db($database_dbca, $dbca);
//$query_Recordset1 = sprintf("SELECT * FROM usuarios, t_unidades WHERE usuarios.id_usr = %s AND t_unidades.CodigoUnidad=usuarios.nivel_usr", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = pg_query($dbca,"SELECT * FROM usuarios, t_unidades WHERE usuarios.id_usr ='$colname_Recordset1' AND t_unidades.CodigoUnidad=usuarios.nivel_usr")  or die ("Error de conexion. ". pg_last_error());
$row_Recordset1 = pg_fetch_assoc($Recordset1);
$totalRows_Recordset1 = pg_num_rows($Recordset1);

$colname_permisos = "-1";
if (isset($_SESSION['MM_Idaladm'])) {
  $colname_permisos = $_SESSION['MM_Idaladm'];
}
////mysql_select_db($database_dbca, $dbca);
//$query_permisos = sprintf("SELECT * FROM usuarios, t_unidades WHERE usuarios.id_usr = %s AND t_unidades.CodigoUnidad=usuarios.nivel_usr", GetSQLValueString($colname_permisos, "int"));
$permisos = pg_query($dbca,"SELECT * FROM usuarios, t_unidades WHERE usuarios.id_usr ='$colname_permisos' AND t_unidades.CodigoUnidad=usuarios.nivel_usr") or die ("Error de conexion. ". pg_last_error());
$row_permisos = pg_fetch_assoc($permisos);
$totalRows_permisos = pg_num_rows($permisos);

$mod_listamenu = "-1";
if (isset($row_permisos['nivel_usr'])) {
  $mod_listamenu = $row_permisos['nivel_usr'];
}
$men_listamenu = "-1";
if (isset($row_permisos['acceso_usr'])) {
  $men_listamenu = $row_permisos['acceso_usr'];
}
////mysql_select_db($database_dbca, $dbca);
//$query_listamenu = sprintf("SELECT * FROM sis_menu_ca WHERE acceso_modulo=%s and acceso_menu=%s ORDER BY orden_menu ASC", GetSQLValueString($mod_listamenu, "text"),GetSQLValueString($men_listamenu, "int"));
$listamenu = pg_query($dbca,"SELECT * FROM sis_menu_ca WHERE acceso_modulo='$mod_listamenu' and acceso_menu='$men_listamenu' ORDER BY orden_menu ASC")  or die ("Error de conexion. ". pg_last_error());
$row_listamenu = pg_fetch_assoc($listamenu);
$totalRows_listamenu = pg_num_rows($listamenu);
?>
<table width="100%" border="0" align="center" cellspacing=0 cellpadding=0>
  <tr>
    
    <td width="742" ><img src="../../images/top1.gif" width="100%" height="35" /></td>
    
  </tr>
  <tr>
   
    <td bgcolor="#CCCCCC"> 
   
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td align="center" valign="middle"><table width="100%" border="0">
      <tr>
        <td width="117"><div align="center"><img src="../../images/ine.jpg" width="110" height="40" align="middle" /></div></td>
        <td width="535"><div align="center"></div></td>
        <td width="117"><div align="center"></div></td>
      </tr>
    </table>
    <img src="../../imgdiseno/lilnea.gif" width="700" height="10" /></td>
  </tr>
  <tr>
    <td>
      <table width="100%" border="0" align="center">
        <tr>
          <td><div align="right" class="menubarmodulo"><span class="formatos">Usuario:<strong>&nbsp;<?php echo $row_permisos['nom_usr']; ?>&nbsp;<?php echo $row_permisos['app_usr']; ?>&nbsp;<?php echo $row_permisos['apm_usr']; ?> Unidad: <?php echo $row_permisos['Descripcion']; ?><br></strong> <a href="<?php echo $logoutAction ?>">Desconectar</a></span>> </div></td>
        </tr>
        <tr>
        <td align="center" class="interlineado_menu">
        <hr  size="2"/>
        <div id="menuhori">
        <a href="/ine_ca/paneldecontroladm.php"> Menú Principal</a>             <?php do { ?>
      <?php if(($row_permisos['nivel_usr']==$row_listamenu['acceso_modulo'])&&($row_permisos['acceso_usr']==$row_listamenu['acceso_menu'])) { echo '         

  
  <a href="'.$row_listamenu['url_menu'].'">'.$row_listamenu['nom_menu'].'</a>';}?>
	  <?php } while ($row_listamenu = pg_fetch_assoc($listamenu)); ?>
        </div>
        <hr  size="2"/>
        </td>
        </tr>
        <tr>
          <td><table   width="100%" border="0">
          
            <tr>
              <td width="100%" align="center" valign="top">
               
                  <!-- InstanceBeginEditable name="region2" -->
<?php 
echo $docID = $_REQUEST['DOC_ID'];
echo $folioComunal = $_REQUEST['folio'];//parametro comunal
$objIns = new ca_boletaproductordb();		
echo $arrayCabecera = $objIns->ca_obtiene_cabecera_por_folio($_REQUEST['folio']);
?>
<?php

if (isset($_POST["botPress"]) && ($_POST["botPress"]=="insertar")) {	
    $existe = $objIns->ca_existe_folio_productor($_POST['txtFolio']);	
    if($existe != 0) { 
        echo '<script>
                 window.alert("ESTA BOLETA YA FUE TRANSCRITA");	
                 window.location = "/ine_ca/censoagropecuario/transcripcion_boletaproductor/ca_boletaproductor_inserta_trans.php";
              </script>';			
    }
    else {
        $objIns->ca_inserta_boleta_productor_p1($docID, $_POST['txtFolio'], $_POST['txtnum_brig'], $_POST['txtnum_empa'], $_POST['txtnum_seg'], $_POST['txtnum_control'], $_POST['txtP1'], $_POST['txtP2'], $_POST['txtP3'], 
            $_POST['txtP4'], $_POST['txtP5'], $_POST['txtP6_1'], $_POST['txtP6_2'], $_POST['txtP12'], $_POST['txtP13'], $_POST['txtP14'], 1, 'prueba-trans', '127.0.0.1');

        $objIns->ca_inserta_boleta_productor_p2($docID, $_POST['txtFolio'], $_POST['txtnum_brig'], $_POST['txtnum_empa'], $_POST['txtnum_seg'], $_POST['txtnum_control'], $_POST['txtP1'], $_POST['txtP2'], $_POST['txtP3'], 
            $_POST['txtP4'], $_POST['txtP5'], $_POST['txtP6_1'], $_POST['txtP6_2'], $_POST['txtP12'], $_POST['txtP13'], $_POST['txtP14'], 1, 'prueba-trans', '127.0.0.1');
                                                                                                                                  
       ?><script>window.location = "/ine_ca/censoagropecuario/transcripcion_boletaproductor/ca_boletaproductor_actualiza_trans.php?folio=<?php echo $_POST['txtFolio']; ?>&foliocomunal=<?php echo $_POST['folioComunal'] ; ?>";</script>
   <?php 
   }
}?>	
<h2 id="titulo">BOLETA DEL PRODUCTOR</h2><br/><br/>
<form action="" method="post" name="boleta_upa">
<div id="p1">
<input type="hidden" name="folioComunal" id="folioComunal" value="<?php echo $_REQUEST['folio']; ?>" />
<table class="fuente" width="100%" style="border: 1px solid #000000;" cellpadding="0" cellspacing="0" >
<h3 id="titulo">P&aacute;gina 1 Cabecera</h3>
<tr>
  <br/>  
  <td colspan="2" align="center" valign="top">	
  <div id="correlativo" >
    Folio: <input class="text-box" name="txtFolio" id="txtFolio" type="text" value="<?php echo $_POST['txtFolio']; ?>" onKeyDown="A(event,this.form.txtnum_empa);" autofocus="autofocus"/>
  </div>
    <?php foreach($arrayCabecera as $row_datos_ca): ?>  
    <table>
      <tr>	
        <td>N&ordm; de brigada</td>
        <td><input class="cuarenta_px" name="txtnum_brig" id="txtnum_brig" type="text" value="<?php echo $row_datos_ca['numerobrigada']; ?>" /></td>
        <td>N &ordf; de empadronador</td>
        <td><input class="cuarenta_px" name="txtnum_empa" id="txtnum_empa" type="text" onKeyDown="A(event,this.form.txtnum_seg);" /></td>
        <td>N&ordm; de segmento</td>
        <td><input class="cuarenta_px" name="txtnum_seg" id="txtnum_seg" type="text" onKeyDown="A(event,this.form.txtnum_control);"/></td>
        <td>N&ordm; hoja de control</td>
        <td><input class="cuarenta_px" name="txtnum_control" id="txtnum_control" type="text" onKeyDown="A(event,this.form.txtP12);"/></td>
      </tr>
    </table>
    <label><strong>I. UBICACI&Oacute;N GEOGR&Aacute;FICA CENSAL DE LA UPA</strong></label>
    <table>
      <tr>
        <td>1. Departamento censal</td>
        <td><input class="cuarenta_px" name="txtP1" id="txtP1" type="text" value="<?php echo $row_datos_ca['cp01_codigodepartamento']; ?>"/></td>
      </tr>                                                                  
      <tr>                                                                   
        <td>2. Provincia censal</td>                                       
        <td><input class="cuarenta_px" name="txtP2" id="txtP2" type="text" value="<?php echo $row_datos_ca['cp02_codigoprovincia']; ?>"/></td>
      </tr>                                                                  
      <tr>                                                                   
        <td>3. Municipio censal</td>                                       
        <td><input class="cuarenta_px" name="txtP3" id="txtP3" type="text" value="<?php echo $row_datos_ca['cp03_codigomunicipio']; ?>"/></td>
      </tr>                                                                  
      <tr>                                                                   
        <td>4. Area censal</td>                                            
        <td><input class="cuarenta_px" name="txtP4" id="txtP4" type="text" value="<?php echo $row_datos_ca['cp04_codigoarea']; ?>"/></td>
      </tr>                                                                  
      <tr>                                                                   
        <td>5. Cant&oacute;n censal</td>                                   
        <td><input class="cuarenta_px" name="txtP5" id="txtP5" type="text" value="<?php echo $row_datos_ca['cp05_codigocanton']; ?>"/></td>
      </tr>
    </table>
    <table>
      <tr align="right">
        <td>6. Comunidad: ind&iacute;gena originario campesino, intercultural, afroboliviana</td>
        <td></td>
      </tr>
      <tr align="right">
        <td>7. Comunidad: brecha, campo, colonia, faja, sindicato u otro </td>
        <td><input class="cuarenta_px" name="txtP6_1" id="txtP6_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos_ca['cp6y7']; ?>" maxlength="2"/></td>
      </tr>
      <tr align="right">
        <td>8. Periferia de ciudad o centro poblado mayor</td>
        <td></td>
      </tr>
      <tr align="right">
        <td>9. &Aacute;rea amanzanada de ciudad</td>
        <td></td>
      </tr>
      <tr align="right">
        <td>10. &Aacute;rea dispersa (hacienda, estancia, finca, rancho u otro)</td>
        <td></td>
      </tr>
      <tr align="right">
        <td>11. &Aacute;rea comunal de la TCO o TIOC</td>
        <td></td>
      </tr>
      <tr align="right">
        <td><input name="txtP6_2" type="text" class="cuarenta_px" id="txtP6_2" onfocus="selecciona_value(this)" value="<?php echo $row_datos_ca['numeroordencomunidad']; ?>" maxlength="1"/></td>
        <td></td>
      </tr>
    </table>
    <table>
      <tr>
        <td>12. Anote el nombre espec&iacute;fico correspondiente al c&oacute;digo marcado del 1 al 6.</td>
      </tr>
      <tr>
        <td><input class="novecientos_px" name="txtP12" id="txtP12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos_ca['cp08_nombrecomunidad']; ?>" onKeyDown="A(event,this.form.txtP13);"/></td>
      </tr>
      <tr>
        <td>13. Nombre de localidad. (si corresponde)</td>
      </tr>
      <tr>
        <td><input class="novecientos_px" name="txtP13" id="txtP13" type="text" value="<?php echo $row_datos['NombreLocalidad']; ?>" onfocus="selecciona_value(this)" onKeyDown="A(event,this.form.txtP14);"/></td>
      </tr>
      <tr>
        <td>14. &iquest;La Unidad de Producci&oacute;n Agropecuaria, a qu&eacute; n&uacute;mero de distrito municipal pertenece?</td>
      </tr>
      <tr>
        <td><input class="cuarenta_px" name="txtP14" id="txtP14" type="text" value="<?php echo $row_datos['NumeroDistritoMunicipal']; ?>" onfocus="selecciona_value(this)" onKeyDown="A(event,this.form.inserta);" maxlength="2"/></td>
      </tr>
    </table>
    <input type="hidden" name="botPress" id="botPress" />
    <?php endforeach; ?>
  </td>
</tr>
<tr>
  <td width="50%" align="center" valign="top"></td>
  <td width="50%" align="rigth" valign="top">  
    <input type="button" name="inserta" id="inserta" value="Crear Boleta" onclick="enviar(this.form,'insertar')"/>      
  </td>
</tr>
</table>
</div>
</form>

				  <!-- InstanceEndEditable --></td>
            </tr>
          </table></td>
        </tr>
      </table>
   </td>
  </tr>
  <tr>
    <td align="center" valign="middle"><p><img src="../../imgdiseno/lineainferior.gif" width="700" height="10" /><br />
    </p>
      <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tbody>
          <tr>
            <td align="center">INE - CNA: Calle Bolivar Nro. 1984. Frente a Identificaciones</td>
          </tr>
          <tr>
            <td align="center">Tel&eacute;fono Contactos e Informaciones : (+591)22124224</td>
          </tr>
        </tbody>
      </table></td>
  </tr>
</table>
 </td>
    
  </tr>
  <tr>
   
    <td valign="top">&nbsp;</td>
   
  </tr>
</table>
</body>
<!-- InstanceEnd --></html>
<?php/*
mysql_free_result($Recordset1);

mysql_free_result($permisos);

mysql_free_result($listamenu);
?>
