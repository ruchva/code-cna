<?php 
require_once $_SERVER["DOCUMENT_ROOT"]."/ine_ca/connections/dbca.php"; 
require_once $_SERVER["DOCUMENT_ROOT"]."/ine_ca/class/ca_boletacomunaldb.php";
?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
   
}
$MM_authorizedUsers = "'.$row_permisos[acceso_usr].'";
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
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/sis_ineca.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Censo Agropecuario</title>
<script language="JavaScript">
function A(e,t)
{
var k=null;
(e.keyCode) ? k=e.keyCode : k=e.which;
if(k==13) (!t) ? B() : t.focus();
}
function B()
{
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
<SCRIPT LANGUAGE="JavaScript">
        function enviar(form,boton){
            form.botPress.value = boton;
            form.submit();
        }

</script>

<script type="text/javascript" src="../../Scripts/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="../../Scripts/jquery.maskedinput.js"></script> 
<script type="text/javascript">
$(function(){
		$("#NumeroBrigada").mask("99");
		$("#NumeroFolio").mask("9999999");
		$("#CP01_CodigoDepartamento").mask("99");
		$("#CP02_CodigoProvincia").mask("99");
		$("#CP03_CodigoMunicipio").mask("99");
		$("#CP03_CP04_CodigoArea").mask("99");
		$("#CP05_CodigoDistrito").mask("99-9");
		$("#CP06_CodigoCanton").mask("99-9");
		$("#CP06_CP78910").mask("99-9");
 
})
</script>
<style type="text/css">
input{            
                background-color:#CFE;      
            } 
			select{            
                background-color:#CFE;      
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
        <a href="/ine_ca/paneldecontroladm.php"> Men� Principal</a>             <?php do { ?>
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
<?php if ((isset($_POST["botPress"])) && ($_POST["botPress"] == "nuevo")) {
    echo '<script>
            window.location = "/ine_ca/censoagropecuario/captura_gps/ca_lectura_gps.php"
	  </script>';
}
?>        
<?php    
$obj = new ca_lectura_gpsdb();
$departamentoArray = $obj->busca_dpto_gps();
$codigodepartamento = $_POST['CodigoDepartamento'];
$provinciaArray = $obj->busca_provincia_gps($codigodepartamento);
$codigoprovincia = $_POST['CodigoProvincia'];
$municipioArray = $obj->busca_municipio_gps($codigodepartamento,$codigoprovincia);
$codigomunicipio = $_POST['CodigoMunicipio'];
$areacensalArray = $obj->busca_area_gps($codigodepartamento,$codigoprovincia,$codigomunicipio);		 
$codigoareacensal = $_POST['CodigoArea'];

?>
<?php
//desde aqui otro
if ((isset($_POST["botPress"])) && ($_POST["botPress"] == "buscar")) {
$codigodepartamento=$_POST['CodigoDepartamento'];
$codigoprovincia=$_POST['CodigoProvincia'];
$codigomunicipio=$_POST['CodigoMunicipio'];
$codigoareacensal=$_POST['CodigoArea'];

$buscagpsArray=$obj->busca_lecgps($codigodepartamento,$codigoprovincia,$codigomunicipio,$codigoareacensal);
$mensaje=$buscagpsArray;
if ($buscagpsArray!='error'){ 
    echo '<script>
             window.alert("Busqueda con Exito");	
          </script>';			
}
else{
    echo '<script>
             window.alert("No se encontro ningun registro")
          </script>';
}
}	
?>	         
<form id="form1" name="form1" method="post" action="">
    <table width="90%" border="0">
        <tr>
          <td colspan="2" align="center" class="Titulo1CA">BUSQUEDA F-09 LECTURA DE DATOS GPS</td>
        </tr>
        <tr>
          <td colspan="2" align="center" class="Titulo1CA">&nbsp;</td>
        </tr>
        <tr>
          <td width="50%" align="right">Departamento censal:</td>
          <td>
            <label for="CodigoDepartamento"></label>
            <select name="CodigoDepartamento" id="CodigoDepartamento" onchange="this.form.submit()">
              <option value=""></option>
              <?php foreach ($departamentoArray as $row_departamento): ?>
              <option value="<?php echo $row_departamento['CodigoDepartamento']?>" <?php if (!(strcmp($row_departamento['CodigoDepartamento'], $_POST['CodigoDepartamento']))) {echo "selected=\"selected\"";} ?>><?php echo $row_departamento['CodigoDepartamento']?>-<?php echo $row_departamento['NombreDepartamento']?></option>
              <?php endforeach; ?>
            </select>
            <input type="hidden" name="botPress" id="botPress"/>
          </td>
        </tr>
        <tr>
          <td width="50%" align="right">Provincia censal:</td>
          <td><select name="CodigoProvincia" id="CodigoProvincia" onchange="this.form.submit()" >
            <option value=""></option>
            <?php foreach ($provinciaArray as $row_provincia): ?>
            <option value="<?php echo $row_provincia['CodigoProvincia']?>" <?php if (!(strcmp($row_provincia['CodigoProvincia'], $_POST['CodigoProvincia']))) {echo "selected=\"selected\"";} ?>><?php echo $row_provincia['CodigoProvincia']?>-<?php echo $row_provincia['Provincia']?></option>
            <?php endforeach; ?>
            </select></td>
          </tr>
        <tr>
          <td align="right">Municipio censal:</td>
          <td><select name="CodigoMunicipio" id="CodigoMunicipio" onchange="this.form.submit()">
            <option value=""></option>
            <?php foreach ($municipioArray as $row_municipio): ?>
            <option value="<?php echo $row_municipio['CodigoMunicipio']?>" <?php if (!(strcmp($row_municipio['CodigoMunicipio'], $_POST['CodigoMunicipio']))) {echo "selected=\"selected\"";} ?>><?php echo $row_municipio['CodigoMunicipio']?>-<?php echo $row_municipio['Municipio']?></option>
            <?php endforeach; ?>
            </select></td>
        </tr>
        <tr>
          <td align="right">&Aacute;rea censal:</td>
          <td><select name="CodigoArea" id="CodigoArea" onchange="this.form.submit()" >
            <option value=""></option>
            <?php foreach ($areacensalArray as $row_areacensal): ?>
            <option value="<?php echo $row_areacensal['codigoac']?>" <?php if (!(strcmp($row_areacensal['codigoac'], $_POST['CodigoArea']))) {echo "selected=\"selected\"";} ?>><?php echo $row_areacensal['codigoac']?></option>
            <?php endforeach; ?>
            </select></td>
        </tr>
        <tr>
          <td colspan="2" align="center"><input type="button" name="buscar" id="buscar" value="Enviar" onKeyDown="A(event,null);" onclick="enviar(this.form,'buscar')" /><input type="button" name="nuevo" id="nuevo" value="Nueva Boleta" onKeyDown="A(event,null);" onclick="enviar(this.form,'nuevo')" /></td>
        </tr>
    </table>            
</form>	
<div>
<?php if(!empty ($buscagpsArray)) {?>
Resultado de Busqueda
<table border="1" align="center">
  <tr>
    <td align="center" bgcolor="#009A9A"><span class="letrapeque">No</span></td>
    <td align="center" bgcolor="#009A9A"><span class="letrapeque">Correlativo</span></td>
    <td align="center" bgcolor="#009A9A"><span class="letrapeque">Numero Brigada</span></td>
    <td align="center" bgcolor="#009A9A"><span class="letrapeque">Codigo Departamento</span></td>
    <td align="center" bgcolor="#009A9A"><span class="letrapeque">Codigo Provincia</span></td>
    <td align="center" bgcolor="#009A9A"><span class="letrapeque">Codigo Municipio</span></td>
    <td align="center" bgcolor="#009A9A"><span class="letrapeque">Codigo Area Censal</span></td>
    <td align="center" bgcolor="#009A9A"><span class="letrapeque"></span></td>
  </tr>
  <?php $k=1; foreach ($buscagpsArray as $row_hojalecturagps):?>
  <tr>
    <td><span class="letrapeque"><?php echo $k; ?></span></td>
    <td><span class="letrapeque"><?php echo $row_hojalecturagps['Correlativo']; ?></span></td>
    <td><span class="letrapeque"><?php echo $row_hojalecturagps['NumeroBrigada']; ?></span></td>      
    <td><span class="letrapeque"><?php echo $row_hojalecturagps['LG01_CodigoDepartamento']; ?></span></td>
    <td><span class="letrapeque"><?php echo $row_hojalecturagps['LG02_CodigoProvincia']; ?></span></td>
    <td><span class="letrapeque"><?php echo $row_hojalecturagps['LG03_CodigoMunicipio']; ?></span></td>
    <td><span class="letrapeque"><?php echo $row_hojalecturagps['LG04_CodigoArea']; ?></span></td>
    <td align="center">
    <form action="/ine_ca/censoagropecuario/captura_gps/modificar2_gps.php" method="post">
      <span class="letrapeque">
      <input name="Correlativo" type="hidden" value="<?php echo $row_hojalecturagps['Correlativo']; ?>" />
      <input name="CodigoDepartamento" type="hidden" value="<?php echo $row_hojalecturagps['NumeroBrigada']; ?>" />
      <input name="CodigoDepartamento" type="hidden" value="<?php echo $row_hojalecturagps['LG01_CodigoDepartamento']; ?>" />
      <input name="CodigoProvincia" type="hidden" value="<?php echo $row_hojalecturagps['LG02_CodigoProvincia']; ?>" />
      <input name="CodigoMunicipio" type="hidden" value="<?php echo $row_hojalecturagps['LG03_CodigoMunicipio']; ?>" />
      <input name="CodigoArea" type="hidden" value="<?php echo $row_hojalecturagps['LG04_CodigoArea']; ?>" />
      <input name="enviart" type="submit" id="enviart" value="Editar" />
      </span>
    </form>
    </td>      
  </tr>
    <?php $k++; endforeach; ?>
</table>
<?php }?>
</div>       
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
<?php
/*mysql_free_result($Departamento);

mysql_free_result($permisos);

mysql_free_result($listamenu);

mysql_free_result($mostrarboletacomunal);*/
?>


