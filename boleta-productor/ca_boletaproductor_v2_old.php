<?php require_once $_SERVER["DOCUMENT_ROOT"]."/ine_ca/Connections/dbca.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/ine_ca/class/ca_boletaproductordb.php"; ?>
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
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/sis_ineca.dwt.php" codeOutsideHTMLIsLocked="false" -->
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
        <script type="text/javascript" src="../../Scripts/jquery-1.10.1.min.js"></script>
        <script type="text/javascript" src="../../Scripts/jquery.maskedinput.js"></script>
        <script type="text/javascript" src="../../Scripts/jquery.alphanumeric.js"></script> 
		
			
        <script type="text/javascript">		
        $(function(){
    		$.mask.definitions['A'] = '[129]';
    		$.mask.definitions['B'] = '[1239]';
    		$.mask.definitions['C'] = '[12349]';
    		$.mask.definitions['D'] = '[123459]';
    		$.mask.definitions['E'] = '[19]';
    		$.mask.definitions['F'] = '[1234569]';
    		$.mask.definitions['G'] = '[1239]';
    		$.mask.definitions['H'] = '[01]';
    		
    		$("#txtnum_brig").mask("99");
    		$("#txtnum_emp").mask("9");
			$("#txtnum_seg").mask("9");
			$("#txtnum_control").mask("999?9");
    		$("#txtP1").mask("99");
    		$("#txtP2").mask("99");
    		$("#txtP3").mask("99");
    		$("#txtP4").mask("99");
    		$("#txtP5").mask("99");
			$("#txtP6_1").mask("99");
			$("#txtP6_2").numeric({ ichars: '780' });
    		$("#txtP14").mask("99");		
    		$("#txtP16").numeric({ ichars: '456780' });
			$("#txtP17").numeric({ ichars: '456780' });
			$("#txtP18").numeric({ ichars: '3456780' });    		
    		$("#txtP19").numeric();    		
    		$("#txtP20_1").numeric({ ichars: '3456780' });
			$("#txtP20_2").numeric();
			$("#txtP20_3").numeric({ allow: "." });
			$("#txtP20_4").numeric({ allow: "." });
			$("#txtP21_1").numeric({ allow: "." });
			$("#txtP21_2").numeric({ allow: "." });
			$("#txtP21_3").numeric({ allow: "." });
			$("#txtP21_4").numeric({ allow: "." });
			$("#txtP21_5").numeric({ allow: "." });
			$("#txtP22_1").numeric({ ichars: '3456780' });
			$("#txtP22_2").numeric({ ichars: '3456780' });
			$("#txtP22_3").numeric({ ichars: '3456780' });
			$("#txtP22_4").numeric({ ichars: '3456780' });
			$("#txtP23_1").numeric({ ichars: '3456780' });        
            $("#txtP23_1_1").mask("9");
            $("#txtP23_1_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP23_1_3").numeric({ allow: "." });
            $("#txtP23_1_4").mask("99");
            $("#txtP23_1_5").numeric({ ichars: '3456780' });
            $("#txtP23_1_6").mask("99");
			$("#txtP23_1_7").numeric({ allow: "." });
            $("#txtP23_1_8").mask("99");
            $("#txtP23_1_9").mask("99");
            $("#txtP23_1_10").numeric({ ichars: '3456780' });
            $("#txtP23_1_11").numeric({ ichars: '3456780' });
            $("#txtP23_1_12").numeric({ ichars: '3456780' });			
			$("#txtP23_2_1").mask("9");
            $("#txtP23_2_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP23_2_3").numeric({ allow: "." });
            $("#txtP23_2_4").mask("99");
            $("#txtP23_2_5").numeric({ ichars: '3456780' });
            $("#txtP23_2_6").mask("99");
			$("#txtP23_2_7").numeric({ allow: "." });
            $("#txtP23_2_8").mask("99");
            $("#txtP23_2_9").mask("99");
            $("#txtP23_2_10").numeric({ ichars: '3456780' });
            $("#txtP23_2_11").numeric({ ichars: '3456780' });
            $("#txtP23_2_12").numeric({ ichars: '3456780' });			
			$("#txtP23_3_1").mask("9");
            $("#txtP23_3_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP23_3_3").numeric({ allow: "." });
            $("#txtP23_3_4").mask("99");
            $("#txtP23_3_5").numeric({ ichars: '3456780' });
            $("#txtP23_3_6").mask("99");
			$("#txtP23_3_7").numeric({ allow: "." });
            $("#txtP23_3_8").mask("99");
            $("#txtP23_3_9").mask("99");
            $("#txtP23_3_10").numeric({ ichars: '3456780' });
            $("#txtP23_3_11").numeric({ ichars: '3456780' });
            $("#txtP23_3_12").numeric({ ichars: '3456780' });			
			$("#txtP23_4_1").mask("9");
            $("#txtP23_4_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP23_4_3").numeric({ allow: "." });
            $("#txtP23_4_4").mask("99");
            $("#txtP23_4_5").numeric({ ichars: '3456780' });
            $("#txtP23_4_6").mask("99");
			$("#txtP23_4_7").numeric({ allow: "." });
            $("#txtP23_4_8").mask("99");
            $("#txtP23_4_9").mask("99");
            $("#txtP23_4_10").numeric({ ichars: '3456780' });
            $("#txtP23_4_11").numeric({ ichars: '3456780' });
            $("#txtP23_4_12").numeric({ ichars: '3456780' });			
			$("#txtP23_5_1").mask("9");
            $("#txtP23_5_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP23_5_3").numeric({ allow: "." });
            $("#txtP23_5_4").mask("99");
            $("#txtP23_5_5").numeric({ ichars: '3456780' });
            $("#txtP23_5_6").mask("99");
			$("#txtP23_5_7").numeric({ allow: "." });
            $("#txtP23_5_8").mask("99");
            $("#txtP23_5_9").mask("99");
            $("#txtP23_5_10").numeric({ ichars: '3456780' });
            $("#txtP23_5_11").numeric({ ichars: '3456780' });
            $("#txtP23_5_12").numeric({ ichars: '3456780' });			
			$("#txtP23_6_1").mask("9");
            $("#txtP23_6_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP23_6_3").numeric({ allow: "." });
            $("#txtP23_6_4").mask("99");
            $("#txtP23_6_5").numeric({ ichars: '3456780' });
            $("#txtP23_6_6").mask("99");
			$("#txtP23_6_7").numeric({ allow: "." });
            $("#txtP23_6_8").mask("99");
            $("#txtP23_6_9").mask("99");
            $("#txtP23_6_10").numeric({ ichars: '3456780' });
            $("#txtP23_6_11").numeric({ ichars: '3456780' });
            $("#txtP23_6_12").numeric({ ichars: '3456780' });
			$("#txtP23_7_1").mask("9");
            $("#txtP23_7_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP23_7_3").numeric({ allow: "." });
            $("#txtP23_7_4").mask("99");
            $("#txtP23_7_5").numeric({ ichars: '3456780' });
            $("#txtP23_7_6").mask("99");
			$("#txtP23_7_7").numeric({ allow: "." });
            $("#txtP23_7_8").mask("99");
            $("#txtP23_7_9").mask("99");
            $("#txtP23_7_10").numeric({ ichars: '3456780' });
            $("#txtP23_7_11").numeric({ ichars: '3456780' });
            $("#txtP23_7_12").numeric({ ichars: '3456780' });
			$("#txtP24_1").numeric({ ichars: '3456780' }); 
			$("#txtP24_1_1").mask("99");
            $("#txtP24_1_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_1_3").mask("9");
            $("#txtP24_1_4").numeric({ allow: "." });
            $("#txtP24_1_5").mask("99");
            $("#txtP24_1_6").numeric({ ichars: '3456780' });
            $("#txtP24_1_7").mask("99");
			$("#txtP24_1_8").mask("9999");
			$("#txtP24_1_9").numeric({ allow: "." });
            $("#txtP24_1_10").mask("99");
            $("#txtP24_1_11").mask("99");
            $("#txtP24_1_12").numeric({ ichars: '3456780' });
            $("#txtP24_1_13").numeric({ ichars: '3456780' });
            $("#txtP24_1_14").numeric({ ichars: '3456780' });
			$("#txtP24_2_1").mask("99");
            $("#txtP24_2_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_2_3").mask("9");
            $("#txtP24_2_4").numeric({ allow: "." });
            $("#txtP24_2_5").mask("99");
            $("#txtP24_2_6").numeric({ ichars: '3456780' });
            $("#txtP24_2_7").mask("99");
			$("#txtP24_2_8").mask("9999");
			$("#txtP24_2_9").numeric({ allow: "." });
            $("#txtP24_2_10").mask("99");
            $("#txtP24_2_11").mask("99");
            $("#txtP24_2_12").numeric({ ichars: '3456780' });
            $("#txtP24_2_13").numeric({ ichars: '3456780' });
            $("#txtP24_2_14").numeric({ ichars: '3456780' });
			$("#txtP24_3_1").mask("99");
            $("#txtP24_3_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_3_3").mask("9");
            $("#txtP24_3_4").numeric({ allow: "." });
            $("#txtP24_3_5").mask("99");
            $("#txtP24_3_6").numeric({ ichars: '3456780' });
            $("#txtP24_3_7").mask("99");
			$("#txtP24_3_8").mask("9999");
			$("#txtP24_3_9").numeric({ allow: "." });
            $("#txtP24_3_10").mask("99");
            $("#txtP24_3_11").mask("99");
            $("#txtP24_3_12").numeric({ ichars: '3456780' });
            $("#txtP24_3_13").numeric({ ichars: '3456780' });
            $("#txtP24_3_14").numeric({ ichars: '3456780' });
			$("#txtP24_4_1").mask("99");
            $("#txtP24_4_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_4_3").mask("9");
            $("#txtP24_4_4").numeric({ allow: "." });
            $("#txtP24_4_5").mask("99");
            $("#txtP24_4_6").numeric({ ichars: '3456780' });
            $("#txtP24_4_7").mask("99");
			$("#txtP24_4_8").mask("9999");
			$("#txtP24_4_9").numeric({ allow: "." });
            $("#txtP24_4_10").mask("99");
            $("#txtP24_4_11").mask("99");
            $("#txtP24_4_12").numeric({ ichars: '3456780' });
            $("#txtP24_4_13").numeric({ ichars: '3456780' });
            $("#txtP24_4_14").numeric({ ichars: '3456780' });
			$("#txtP24_5_1").mask("99");
            $("#txtP24_5_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_5_3").mask("9");
            $("#txtP24_5_4").numeric({ allow: "." });
            $("#txtP24_5_5").mask("99");
            $("#txtP24_5_6").numeric({ ichars: '3456780' });
            $("#txtP24_5_7").mask("99");
			$("#txtP24_5_8").mask("9999");
			$("#txtP24_5_9").numeric({ allow: "." });
            $("#txtP24_5_10").mask("99");
            $("#txtP24_5_11").mask("99");
            $("#txtP24_5_12").numeric({ ichars: '3456780' });
            $("#txtP24_5_13").numeric({ ichars: '3456780' });
            $("#txtP24_5_14").numeric({ ichars: '3456780' });
			$("#txtP24_6_1").mask("99");
            $("#txtP24_6_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_6_3").mask("9");
            $("#txtP24_6_4").numeric({ allow: "." });
            $("#txtP24_6_5").mask("99");
            $("#txtP24_6_6").numeric({ ichars: '3456780' });
            $("#txtP24_6_7").mask("99");
			$("#txtP24_6_8").mask("9999");
			$("#txtP24_6_9").numeric({ allow: "." });
            $("#txtP24_6_10").mask("99");
            $("#txtP24_6_11").mask("99");
            $("#txtP24_6_12").numeric({ ichars: '3456780' });
            $("#txtP24_6_13").numeric({ ichars: '3456780' });
            $("#txtP24_6_14").numeric({ ichars: '3456780' });
			$("#txtP24_7_1").mask("99");
            $("#txtP24_7_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_7_3").mask("9");
            $("#txtP24_7_4").numeric({ allow: "." });
            $("#txtP24_7_5").mask("99");
            $("#txtP24_7_6").numeric({ ichars: '3456780' });
            $("#txtP24_7_7").mask("99");
			$("#txtP24_7_8").mask("9999");
			$("#txtP24_7_9").numeric({ allow: "." });
            $("#txtP24_7_10").mask("99");
            $("#txtP24_7_11").mask("99");
            $("#txtP24_7_12").numeric({ ichars: '3456780' });
            $("#txtP24_7_13").numeric({ ichars: '3456780' });
            $("#txtP24_7_14").numeric({ ichars: '3456780' });			
			$("#txtP24_8_1").mask("99");
            $("#txtP24_8_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_8_3").mask("9");
            $("#txtP24_8_4").numeric({ allow: "." });
            $("#txtP24_8_5").mask("99");
            $("#txtP24_8_6").numeric({ ichars: '3456780' });
            $("#txtP24_8_7").mask("99");
			$("#txtP24_8_8").mask("9999");
			$("#txtP24_8_9").numeric({ allow: "." });
            $("#txtP24_8_10").mask("99");
            $("#txtP24_8_11").mask("99");
            $("#txtP24_8_12").numeric({ ichars: '3456780' });
            $("#txtP24_8_13").numeric({ ichars: '3456780' });
            $("#txtP24_8_14").numeric({ ichars: '3456780' });
			$("#txtP24_9_1").mask("99");
            $("#txtP24_9_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_9_3").mask("9");
            $("#txtP24_9_4").numeric({ allow: "." });
            $("#txtP24_9_5").mask("99");
            $("#txtP24_9_6").numeric({ ichars: '3456780' });
            $("#txtP24_9_7").mask("99");
			$("#txtP24_9_8").mask("9999");
			$("#txtP24_9_9").numeric({ allow: "." });
            $("#txtP24_9_10").mask("99");
            $("#txtP24_9_11").mask("99");
            $("#txtP24_9_12").numeric({ ichars: '3456780' });
            $("#txtP24_9_13").numeric({ ichars: '3456780' });
            $("#txtP24_9_14").numeric({ ichars: '3456780' });
			$("#txtP24_10_1").mask("99");
            $("#txtP24_10_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_10_3").mask("9");
            $("#txtP24_10_4").numeric({ allow: "." });
            $("#txtP24_10_5").mask("99");
            $("#txtP24_10_6").numeric({ ichars: '3456780' });
            $("#txtP24_10_7").mask("99");
			$("#txtP24_10_8").mask("9999");
			$("#txtP24_10_9").numeric({ allow: "." });
            $("#txtP24_10_10").mask("99");
            $("#txtP24_10_11").mask("99");
            $("#txtP24_10_12").numeric({ ichars: '3456780' });
            $("#txtP24_10_13").numeric({ ichars: '3456780' });
            $("#txtP24_10_14").numeric({ ichars: '3456780' });
			$("#txtP24_11_1").mask("99");
            $("#txtP24_11_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_11_3").mask("9");
            $("#txtP24_11_4").numeric({ allow: "." });
            $("#txtP24_11_5").mask("99");
            $("#txtP24_11_6").numeric({ ichars: '3456780' });
            $("#txtP24_11_7").mask("99");
			$("#txtP24_11_8").mask("9999");
			$("#txtP24_11_9").numeric({ allow: "." });
            $("#txtP24_11_10").mask("99");
            $("#txtP24_11_11").mask("99");
            $("#txtP24_11_12").numeric({ ichars: '3456780' });
            $("#txtP24_11_13").numeric({ ichars: '3456780' });
            $("#txtP24_11_14").numeric({ ichars: '3456780' });
			$("#txtP24_12_1").mask("99");
            $("#txtP24_12_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_12_3").mask("9");
            $("#txtP24_12_4").numeric({ allow: "." });
            $("#txtP24_12_5").mask("99");
            $("#txtP24_12_6").numeric({ ichars: '3456780' });
            $("#txtP24_12_7").mask("99");
			$("#txtP24_12_8").mask("9999");
			$("#txtP24_12_9").numeric({ allow: "." });
            $("#txtP24_12_10").mask("99");
            $("#txtP24_12_11").mask("99");
            $("#txtP24_12_12").numeric({ ichars: '3456780' });
            $("#txtP24_12_13").numeric({ ichars: '3456780' });
            $("#txtP24_12_14").numeric({ ichars: '3456780' });
			$("#txtP24_13_1").mask("99");
            $("#txtP24_13_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_13_3").mask("9");
            $("#txtP24_13_4").numeric({ allow: "." });
            $("#txtP24_13_5").mask("99");
            $("#txtP24_13_6").numeric({ ichars: '3456780' });
            $("#txtP24_13_7").mask("99");
			$("#txtP24_13_8").mask("9999");
			$("#txtP24_13_9").numeric({ allow: "." });
            $("#txtP24_13_10").mask("99");
            $("#txtP24_13_11").mask("99");
            $("#txtP24_13_12").numeric({ ichars: '3456780' });
            $("#txtP24_13_13").numeric({ ichars: '3456780' });
            $("#txtP24_13_14").numeric({ ichars: '3456780' });
			$("#txtP24_14_1").mask("99");
            $("#txtP24_14_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_14_3").mask("9");
            $("#txtP24_14_4").numeric({ allow: "." });
            $("#txtP24_14_5").mask("99");
            $("#txtP24_14_6").numeric({ ichars: '3456780' });
            $("#txtP24_14_7").mask("99");
			$("#txtP24_14_8").mask("9999");
			$("#txtP24_14_9").numeric({ allow: "." });
            $("#txtP24_14_10").mask("99");
            $("#txtP24_14_11").mask("99");
            $("#txtP24_14_12").numeric({ ichars: '3456780' });
            $("#txtP24_14_13").numeric({ ichars: '3456780' });
            $("#txtP24_14_14").numeric({ ichars: '3456780' });
			$("#txtP24_15_1").mask("99");
            $("#txtP24_15_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_15_3").mask("9");
            $("#txtP24_15_4").numeric({ allow: "." });
            $("#txtP24_15_5").mask("99");
            $("#txtP24_15_6").numeric({ ichars: '3456780' });
            $("#txtP24_15_7").mask("99");
			$("#txtP24_15_8").mask("9999");
			$("#txtP24_15_9").numeric({ allow: "." });
            $("#txtP24_15_10").mask("99");
            $("#txtP24_15_11").mask("99");
            $("#txtP24_15_12").numeric({ ichars: '3456780' });
            $("#txtP24_15_13").numeric({ ichars: '3456780' });
            $("#txtP24_15_14").numeric({ ichars: '3456780' });
			$("#txtP24_16_1").mask("99");
            $("#txtP24_16_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_16_3").mask("9");
            $("#txtP24_16_4").numeric({ allow: "." });
            $("#txtP24_16_5").mask("99");
            $("#txtP24_16_6").numeric({ ichars: '3456780' });
            $("#txtP24_16_7").mask("99");
			$("#txtP24_16_8").mask("9999");
			$("#txtP24_16_9").numeric({ allow: "." });
            $("#txtP24_16_10").mask("99");
            $("#txtP24_16_11").mask("99");
            $("#txtP24_16_12").numeric({ ichars: '3456780' });
            $("#txtP24_16_13").numeric({ ichars: '3456780' });
            $("#txtP24_16_14").numeric({ ichars: '3456780' });
			$("#txtP24_17_1").mask("99");
            $("#txtP24_17_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_17_3").mask("9");
            $("#txtP24_17_4").numeric({ allow: "." });
            $("#txtP24_17_5").mask("99");
            $("#txtP24_17_6").numeric({ ichars: '3456780' });
            $("#txtP24_17_7").mask("99");
			$("#txtP24_17_8").mask("9999");
			$("#txtP24_17_9").numeric({ allow: "." });
            $("#txtP24_17_10").mask("99");
            $("#txtP24_17_11").mask("99");
            $("#txtP24_17_12").numeric({ ichars: '3456780' });
            $("#txtP24_17_13").numeric({ ichars: '3456780' });
            $("#txtP24_17_14").numeric({ ichars: '3456780' });
			$("#txtP24_18_1").mask("99");
            $("#txtP24_18_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_18_3").mask("9");
            $("#txtP24_18_4").numeric({ allow: "." });
            $("#txtP24_18_5").mask("99");
            $("#txtP24_18_6").numeric({ ichars: '3456780' });
            $("#txtP24_18_7").mask("99");
			$("#txtP24_18_8").mask("9999");
			$("#txtP24_18_9").numeric({ allow: "." });
            $("#txtP24_18_10").mask("99");
            $("#txtP24_18_11").mask("99");
            $("#txtP24_18_12").numeric({ ichars: '3456780' });
            $("#txtP24_18_13").numeric({ ichars: '3456780' });
            $("#txtP24_18_14").numeric({ ichars: '3456780' });
			$("#txtP24_19_1").mask("99");
            $("#txtP24_19_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_19_3").mask("9");
            $("#txtP24_19_4").numeric({ allow: "." });
            $("#txtP24_19_5").mask("99");
            $("#txtP24_19_6").numeric({ ichars: '3456780' });
            $("#txtP24_19_7").mask("99");
			$("#txtP24_19_8").mask("9999");
			$("#txtP24_19_9").numeric({ allow: "." });
            $("#txtP24_19_10").mask("99");
            $("#txtP24_19_11").mask("99");
            $("#txtP24_19_12").numeric({ ichars: '3456780' });
            $("#txtP24_19_13").numeric({ ichars: '3456780' });
            $("#txtP24_19_14").numeric({ ichars: '3456780' });
			$("#txtP24_20_1").mask("99");
            $("#txtP24_20_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_20_3").mask("9");
            $("#txtP24_20_4").numeric({ allow: "." });
            $("#txtP24_20_5").mask("99");
            $("#txtP24_20_6").numeric({ ichars: '3456780' });
            $("#txtP24_20_7").mask("99");
			$("#txtP24_20_8").mask("9999");
			$("#txtP24_20_9").numeric({ allow: "." });
            $("#txtP24_20_10").mask("99");
            $("#txtP24_20_11").mask("99");
            $("#txtP24_20_12").numeric({ ichars: '3456780' });
            $("#txtP24_20_13").numeric({ ichars: '3456780' });
            $("#txtP24_20_14").numeric({ ichars: '3456780' });
			$("#txtP24_21_1").mask("99");
            $("#txtP24_21_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_21_3").mask("9");
            $("#txtP24_21_4").numeric({ allow: "." });
            $("#txtP24_21_5").mask("99");
            $("#txtP24_21_6").numeric({ ichars: '3456780' });
            $("#txtP24_21_7").mask("99");
			$("#txtP24_21_8").mask("9999");
			$("#txtP24_21_9").numeric({ allow: "." });
            $("#txtP24_21_10").mask("99");
            $("#txtP24_21_11").mask("99");
            $("#txtP24_21_12").numeric({ ichars: '3456780' });
            $("#txtP24_21_13").numeric({ ichars: '3456780' });
            $("#txtP24_21_14").numeric({ ichars: '3456780' });
			$("#txtP24_22_1").mask("99");
            $("#txtP24_22_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_22_3").mask("9");
            $("#txtP24_22_4").numeric({ allow: "." });
            $("#txtP24_22_5").mask("99");
            $("#txtP24_22_6").numeric({ ichars: '3456780' });
            $("#txtP24_22_7").mask("99");
			$("#txtP24_22_8").mask("9999");
			$("#txtP24_22_9").numeric({ allow: "." });
            $("#txtP24_22_10").mask("99");
            $("#txtP24_22_11").mask("99");
            $("#txtP24_22_12").numeric({ ichars: '3456780' });
            $("#txtP24_22_13").numeric({ ichars: '3456780' });
            $("#txtP24_22_14").numeric({ ichars: '3456780' });
			$("#txtP24_23_1").mask("99");
            $("#txtP24_23_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_23_3").mask("9");
            $("#txtP24_23_4").numeric({ allow: "." });
            $("#txtP24_23_5").mask("99");
            $("#txtP24_23_6").numeric({ ichars: '3456780' });
            $("#txtP24_23_7").mask("99");
			$("#txtP24_23_8").mask("9999");
			$("#txtP24_23_9").numeric({ allow: "." });
            $("#txtP24_23_10").mask("99");
            $("#txtP24_23_11").mask("99");
            $("#txtP24_23_12").numeric({ ichars: '3456780' });
            $("#txtP24_23_13").numeric({ ichars: '3456780' });
            $("#txtP24_23_14").numeric({ ichars: '3456780' });
			$("#txtP24_24_1").mask("99");
            $("#txtP24_24_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_24_3").mask("9");
            $("#txtP24_24_4").numeric({ allow: "." });
            $("#txtP24_24_5").mask("99");
            $("#txtP24_24_6").numeric({ ichars: '3456780' });
            $("#txtP24_24_7").mask("99");
			$("#txtP24_24_8").mask("9999");
			$("#txtP24_24_9").numeric({ allow: "." });
            $("#txtP24_24_10").mask("99");
            $("#txtP24_24_11").mask("99");
            $("#txtP24_24_12").numeric({ ichars: '3456780' });
            $("#txtP24_24_13").numeric({ ichars: '3456780' });
            $("#txtP24_24_14").numeric({ ichars: '3456780' });
			$("#txtP24_25_1").mask("99");
            $("#txtP24_25_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_25_3").mask("9");
            $("#txtP24_25_4").numeric({ allow: "." });
            $("#txtP24_25_5").mask("99");
            $("#txtP24_25_6").numeric({ ichars: '3456780' });
            $("#txtP24_25_7").mask("99");
			$("#txtP24_25_8").mask("9999");
			$("#txtP24_25_9").numeric({ allow: "." });
            $("#txtP24_25_10").mask("99");
            $("#txtP24_25_11").mask("99");
            $("#txtP24_25_12").numeric({ ichars: '3456780' });
            $("#txtP24_25_13").numeric({ ichars: '3456780' });
            $("#txtP24_25_14").numeric({ ichars: '3456780' });
			$("#txtP24_26_1").mask("99");
            $("#txtP24_26_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_26_3").mask("9");
            $("#txtP24_26_4").numeric({ allow: "." });
            $("#txtP24_26_5").mask("99");
            $("#txtP24_26_6").numeric({ ichars: '3456780' });
            $("#txtP24_26_7").mask("99");
			$("#txtP24_26_8").mask("9999");
			$("#txtP24_26_9").numeric({ allow: "." });
            $("#txtP24_26_10").mask("99");
            $("#txtP24_26_11").mask("99");
            $("#txtP24_26_12").numeric({ ichars: '3456780' });
            $("#txtP24_26_13").numeric({ ichars: '3456780' });
            $("#txtP24_26_14").numeric({ ichars: '3456780' });
			$("#txtP24_27_1").mask("99");
            $("#txtP24_27_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_27_3").mask("9");
            $("#txtP24_27_4").numeric({ allow: "." });
            $("#txtP24_27_5").mask("99");
            $("#txtP24_27_6").numeric({ ichars: '3456780' });
            $("#txtP24_27_7").mask("99");
			$("#txtP24_27_8").mask("9999");
			$("#txtP24_27_9").numeric({ allow: "." });
            $("#txtP24_27_10").mask("99");
            $("#txtP24_27_11").mask("99");
            $("#txtP24_27_12").numeric({ ichars: '3456780' });
            $("#txtP24_27_13").numeric({ ichars: '3456780' });
            $("#txtP24_27_14").numeric({ ichars: '3456780' });
			$("#txtP24_28_1").mask("99");
            $("#txtP24_28_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_28_3").mask("9");
            $("#txtP24_28_4").numeric({ allow: "." });
            $("#txtP24_28_5").mask("99");
            $("#txtP24_28_6").numeric({ ichars: '3456780' });
            $("#txtP24_28_7").mask("99");
			$("#txtP24_28_8").mask("9999");
			$("#txtP24_28_9").numeric({ allow: "." });
            $("#txtP24_28_10").mask("99");
            $("#txtP24_28_11").mask("99");
            $("#txtP24_28_12").numeric({ ichars: '3456780' });
            $("#txtP24_28_13").numeric({ ichars: '3456780' });
            $("#txtP24_28_14").numeric({ ichars: '3456780' });
			$("#txtP24_29_1").mask("99");
            $("#txtP24_29_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_29_3").mask("9");
            $("#txtP24_29_4").numeric({ allow: "." });
            $("#txtP24_29_5").mask("99");
            $("#txtP24_29_6").numeric({ ichars: '3456780' });
            $("#txtP24_29_7").mask("99");
			$("#txtP24_29_8").mask("9999");
			$("#txtP24_29_9").numeric({ allow: "." });
            $("#txtP24_29_10").mask("99");
            $("#txtP24_29_11").mask("99");
            $("#txtP24_29_12").numeric({ ichars: '3456780' });
            $("#txtP24_29_13").numeric({ ichars: '3456780' });
            $("#txtP24_29_14").numeric({ ichars: '3456780' });
			$("#txtP24_30_1").mask("99");
            $("#txtP24_30_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_30_3").mask("9");
            $("#txtP24_30_4").numeric({ allow: "." });
            $("#txtP24_30_5").mask("99");
            $("#txtP24_30_6").numeric({ ichars: '3456780' });
            $("#txtP24_30_7").mask("99");
			$("#txtP24_30_8").mask("9999");
			$("#txtP24_30_9").numeric({ allow: "." });
            $("#txtP24_30_10").mask("99");
            $("#txtP24_30_11").mask("99");
            $("#txtP24_30_12").numeric({ ichars: '3456780' });
            $("#txtP24_30_13").numeric({ ichars: '3456780' });
            $("#txtP24_30_14").numeric({ ichars: '3456780' });
			$("#txtP24_31_1").mask("99");
            $("#txtP24_31_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_31_3").mask("9");
            $("#txtP24_31_4").numeric({ allow: "." });
            $("#txtP24_31_5").mask("99");
            $("#txtP24_31_6").numeric({ ichars: '3456780' });
            $("#txtP24_31_7").mask("99");
			$("#txtP24_31_8").mask("9999");
			$("#txtP24_31_9").numeric({ allow: "." });
            $("#txtP24_31_10").mask("99");
            $("#txtP24_31_11").mask("99");
            $("#txtP24_31_12").numeric({ ichars: '3456780' });
            $("#txtP24_31_13").numeric({ ichars: '3456780' });
            $("#txtP24_31_14").numeric({ ichars: '3456780' });
			$("#txtP24_32_1").mask("99");
            $("#txtP24_32_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_32_3").mask("9");
            $("#txtP24_32_4").numeric({ allow: "." });
            $("#txtP24_32_5").mask("99");
            $("#txtP24_32_6").numeric({ ichars: '3456780' });
            $("#txtP24_32_7").mask("99");
			$("#txtP24_32_8").mask("9999");
			$("#txtP24_32_9").numeric({ allow: "." });
            $("#txtP24_32_10").mask("99");
            $("#txtP24_32_11").mask("99");
            $("#txtP24_32_12").numeric({ ichars: '3456780' });
            $("#txtP24_32_13").numeric({ ichars: '3456780' });
            $("#txtP24_32_14").numeric({ ichars: '3456780' });
			$("#txtP24_33_1").mask("99");
            $("#txtP24_33_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_33_3").mask("9");
            $("#txtP24_33_4").numeric({ allow: "." });
            $("#txtP24_33_5").mask("99");
            $("#txtP24_33_6").numeric({ ichars: '3456780' });
            $("#txtP24_33_7").mask("99");
			$("#txtP24_33_8").mask("9999");
			$("#txtP24_33_9").numeric({ allow: "." });
            $("#txtP24_33_10").mask("99");
            $("#txtP24_33_11").mask("99");
            $("#txtP24_33_12").numeric({ ichars: '3456780' });
            $("#txtP24_33_13").numeric({ ichars: '3456780' });
            $("#txtP24_33_14").numeric({ ichars: '3456780' });
			$("#txtP24_34_1").mask("99");
            $("#txtP24_34_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP24_34_3").mask("9");
            $("#txtP24_34_4").numeric({ allow: "." });
            $("#txtP24_34_5").mask("99");
            $("#txtP24_34_6").numeric({ ichars: '3456780' });
            $("#txtP24_34_7").mask("99");
			$("#txtP24_34_8").mask("9999");
			$("#txtP24_34_9").numeric({ allow: "." });
            $("#txtP24_34_10").mask("99");
            $("#txtP24_34_11").mask("99");
            $("#txtP24_34_12").numeric({ ichars: '3456780' });
            $("#txtP24_34_13").numeric({ ichars: '3456780' });
            $("#txtP24_34_14").numeric({ ichars: '3456780' });			
			$("#txtP25_1").numeric({ ichars: '3456780' });
            $("#txtP25_1_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP25_1_2").umeric({ ichars: '3456780' });
            $("#txtP25_1_3").mask("99");
			$("#txtP25_2_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP25_2_2").umeric({ ichars: '3456780' });
            $("#txtP25_2_3").mask("99");
            $("#txtP25_3_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP25_3_2").umeric({ ichars: '3456780' });
            $("#txtP25_3_3").mask("99");
			$("#txtP25_4_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP25_4_2").umeric({ ichars: '3456780' });
            $("#txtP25_4_3").mask("99");
			$("#txtP25_5_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP25_5_2").umeric({ ichars: '3456780' });
            $("#txtP25_5_3").mask("99");            
            $("#txtP26_1").numeric({ ichars: '3456780' });
            $("#txtP26_1_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP26_1_2").umeric({ ichars: '3456780' });
            $("#txtP26_1_3").mask("99");
			$("#txtP26_2_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP26_2_2").umeric({ ichars: '3456780' });
            $("#txtP26_2_3").mask("99");
            $("#txtP26_3_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP26_3_2").umeric({ ichars: '3456780' });
            $("#txtP26_3_3").mask("99");
			$("#txtP26_4_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP26_4_2").umeric({ ichars: '3456780' });
            $("#txtP26_4_3").mask("99");
			$("#txtP26_5_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP26_5_2").umeric({ ichars: '3456780' });
            $("#txtP26_5_3").mask("99");			
			$("#txtP27_1").numeric({ ichars: '3456780' });
            $("#txtP27_1_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP27_1_2").umeric({ ichars: '3456780' });
            $("#txtP27_1_3").mask("99");
			$("#txtP27_2_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP27_2_2").umeric({ ichars: '3456780' });
            $("#txtP27_2_3").mask("99");
            $("#txtP27_3_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP27_3_2").umeric({ ichars: '3456780' });
            $("#txtP27_3_3").mask("99");
			$("#txtP27_4_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP27_4_2").umeric({ ichars: '3456780' });
            $("#txtP27_4_3").mask("99");
			$("#txtP27_5_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP27_5_2").umeric({ ichars: '3456780' });
            $("#txtP27_5_3").mask("99");			
			$("#txtP28_1").numeric({ ichars: '3456780' });            
            $("#txtP28_1_1").umeric({ ichars: '3456780' });
            $("#txtP28_1_2").mask("99");			
            $("#txtP28_2_1").umeric({ ichars: '3456780' });
            $("#txtP28_2_2").mask("99");            
            $("#txtP28_3_1").umeric({ ichars: '3456780' });
            $("#txtP28_3_2").mask("99");			
            $("#txtP28_4_1").umeric({ ichars: '3456780' });
            $("#txtP28_4_2").mask("99");			
            $("#txtP28_5_1").umeric({ ichars: '3456780' });
            $("#txtP28_5_2").mask("99");			
			$("#txtP29_1").numeric({ ichars: '3456780' });
            $("#txtP29_1_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP29_1_2").umeric();
			$("#txtP29_2_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP29_2_2").umeric();
            $("#txtP29_3_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP29_3_2").umeric();
			$("#txtP29_4_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP29_4_2").umeric();
			$("#txtP29_5_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP29_5_2").umeric();            
			$("#txtP30_1").numeric({ ichars: '3456780' });
            $("#txtP30_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });            
			$("#txtP30_3").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });            
            $("#txtP30_4").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });            
			$("#txtP30_5").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });            
			$("#txtP30_6").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#txtP31_1").numeric({ ichars: '3456780' });
			$("#txtP31_2").numeric({ ichars: '3456780' });
			$("#txtP31_3").numeric({ ichars: '3456780' });
			$("#txtP32").numeric({ ichars: '3456780' });
			$("#txtP33").numeric({ ichars: '3456780' });
			$("#txtP34").numeric({ ichars: '3456780' });
			$("#txtP35").numeric({ ichars: '3456780' });
			$("#txtP36").numeric({ ichars: '3456780' });
			$("#txtP37_1").numeric({ ichars: '3456780' });
			$("#txtP37_1_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP37_1_2").numeric({ ichars: '3456780' });
			$("#txtP37_2_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP37_2_2").numeric({ ichars: '3456780' });
			$("#txtP37_3_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP37_3_2").numeric({ ichars: '3456780' });
			$("#txtP37_4_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP37_4_2").numeric({ ichars: '3456780' });
			$("#txtP37_5_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP37_5_2").numeric({ ichars: '3456780' });
			$("#txtP38_1_1").numeric();
			$("#txtP38_1_2").mask("9999");
			$("#txtP38_1_3").mask("9999");
			$("#txtP38_2_1").numeric();
			$("#txtP38_2_2").mask("9999");
			$("#txtP38_2_3").mask("9999");
			$("#txtP38_3_1").numeric();
			$("#txtP38_3_2").mask("9999");
			$("#txtP38_3_3").mask("9999");
			$("#txtP38_4_1").numeric();
			$("#txtP38_4_2").mask("9999");
			$("#txtP38_4_3").mask("9999");			
			$("#txtP39_1_1").numeric();
			$("#txtP39_1_2").mask("9999");
			$("#txtP39_1_3").mask("9999");
			$("#txtP39_2_1").numeric();
			$("#txtP39_2_2").mask("9999");
			$("#txtP39_2_3").mask("9999");
			$("#txtP39_3_1").numeric();
			$("#txtP39_3_2").mask("9999");
			$("#txtP39_3_3").mask("9999");
			$("#txtP39_4_1").numeric();
			$("#txtP39_4_2").mask("9999");
			$("#txtP39_4_3").mask("9999");
			$("#txtP39_5_1").numeric();
			$("#txtP39_5_2").mask("9999");
			$("#txtP39_5_3").mask("9999");
			$("#txtP39_6_1").numeric();
			$("#txtP39_6_2").mask("9999");
			$("#txtP39_6_3").mask("9999");
			$("#txtP39_7_1").numeric();
			$("#txtP39_7_2").mask("9999");
			$("#txtP39_7_3").mask("9999");
			$("#txtP39_8_1").numeric();
			$("#txtP39_8_2").mask("9999");
			$("#txtP39_8_3").mask("9999");
			$("#txtP39_9_1").numeric();
			$("#txtP39_9_2").mask("9999");
			$("#txtP39_9_3").mask("9999");
			$("#txtP39_10_1").numeric();
			$("#txtP39_10_2").mask("9999");
			$("#txtP39_10_3").mask("9999");
			$("#txtP39_11_1").numeric();
			$("#txtP39_11_2").mask("9999");
			$("#txtP39_11_3").mask("9999");
			$("#txtP39_12_1").numeric();
			$("#txtP39_12_2").mask("9999");
			$("#txtP39_12_3").mask("9999");
			$("#txtP39_13_1").numeric();
			$("#txtP39_13_2").mask("9999");
			$("#txtP39_13_3").mask("9999");
			$("#txtP39_14_1").numeric();
			$("#txtP39_14_2").mask("9999");
			$("#txtP39_14_3").mask("9999");
			$("#txtP39_15_1").numeric();
			$("#txtP39_15_2").mask("9999");
			$("#txtP39_15_3").mask("9999");
			$("#txtP39_16_1").numeric();
			$("#txtP39_16_2").mask("9999");
			$("#txtP39_16_3").mask("9999");
			$("#txtP39_17_1").numeric();
			$("#txtP39_17_2").mask("9999");
			$("#txtP39_17_3").mask("9999");
			$("#txtP39_18_1").numeric();
			$("#txtP39_18_2").mask("9999");
			$("#txtP39_18_3").mask("9999");
			$("#txtP40").numeric({ ichars: '3456780' });			
			$("#txtP41_1_1").numeric();
			$("#txtP41_1_2").numeric();
			$("#txtP41_1_3").numeric();
			$("#txtP41_2_1").numeric();
			$("#txtP41_2_2").numeric();
			$("#txtP41_2_3").numeric();
			$("#txtP41_3_1").numeric();
			$("#txtP41_3_2").numeric();
			$("#txtP41_3_3").numeric();
			$("#txtP41_4_1").numeric();
			$("#txtP41_4_2").numeric();
			$("#txtP41_4_3").numeric();
			$("#txtP41_5_1").numeric();
			$("#txtP41_5_2").numeric();
			$("#txtP41_5_3").numeric();
			$("#txtP41_6_1").numeric();
			$("#txtP41_6_2").numeric();
			$("#txtP41_6_3").numeric();
			$("#txtP41_7_1").numeric();
			$("#txtP41_7_2").numeric();
			$("#txtP41_7_3").numeric();
			$("#txtP41_8_1").numeric();
			$("#txtP41_8_2").numeric();
			$("#txtP41_8_3").numeric();
			$("#txtP41_9_1").numeric();
			$("#txtP41_9_2").numeric();
			$("#txtP41_9_3").numeric();
			$("#txtP41_10_1").numeric();
			$("#txtP41_10_2").numeric();
			$("#txtP41_10_3").numeric();
			$("#txtP41_11_1").numeric();
			$("#txtP41_11_2").numeric();
			$("#txtP41_11_3").numeric();
			$("#txtP41_12_1").numeric();
			$("#txtP41_12_2").numeric();
			$("#txtP41_12_3").numeric();
			$("#txtP42").numeric();
			$("#txtP43").mask("9");
			$("#txtP44").numeric();			
			$("#txtP45_1").numeric({ ichars: '3456780' });
			$("#txtP45_2").numeric({ ichars: '3456780' });
			$("#txtP45_3").numeric({ ichars: '3456780' });
			$("#txtP46").numeric({ ichars: '3456780' });
			$("#txtP47_1").numeric({ ichars: '3456780' });
			$("#txtP47_2").numeric({ ichars: '3456780' });
			$("#txtP47_3").numeric({ ichars: '3456780' });
			$("#txtP48").numeric({ ichars: '3456780' });
			$("#txtP49_1").numeric();
			$("#txtP49_2").numeric();
			$("#txtP49_3").numeric();
			$("#txtP50").numeric({ ichars: '3456780' });			
			$("#txtP51_1_1").numeric();
			$("#txtP51_1_2").numeric();
			$("#txtP51_1_3").numeric();
			$("#txtP51_2_1").numeric();
			$("#txtP51_2_2").numeric();
			$("#txtP51_2_3").numeric();
			$("#txtP51_3_1").numeric();
			$("#txtP51_3_2").numeric();
			$("#txtP51_3_3").numeric();
			$("#txtP51_4_1").numeric();
			$("#txtP51_4_2").numeric();
			$("#txtP51_4_3").numeric();			
			$("#txtP52_1").numeric({ ichars: '3456780' });
			$("#txtP52_2").numeric({ ichars: '3456780' });
			$("#txtP52_3").numeric({ ichars: '3456780' });			
			$("#txtP53_1").numeric({ ichars: '3456780' });
			$("#txtP53_2").numeric({ ichars: '3456780' });
			$("#txtP53_3").numeric({ ichars: '3456780' });			
			$("#txtP54").numeric({ ichars: '3456780' });						
			$("#txtP55_1_1").numeric();
			$("#txtP55_1_2").numeric();
			$("#txtP55_1_3").numeric();
			$("#txtP55_1_4").numeric();
			$("#txtP55_1_5").numeric();
			$("#txtP55_2_1").numeric();
			$("#txtP55_2_2").numeric();
			$("#txtP55_2_3").numeric();
			$("#txtP55_2_4").numeric();
			$("#txtP55_2_5").numeric();
			$("#txtP55_3_1").numeric();
			$("#txtP55_3_2").numeric();
			$("#txtP55_3_3").numeric();
			$("#txtP55_3_4").numeric();
			$("#txtP55_3_5").numeric();
			$("#txtP55_4_1").numeric();
			$("#txtP55_4_2").numeric();
			$("#txtP55_4_3").numeric();
			$("#txtP55_4_4").numeric();
			$("#txtP55_4_5").numeric();
			$("#txtP56").numeric({ ichars: '3456780' });			
			$("#txtP57_1_1").numeric();
			$("#txtP57_1_2").numeric();
			$("#txtP57_1_3").numeric();
			$("#txtP57_2_1").numeric();
			$("#txtP57_2_2").numeric();
			$("#txtP57_2_3").numeric();
			$("#txtP57_3_1").numeric();
			$("#txtP57_3_2").numeric();
			$("#txtP57_3_3").numeric();
			$("#txtP57_4_1").numeric();
			$("#txtP57_4_2").numeric();
			$("#txtP57_4_3").numeric();				
			$("#txtP58_1").numeric({ ichars: '3456780' });
			$("#txtP58_2").numeric({ ichars: '3456780' });
			$("#txtP58_3").numeric({ ichars: '3456780' });
			$("#txtP59").numeric({ ichars: '3456780' });			
			$("#txtP60_1_1").numeric();
			$("#txtP60_1_2").numeric();
			$("#txtP60_1_3").numeric();
			$("#txtP60_2_1").numeric();
			$("#txtP60_2_2").numeric();
			$("#txtP60_2_3").numeric();
			$("#txtP60_3_1").numeric();
			$("#txtP60_3_2").numeric();
			$("#txtP60_3_3").numeric();
			$("#txtP60_4_1").numeric();
			$("#txtP60_4_2").numeric();
			$("#txtP60_4_3").numeric();	
			$("#txtP61_1").numeric({ ichars: '3456780' });
			$("#txtP61_2").numeric({ ichars: '3456780' });
			$("#txtP61_3").numeric({ ichars: '3456780' });			
			$("#txtP62").numeric({ ichars: '3456780' });				
			$("#txtP63_1_1").numeric();
			$("#txtP63_1_2").numeric();
			$("#txtP63_1_3").numeric();
			$("#txtP63_1_4").numeric();			
			$("#txtP63_2_1").numeric();
			$("#txtP63_2_2").numeric();
			$("#txtP63_2_3").numeric();
			$("#txtP63_2_4").numeric();			
			$("#txtP63_3_1").numeric();
			$("#txtP63_3_2").numeric();
			$("#txtP63_3_3").numeric();
			$("#txtP63_3_4").numeric();			
			$("#txtP63_4_1").numeric();
			$("#txtP63_4_2").numeric();
			$("#txtP63_4_3").numeric();
			$("#txtP63_4_4").numeric();			
			$("#txtP63_5_1").numeric();
			$("#txtP63_5_2").numeric();
			$("#txtP63_5_3").numeric();
			$("#txtP63_5_4").numeric();			
			$("#txtP63_6_1").numeric();
			$("#txtP63_6_2").numeric();
			$("#txtP63_6_3").numeric();
			$("#txtP63_6_4").numeric();			
			$("#txtP63_7_1").numeric();
			$("#txtP63_7_2").numeric();
			$("#txtP63_7_3").numeric();
			$("#txtP63_7_4").numeric();			
			$("#txtP63_8_1").numeric();
			$("#txtP63_8_2").numeric();
			$("#txtP63_8_3").numeric();
			$("#txtP63_8_4").numeric();			
			$("#txtP63_9_1").numeric();
			$("#txtP63_9_2").numeric();
			$("#txtP63_9_3").numeric();
			$("#txtP63_9_4").numeric();			
			$("#txtP64_1").numeric({ ichars: '3456780' });
			$("#txtP64_2").numeric({ ichars: '3456780' });
			$("#txtP64_3").numeric({ ichars: '3456780' });				
			$("#txtP65_1").numeric({ ichars: '3456780' });
			$("#txtP65_2").numeric({ ichars: '3456780' });
			$("#txtP65_3").numeric({ ichars: '3456780' });			
			$("#txtP66").numeric({ ichars: '3456780' });			
			$("#txtP67_1_1").numeric();
			$("#txtP67_1_2").numeric();
			$("#txtP67_1_3").numeric();
			$("#txtP67_1_4").numeric();			
			$("#txtP67_2_1").numeric();
			$("#txtP67_2_2").numeric();
			$("#txtP67_2_3").numeric();
			$("#txtP67_2_4").numeric();			
			$("#txtP67_3_1").numeric();
			$("#txtP67_3_2").numeric();
			$("#txtP67_3_3").numeric();
			$("#txtP67_3_4").numeric();			
			$("#txtP67_4_1").numeric();
			$("#txtP67_4_2").numeric();
			$("#txtP67_4_3").numeric();
			$("#txtP67_4_4").numeric();			
			$("#txtP67_5_1").numeric();
			$("#txtP67_5_2").numeric();
			$("#txtP67_5_3").numeric();
			$("#txtP67_5_4").numeric();			
			$("#txtP67_6_1").numeric();
			$("#txtP67_6_2").numeric();
			$("#txtP67_6_3").numeric();
			$("#txtP67_6_4").numeric();			
			$("#txtP67_7_1").numeric();
			$("#txtP67_7_2").numeric();
			$("#txtP67_7_3").numeric();
			$("#txtP67_7_4").numeric();			
			$("#txtP67_8_1").numeric();
			$("#txtP67_8_2").numeric();
			$("#txtP67_8_3").numeric();
			$("#txtP67_8_4").numeric();			
			$("#txtP67_9_1").numeric();
			$("#txtP67_9_2").numeric();
			$("#txtP67_9_3").numeric();
			$("#txtP67_9_4").numeric();			
			$("#txtP68_1").numeric({ ichars: '3456780' });
			$("#txtP68_2").numeric({ ichars: '3456780' });
			$("#txtP68_3").numeric({ ichars: '3456780' });			
			$("#txtP69_1").numeric({ ichars: '3456780' });
			$("#txtP69_2").numeric({ ichars: '3456780' });
			$("#txtP69_3").numeric({ ichars: '3456780' });			
			$("#txtP70_1").numeric();
			$("#txtP70_2").numeric();
			$("#txtP70_3").numeric();			
			$("#txtP70_4").numeric();
			$("#txtP70_5").numeric();			
			$("#txtP71_1").numeric({ ichars: '3456780' });
			$("#txtP71_2").numeric({ ichars: '3456780' });
			$("#txtP71_3").numeric({ ichars: '3456780' });			
			$("#txtP72").numeric({ ichars: '456780' });			
			$("#txtP73_1").numeric();
			$("#txtP73_2").numeric();
			$("#txtP73_3").numeric();			
			$("#txtP73_4").numeric();
			$("#txtP73_5").numeric();
			$("#txtP73_6").numeric();
			$("#txtP73_7").numeric();
			$("#txtP73_8").numeric();			
			$("#txtP73_9").numeric();
			$("#txtP73_10").numeric();			
			$("#txtP74_1_1").numeric();
			$("#txtP74_1_2").mask("9999");
			$("#txtP74_1_3").mask("9999");
			$("#txtP74_2_1").numeric();
			$("#txtP74_2_2").mask("9999");
			$("#txtP74_2_3").mask("9999");
			$("#txtP74_3_1").numeric();
			$("#txtP74_3_2").mask("9999");
			$("#txtP74_3_3").mask("9999");
			$("#txtP74_4_1").numeric();
			$("#txtP74_4_2").mask("9999");
			$("#txtP74_4_3").mask("9999");
			$("#txtP75").numeric({ ichars: '3456780' });			
			$("#txtP76_1").numeric();
			$("#txtP76_2").numeric();
			$("#txtP76_3").numeric();			
			$("#txtP76_4").numeric();
			$("#txtP77_1").numeric({ ichars: '3456780' });
			$("#txtP77_2").numeric({ ichars: '3456780' });
			$("#txtP77_3").numeric({ ichars: '3456780' });	
			$("#txtP78").numeric({ ichars: '3456780' });			
			$("#txtP79_1").numeric({ ichars: '3456780' });
			$("#txtP79_2").numeric({ ichars: '3456780' });
			$("#txtP80").numeric();
			$("#txtP81_1").numeric();
			$("#txtP81_2").mask("99");			
			$("#txtP82_1").numeric({ ichars: '3456780' });
			$("#txtP82_2").numeric({ ichars: '3456780' });
			$("#txtP82_3").numeric({ ichars: '3456780' });
			$("#txtP83_1_1").numeric({ ichars: '3456780' });
			$("#txtP83_1_2").numeric({ ichars: '3456780' });
			$("#txtP83_2_1").numeric({ ichars: '3456780' });
			$("#txtP83_3_1").numeric({ ichars: '3456780' });
			$("#txtP83_4_1").numeric({ ichars: '3456780' });
			$("#txtP83_5_1").numeric({ ichars: '3456780' });
			$("#txtP83_6_1").numeric({ ichars: '3456780' });
			$("#txtP84_1").numeric({ ichars: '3456780' });
			$("#txtP84_2").numeric({ ichars: '3456780' });
			$("#txtP85_1").numeric({ ichars: '3456780' });
			$("#txtP85_2").numeric({ ichars: '3456780' });
			$("#txtP85_3").numeric({ ichars: '3456780' });
			$("#txtP86_1_1").numeric();
			$("#txtP86_1_2").numeric();
			$("#txtP86_1_3").numeric();
			$("#txtP86_2_1").numeric();
			$("#txtP86_2_2").numeric();
			$("#txtP86_2_3").numeric();
			$("#txtP86_3_1").numeric();
			$("#txtP86_3_2").numeric();
			$("#txtP86_3_3").numeric();
			$("#txtP86_4_1").numeric();
			$("#txtP86_4_2").numeric();
			$("#txtP86_4_3").numeric();
			$("#txtP86_5_1").numeric();
			$("#txtP86_5_2").numeric();
			$("#txtP86_5_3").numeric();
			$("#txtP86_6_1").numeric();
			$("#txtP86_6_2").numeric();
			$("#txtP86_6_3").numeric();
			$("#txtP86_7_1").numeric();
			$("#txtP86_7_2").numeric();
			$("#txtP86_7_3").numeric();
			$("#txtP87_1_1").numeric();
			$("#txtP87_1_2").numeric();
			$("#txtP87_1_3").numeric();
			$("#txtP87_2_1").numeric();
			$("#txtP87_2_2").numeric();
			$("#txtP87_2_3").numeric();
			$("#txtP88_1").numeric({ ichars: '3456780' });
			$("#txtP89_1").numeric({ ichars: '3456780' });
			$("#txtP89_2").numeric({ ichars: '3456780' });
			$("#txtP89_3").numeric({ ichars: '3456780' });
			$("#txtP90_1").numeric({ ichars: '3456780' });
			$("#txtP90_2").numeric({ ichars: '3456780' });
			$("#txtP90_3").numeric({ ichars: '3456780' });
			$("#txtP90_4").numeric({ ichars: '3456780' });
			$("#txtP90_5").numeric({ ichars: '3456780' });
			$("#txtP90_6").numeric({ ichars: '3456780' });
			$("#txtP90_7").numeric({ ichars: '3456780' });
			$("#txtP90_8").numeric({ ichars: '3456780' });
			$("#txtP90_9").numeric({ ichars: '3456780' });
			$("#txtP90_10").numeric({ ichars: '3456780' });
			$("#txtP91_1").numeric({ ichars: '3456780' });
			$("#txtP92_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP92_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP92_3").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP92_4").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP93_1").numeric({ ichars: '3456780' });
			$("#txtP93_2").numeric({ ichars: '3456780' });
			$("#txtP94_1").numeric({ ichars: '3456780' });
			$("#txtP95_1").numeric({ ichars: '3456780' });
			$("#txtP96_1_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP96_1_2").numeric();
			$("#txtP96_1_3").numeric();
			$("#txtP96_1_4").numeric();
			$("#txtP96_2_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP96_2_2").numeric();
			$("#txtP96_2_3").numeric();
			$("#txtP96_2_4").numeric();
			$("#txtP96_3_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP96_3_2").numeric();
			$("#txtP96_3_3").numeric();
			$("#txtP96_3_4").numeric();
			$("#txtP96_4_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP96_4_2").numeric();
			$("#txtP96_4_3").numeric();
			$("#txtP96_4_4").numeric();
			$("#txtP96_5_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP96_5_2").numeric();
			$("#txtP96_5_3").numeric();
			$("#txtP96_5_4").numeric();
			$("#txtP97_1").numeric({ ichars: '3456780' });
			$("#txtP98_1_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP98_1_2").numeric();
			$("#txtP98_1_3").numeric();
			$("#txtP98_2_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP98_2_2").numeric();
			$("#txtP98_2_3").numeric();
			$("#txtP98_3_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP98_3_2").numeric();
			$("#txtP98_3_3").numeric();
			$("#txtP98_4_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP98_4_2").numeric();
			$("#txtP98_4_3").numeric();
			$("#txtP99_1").numeric({ ichars: '3456780' });
			$("#txtP99_2").numeric({ ichars: '3456780' });
			$("#txtP100_1").numeric({ ichars: '3456780' });
			$("#txtP101_1_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP101_1_2").numeric();
			$("#txtP101_1_3").numeric();
			$("#txtP101_2_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP101_2_2").numeric();
			$("#txtP101_2_3").numeric();
			$("#txtP101_3_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP101_3_2").numeric();
			$("#txtP101_3_3").numeric();
			$("#txtP101_4_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP101_4_2").numeric();
			$("#txtP101_4_3").numeric();
			$("#txtP102_1").numeric({ ichars: '3456780' });
			$("#txtP102_2").numeric({ ichars: '3456780' });
			$("#txtP102_3").numeric({ ichars: '3456780' });
			$("#txtP103_1").numeric({ ichars: '3456780' });
			$("#txtP104_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP104_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP104_3").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP104_4").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP104_5").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP105_1").numeric({ ichars: '23456780' });
			$("#txtP105_2").numeric({ ichars: '23456780' });
			$("#txtP105_3").numeric({ ichars: '23456780' });
			$("#txtP106_1").numeric({ ichars: '23456780' });
			$("#txtP107_1").numeric({ ichars: '23456780' });
			$("#txtP107_2").numeric({ ichars: '23456780' });
			$("#txtP107_3").numeric({ ichars: '23456780' });
			$("#txtP107_4").numeric({ ichars: '23456780' });
			$("#txtP107_5").numeric({ ichars: '23456780' });
			$("#txtP108_1").numeric({ ichars: '3456780' });
			$("#txtP109_1").numeric({ ichars: '3456780' });
			$("#txtP110_1").numeric({ ichars: '3456780' });
			$("#txtP110_2").numeric({ ichars: '3456780' });
			$("#txtP111_1").numeric({ ichars: '3456780' });
			$("#txtP111_2").numeric({ ichars: '3456780' });
			$("#txtP111_3").numeric({ ichars: '3456780' });
			$("#txtP111_4").numeric({ ichars: '3456780' });
			$("#txtP112_1").numeric({ ichars: '3456780' });
			$("#txtP112_2").numeric({ ichars: '3456780' });
			$("#txtP112_3").numeric({ ichars: '3456780' });
			$("#txtP113_1").numeric({ ichars: '3456780' });
			$("#txtP114_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP114_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP114_3").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP115_1_1").numeric();
			$("#txtP115_1_2").numeric();
			$("#txtP115_1_3").numeric();
			$("#txtP115_2_1").numeric();
			$("#txtP115_2_2").numeric();
			$("#txtP115_2_3").numeric();
			$("#txtP115_3_1").numeric();
			$("#txtP115_3_2").numeric();
			$("#txtP115_3_3").numeric();
			$("#txtP115_4_1").numeric();
			$("#txtP115_4_2").numeric();
			$("#txtP115_4_3").numeric();
			$("#txtP115_5_1").numeric();
			$("#txtP115_5_2").numeric();
			$("#txtP115_5_3").numeric();
			$("#txtP115_6_1").numeric();
			$("#txtP115_6_2").numeric();
			$("#txtP115_6_3").numeric();
			$("#txtP115_7_1").numeric();
			$("#txtP115_7_2").numeric();
			$("#txtP115_7_3").numeric();
			$("#txtP116_1_1").numeric();
			$("#txtP116_1_2").numeric();
			$("#txtP116_1_3").numeric();
			$("#txtP116_2_1").numeric();
			$("#txtP116_2_2").numeric();
			$("#txtP116_2_3").numeric();
			$("#txtP116_3_1").numeric();
			$("#txtP116_3_2").numeric();
			$("#txtP116_3_3").numeric();
			$("#txtP116_4_1").numeric();
			$("#txtP116_4_2").numeric();
			$("#txtP116_4_3").numeric();
			$("#txtP116_5_1").numeric();
			$("#txtP116_5_2").numeric();
			$("#txtP116_5_3").numeric();
			$("#txtP116_6_1").numeric();
			$("#txtP116_6_2").numeric();
			$("#txtP116_6_3").numeric();
			$("#txtP116_7_1").numeric();
			$("#txtP116_7_2").numeric();
			$("#txtP116_7_3").numeric();
			$("#txtP117_1").numeric({ ichars: '3456780' });
			$("#txtP117_2").numeric({ ichars: '3456780' });
			$("#txtP117_3").numeric({ ichars: '3456780' });
			$("#txtP117_4").numeric({ ichars: '3456780' });
			$("#txtP117_5").numeric({ ichars: '3456780' });
			$("#txtP117_6").numeric({ ichars: '3456780' });
			$("#txtP117_7").numeric({ ichars: '3456780' });
			$("#txtP117_8").numeric({ ichars: '3456780' });
			$("#txtP118_1").numeric({ ichars: '3456780' });
			$("#txtP119_1").numeric({ ichars: '3456780' });
			$("#txtP120_1").numeric({ ichars: '3456780' });
			$("#txtP121_1").numeric({ ichars: '3456780' });
			$("#txtP122_1").numeric({ ichars: '456780' });
			$("#txtP123_1").numeric({ ichars: '3456780' });
			$("#txtP123_2").numeric({ ichars: '3456780' });
			$("#txtP124_1_1").numeric({ ichars: '3456780' });
			$("#txtP124_2_1").numeric();
			$("#txtP124_2_2").numeric();
			$("#txtP124_2_3").numeric();
			$("#txtP124_3_1").numeric();
			$("#txtP124_3_2").numeric();
			$("#txtP124_3_3").numeric();
			$("#txtP125_1_1").numeric({ ichars: '3456780' });
			$("#txtP125_2_1").numeric();
			$("#txtP125_2_2").numeric();
			$("#txtP125_2_3").numeric();
			$("#txtP125_3_1").numeric();
			$("#txtP125_3_2").numeric();
			$("#txtP125_3_3").numeric();
			$("#txtP126_1").numeric({ ichars: '3456780' });
			$("#txtP127_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP127_3").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' }); 
			$("#txtP127_4").numeric({ ichars: '3456780' });
			$("#txtP127_5").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP127_6").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP127_1").numeric({ ichars: '3456780' });
			$("#txtP127_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP127_3").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' }); 
			$("#txtP127_4").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP128_1").numeric({ ichars: '3456780' });
			$("#txtP128_2").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' }); 
			$("#txtP128_3").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' }); 
			$("#txtP128_4").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' }); 
			$("#txtP129_1").numeric();
			$("#txtP129_2").numeric({ ichars: '3456780' });
			$("#txtP129_3").numeric({ ichars: '0' });
			$("#txtP129_4").numeric({ ichars: '0' });
			$("#txtP129_5").numeric({ ichars: '3456780' });
			$("#txtP129_6").numeric({ ichars: '890' });
			$("#txtP130_1").numeric({ ichars: '3456780' });
	/*pregunta 131*/
			$("#txtP131_1_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP131_1_2").numeric();
			$("#txtP131_1_3").numeric({ ichars: '456780' });
			$("#txtP131_1_4").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP131_1_5").numeric({ allow: "." });
			$("#txtP131_1_6").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP131_2_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP131_2_2").numeric();
			$("#txtP131_2_3").numeric({ ichars: '456780' });
			$("#txtP131_2_4").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP131_2_5").numeric({ allow: "." });
			$("#txtP131_2_6").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP131_3_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP131_3_2").numeric();
			$("#txtP131_3_3").numeric({ ichars: '456780' });
			$("#txtP131_3_4").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP131_3_5").numeric({ allow: "." });
			$("#txtP131_3_6").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP131_4_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP131_4_2").numeric();
			$("#txtP131_4_3").numeric({ ichars: '456780' });
			$("#txtP131_4_4").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP131_4_5").numeric({ allow: "." });
			$("#txtP131_4_6").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP131_5_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP131_5_2").numeric();
			$("#txtP131_5_3").numeric({ ichars: '456780' });
			$("#txtP131_5_4").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP131_5_5").numeric({ allow: "." });
			$("#txtP131_5_6").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP131_6_1").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP131_6_2").numeric();
			$("#txtP131_6_3").numeric({ ichars: '456780' });
			$("#txtP131_6_4").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			$("#txtP131_6_5").numeric({ allow: "." });
			$("#txtP131_6_6").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
			

			$("#txtP132_1").numeric({ ichars: '456780' });
			
			
            $("#NombreAutoridadesEntrevistadas_01").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#Cargo_01").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#NombreAutoridadesEntrevistadas_02").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#Cargo_02").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#NombreAutoridadesEntrevistadas_03").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#Cargo_03").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#NombreAutoridadesEntrevistadas_04").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#Cargo_04").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
            $("#Dia").mask("99");
            $("#Mes").mask("99");
            $("#Anio").mask("9999");
            $("#Observaciones").alphanumeric({ ichars: '-_:.,}{[+]/-;,./´º+^~<>«»=()&\ñÑ¡!?#:$%[_*@áéíóú{}'+'¿?¡' });
        
         
        })
        </script>
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
<!-- InstanceBeginEditable name="head" -->
        <style type="text/css">
            .text-box{            
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
        </style>



        <!-- InstanceEndEditable --><!-- InstanceParam name="region1" type="boolean" value="true" -->
<!--<link href="../css/formatos.css" rel="stylesheet" type="text/css" />-->
<!--<link href="../css/a4.css" rel="stylesheet" type="text/css" />-->
<link href="../../css/formato.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
if (!function_exists("GetSQLValueString")) {
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
}

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Idaladm'])) {
  $colname_Recordset1 = $_SESSION['MM_Idaladm'];
}
mysql_select_db($database_dbca, $dbca);
$query_Recordset1 = sprintf("SELECT * FROM usuarios, t_unidades WHERE usuarios.id_usr = %s AND t_unidades.CodigoUnidad=usuarios.nivel_usr", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $dbca) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_permisos = "-1";
if (isset($_SESSION['MM_Idaladm'])) {
  $colname_permisos = $_SESSION['MM_Idaladm'];
}
mysql_select_db($database_dbca, $dbca);
$query_permisos = sprintf("SELECT * FROM usuarios, t_unidades WHERE usuarios.id_usr = %s AND t_unidades.CodigoUnidad=usuarios.nivel_usr", GetSQLValueString($colname_permisos, "int"));
$permisos = mysql_query($query_permisos, $dbca) or die(mysql_error());
$row_permisos = mysql_fetch_assoc($permisos);
$totalRows_permisos = mysql_num_rows($permisos);

$mod_listamenu = "-1";
if (isset($row_permisos['nivel_usr'])) {
  $mod_listamenu = $row_permisos['nivel_usr'];
}
$men_listamenu = "-1";
if (isset($row_permisos['acceso_usr'])) {
  $men_listamenu = $row_permisos['acceso_usr'];
}
mysql_select_db($database_dbca, $dbca);
$query_listamenu = sprintf("SELECT * FROM sis_menu_ca WHERE acceso_modulo=%s and acceso_menu=%s ORDER BY orden_menu ASC", GetSQLValueString($mod_listamenu, "text"),GetSQLValueString($men_listamenu, "int"));
$listamenu = mysql_query($query_listamenu, $dbca) or die(mysql_error());
$row_listamenu = mysql_fetch_assoc($listamenu);
$totalRows_listamenu = mysql_num_rows($listamenu);
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
	  <?php } while ($row_listamenu = mysql_fetch_assoc($listamenu)); ?>
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
	for ($i = 15; $i <= 135; $i++) {
        ${"p".$i} = 'none';
    }
    if (isset($_POST["botPress"])) {
        $mostrar = $_POST["botPress"];
        $p0 = 'none';
        $$mostrar = 'block';
    }
?>
<?php if ((isset($_POST["botPress"])) && ($_POST["botPress"] == "p134")) {
    echo '<script>
		      window.alert("Registro Correctamente");	
		      window.location = "/ine_ca/censoagropecuario/transcripcion_boletaproductor/ca_boletaproductor_v2.php"
		  </script>';
}
?>
<?php 
if (isset($_POST["botPress"]) && ($_POST["botPress"]=="p0")){
    $docID  = '02-02-01-01-001';
	//$docID  = $_POST['DOC_ID'];
	$objIns=new ca_boletaproductordb();
	$arrayCabecera=$objIns->ca_obtiene_cabecera($docID);	
}
?>
<?php
$docID  = '02-02-01-01-001';
//$docID  = $_POST['DOC_ID'];

if (isset($_POST["botPress"]) && ($_POST["botPress"]=="insertar")){
	$objIns=new ca_boletaproductordb();	
	$arrayCabecera = $objIns->ca_obtiene_cabecera($docID);	
	foreach ($arrayCabecera as $row_cabecera): 
		$NumeroBrigada=$row_cabecera['NumeroBrigada'];		
		$P01_CodigoDepartamento=$row_cabecera['CP01_CodigoDepartamento'];
		$P02_CodigoProvincia=$row_cabecera['CP02_CodigoProvincia'];
		$P03_CodigoMunicipio=$row_cabecera['CP03_CodigoMunicipio'];
		$P04_CodigoArea=$row_cabecera['CP04_CodigoArea'];
		$P05_CodigoCanton=$row_cabecera['CP05_CodigoCanton'];
		$NumeroOrden=$row_cabecera['NumeroOrdenComunidad'];
		$CodigoComunidad=$row_cabecera['CP6y7'];
		$P12=$row_cabecera['CP08_NombreComunidad'];
	endforeach;	
	
	$NumeroEmpadronador=$_POST['txtnum_emp'];
	$NumeroSegmento=$_POST['txtnum_seg'];
	$NumeroHojaControl=$_POST['txtnum_control'];	
    $P13=$_POST['txtP13'];    
    $P14=$_POST['txtP14'];
	
	$arrayIns_1=$objIns->ca_inserta_boleta_productor_p1($docID, $NumeroBrigada, $NumeroEmpadronador, $NumeroSegmento, $P01_CodigoDepartamento, $P02_CodigoProvincia, $P03_CodigoMunicipio, $P04_CodigoArea, $P05_CodigoCanton,
	                                        $NumeroOrden, $CodigoComunidad, $P12, $P13, $P14, 1, 'prueba-trans', '127.0.0.1');
	$arrayIns_2=$objIns->ca_inserta_boleta_productor_p2($docID, $NumeroBrigada, $NumeroEmpadronador, $NumeroSegmento, $P01_CodigoDepartamento, $P02_CodigoProvincia, $P03_CodigoMunicipio, $P04_CodigoArea, $P05_CodigoCanton,
	                                        $NumeroOrden, $CodigoComunidad, $P12, $P13, $P14, 1, 'prueba-trans', '127.0.0.1');
}//*/
?>
<?php 
if (isset($_POST["MM_update"]) && ($_POST["MM_update"]=="form"))
{	
	$obj=new ca_boletaproductordb();    	
    
	$NumeroEmpadronador=$_POST['txtnum_emp'];
	$NumeroSegmento=$_POST['txtnum_seg'];
	$NumeroHojaControl=$_POST['txtnum_control'];	
        
    $P13=$_POST['txtP13'];    
    $P14=$_POST['txtP14'];
    $P15_1=$_POST['txtP15_1'];
    $P15_2=$_POST['txtP15_2'];
    $P15_3=$_POST['txtP15_3'];
	$P15_4=$_POST['txtP15_4'];
	$P15_5=$_POST['txtP15_5'];
    $P16=$_POST['txtP16'];
    $P17_1=$_POST['txtP17_1'];
    $P17_2=$_POST['txtP17_2'];    
    $P18=$_POST['txtP18'];    
    $P19=$_POST['txtP19'];
	$P20_1=$_POST['txtP20_1'];
	$P20_2=$_POST['txtP20_2'];
	$P20_3=$_POST['txtP20_3'];
	$P20_4=$_POST['txtP20_4'];
    $P21_1_1=$_POST['txtP21_1_1'];
	$P21_1_2=$_POST['txtP21_1_2'];
	$P21_2_1=$_POST['txtP21_2_1'];
	$P21_2_2=$_POST['txtP21_2_2'];
	$P21_3_1=$_POST['txtP21_3_1'];
	$P21_3_1=$_POST['txtP21_3_2'];
	$P21_4_1=$_POST['txtP21_4_1'];
	$P21_4_2=$_POST['txtP21_4_2'];
	$P21_5_1=$_POST['txtP21_5_1'];
	$P21_5_2=$_POST['txtP21_5_2'];
    $P22_1=$_POST['txtP22_1'];
	$P22_2=$_POST['txtP22_2'];
	$P22_3=$_POST['txtP22_3'];
	$P22_4=$_POST['txtP22_4'];
    $P23_1=$_POST['txtP23_1'];
    $P23_1_1=$_POST['txtP23_1_1'];
	$P23_1_2=$_POST['txtP23_1_2'];
	$P23_1_3=$_POST['txtP23_1_3'];
	$P23_1_4=$_POST['txtP23_1_4'];
	$P23_1_5=$_POST['txtP23_1_5'];
	$P23_1_6=$_POST['txtP23_1_6'];
	$P23_1_7=$_POST['txtP23_1_7'];
	$P23_1_8=$_POST['txtP23_1_8'];
	$P23_1_9=$_POST['txtP23_1_9'];
	$P23_1_10=$_POST['txtP23_1_10'];
	$P23_1_11=$_POST['txtP23_1_11'];
	$P23_1_12=$_POST['txtP23_1_12'];	
	$P23_2_1=$_POST['txtP23_2_1'];
	$P23_2_2=$_POST['txtP23_2_2'];
	$P23_2_3=$_POST['txtP23_2_3'];
	$P23_2_4=$_POST['txtP23_2_4'];
	$P23_2_5=$_POST['txtP23_2_5'];
	$P23_2_6=$_POST['txtP23_2_6'];
	$P23_2_7=$_POST['txtP23_2_7'];
	$P23_2_8=$_POST['txtP23_2_8'];
	$P23_2_9=$_POST['txtP23_2_9'];
	$P23_2_10=$_POST['txtP23_2_10'];
	$P23_2_11=$_POST['txtP23_2_11'];
	$P23_2_12=$_POST['txtP23_2_12'];	
	$P23_3_1=$_POST['txtP23_3_1'];
	$P23_3_2=$_POST['txtP23_3_2'];
	$P23_3_3=$_POST['txtP23_3_3'];
	$P23_3_4=$_POST['txtP23_3_4'];
	$P23_3_5=$_POST['txtP23_3_5'];
	$P23_3_6=$_POST['txtP23_3_6'];
	$P23_3_7=$_POST['txtP23_3_7'];
	$P23_3_8=$_POST['txtP23_3_8'];
	$P23_3_9=$_POST['txtP23_3_9'];
	$P23_3_10=$_POST['txtP23_3_10'];
	$P23_3_11=$_POST['txtP23_3_11'];
	$P23_3_12=$_POST['txtP23_3_12'];	
	$P23_4_1=$_POST['txtP23_4_1'];
	$P23_4_2=$_POST['txtP23_4_2'];
	$P23_4_3=$_POST['txtP23_4_3'];
	$P23_4_4=$_POST['txtP23_4_4'];
	$P23_4_5=$_POST['txtP23_4_5'];
	$P23_4_6=$_POST['txtP23_4_6'];
	$P23_4_7=$_POST['txtP23_4_7'];
	$P23_4_8=$_POST['txtP23_4_8'];
	$P23_4_9=$_POST['txtP23_4_9'];
	$P23_4_10=$_POST['txtP23_4_10'];
	$P23_4_11=$_POST['txtP23_4_11'];
	$P23_4_12=$_POST['txtP23_4_12'];	
	$P23_5_1=$_POST['txtP23_5_1'];
	$P23_5_2=$_POST['txtP23_5_2'];
	$P23_5_3=$_POST['txtP23_5_3'];
	$P23_5_4=$_POST['txtP23_5_4'];
	$P23_5_5=$_POST['txtP23_5_5'];
	$P23_5_6=$_POST['txtP23_5_6'];
	$P23_5_7=$_POST['txtP23_5_7'];
	$P23_5_8=$_POST['txtP23_5_8'];
	$P23_5_9=$_POST['txtP23_5_9'];
	$P23_5_10=$_POST['txtP23_5_10'];
	$P23_5_11=$_POST['txtP23_5_11'];
	$P23_5_12=$_POST['txtP23_5_12'];	
	$P23_6_1=$_POST['txtP23_6_1'];
	$P23_6_2=$_POST['txtP23_6_2'];
	$P23_6_3=$_POST['txtP23_6_3'];
	$P23_6_4=$_POST['txtP23_6_4'];
	$P23_6_5=$_POST['txtP23_6_5'];
	$P23_6_6=$_POST['txtP23_6_6'];
	$P23_6_7=$_POST['txtP23_6_7'];
	$P23_6_8=$_POST['txtP23_6_8'];
	$P23_6_9=$_POST['txtP23_6_9'];
	$P23_6_10=$_POST['txtP23_6_10'];
	$P23_6_11=$_POST['txtP23_6_11'];
	$P23_6_12=$_POST['txtP23_6_12'];    
	$P23_7_1=$_POST['txtP23_7_1'];
	$P23_7_2=$_POST['txtP23_7_2'];
	$P23_7_3=$_POST['txtP23_7_3'];
	$P23_7_4=$_POST['txtP23_7_4'];
	$P23_7_5=$_POST['txtP23_7_5'];
	$P23_7_6=$_POST['txtP23_7_6'];
	$P23_7_7=$_POST['txtP23_7_7'];
	$P23_7_8=$_POST['txtP23_7_8'];
	$P23_7_9=$_POST['txtP23_7_9'];
	$P23_7_10=$_POST['txtP23_7_10'];
	$P23_7_11=$_POST['txtP23_7_11'];
	$P23_7_12=$_POST['txtP23_7_12'];
	$P24_1=$_POST['txtP24_1'];
	$P24_1_1=$_POST['txtP24_1_1'];
	$P24_1_2=$_POST['txtP24_1_2'];
	$P24_1_3=$_POST['txtP24_1_3'];
	$P24_1_4=$_POST['txtP24_1_4'];
	$P24_1_5=$_POST['txtP24_1_5'];
	$P24_1_6=$_POST['txtP24_1_6'];
	$P24_1_7=$_POST['txtP24_1_7'];
	$P24_1_8=$_POST['txtP24_1_8'];
	$P24_1_9=$_POST['txtP24_1_9'];
	$P24_1_10=$_POST['txtP24_1_10'];
	$P24_1_11=$_POST['txtP24_1_11'];
	$P24_1_12=$_POST['txtP24_1_12'];
	$P24_1_13=$_POST['txtP24_1_13'];
	$P24_1_14=$_POST['txtP24_1_14'];	
	$P24_2_1=$_POST['txtP24_2_1'];
	$P24_2_2=$_POST['txtP24_2_2'];
	$P24_2_3=$_POST['txtP24_2_3'];
	$P24_2_4=$_POST['txtP24_2_4'];
	$P24_2_5=$_POST['txtP24_2_5'];
	$P24_2_6=$_POST['txtP24_2_6'];
	$P24_2_7=$_POST['txtP24_2_7'];
	$P24_2_8=$_POST['txtP24_2_8'];
	$P24_2_9=$_POST['txtP24_2_9'];
	$P24_2_10=$_POST['txtP24_2_10'];
	$P24_2_11=$_POST['txtP24_2_11'];
	$P24_2_12=$_POST['txtP24_2_12'];
	$P24_2_13=$_POST['txtP24_2_13'];
	$P24_2_14=$_POST['txtP24_2_14'];	
	$P24_3_1=$_POST['txtP24_3_1'];
	$P24_3_2=$_POST['txtP24_3_2'];
	$P24_3_3=$_POST['txtP24_3_3'];
	$P24_3_4=$_POST['txtP24_3_4'];
	$P24_3_5=$_POST['txtP24_3_5'];
	$P24_3_6=$_POST['txtP24_3_6'];
	$P24_3_7=$_POST['txtP24_3_7'];
	$P24_3_8=$_POST['txtP24_3_8'];
	$P24_3_9=$_POST['txtP24_3_9'];
	$P24_3_10=$_POST['txtP24_3_10'];
	$P24_3_11=$_POST['txtP24_3_11'];
	$P24_3_12=$_POST['txtP24_3_12'];
	$P24_3_13=$_POST['txtP24_3_13'];
	$P24_3_14=$_POST['txtP24_3_14'];    
	$P24_4_1=$_POST['txtP24_4_1'];
	$P24_4_2=$_POST['txtP24_4_2'];
	$P24_4_3=$_POST['txtP24_4_3'];
	$P24_4_4=$_POST['txtP24_4_4'];
	$P24_4_5=$_POST['txtP24_4_5'];
	$P24_4_6=$_POST['txtP24_4_6'];
	$P24_4_7=$_POST['txtP24_4_7'];
	$P24_4_8=$_POST['txtP24_4_8'];
	$P24_4_9=$_POST['txtP24_4_9'];
	$P24_4_10=$_POST['txtP24_4_10'];
	$P24_4_11=$_POST['txtP24_4_11'];
	$P24_4_12=$_POST['txtP24_4_12'];
	$P24_4_13=$_POST['txtP24_4_13'];
	$P24_4_14=$_POST['txtP24_4_14'];	
	$P24_5_1=$_POST['txtP24_5_1'];
	$P24_5_2=$_POST['txtP24_5_2'];
	$P24_5_3=$_POST['txtP24_5_3'];
	$P24_5_4=$_POST['txtP24_5_4'];
	$P24_5_5=$_POST['txtP24_5_5'];
	$P24_5_6=$_POST['txtP24_5_6'];
	$P24_5_7=$_POST['txtP24_5_7'];
	$P24_5_8=$_POST['txtP24_5_8'];
	$P24_5_9=$_POST['txtP24_5_9'];
	$P24_5_10=$_POST['txtP24_5_10'];
	$P24_5_11=$_POST['txtP24_5_11'];
	$P24_5_12=$_POST['txtP24_5_12'];
	$P24_5_13=$_POST['txtP24_5_13'];
	$P24_5_14=$_POST['txtP24_5_14'];	
	$P24_6_1=$_POST['txtP24_6_1'];
	$P24_6_2=$_POST['txtP24_6_2'];
	$P24_6_3=$_POST['txtP24_6_3'];
	$P24_6_4=$_POST['txtP24_6_4'];
	$P24_6_5=$_POST['txtP24_6_5'];
	$P24_6_6=$_POST['txtP24_6_6'];
	$P24_6_7=$_POST['txtP24_6_7'];
	$P24_6_8=$_POST['txtP24_6_8'];
	$P24_6_9=$_POST['txtP24_6_9'];
	$P24_6_10=$_POST['txtP24_6_10'];
	$P24_6_11=$_POST['txtP24_6_11'];
	$P24_6_12=$_POST['txtP24_6_12'];
	$P24_6_13=$_POST['txtP24_6_13'];
	$P24_6_14=$_POST['txtP24_6_14'];	
	$P24_7_1=$_POST['txtP24_7_1'];
	$P24_7_2=$_POST['txtP24_7_2'];
	$P24_7_3=$_POST['txtP24_7_3'];
	$P24_7_4=$_POST['txtP24_7_4'];
	$P24_7_5=$_POST['txtP24_7_5'];
	$P24_7_6=$_POST['txtP24_7_6'];
	$P24_7_7=$_POST['txtP24_7_7'];
	$P24_7_8=$_POST['txtP24_7_8'];
	$P24_7_9=$_POST['txtP24_7_9'];
	$P24_7_10=$_POST['txtP24_7_10'];
	$P24_7_11=$_POST['txtP24_7_11'];
	$P24_7_12=$_POST['txtP24_7_12'];
	$P24_7_13=$_POST['txtP24_7_13'];
	$P24_7_14=$_POST['txtP24_7_14'];	
	$P24_8_1=$_POST['txtP24_8_1'];
	$P24_8_2=$_POST['txtP24_8_2'];
	$P24_8_3=$_POST['txtP24_8_3'];
	$P24_8_4=$_POST['txtP24_8_4'];
	$P24_8_5=$_POST['txtP24_8_5'];
	$P24_8_6=$_POST['txtP24_8_6'];
	$P24_8_7=$_POST['txtP24_8_7'];
	$P24_8_8=$_POST['txtP24_8_8'];
	$P24_8_9=$_POST['txtP24_8_9'];
	$P24_8_10=$_POST['txtP24_8_10'];
	$P24_8_11=$_POST['txtP24_8_11'];
	$P24_8_12=$_POST['txtP24_8_12'];
	$P24_8_13=$_POST['txtP24_8_13'];
	$P24_8_14=$_POST['txtP24_8_14'];	
	$P24_9_1=$_POST['txtP24_9_1'];
	$P24_9_2=$_POST['txtP24_9_2'];
	$P24_9_3=$_POST['txtP24_9_3'];
	$P24_9_4=$_POST['txtP24_9_4'];
	$P24_9_5=$_POST['txtP24_9_5'];
	$P24_9_6=$_POST['txtP24_9_6'];
	$P24_9_7=$_POST['txtP24_9_7'];
	$P24_9_8=$_POST['txtP24_9_8'];
	$P24_9_9=$_POST['txtP24_9_9'];
	$P24_9_10=$_POST['txtP24_9_10'];
	$P24_9_11=$_POST['txtP24_9_11'];
	$P24_9_12=$_POST['txtP24_9_12'];
	$P24_9_13=$_POST['txtP24_9_13'];
	$P24_9_14=$_POST['txtP24_9_14'];	
	$P24_10_1=$_POST['txtP24_10_1'];
	$P24_10_2=$_POST['txtP24_10_2'];
	$P24_10_3=$_POST['txtP24_10_3'];
	$P24_10_4=$_POST['txtP24_10_4'];
	$P24_10_5=$_POST['txtP24_10_5'];
	$P24_10_6=$_POST['txtP24_10_6'];
	$P24_10_7=$_POST['txtP24_10_7'];
	$P24_10_8=$_POST['txtP24_10_8'];
	$P24_10_9=$_POST['txtP24_10_9'];
	$P24_10_10=$_POST['txtP24_10_10'];
	$P24_10_11=$_POST['txtP24_10_11'];
	$P24_10_12=$_POST['txtP24_10_12'];
	$P24_10_13=$_POST['txtP24_10_13'];
	$P24_10_14=$_POST['txtP24_10_14'];	
	$P24_11_1=$_POST['txtP24_11_1'];
	$P24_11_2=$_POST['txtP24_11_2'];
	$P24_11_3=$_POST['txtP24_11_3'];
	$P24_11_4=$_POST['txtP24_11_4'];
	$P24_11_5=$_POST['txtP24_11_5'];
	$P24_11_6=$_POST['txtP24_11_6'];
	$P24_11_7=$_POST['txtP24_11_7'];
	$P24_11_8=$_POST['txtP24_11_8'];
	$P24_11_9=$_POST['txtP24_11_9'];
	$P24_11_10=$_POST['txtP24_11_10'];
	$P24_11_11=$_POST['txtP24_11_11'];
	$P24_11_12=$_POST['txtP24_11_12'];
	$P24_11_13=$_POST['txtP24_11_13'];
	$P24_11_14=$_POST['txtP24_11_14'];	
	$P24_12_1=$_POST['txtP24_12_1'];
	$P24_12_2=$_POST['txtP24_12_2'];
	$P24_12_3=$_POST['txtP24_12_3'];
	$P24_12_4=$_POST['txtP24_12_4'];
	$P24_12_5=$_POST['txtP24_12_5'];
	$P24_12_6=$_POST['txtP24_12_6'];
	$P24_12_7=$_POST['txtP24_12_7'];
	$P24_12_8=$_POST['txtP24_12_8'];
	$P24_12_9=$_POST['txtP24_12_9'];
	$P24_12_10=$_POST['txtP24_12_10'];
	$P24_12_11=$_POST['txtP24_12_11'];
	$P24_12_12=$_POST['txtP24_12_12'];
	$P24_12_13=$_POST['txtP24_12_13'];
	$P24_12_14=$_POST['txtP24_12_14'];	
	$P24_13_1=$_POST['txtP24_13_1'];
	$P24_13_2=$_POST['txtP24_13_2'];
	$P24_13_3=$_POST['txtP24_13_3'];
	$P24_13_4=$_POST['txtP24_13_4'];
	$P24_13_5=$_POST['txtP24_13_5'];
	$P24_13_6=$_POST['txtP24_13_6'];
	$P24_13_7=$_POST['txtP24_13_7'];
	$P24_13_8=$_POST['txtP24_13_8'];
	$P24_13_9=$_POST['txtP24_13_9'];
	$P24_13_10=$_POST['txtP24_13_10'];
	$P24_13_11=$_POST['txtP24_13_11'];
	$P24_13_12=$_POST['txtP24_13_12'];
	$P24_13_13=$_POST['txtP24_13_13'];
	$P24_13_14=$_POST['txtP24_13_14'];	
	$P24_14_1=$_POST['txtP24_14_1'];
	$P24_14_2=$_POST['txtP24_14_2'];
	$P24_14_3=$_POST['txtP24_14_3'];
	$P24_14_4=$_POST['txtP24_14_4'];
	$P24_14_5=$_POST['txtP24_14_5'];
	$P24_14_6=$_POST['txtP24_14_6'];
	$P24_14_7=$_POST['txtP24_14_7'];
	$P24_14_8=$_POST['txtP24_14_8'];
	$P24_14_9=$_POST['txtP24_14_9'];
	$P24_14_10=$_POST['txtP24_14_10'];
	$P24_14_11=$_POST['txtP24_14_11'];
	$P24_14_12=$_POST['txtP24_14_12'];
	$P24_14_13=$_POST['txtP24_14_13'];
	$P24_14_14=$_POST['txtP24_14_14'];	
	$P24_15_1=$_POST['txtP24_15_1'];
	$P24_15_2=$_POST['txtP24_15_2'];
	$P24_15_3=$_POST['txtP24_15_3'];
	$P24_15_4=$_POST['txtP24_15_4'];
	$P24_15_5=$_POST['txtP24_15_5'];
	$P24_15_6=$_POST['txtP24_15_6'];
	$P24_15_7=$_POST['txtP24_15_7'];
	$P24_15_8=$_POST['txtP24_15_8'];
	$P24_15_9=$_POST['txtP24_15_9'];
	$P24_15_10=$_POST['txtP24_15_10'];
	$P24_15_11=$_POST['txtP24_15_11'];
	$P24_15_12=$_POST['txtP24_15_12'];
	$P24_15_13=$_POST['txtP24_15_13'];
	$P24_15_14=$_POST['txtP24_15_14'];	
	$P24_16_1=$_POST['txtP24_16_1'];
	$P24_16_2=$_POST['txtP24_16_2'];
	$P24_16_3=$_POST['txtP24_16_3'];
	$P24_16_4=$_POST['txtP24_16_4'];
	$P24_16_5=$_POST['txtP24_16_5'];
	$P24_16_6=$_POST['txtP24_16_6'];
	$P24_16_7=$_POST['txtP24_16_7'];
	$P24_16_8=$_POST['txtP24_16_8'];
	$P24_16_9=$_POST['txtP24_16_9'];
	$P24_16_10=$_POST['txtP24_16_10'];
	$P24_16_11=$_POST['txtP24_16_11'];
	$P24_16_12=$_POST['txtP24_16_12'];
	$P24_16_13=$_POST['txtP24_16_13'];
	$P24_16_14=$_POST['txtP24_16_14'];	
	$P24_17_1=$_POST['txtP24_17_1'];
	$P24_17_2=$_POST['txtP24_17_2'];
	$P24_17_3=$_POST['txtP24_17_3'];
	$P24_17_4=$_POST['txtP24_17_4'];
	$P24_17_5=$_POST['txtP24_17_5'];
	$P24_17_6=$_POST['txtP24_17_6'];
	$P24_17_7=$_POST['txtP24_17_7'];
	$P24_17_8=$_POST['txtP24_17_8'];
	$P24_17_9=$_POST['txtP24_17_9'];
	$P24_17_10=$_POST['txtP24_17_10'];
	$P24_17_11=$_POST['txtP24_17_11'];
	$P24_17_12=$_POST['txtP24_17_12'];
	$P24_17_13=$_POST['txtP24_17_13'];
	$P24_17_14=$_POST['txtP24_17_14'];	
	$P24_18_1=$_POST['txtP24_18_1'];
	$P24_18_2=$_POST['txtP24_18_2'];
	$P24_18_3=$_POST['txtP24_18_3'];
	$P24_18_4=$_POST['txtP24_18_4'];
	$P24_18_5=$_POST['txtP24_18_5'];
	$P24_18_6=$_POST['txtP24_18_6'];
	$P24_18_7=$_POST['txtP24_18_7'];
	$P24_18_8=$_POST['txtP24_18_8'];
	$P24_18_9=$_POST['txtP24_18_9'];
	$P24_18_10=$_POST['txtP24_18_10'];
	$P24_18_11=$_POST['txtP24_18_11'];
	$P24_18_12=$_POST['txtP24_18_12'];
	$P24_18_13=$_POST['txtP24_18_13'];
	$P24_18_14=$_POST['txtP24_18_14'];	
	$P24_19_1=$_POST['txtP24_19_1'];
	$P24_19_2=$_POST['txtP24_19_2'];
	$P24_19_3=$_POST['txtP24_19_3'];
	$P24_19_4=$_POST['txtP24_19_4'];
	$P24_19_5=$_POST['txtP24_19_5'];
	$P24_19_6=$_POST['txtP24_19_6'];
	$P24_19_7=$_POST['txtP24_19_7'];
	$P24_19_8=$_POST['txtP24_19_8'];
	$P24_19_9=$_POST['txtP24_19_9'];
	$P24_19_10=$_POST['txtP24_19_10'];
	$P24_19_11=$_POST['txtP24_19_11'];
	$P24_19_12=$_POST['txtP24_19_12'];
	$P24_19_13=$_POST['txtP24_19_13'];
	$P24_19_14=$_POST['txtP24_19_14'];	
	$P24_20_1=$_POST['txtP24_20_1'];
	$P24_20_2=$_POST['txtP24_20_2'];
	$P24_20_3=$_POST['txtP24_20_3'];
	$P24_20_4=$_POST['txtP24_20_4'];
	$P24_20_5=$_POST['txtP24_20_5'];
	$P24_20_6=$_POST['txtP24_20_6'];
	$P24_20_7=$_POST['txtP24_20_7'];
	$P24_20_8=$_POST['txtP24_20_8'];
	$P24_20_9=$_POST['txtP24_20_9'];
	$P24_20_10=$_POST['txtP24_20_10'];
	$P24_20_11=$_POST['txtP24_20_11'];
	$P24_20_12=$_POST['txtP24_20_12'];
	$P24_20_13=$_POST['txtP24_20_13'];
	$P24_20_14=$_POST['txtP24_20_14'];	
	$P24_21_1=$_POST['txtP24_21_1'];
	$P24_21_2=$_POST['txtP24_21_2'];
	$P24_21_3=$_POST['txtP24_21_3'];
	$P24_21_4=$_POST['txtP24_21_4'];
	$P24_21_5=$_POST['txtP24_21_5'];
	$P24_21_6=$_POST['txtP24_21_6'];
	$P24_21_7=$_POST['txtP24_21_7'];
	$P24_21_8=$_POST['txtP24_21_8'];
	$P24_21_9=$_POST['txtP24_21_9'];
	$P24_21_10=$_POST['txtP24_21_10'];
	$P24_21_11=$_POST['txtP24_21_11'];
	$P24_21_12=$_POST['txtP24_21_12'];
	$P24_21_13=$_POST['txtP24_21_13'];
	$P24_21_14=$_POST['txtP24_21_14'];	
	$P24_22_1=$_POST['txtP24_22_1'];
	$P24_22_2=$_POST['txtP24_22_2'];
	$P24_22_3=$_POST['txtP24_22_3'];
	$P24_22_4=$_POST['txtP24_22_4'];
	$P24_22_5=$_POST['txtP24_22_5'];
	$P24_22_6=$_POST['txtP24_22_6'];
	$P24_22_7=$_POST['txtP24_22_7'];
	$P24_22_8=$_POST['txtP24_22_8'];
	$P24_22_9=$_POST['txtP24_22_9'];
	$P24_22_10=$_POST['txtP24_22_10'];
	$P24_22_11=$_POST['txtP24_22_11'];
	$P24_22_12=$_POST['txtP24_22_12'];
	$P24_22_13=$_POST['txtP24_22_13'];
	$P24_22_14=$_POST['txtP24_22_14'];	
	$P24_23_1=$_POST['txtP24_23_1'];
	$P24_23_2=$_POST['txtP24_23_2'];
	$P24_23_3=$_POST['txtP24_23_3'];
	$P24_23_4=$_POST['txtP24_23_4'];
	$P24_23_5=$_POST['txtP24_23_5'];
	$P24_23_6=$_POST['txtP24_23_6'];
	$P24_23_7=$_POST['txtP24_23_7'];
	$P24_23_8=$_POST['txtP24_23_8'];
	$P24_23_9=$_POST['txtP24_23_9'];
	$P24_23_10=$_POST['txtP24_23_10'];
	$P24_23_11=$_POST['txtP24_23_11'];
	$P24_23_12=$_POST['txtP24_23_12'];
	$P24_23_13=$_POST['txtP24_23_13'];
	$P24_23_14=$_POST['txtP24_23_14'];	
	$P24_24_1=$_POST['txtP24_24_1'];
	$P24_24_2=$_POST['txtP24_24_2'];
	$P24_24_3=$_POST['txtP24_24_3'];
	$P24_24_4=$_POST['txtP24_24_4'];
	$P24_24_5=$_POST['txtP24_24_5'];
	$P24_24_6=$_POST['txtP24_24_6'];
	$P24_24_7=$_POST['txtP24_24_7'];
	$P24_24_8=$_POST['txtP24_24_8'];
	$P24_24_9=$_POST['txtP24_24_9'];
	$P24_24_10=$_POST['txtP24_24_10'];
	$P24_24_11=$_POST['txtP24_24_11'];
	$P24_24_12=$_POST['txtP24_24_12'];
	$P24_24_13=$_POST['txtP24_24_13'];
	$P24_24_14=$_POST['txtP24_24_14'];	
	$P24_25_1=$_POST['txtP24_25_1'];
	$P24_25_2=$_POST['txtP24_25_2'];
	$P24_25_3=$_POST['txtP24_25_3'];
	$P24_25_4=$_POST['txtP24_25_4'];
	$P24_25_5=$_POST['txtP24_25_5'];
	$P24_25_6=$_POST['txtP24_25_6'];
	$P24_25_7=$_POST['txtP24_25_7'];
	$P24_25_8=$_POST['txtP24_25_8'];
	$P24_25_9=$_POST['txtP24_25_9'];
	$P24_25_10=$_POST['txtP24_25_10'];
	$P24_25_11=$_POST['txtP24_25_11'];
	$P24_25_12=$_POST['txtP24_25_12'];
	$P24_25_13=$_POST['txtP24_25_13'];
	$P24_25_14=$_POST['txtP24_25_14'];	
	$P24_26_1=$_POST['txtP24_26_1'];
	$P24_26_2=$_POST['txtP24_26_2'];
	$P24_26_3=$_POST['txtP24_26_3'];
	$P24_26_4=$_POST['txtP24_26_4'];
	$P24_26_5=$_POST['txtP24_26_5'];
	$P24_26_6=$_POST['txtP24_26_6'];
	$P24_26_7=$_POST['txtP24_26_7'];
	$P24_26_8=$_POST['txtP24_26_8'];
	$P24_26_9=$_POST['txtP24_26_9'];
	$P24_26_10=$_POST['txtP24_26_10'];
	$P24_26_11=$_POST['txtP24_26_11'];
	$P24_26_12=$_POST['txtP24_26_12'];
	$P24_26_13=$_POST['txtP24_26_13'];
	$P24_26_14=$_POST['txtP24_26_14'];	
	$P24_27_1=$_POST['txtP24_27_1'];
	$P24_27_2=$_POST['txtP24_27_2'];
	$P24_27_3=$_POST['txtP24_27_3'];
	$P24_27_4=$_POST['txtP24_27_4'];
	$P24_27_5=$_POST['txtP24_27_5'];
	$P24_27_6=$_POST['txtP24_27_6'];
	$P24_27_7=$_POST['txtP24_27_7'];
	$P24_27_8=$_POST['txtP24_27_8'];
	$P24_27_9=$_POST['txtP24_27_9'];
	$P24_27_10=$_POST['txtP24_27_10'];
	$P24_27_11=$_POST['txtP24_27_11'];
	$P24_27_12=$_POST['txtP24_27_12'];
	$P24_27_13=$_POST['txtP24_27_13'];
	$P24_27_14=$_POST['txtP24_27_14'];	
	$P24_28_1=$_POST['txtP24_28_1'];
	$P24_28_2=$_POST['txtP24_28_2'];
	$P24_28_3=$_POST['txtP24_28_3'];
	$P24_28_4=$_POST['txtP24_28_4'];
	$P24_28_5=$_POST['txtP24_28_5'];
	$P24_28_6=$_POST['txtP24_28_6'];
	$P24_28_7=$_POST['txtP24_28_7'];
	$P24_28_8=$_POST['txtP24_28_8'];
	$P24_28_9=$_POST['txtP24_28_9'];
	$P24_28_10=$_POST['txtP24_28_10'];
	$P24_28_11=$_POST['txtP24_28_11'];
	$P24_28_12=$_POST['txtP24_28_12'];
	$P24_28_13=$_POST['txtP24_28_13'];
	$P24_28_14=$_POST['txtP24_28_14'];	
    $P24_29_1=$_POST['txtP24_29_1'];
	$P24_29_2=$_POST['txtP24_29_2'];
	$P24_29_3=$_POST['txtP24_29_3'];
	$P24_29_4=$_POST['txtP24_29_4'];
	$P24_29_5=$_POST['txtP24_29_5'];
	$P24_29_6=$_POST['txtP24_29_6'];
	$P24_29_7=$_POST['txtP24_29_7'];
	$P24_29_8=$_POST['txtP24_29_8'];
	$P24_29_9=$_POST['txtP24_29_9'];
	$P24_29_10=$_POST['txtP24_29_10'];
	$P24_29_11=$_POST['txtP24_29_11'];
	$P24_29_12=$_POST['txtP24_29_12'];
	$P24_29_13=$_POST['txtP24_29_13'];
	$P24_29_14=$_POST['txtP24_29_14'];	
	$P24_30_1=$_POST['txtP24_30_1'];
	$P24_30_2=$_POST['txtP24_30_2'];
	$P24_30_3=$_POST['txtP24_30_3'];
	$P24_30_4=$_POST['txtP24_30_4'];
	$P24_30_5=$_POST['txtP24_30_5'];
	$P24_30_6=$_POST['txtP24_30_6'];
	$P24_30_7=$_POST['txtP24_30_7'];
	$P24_30_8=$_POST['txtP24_30_8'];
	$P24_30_9=$_POST['txtP24_30_9'];
	$P24_30_10=$_POST['txtP24_30_10'];
	$P24_30_11=$_POST['txtP24_30_11'];
	$P24_30_12=$_POST['txtP24_30_12'];
	$P24_30_13=$_POST['txtP24_30_13'];
	$P24_30_14=$_POST['txtP24_30_14'];	
	$P24_31_1=$_POST['txtP24_31_1'];
	$P24_31_2=$_POST['txtP24_31_2'];
	$P24_31_3=$_POST['txtP24_31_3'];
	$P24_31_4=$_POST['txtP24_31_4'];
	$P24_31_5=$_POST['txtP24_31_5'];
	$P24_31_6=$_POST['txtP24_31_6'];
	$P24_31_7=$_POST['txtP24_31_7'];
	$P24_31_8=$_POST['txtP24_31_8'];
	$P24_31_9=$_POST['txtP24_31_9'];
	$P24_31_10=$_POST['txtP24_31_10'];
	$P24_31_11=$_POST['txtP24_31_11'];
	$P24_31_12=$_POST['txtP24_31_12'];
	$P24_31_13=$_POST['txtP24_31_13'];
	$P24_31_14=$_POST['txtP24_31_14'];	
	$P24_32_1=$_POST['txtP24_32_1'];
	$P24_32_2=$_POST['txtP24_32_2'];
	$P24_32_3=$_POST['txtP24_32_3'];
	$P24_32_4=$_POST['txtP24_32_4'];
	$P24_32_5=$_POST['txtP24_32_5'];
	$P24_32_6=$_POST['txtP24_32_6'];
	$P24_32_7=$_POST['txtP24_32_7'];
	$P24_32_8=$_POST['txtP24_32_8'];
	$P24_32_9=$_POST['txtP24_32_9'];
	$P24_32_10=$_POST['txtP24_32_10'];
	$P24_32_11=$_POST['txtP24_32_11'];
	$P24_32_12=$_POST['txtP24_32_12'];
	$P24_32_13=$_POST['txtP24_32_13'];
	$P24_32_14=$_POST['txtP24_32_14'];	
	$P24_33_1=$_POST['txtP24_33_1'];
	$P24_33_2=$_POST['txtP24_33_2'];
	$P24_33_3=$_POST['txtP24_33_3'];
	$P24_33_4=$_POST['txtP24_33_4'];
	$P24_33_5=$_POST['txtP24_33_5'];
	$P24_33_6=$_POST['txtP24_33_6'];
	$P24_33_7=$_POST['txtP24_33_7'];
	$P24_33_8=$_POST['txtP24_33_8'];
	$P24_33_9=$_POST['txtP24_33_9'];
	$P24_33_10=$_POST['txtP24_33_10'];
	$P24_33_11=$_POST['txtP24_33_11'];
	$P24_33_12=$_POST['txtP24_33_12'];
	$P24_33_13=$_POST['txtP24_33_13'];
	$P24_33_14=$_POST['txtP24_33_14'];
	$P24_34_1=$_POST['txtP24_34_1'];
	$P24_34_2=$_POST['txtP24_34_2'];
	$P24_34_3=$_POST['txtP24_34_3'];
	$P24_34_4=$_POST['txtP24_34_4'];
	$P24_34_5=$_POST['txtP24_34_5'];
	$P24_34_6=$_POST['txtP24_34_6'];
	$P24_34_7=$_POST['txtP24_34_7'];
	$P24_34_8=$_POST['txtP24_34_8'];
	$P24_34_9=$_POST['txtP24_34_9'];
	$P24_34_10=$_POST['txtP24_34_10'];
	$P24_34_11=$_POST['txtP24_34_11'];
	$P24_34_12=$_POST['txtP24_34_12'];
	$P24_34_13=$_POST['txtP24_34_13'];
	$P24_34_14=$_POST['txtP24_34_14'];		
	$P25_1=$_POST['txtP25_1'];
    $P25_1_1=$_POST['txtP25_1_1'];
    $P25_1_2=$_POST['txtP25_1_2'];
    $P25_1_3=$_POST['txtP25_1_3'];
    $P25_2_1=$_POST['txtP25_2_1'];
    $P25_2_2=$_POST['txtP25_2_2'];
    $P25_2_3=$_POST['txtP25_2_3'];
    $P25_3_1=$_POST['txtP25_3_1'];
    $P25_3_2=$_POST['txtP25_3_2'];
    $P25_3_3=$_POST['txtP25_3_3'];
    $P25_4_1=$_POST['txtP25_4_1'];
    $P25_4_2=$_POST['txtP25_4_2'];
    $P25_4_3=$_POST['txtP25_4_3'];
    $P25_5_1=$_POST['txtP25_5_1'];
    $P25_5_2=$_POST['txtP25_5_2'];
    $P25_5_3=$_POST['txtP25_5_3'];    
	$P26_1=$_POST['txtP26_1'];
    $P26_1_1=$_POST['txtP26_1_1'];
    $P26_1_2=$_POST['txtP26_1_2'];
    $P26_1_3=$_POST['txtP26_1_3'];
    $P26_2_1=$_POST['txtP26_2_1'];
    $P26_2_2=$_POST['txtP26_2_2'];
    $P26_2_3=$_POST['txtP26_2_3'];
    $P26_3_1=$_POST['txtP26_3_1'];
    $P26_3_2=$_POST['txtP26_3_2'];
    $P26_3_3=$_POST['txtP26_3_3'];
    $P26_4_1=$_POST['txtP26_4_1'];
    $P26_4_2=$_POST['txtP26_4_2'];
    $P26_4_3=$_POST['txtP26_4_3'];
    $P26_5_1=$_POST['txtP26_5_1'];
    $P26_5_2=$_POST['txtP26_5_2'];
    $P26_5_3=$_POST['txtP26_5_3'];    
	$P27_1=$_POST['txtP27_1'];
    $P27_1_1=$_POST['txtP27_1_1'];
    $P27_1_2=$_POST['txtP27_1_2'];
    $P27_1_3=$_POST['txtP27_1_3'];
    $P27_2_1=$_POST['txtP27_2_1'];
    $P27_2_2=$_POST['txtP27_2_2'];
    $P27_2_3=$_POST['txtP27_2_3'];
    $P27_3_1=$_POST['txtP27_3_1'];
    $P27_3_2=$_POST['txtP27_3_2'];
    $P27_3_3=$_POST['txtP27_3_3'];
    $P27_4_1=$_POST['txtP27_4_1'];
    $P27_4_2=$_POST['txtP27_4_2'];
    $P27_4_3=$_POST['txtP27_4_3'];
    $P27_5_1=$_POST['txtP27_5_1'];
    $P27_5_2=$_POST['txtP27_5_2'];
    $P27_5_3=$_POST['txtP27_5_3'];	    
    $P28_1=$_POST['txtP28_1'];
	$P28_1_1=$_POST['txtP28_1_1'];
	$P28_1_2=$_POST['txtP28_1_2'];
    $P28_2_1=$_POST['txtP28_2_1'];
	$P28_2_2=$_POST['txtP28_2_2'];
	$P28_3_1=$_POST['txtP28_3_1'];
	$P28_3_2=$_POST['txtP28_3_2'];
	$P28_4_1=$_POST['txtP28_4_1'];
	$P28_4_2=$_POST['txtP28_4_2'];
	$P28_5_1=$_POST['txtP28_5_1'];
	$P28_5_2=$_POST['txtP28_5_2'];	
	$P29_1=$_POST['txtP29_1'];
	$P29_1_1=$_POST['txtP29_1_1'];
	$P29_1_2=$_POST['txtP29_1_2'];
    $P29_2_1=$_POST['txtP29_2_1'];
	$P29_2_2=$_POST['txtP29_2_2'];
	$P29_3_1=$_POST['txtP29_3_1'];
	$P29_3_2=$_POST['txtP29_3_2'];
	$P29_4_1=$_POST['txtP29_4_1'];
	$P29_4_2=$_POST['txtP29_4_2'];
	$P29_5_1=$_POST['txtP29_5_1'];
	$P29_5_2=$_POST['txtP29_5_2'];		
    $P30_1=$_POST['txtP30_1'];
    $P30_2=$_POST['txtP30_2'];
    $P30_3=$_POST['txtP30_3'];
	$P30_4=$_POST['txtP30_4'];
    $P30_5=$_POST['txtP30_5'];
    $P30_6=$_POST['txtP30_6'];
    $P31_1=$_POST['txtP31_1'];
	$P31_2=$_POST['txtP31_2'];
	$P31_3=$_POST['txtP31_3'];	
    $P32=$_POST['txtP32'];
    $P33=$_POST['txtP33'];
    $P34=$_POST['txtP34'];
	$P35=$_POST['txtP35'];
    $P36=$_POST['txtP36'];	
	$P37_1=$_POST['txtP37_1'];
	$P37_1_1=$_POST['txtP37_1_1'];
	$P37_1_2=$_POST['txtP37_1_2'];
    $P37_2_1=$_POST['txtP37_2_1'];
	$P37_2_2=$_POST['txtP37_2_2'];
	$P37_3_1=$_POST['txtP37_3_1'];
	$P37_3_2=$_POST['txtP37_3_2'];
	$P37_4_1=$_POST['txtP37_4_1'];
	$P37_4_2=$_POST['txtP37_4_2'];
	$P37_5_1=$_POST['txtP37_5_1'];
	$P37_5_2=$_POST['txtP37_5_2'];	
	$P38_1_1=$_POST['txtP38_1_1'];
    $P38_1_2=$_POST['txtP38_1_2'];
    $P38_1_3=$_POST['txtP38_1_3'];
    $P38_2_1=$_POST['txtP38_2_1'];
    $P38_2_2=$_POST['txtP38_2_2'];
    $P38_2_3=$_POST['txtP38_2_3'];
    $P38_3_1=$_POST['txtP38_3_1'];
    $P38_3_2=$_POST['txtP38_3_2'];
    $P38_3_3=$_POST['txtP38_3_3'];
    $P38_4_1=$_POST['txtP38_4_1'];
    $P38_4_2=$_POST['txtP38_4_2'];
    $P38_4_3=$_POST['txtP38_4_3'];	
    $P39_1_1=$_POST['txtP39_1_1'];
    $P39_1_2=$_POST['txtP39_1_2'];
    $P39_1_3=$_POST['txtP39_1_3'];
    $P39_2_1=$_POST['txtP39_2_1'];
    $P39_2_2=$_POST['txtP39_2_2'];
    $P39_2_3=$_POST['txtP39_2_3'];
    $P39_3_1=$_POST['txtP39_3_1'];
    $P39_3_2=$_POST['txtP39_3_2'];
    $P39_3_3=$_POST['txtP39_3_3'];
    $P39_4_1=$_POST['txtP39_4_1'];
    $P39_4_2=$_POST['txtP39_4_2'];
    $P39_4_3=$_POST['txtP39_4_3'];
	$P39_5_1=$_POST['txtP39_5_1'];
    $P39_5_2=$_POST['txtP39_5_2'];
    $P39_5_3=$_POST['txtP39_5_3'];
    $P39_6_1=$_POST['txtP39_6_1'];
    $P39_6_2=$_POST['txtP39_6_2'];
    $P39_6_3=$_POST['txtP39_6_3'];
    $P39_7_1=$_POST['txtP39_7_1'];
    $P39_7_2=$_POST['txtP39_7_2'];
    $P39_7_3=$_POST['txtP39_7_3'];
    $P39_8_1=$_POST['txtP39_8_1'];
    $P39_8_2=$_POST['txtP39_8_2'];
    $P39_8_3=$_POST['txtP39_8_3'];
	$P39_9_1=$_POST['txtP39_9_1'];
    $P39_9_2=$_POST['txtP39_9_2'];
    $P39_9_3=$_POST['txtP39_9_3'];
    $P39_10_1=$_POST['txtP39_10_1'];
    $P39_10_2=$_POST['txtP39_10_2'];
    $P39_10_3=$_POST['txtP39_10_3'];
    $P39_11_1=$_POST['txtP39_11_1'];
    $P39_11_2=$_POST['txtP39_11_2'];
    $P39_11_3=$_POST['txtP39_11_3'];
    $P39_12_1=$_POST['txtP39_12_1'];
    $P39_12_2=$_POST['txtP39_12_2'];
    $P39_12_3=$_POST['txtP39_12_3'];
	$P39_13_1=$_POST['txtP39_13_1'];
    $P39_13_2=$_POST['txtP39_13_2'];
    $P39_13_3=$_POST['txtP39_13_3'];
    $P39_14_1=$_POST['txtP39_14_1'];
    $P39_14_2=$_POST['txtP39_14_2'];
    $P39_14_3=$_POST['txtP39_14_3'];
    $P39_15_1=$_POST['txtP39_15_1'];
    $P39_15_2=$_POST['txtP39_15_2'];
    $P39_15_3=$_POST['txtP39_15_3'];
	$P39_16_1=$_POST['txtP39_16_1'];
    $P39_16_2=$_POST['txtP39_16_2'];
    $P39_16_3=$_POST['txtP39_16_3'];
    $P39_17_1=$_POST['txtP39_17_1'];
    $P39_17_2=$_POST['txtP39_17_2'];
    $P39_17_3=$_POST['txtP39_17_3'];
    $P39_18_1=$_POST['txtP39_18_1'];
    $P39_18_2=$_POST['txtP39_18_2'];
    $P39_18_3=$_POST['txtP39_18_3'];	
    $P40=$_POST['txtP40'];	
	$P41_1_1=$_POST['txtP41_1_1'];
    $P41_1_2=$_POST['txtP41_1_2'];
    $P41_1_3=$_POST['txtP41_1_3'];
    $P41_2_1=$_POST['txtP41_2_1'];
    $P41_2_2=$_POST['txtP41_2_2'];
    $P41_2_3=$_POST['txtP41_2_3'];
    $P41_3_1=$_POST['txtP41_3_1'];
    $P41_3_2=$_POST['txtP41_3_2'];
    $P41_3_3=$_POST['txtP41_3_3'];
    $P41_4_1=$_POST['txtP41_4_1'];
    $P41_4_2=$_POST['txtP41_4_2'];
    $P41_4_3=$_POST['txtP41_4_3'];
	$P41_5_1=$_POST['txtP41_5_1'];
    $P41_5_2=$_POST['txtP41_5_2'];
    $P41_5_3=$_POST['txtP41_5_3'];
    $P41_6_1=$_POST['txtP41_6_1'];
    $P41_6_2=$_POST['txtP41_6_2'];
    $P41_6_3=$_POST['txtP41_6_3'];
    $P41_7_1=$_POST['txtP41_7_1'];
    $P41_7_2=$_POST['txtP41_7_2'];
    $P41_7_3=$_POST['txtP41_7_3'];
    $P41_8_1=$_POST['txtP41_8_1'];
    $P41_8_2=$_POST['txtP41_8_2'];
    $P41_8_3=$_POST['txtP41_8_3'];
	$P41_9_1=$_POST['txtP41_9_1'];
    $P41_9_2=$_POST['txtP41_9_2'];
    $P41_9_3=$_POST['txtP41_9_3'];
    $P41_10_1=$_POST['txtP41_10_1'];
    $P41_10_2=$_POST['txtP41_10_2'];
    $P41_10_3=$_POST['txtP41_10_3'];
    $P41_11_1=$_POST['txtP41_11_1'];
    $P41_11_2=$_POST['txtP41_11_2'];
    $P41_11_3=$_POST['txtP41_11_3'];
    $P41_12_1=$_POST['txtP41_12_1'];
    $P41_12_2=$_POST['txtP41_12_2'];
    $P41_12_3=$_POST['txtP41_12_3'];	   
    $P42=$_POST['txtP42'];
	$P43=$_POST['txtP43'];
	$P44=$_POST['txtP44'];
    $P45_1=$_POST['txtP45_1'];
	$P45_2=$_POST['txtP45_2'];
	$P45_3=$_POST['txtP45_3'];
    $P46=$_POST['txtP46'];
	$P47_1=$_POST['txtP47_1'];
	$P47_2=$_POST['txtP47_2'];
	$P47_3=$_POST['txtP47_3'];
	$P48=$_POST['txtP48'];
	$P49_1=$_POST['txtP49_1'];
	$P49_2=$_POST['txtP49_2'];
	$P49_3=$_POST['txtP49_3'];
	$P50=$_POST['txtP50'];
	$P51_1_1=$_POST['txtP51_1_1'];
    $P51_1_2=$_POST['txtP51_1_2'];
    $P51_1_3=$_POST['txtP51_1_3'];
    $P51_2_1=$_POST['txtP51_2_1'];
    $P51_2_2=$_POST['txtP51_2_2'];
    $P51_2_3=$_POST['txtP51_2_3'];
    $P51_3_1=$_POST['txtP51_3_1'];
    $P51_3_2=$_POST['txtP51_3_2'];
    $P51_3_3=$_POST['txtP51_3_3'];
    $P51_4_1=$_POST['txtP51_4_1'];
    $P51_4_2=$_POST['txtP51_4_2'];
    $P51_4_3=$_POST['txtP51_4_3'];
	$P52_1=$_POST['txtP52_1'];
	$P52_2=$_POST['txtP52_2'];
	$P52_3=$_POST['txtP52_3'];
	$P53_1=$_POST['txtP53_1'];
	$P53_2=$_POST['txtP53_2'];
	$P53_3=$_POST['txtP53_3'];
	$P54=$_POST['txtP54'];		  
    $P55_1_1=$_POST['txtP55_1_1'];
    $P55_1_2=$_POST['txtP55_1_2'];
    $P55_1_3=$_POST['txtP55_1_3'];
    $P55_1_4=$_POST['txtP55_1_4'];
    $P55_1_5=$_POST['txtP55_1_5'];
	$P55_2_1=$_POST['txtP55_2_1'];
    $P55_2_2=$_POST['txtP55_2_2'];
    $P55_2_3=$_POST['txtP55_2_3'];
    $P55_2_4=$_POST['txtP55_2_4'];
    $P55_2_5=$_POST['txtP55_2_5'];
	$P55_3_1=$_POST['txtP55_3_1'];
    $P55_3_2=$_POST['txtP55_3_2'];
    $P55_3_3=$_POST['txtP55_3_3'];
    $P55_3_4=$_POST['txtP55_3_4'];
    $P55_3_5=$_POST['txtP55_3_5'];
    $P56=$_POST['txtP56'];    
	$P57_1_1=$_POST['txtP57_1_1'];
    $P57_1_2=$_POST['txtP57_1_2'];
    $P57_1_3=$_POST['txtP57_1_3'];
    $P57_2_1=$_POST['txtP57_2_1'];
    $P57_2_2=$_POST['txtP57_2_2'];
    $P57_2_3=$_POST['txtP57_2_3'];
    $P57_3_1=$_POST['txtP57_3_1'];
    $P57_3_2=$_POST['txtP57_3_2'];
    $P57_3_3=$_POST['txtP57_3_3'];
    $P57_4_1=$_POST['txtP57_4_1'];
    $P57_4_2=$_POST['txtP57_4_2'];
    $P57_4_3=$_POST['txtP57_4_3'];	
	$P58_1=$_POST['txtP58_1'];
	$P58_2=$_POST['txtP58_2'];
	$P58_3=$_POST['txtP58_3'];
	$P59=$_POST['txtP59'];	
	$P60_1_1=$_POST['txtP60_1_1'];
    $P60_1_2=$_POST['txtP60_1_2'];
    $P60_1_3=$_POST['txtP60_1_3'];
    $P60_2_1=$_POST['txtP60_2_1'];
    $P60_2_2=$_POST['txtP60_2_2'];
    $P60_2_3=$_POST['txtP60_2_3'];
    $P60_3_1=$_POST['txtP60_3_1'];
    $P60_3_2=$_POST['txtP60_3_2'];
    $P60_3_3=$_POST['txtP60_3_3'];
    $P60_4_1=$_POST['txtP60_4_1'];
    $P60_4_2=$_POST['txtP60_4_2'];
    $P60_4_3=$_POST['txtP60_4_3'];
	$P61_1=$_POST['txtP61_1'];
	$P61_2=$_POST['txtP61_2'];
	$P61_3=$_POST['txtP61_3'];
	$P62=$_POST['txtP62'];		
	$P63_1_1=$_POST['txtP63_1_1'];
    $P63_1_2=$_POST['txtP63_1_2'];
    $P63_1_3=$_POST['txtP63_1_3'];
    $P63_1_4=$_POST['txtP63_1_4'];    
	$P63_2_1=$_POST['txtP63_2_1'];
    $P63_2_2=$_POST['txtP63_2_2'];
    $P63_2_3=$_POST['txtP63_2_3'];
    $P63_2_4=$_POST['txtP63_2_4'];    
	$P63_3_1=$_POST['txtP63_3_1'];
    $P63_3_2=$_POST['txtP63_3_2'];
    $P63_3_3=$_POST['txtP63_3_3'];
    $P63_3_4=$_POST['txtP63_3_4'];    
	$P63_4_1=$_POST['txtP63_4_1'];
    $P63_4_2=$_POST['txtP63_4_2'];
    $P63_4_3=$_POST['txtP63_4_3'];
    $P63_4_4=$_POST['txtP63_4_4'];    
	$P63_5_1=$_POST['txtP63_5_1'];
    $P63_5_2=$_POST['txtP63_5_2'];
    $P63_5_3=$_POST['txtP63_5_3'];
    $P63_5_4=$_POST['txtP63_5_4'];    
	$P63_6_1=$_POST['txtP63_6_1'];
    $P63_6_2=$_POST['txtP63_6_2'];
    $P63_6_3=$_POST['txtP63_6_3'];
    $P63_6_4=$_POST['txtP63_6_4'];
	$P63_7_1=$_POST['txtP63_7_1'];
    $P63_7_2=$_POST['txtP63_7_2'];
    $P63_7_3=$_POST['txtP63_7_3'];
    $P63_7_4=$_POST['txtP63_7_4'];    
	$P63_8_1=$_POST['txtP63_8_1'];
    $P63_8_2=$_POST['txtP63_8_2'];
    $P63_8_3=$_POST['txtP63_8_3'];
    $P63_8_4=$_POST['txtP63_8_4'];    
	$P63_9_1=$_POST['txtP63_9_1'];
    $P63_9_2=$_POST['txtP63_9_2'];
    $P63_9_3=$_POST['txtP63_9_3'];
    $P63_9_4=$_POST['txtP63_9_4'];
	$P64_1=$_POST['txtP64_1'];
	$P64_2=$_POST['txtP64_2'];
	$P64_3=$_POST['txtP64_3'];
	$P65_1=$_POST['txtP65_1'];
	$P65_2=$_POST['txtP65_2'];
	$P65_3=$_POST['txtP65_3'];
	$P66=$_POST['txtP66'];	
	$P67_1_1=$_POST['txtP67_1_1'];
    $P67_1_2=$_POST['txtP67_1_2'];
    $P67_1_3=$_POST['txtP67_1_3'];
    $P67_1_4=$_POST['txtP67_1_4'];    
	$P67_2_1=$_POST['txtP67_2_1'];
    $P67_2_2=$_POST['txtP67_2_2'];
    $P67_2_3=$_POST['txtP67_2_3'];
    $P67_2_4=$_POST['txtP67_2_4'];    
	$P67_3_1=$_POST['txtP67_3_1'];
    $P67_3_2=$_POST['txtP67_3_2'];
    $P67_3_3=$_POST['txtP67_3_3'];
    $P67_3_4=$_POST['txtP67_3_4'];    
	$P67_4_1=$_POST['txtP67_4_1'];
    $P67_4_2=$_POST['txtP67_4_2'];
    $P67_4_3=$_POST['txtP67_4_3'];
    $P67_4_4=$_POST['txtP67_4_4'];    
	$P67_5_1=$_POST['txtP67_5_1'];
    $P67_5_2=$_POST['txtP67_5_2'];
    $P67_5_3=$_POST['txtP67_5_3'];
    $P67_5_4=$_POST['txtP67_5_4'];    
	$P67_6_1=$_POST['txtP67_6_1'];
    $P67_6_2=$_POST['txtP67_6_2'];
    $P67_6_3=$_POST['txtP67_6_3'];
    $P67_6_4=$_POST['txtP67_6_4'];
	$P67_7_1=$_POST['txtP67_7_1'];
    $P67_7_2=$_POST['txtP67_7_2'];
    $P67_7_3=$_POST['txtP67_7_3'];
    $P67_7_4=$_POST['txtP67_7_4'];    
	$P67_8_1=$_POST['txtP67_8_1'];
    $P67_8_2=$_POST['txtP67_8_2'];
    $P67_8_3=$_POST['txtP67_8_3'];
    $P67_8_4=$_POST['txtP67_8_4'];    
	$P67_9_1=$_POST['txtP67_9_1'];
    $P67_9_2=$_POST['txtP67_9_2'];
    $P67_9_3=$_POST['txtP67_9_3'];
    $P67_9_4=$_POST['txtP67_9_4'];
	$P68_1=$_POST['txtP68_1'];
	$P68_2=$_POST['txtP68_2'];
	$P68_3=$_POST['txtP68_3'];
	$P69_1=$_POST['txtP69_1'];
	$P69_2=$_POST['txtP69_2'];
	$P69_3=$_POST['txtP69_3'];
	$P70_1=$_POST['txtP70_1'];
	$P70_2=$_POST['txtP70_2'];
	$P70_3=$_POST['txtP70_3'];
	$P70_4=$_POST['txtP70_4'];
	$P70_5=$_POST['txtP70_5'];
	$P71_1=$_POST['txtP71_1'];
	$P71_2=$_POST['txtP71_2'];
	$P71_3=$_POST['txtP71_3'];
	$P72=$_POST['txtP72'];	
	$P73_1=$_POST['txtP73_1'];
	$P73_2=$_POST['txtP73_2'];
	$P73_3=$_POST['txtP73_3'];
	$P73_4=$_POST['txtP73_4'];
	$P73_5=$_POST['txtP73_5'];
	$P73_6=$_POST['txtP73_6'];
	$P73_7=$_POST['txtP73_7'];
	$P73_8=$_POST['txtP73_8'];
	$P73_9=$_POST['txtP73_9'];
	$P73_10=$_POST['txtP73_10'];
	$P74_1_1=$_POST['txtP74_1_1'];
    $P74_1_2=$_POST['txtP74_1_2'];
    $P74_1_3=$_POST['txtP74_1_3'];
    $P74_2_1=$_POST['txtP74_2_1'];
    $P74_2_2=$_POST['txtP74_2_2'];
    $P74_2_3=$_POST['txtP74_2_3'];
    $P74_3_1=$_POST['txtP74_3_1'];
    $P74_3_2=$_POST['txtP74_3_2'];
    $P74_3_3=$_POST['txtP74_3_3'];
    $P74_4_1=$_POST['txtP74_4_1'];
    $P74_4_2=$_POST['txtP74_4_2'];
    $P74_4_3=$_POST['txtP74_4_3'];
	$P75=$_POST['txtP75'];	
	$P76_1=$_POST['txtP76_1'];
	$P76_2=$_POST['txtP76_2'];
	$P76_3=$_POST['txtP76_3'];
	$P76_4=$_POST['txtP76_4'];
	$P77_1=$_POST['txtP77_1'];
	$P77_2=$_POST['txtP77_2'];
	$P77_3=$_POST['txtP77_3'];
	$P78=$_POST['txtP78'];
	$P79_1=$_POST['txtP79_1'];
	$P79_2=$_POST['txtP79_2'];
	$P80=$_POST['txtP80'];	
	$P81_1=$_POST['txtP81_1'];
	$P81_2=$_POST['txtP81_2'];
	$P82_1=$_POST['txtP82_1'];
	$P82_2=$_POST['txtP82_2'];
	$P82_3=$_POST['txtP82_3'];	
	$P83_1=$_POST['txtP83_1'];
	$P83_2=$_POST['txtP83_2'];
	$P83_3=$_POST['txtP83_3'];
	$P83_4=$_POST['txtP83_4'];
	$P83_5=$_POST['txtP83_5'];
	$P83_6=$_POST['txtP83_6'];
	$P83_7=$_POST['txtP83_7'];
	$P84_1=$_POST['txtP84_1'];
	$P84_2=$_POST['txtP84_2'];
	$P85_1=$_POST['txtP85_1'];
	$P85_2=$_POST['txtP85_2'];
	$P85_3=$_POST['txtP85_3'];	
	$P86_1_1=$_POST['txtP86_1_1'];
    $P86_1_2=$_POST['txtP86_1_2'];
    $P86_1_3=$_POST['txtP86_1_3'];
    $P86_2_1=$_POST['txtP86_2_1'];
    $P86_2_2=$_POST['txtP86_2_2'];
    $P86_2_3=$_POST['txtP86_2_3'];
    $P86_3_1=$_POST['txtP86_3_1'];
    $P86_3_2=$_POST['txtP86_3_2'];
    $P86_3_3=$_POST['txtP86_3_3'];
    $P86_4_1=$_POST['txtP86_4_1'];
    $P86_4_2=$_POST['txtP86_4_2'];
    $P86_4_3=$_POST['txtP86_4_3'];
	$P86_5_1=$_POST['txtP86_5_1'];
    $P86_5_2=$_POST['txtP86_5_2'];
    $P86_5_3=$_POST['txtP86_5_3'];
    $P86_6_1=$_POST['txtP86_6_1'];
    $P86_6_2=$_POST['txtP86_6_2'];
    $P86_6_3=$_POST['txtP86_6_3'];
    $P86_7_1=$_POST['txtP86_7_1'];
    $P86_7_2=$_POST['txtP86_7_2'];
    $P86_7_3=$_POST['txtP86_7_3'];    
	$P87_1_1=$_POST['txtP87_1_1'];
    $P87_1_2=$_POST['txtP87_1_2'];
    $P87_1_3=$_POST['txtP87_1_3'];
    $P87_2_1=$_POST['txtP87_2_1'];
    $P87_2_2=$_POST['txtP87_2_2'];
    $P87_2_3=$_POST['txtP87_2_3'];
	$P88=$_POST['txtP88'];
	$P89_1=$_POST['txtP89_1'];
	$P89_2=$_POST['txtP89_2'];
	$P89_3=$_POST['txtP89_3'];
	$P90_1=$_POST['txtP90_1'];
	$P90_2=$_POST['txtP90_2'];
	$P90_3=$_POST['txtP90_3'];
	$P90_4=$_POST['txtP90_4'];
	$P90_5=$_POST['txtP90_5'];
	$P90_6=$_POST['txtP90_6'];
	$P90_7=$_POST['txtP90_7'];
	$P90_8=$_POST['txtP90_8'];
	$P90_9=$_POST['txtP90_9'];
	$P90_10=$_POST['txtP90_10'];
	$P91=$_POST['txtP91'];
	$P92_1=$_POST['txtP92_1'];
	$P92_2=$_POST['txtP92_2'];
	$P92_3=$_POST['txtP92_3'];
	$P92_4=$_POST['txtP92_4'];
	$P93_1=$_POST['txtP93_1'];
	$P93_2=$_POST['txtP93_2'];
	$P94=$_POST['txtP94'];
	$P95=$_POST['txtP95'];    
    $P96_1_1=$_POST['txtP96_1_1'];
    $P96_1_2=$_POST['txtP96_1_2'];
    $P96_1_3=$_POST['txtP96_1_3'];
    $P96_1_4=$_POST['txtP96_1_4'];    
	$P96_2_1=$_POST['txtP96_2_1'];
    $P96_2_2=$_POST['txtP96_2_2'];
    $P96_2_3=$_POST['txtP96_2_3'];
    $P96_2_4=$_POST['txtP96_2_4'];    
	$P96_3_1=$_POST['txtP96_3_1'];
    $P96_3_2=$_POST['txtP96_3_2'];
    $P96_3_3=$_POST['txtP96_3_3'];
    $P96_3_4=$_POST['txtP96_3_4'];    
	$P96_4_1=$_POST['txtP96_4_1'];
    $P96_4_2=$_POST['txtP96_4_2'];
    $P96_4_3=$_POST['txtP96_4_3'];
    $P96_4_4=$_POST['txtP96_4_4'];    
	$P96_5_1=$_POST['txtP96_5_1'];
    $P96_5_2=$_POST['txtP96_5_2'];
    $P96_5_3=$_POST['txtP96_5_3'];
    $P96_5_4=$_POST['txtP96_5_4'];   
	$P97=$_POST['txtP97'];
	$P98_1_1=$_POST['txtP98_1_1'];
    $P98_1_2=$_POST['txtP98_1_2'];
    $P98_1_3=$_POST['txtP98_1_3'];
    $P98_2_1=$_POST['txtP98_2_1'];
    $P98_2_2=$_POST['txtP98_2_2'];
    $P98_2_3=$_POST['txtP98_2_3'];
    $P98_3_1=$_POST['txtP98_3_1'];
    $P98_3_2=$_POST['txtP98_3_2'];
    $P98_3_3=$_POST['txtP98_3_3'];
    $P98_4_1=$_POST['txtP98_4_1'];
    $P98_4_2=$_POST['txtP98_4_2'];
    $P98_4_3=$_POST['txtP98_4_3'];
	$P99_1=$_POST['txtP99_1'];
	$P99_2=$_POST['txtP99_2'];
	$P100=$_POST['txtP100'];
	$P101_1_1=$_POST['txtP101_1_1'];
    $P101_1_2=$_POST['txtP101_1_2'];
    $P101_1_3=$_POST['txtP101_1_3'];
    $P101_2_1=$_POST['txtP101_2_1'];
    $P101_2_2=$_POST['txtP101_2_2'];
    $P101_2_3=$_POST['txtP101_2_3'];
    $P101_3_1=$_POST['txtP101_3_1'];
    $P101_3_2=$_POST['txtP101_3_2'];
    $P101_3_3=$_POST['txtP101_3_3'];
    $P101_4_1=$_POST['txtP101_4_1'];
    $P101_4_2=$_POST['txtP101_4_2'];
    $P101_4_3=$_POST['txtP101_4_3'];
	$P102_1=$_POST['txtP102_1'];
	$P102_2=$_POST['txtP102_2'];
	$P102_3=$_POST['txtP102_3'];
	$P103=$_POST['txtP103'];
	$P104_1=$_POST['txtP104_1'];
	$P104_2=$_POST['txtP104_2'];
	$P104_3=$_POST['txtP104_3'];
	$P104_4=$_POST['txtP104_4'];
	$P105_1=$_POST['txtP105_1'];
	$P105_2=$_POST['txtP105_2'];
	$P105_3=$_POST['txtP105_3'];
	$P106=$_POST['txtP106'];	
	$P107_1_1=$_POST['txtP107_1_1'];
    $P107_1_2=$_POST['txtP107_1_2'];
    $P107_1_3=$_POST['txtP107_1_3'];
    $P107_1_4=$_POST['txtP107_1_4'];
    $P107_1_5=$_POST['txtP107_1_5'];
    $P107_1_6=$_POST['txtP107_1_6'];    
	$P107_2_1=$_POST['txtP107_2_1'];
    $P107_2_2=$_POST['txtP107_2_2'];
    $P107_2_3=$_POST['txtP107_2_3'];
    $P107_2_4=$_POST['txtP107_2_4'];
    $P107_2_5=$_POST['txtP107_2_5'];
    $P107_2_6=$_POST['txtP107_2_6'];
	$P107_3_1=$_POST['txtP107_3_1'];
    $P107_3_2=$_POST['txtP107_3_2'];
    $P107_3_3=$_POST['txtP107_3_3'];
    $P107_3_4=$_POST['txtP107_3_4'];    
	$P107_3_5=$_POST['txtP107_3_5'];
    $P107_3_6=$_POST['txtP107_3_6'];
    $P107_4_1=$_POST['txtP107_4_1'];
    $P107_4_2=$_POST['txtP107_4_2'];    
	$P107_4_3=$_POST['txtP107_4_3'];
    $P107_4_4=$_POST['txtP107_4_4'];
    $P107_4_5=$_POST['txtP107_4_5'];
    $P107_4_6=$_POST['txtP107_4_6']; 
	$P108=$_POST['txtP108'];
	$P109=$_POST['txtP109'];
	$P110_1=$_POST['txtP110_1'];
	$P110_2=$_POST['txtP110_2'];	
	$P111_1=$_POST['txtP111_1'];
	$P111_2=$_POST['txtP111_2'];
	$P111_3=$_POST['txtP111_3'];
	$P111_4=$_POST['txtP111_4'];
	$P112_1=$_POST['txtP112_1'];
	$P112_2=$_POST['txtP112_2'];
	$P112_3=$_POST['txtP112_3'];
	$P113=$_POST['txtP113'];
	$P114_1=$_POST['txtP114_1'];
	$P114_2=$_POST['txtP114_2'];
	$P114_3=$_POST['txtP114_3'];	
	$P115_1_1=$_POST['txtP115_1_1'];
    $P115_1_2=$_POST['txtP115_1_2'];
    $P115_1_3=$_POST['txtP115_1_3'];
    $P115_2_1=$_POST['txtP115_2_1'];
    $P115_2_2=$_POST['txtP115_2_2'];
    $P115_2_3=$_POST['txtP115_2_3'];
    $P115_3_1=$_POST['txtP115_3_1'];
    $P115_3_2=$_POST['txtP115_3_2'];
    $P115_3_3=$_POST['txtP115_3_3'];
    $P115_4_1=$_POST['txtP115_4_1'];
    $P115_4_2=$_POST['txtP115_4_2'];
    $P115_4_3=$_POST['txtP115_4_3'];
	$P115_5_1=$_POST['txtP115_5_1'];
    $P115_5_2=$_POST['txtP115_5_2'];
    $P115_5_3=$_POST['txtP115_5_3'];
    $P115_6_1=$_POST['txtP115_6_1'];
    $P115_6_2=$_POST['txtP115_6_2'];
    $P115_6_3=$_POST['txtP115_6_3'];
    $P115_7_1=$_POST['txtP115_7_1'];
    $P115_7_2=$_POST['txtP115_7_2'];
    $P115_7_3=$_POST['txtP115_7_3'];    
	$P116_1_1=$_POST['txtP116_1_1'];
    $P116_1_2=$_POST['txtP116_1_2'];
    $P116_1_3=$_POST['txtP116_1_3'];
    $P116_2_1=$_POST['txtP116_2_1'];
    $P116_2_2=$_POST['txtP116_2_2'];
    $P116_2_3=$_POST['txtP116_2_3'];
    $P116_3_1=$_POST['txtP116_3_1'];
    $P116_3_2=$_POST['txtP116_3_2'];
    $P116_3_3=$_POST['txtP116_3_3'];
    $P116_4_1=$_POST['txtP116_4_1'];
    $P116_4_2=$_POST['txtP116_4_2'];
    $P116_4_3=$_POST['txtP116_4_3'];
	$P116_5_1=$_POST['txtP116_5_1'];
    $P116_5_2=$_POST['txtP116_5_2'];
    $P116_5_3=$_POST['txtP116_5_3'];
    $P116_6_1=$_POST['txtP116_6_1'];
    $P116_6_2=$_POST['txtP116_6_2'];
    $P116_6_3=$_POST['txtP116_6_3'];
    $P116_7_1=$_POST['txtP116_7_1'];
    $P116_7_2=$_POST['txtP116_7_2'];
    $P116_7_3=$_POST['txtP116_7_3'];	
	$P117_1=$_POST['txtP117_1'];
	$P117_2=$_POST['txtP117_2'];
	$P117_3=$_POST['txtP117_3'];
	$P117_4=$_POST['txtP117_4'];
	$P117_5=$_POST['txtP117_5'];
	$P117_6=$_POST['txtP117_6'];
	$P117_7=$_POST['txtP117_7'];
	$P117_8=$_POST['txtP117_8'];
	$P118=$_POST['txtP118'];
	$P119=$_POST['txtP119'];
	$P120=$_POST['txtP120'];
	$P121=$_POST['txtP121'];
	$P122=$_POST['txtP122'];
	$P123_1=$_POST['txtP123_1'];
	$P123_2=$_POST['txtP123_2'];
	$P124=$_POST['txtP124'];
	$P124_1_1=$_POST['txtP124_1_1'];
    $P124_1_2=$_POST['txtP124_1_2'];
    $P124_1_3=$_POST['txtP124_1_3'];
    $P124_2_1=$_POST['txtP124_2_1'];
    $P124_2_2=$_POST['txtP124_2_2'];
    $P124_2_3=$_POST['txtP124_2_3'];
	$P125_1=$_POST['txtP125_1'];
	$P125_1_1=$_POST['txtP125_1_1'];
    $P125_1_2=$_POST['txtP125_1_2'];
    $P125_1_3=$_POST['txtP125_1_3'];
    $P125_2_1=$_POST['txtP125_2_1'];
    $P125_2_2=$_POST['txtP125_2_2'];
    $P125_2_3=$_POST['txtP125_2_3'];
	$P126=$_POST['txtP126'];
	$P127_1=$_POST['txtP127_1'];
	$P127_2=$_POST['txtP127_2'];
	$P127_3=$_POST['txtP127_3'];
	$P127_4=$_POST['txtP127_4'];
	$P127_5=$_POST['txtP127_5'];
	$P127_6=$_POST['txtP127_6'];
	$P128_1=$_POST['txtP128_1'];
	$P128_2=$_POST['txtP128_2'];
	$P128_3=$_POST['txtP128_3'];
	$P128_4=$_POST['txtP128_4'];	
	$P129_1_1=$_POST['txtP125_1_1'];
    $P129_1_2=$_POST['txtP125_1_2'];
    $P129_1_3=$_POST['txtP125_1_3'];
	$P129_1_4=$_POST['txtP125_1_4'];
    $P129_1_5=$_POST['txtP125_1_5'];
    $P129_1_6=$_POST['txtP125_1_6'];	
	$P129_2_1=$_POST['txtP125_2_1'];
    $P129_2_2=$_POST['txtP125_2_2'];
    $P129_2_3=$_POST['txtP125_2_3'];
	$P129_2_4=$_POST['txtP125_2_4'];
    $P129_2_5=$_POST['txtP125_2_5'];
    $P129_2_6=$_POST['txtP125_2_6'];
    $P129_3_1=$_POST['txtP125_3_1'];
    $P129_3_2=$_POST['txtP125_3_2'];
    $P129_3_3=$_POST['txtP125_3_3'];
	$P129_3_4=$_POST['txtP125_3_4'];
    $P129_3_5=$_POST['txtP125_3_5'];
    $P129_3_6=$_POST['txtP125_3_6'];
	$P129_4_1=$_POST['txtP125_4_1'];
    $P129_4_2=$_POST['txtP125_4_2'];
    $P129_4_3=$_POST['txtP125_4_3'];
	$P129_4_4=$_POST['txtP125_4_4'];
    $P129_4_5=$_POST['txtP125_4_5'];
    $P129_4_6=$_POST['txtP125_4_6'];
	$P129_5_1=$_POST['txtP125_5_1'];
    $P129_5_2=$_POST['txtP125_5_2'];
    $P129_5_3=$_POST['txtP125_5_3'];
	$P129_5_4=$_POST['txtP125_5_4'];
    $P129_5_5=$_POST['txtP125_5_5'];
    $P129_5_6=$_POST['txtP125_5_6'];	
	$P129_6_1=$_POST['txtP125_6_1'];
    $P129_6_2=$_POST['txtP125_6_2'];
    $P129_6_3=$_POST['txtP125_6_3'];
	$P129_6_4=$_POST['txtP125_6_4'];
    $P129_6_5=$_POST['txtP125_6_5'];
    $P129_6_6=$_POST['txtP125_6_6'];	
	$P129_7_1=$_POST['txtP125_7_1'];
    $P129_7_2=$_POST['txtP125_7_2'];
    $P129_7_3=$_POST['txtP125_7_3'];
	$P129_7_4=$_POST['txtP125_7_4'];
    $P129_7_5=$_POST['txtP125_7_5'];
    $P129_7_6=$_POST['txtP125_7_6'];
    $P129_8_1=$_POST['txtP125_8_1'];
    $P129_8_2=$_POST['txtP125_8_2'];
    $P129_8_3=$_POST['txtP125_8_3'];
	$P129_8_4=$_POST['txtP125_8_4'];
    $P129_8_5=$_POST['txtP125_8_5'];
    $P129_8_6=$_POST['txtP125_8_6'];
	$P129_9_1=$_POST['txtP125_9_1'];
    $P129_9_2=$_POST['txtP125_9_2'];
    $P129_9_3=$_POST['txtP125_9_3'];
	$P129_9_4=$_POST['txtP125_9_4'];
    $P129_9_5=$_POST['txtP125_9_5'];
    $P129_9_6=$_POST['txtP125_9_6'];
	$P129_10_1=$_POST['txtP125_10_1'];
    $P129_10_2=$_POST['txtP125_10_2'];
    $P129_10_3=$_POST['txtP125_10_3'];
	$P129_10_4=$_POST['txtP125_10_4'];
    $P129_10_5=$_POST['txtP125_10_5'];
    $P129_10_6=$_POST['txtP125_10_6'];
	$P130=$_POST['txtP130'];	
	$P131_1_1=$_POST['txtP131_1_1'];
    $P131_1_2=$_POST['txtP131_1_2'];
    $P131_1_3=$_POST['txtP131_1_3'];
	$P131_1_4=$_POST['txtP131_1_4'];
    $P131_1_5=$_POST['txtP131_1_5'];
    $P131_1_6=$_POST['txtP131_1_6'];	
	$P131_2_1=$_POST['txtP131_2_1'];
    $P131_2_2=$_POST['txtP131_2_2'];
    $P131_2_3=$_POST['txtP131_2_3'];
	$P131_2_4=$_POST['txtP131_2_4'];
    $P131_2_5=$_POST['txtP131_2_5'];
    $P131_2_6=$_POST['txtP131_2_6'];
    $P131_3_1=$_POST['txtP131_3_1'];
    $P131_3_2=$_POST['txtP131_3_2'];
    $P131_3_3=$_POST['txtP131_3_3'];
	$P131_3_4=$_POST['txtP131_3_4'];
    $P131_3_5=$_POST['txtP131_3_5'];
    $P131_3_6=$_POST['txtP131_3_6'];
	$P131_4_1=$_POST['txtP131_4_1'];
    $P131_4_2=$_POST['txtP131_4_2'];
    $P131_4_3=$_POST['txtP131_4_3'];
	$P131_4_4=$_POST['txtP131_4_4'];
    $P131_4_5=$_POST['txtP131_4_5'];
    $P131_4_6=$_POST['txtP131_4_6'];
	$P131_5_1=$_POST['txtP131_5_1'];
    $P131_5_2=$_POST['txtP131_5_2'];
    $P131_5_3=$_POST['txtP131_5_3'];
	$P131_5_4=$_POST['txtP131_5_4'];
    $P131_5_5=$_POST['txtP131_5_5'];
    $P131_5_6=$_POST['txtP131_5_6'];
	$P132=$_POST['txtP132'];
	
	$InformanteCalificado_1=$_POST['txtInformante_1'];
	$Dia=$_POST['txtInformante_2'];
	$Mes=$_POST['txtInformante_3'];
	$Anio=$_POST['txtInformante_4'];
	$Observaciones=$_POST['txtObservaciones'];
    
    $estado=$_POST['estado'];
    $UsuarioModificacion=$_SESSION['MM_Username'];
    $FechaModificacion=date("Y-m-d H:i:s");    
    //$IpModificacion=$obj->get_real_ip();    
    $estado=1;
    	
	$pregunta = $_POST["botPress"];
		
	$datosArray_p1=$obj->ca_busqueda_doc_id_p1($docID);
	$datosArray_p2=$obj->ca_busqueda_doc_id_p2($docID);
	
    $updatedatos_p1=$obj->ca_actualiza_boleta_productor_p1(             
			 $docID
			,$P15_1, $P15_2, $P15_3, $P15_4, $P15_5             
			,$P16
            ,$P17_1 ,$P17_2
            ,$P18
            ,$P19            
            ,$P20_1 ,$P20_2 ,$P20_3 ,$P20_4
            ,$P21_1_1 ,$P21_1_2 ,$P21_2_1 ,$P21_2_2 ,$P21_3_1 ,$P21_3_2 ,$P21_4_1 ,$P21_4_2 ,$P21_5_1 ,$P21_5_2            
            ,$P22_1 ,$P22_2 ,$P22_3 ,$P22_4            
            ,$P23_1, $P23_1_1 ,$P23_1_2 ,$P23_1_3 ,$P23_1_4 ,$P23_1_5 ,$P23_1_6 ,$P23_1_7 ,$P23_1_8 ,$P23_1_9 ,$P23_1_10 ,$P23_1_11 ,$P23_1_12
            ,$P23_2_1 ,$P23_2_2 ,$P23_2_3 ,$P23_2_4 ,$P23_2_5 ,$P23_2_6 ,$P23_2_7 ,$P23_2_8 ,$P23_2_9 ,$P23_2_10 ,$P23_2_11 ,$P23_2_12
            ,$P23_3_1 ,$P23_3_2 ,$P23_3_3 ,$P23_3_4 ,$P23_3_5 ,$P23_3_6 ,$P23_3_7 ,$P23_3_8 ,$P23_3_9 ,$P23_3_10 ,$P23_3_11 ,$P23_3_12
            ,$P23_4_1 ,$P23_4_2 ,$P23_4_3 ,$P23_4_4 ,$P23_4_5 ,$P23_4_6 ,$P23_4_7 ,$P23_4_8 ,$P23_4_9 ,$P23_4_10 ,$P23_4_11 ,$P23_4_12
            ,$P23_5_1 ,$P23_5_2 ,$P23_5_3 ,$P23_5_4 ,$P23_5_5 ,$P23_5_6 ,$P23_5_7 ,$P23_5_8 ,$P23_5_9 ,$P23_5_10 ,$P23_5_11 ,$P23_5_12
            ,$P23_6_1 ,$P23_6_2 ,$P23_6_3 ,$P23_6_4 ,$P23_6_5 ,$P23_6_6 ,$P23_6_7 ,$P23_6_8 ,$P23_6_9 ,$P23_6_10 ,$P23_6_11 ,$P23_6_12
            ,$P23_7_1 ,$P23_7_2 ,$P23_7_3 ,$P23_7_4 ,$P23_7_5 ,$P23_7_6 ,$P23_7_7 ,$P23_7_8 ,$P23_7_9 ,$P23_7_10 ,$P23_7_11 ,$P23_7_12            
            ,$P24_1, $P24_1_1 ,$P24_1_2 ,$P24_1_3 ,$P24_1_4 ,$P24_1_5 ,$P24_1_6 ,$P24_1_7 ,$P24_1_8 ,$P24_1_9 ,$P24_1_10,$P24_1_11,$P24_1_12,$P24_1_13,$P24_1_14
            ,$P24_2_1 ,$P24_2_2 ,$P24_2_3 ,$P24_2_4 ,$P24_2_5 ,$P24_2_6 ,$P24_2_7 ,$P24_2_8 ,$P24_2_9 ,$P24_2_10,$P24_2_11,$P24_2_12,$P24_2_13,$P24_2_14
            ,$P24_3_1 ,$P24_3_2 ,$P24_3_3 ,$P24_3_4 ,$P24_3_5 ,$P24_3_6 ,$P24_3_7 ,$P24_3_8 ,$P24_3_9 ,$P24_3_10,$P24_3_11,$P24_3_12,$P24_3_13,$P24_3_14
            ,$P24_4_1 ,$P24_4_2 ,$P24_4_3 ,$P24_4_4 ,$P24_4_5 ,$P24_4_6 ,$P24_4_7 ,$P24_4_8 ,$P24_4_9 ,$P24_4_10,$P24_4_11,$P24_4_12,$P24_4_13,$P24_4_14
            ,$P24_5_1 ,$P24_5_2 ,$P24_5_3 ,$P24_5_4 ,$P24_5_5 ,$P24_5_6 ,$P24_5_7 ,$P24_5_8 ,$P24_5_9 ,$P24_5_10,$P24_5_11,$P24_5_12,$P24_5_13,$P24_5_14
            ,$P24_6_1 ,$P24_6_2 ,$P24_6_3 ,$P24_6_4 ,$P24_6_5 ,$P24_6_6 ,$P24_6_7 ,$P24_6_8 ,$P24_6_9 ,$P24_6_10,$P24_6_11,$P24_6_12,$P24_6_13,$P24_6_14
            ,$P24_7_1 ,$P24_7_2 ,$P24_7_3 ,$P24_7_4 ,$P24_7_5 ,$P24_7_6 ,$P24_7_7 ,$P24_7_8 ,$P24_7_9 ,$P24_7_10,$P24_7_11,$P24_7_12,$P24_7_13,$P24_7_14
            ,$P24_8_1 ,$P24_8_2 ,$P24_8_3 ,$P24_8_4 ,$P24_8_5 ,$P24_8_6 ,$P24_8_7 ,$P24_8_8 ,$P24_8_9 ,$P24_8_10,$P24_8_11,$P24_8_12,$P24_8_13,$P24_8_14
            ,$P24_9_1 ,$P24_9_2 ,$P24_9_3 ,$P24_9_4 ,$P24_9_5 ,$P24_9_6 ,$P24_9_7 ,$P24_9_8 ,$P24_9_9 ,$P24_9_10,$P24_9_11,$P24_9_12,$P24_9_13,$P24_9_14
            ,$P24_10_1 ,$P24_10_2 ,$P24_10_3 ,$P24_10_4 ,$P24_10_5 ,$P24_10_6 ,$P24_10_7 ,$P24_10_8 ,$P24_10_9 ,$P24_10_10 ,$P24_10_11 ,$P24_10_12 ,$P24_10_13 ,$P24_10_14
            ,$P24_11_1 ,$P24_11_2 ,$P24_11_3 ,$P24_11_4 ,$P24_11_5 ,$P24_11_6 ,$P24_11_7 ,$P24_11_8 ,$P24_11_9 ,$P24_11_10 ,$P24_11_11 ,$P24_11_12 ,$P24_11_13 ,$P24_11_14
            ,$P24_12_1 ,$P24_12_2 ,$P24_12_3 ,$P24_12_4 ,$P24_12_5 ,$P24_12_6 ,$P24_12_7 ,$P24_12_8 ,$P24_12_9 ,$P24_12_10 ,$P24_12_11 ,$P24_12_12 ,$P24_12_13 ,$P24_12_14
            ,$P24_13_1 ,$P24_13_2 ,$P24_13_3 ,$P24_13_4 ,$P24_13_5 ,$P24_13_6 ,$P24_13_7 ,$P24_13_8 ,$P24_13_9 ,$P24_13_10 ,$P24_13_11 ,$P24_13_12 ,$P24_13_13 ,$P24_13_14
            ,$P24_14_1 ,$P24_14_2 ,$P24_14_3 ,$P24_14_4 ,$P24_14_5 ,$P24_14_6 ,$P24_14_7 ,$P24_14_8 ,$P24_14_9 ,$P24_14_10 ,$P24_14_11 ,$P24_14_12 ,$P24_14_13 ,$P24_14_14
            ,$P24_15_1 ,$P24_15_2 ,$P24_15_3 ,$P24_15_4 ,$P24_15_5 ,$P24_15_6 ,$P24_15_7 ,$P24_15_8 ,$P24_15_9 ,$P24_15_10 ,$P24_15_11 ,$P24_15_12 ,$P24_15_13 ,$P24_15_14
            ,$P24_16_1 ,$P24_16_2 ,$P24_16_3 ,$P24_16_4 ,$P24_16_5 ,$P24_16_6 ,$P24_16_7 ,$P24_16_8 ,$P24_16_9 ,$P24_16_10 ,$P24_16_11 ,$P24_16_12 ,$P24_16_13 ,$P24_16_14
            ,$P24_17_1 ,$P24_17_2 ,$P24_17_3 ,$P24_17_4 ,$P24_17_5 ,$P24_17_6 ,$P24_17_7 ,$P24_17_8 ,$P24_17_9 ,$P24_17_10 ,$P24_17_11 ,$P24_17_12 ,$P24_17_13 ,$P24_17_14
            ,$P24_18_1 ,$P24_18_2 ,$P24_18_3 ,$P24_18_4 ,$P24_18_5 ,$P24_18_6 ,$P24_18_7 ,$P24_18_8 ,$P24_18_9 ,$P24_18_10 ,$P24_18_11 ,$P24_18_12 ,$P24_18_13 ,$P24_18_14
            ,$P24_19_1 ,$P24_19_2 ,$P24_19_3 ,$P24_19_4 ,$P24_19_5 ,$P24_19_6 ,$P24_19_7 ,$P24_19_8 ,$P24_19_9 ,$P24_19_10 ,$P24_19_11 ,$P24_19_12 ,$P24_19_13 ,$P24_19_14
            ,$P24_20_1 ,$P24_20_2 ,$P24_20_3 ,$P24_20_4 ,$P24_20_5 ,$P24_20_6 ,$P24_20_7 ,$P24_20_8 ,$P24_20_9 ,$P24_20_10 ,$P24_20_11 ,$P24_20_12 ,$P24_20_13 ,$P24_20_14
            ,$P24_21_1 ,$P24_21_2 ,$P24_21_3 ,$P24_21_4 ,$P24_21_5 ,$P24_21_6 ,$P24_21_7 ,$P24_21_8 ,$P24_21_9 ,$P24_21_10 ,$P24_21_11 ,$P24_21_12 ,$P24_21_13 ,$P24_21_14
            ,$P24_22_1 ,$P24_22_2 ,$P24_22_3 ,$P24_22_4 ,$P24_22_5 ,$P24_22_6 ,$P24_22_7 ,$P24_22_8 ,$P24_22_9 ,$P24_22_10 ,$P24_22_11 ,$P24_22_12 ,$P24_22_13 ,$P24_22_14
            ,$P24_23_1 ,$P24_23_2 ,$P24_23_3 ,$P24_23_4 ,$P24_23_5 ,$P24_23_6 ,$P24_23_7 ,$P24_23_8 ,$P24_23_9 ,$P24_23_10 ,$P24_23_11 ,$P24_23_12 ,$P24_23_13 ,$P24_23_14
            ,$P24_24_1 ,$P24_24_2 ,$P24_24_3 ,$P24_24_4 ,$P24_24_5 ,$P24_24_6 ,$P24_24_7 ,$P24_24_8 ,$P24_24_9 ,$P24_24_10 ,$P24_24_11 ,$P24_24_12 ,$P24_24_13 ,$P24_24_14
            ,$P24_25_1 ,$P24_25_2 ,$P24_25_3 ,$P24_25_4 ,$P24_25_5 ,$P24_25_6 ,$P24_25_7 ,$P24_25_8 ,$P24_25_9 ,$P24_25_10 ,$P24_25_11 ,$P24_25_12 ,$P24_25_13 ,$P24_25_14
            ,$P24_26_1 ,$P24_26_2 ,$P24_26_3 ,$P24_26_4 ,$P24_26_5 ,$P24_26_6 ,$P24_26_7 ,$P24_26_8 ,$P24_26_9 ,$P24_26_10 ,$P24_26_11 ,$P24_26_12 ,$P24_26_13 ,$P24_26_14
            ,$P24_27_1 ,$P24_27_2 ,$P24_27_3 ,$P24_27_4 ,$P24_27_5 ,$P24_27_6 ,$P24_27_7 ,$P24_27_8 ,$P24_27_9 ,$P24_27_10 ,$P24_27_11 ,$P24_27_12 ,$P24_27_13 ,$P24_27_14
            ,$P24_28_1 ,$P24_28_2 ,$P24_28_3 ,$P24_28_4 ,$P24_28_5 ,$P24_28_6 ,$P24_28_7 ,$P24_28_8 ,$P24_28_9 ,$P24_28_10 ,$P24_28_11 ,$P24_28_12 ,$P24_28_13 ,$P24_28_14
            ,$P24_29_1 ,$P24_29_2 ,$P24_29_3 ,$P24_29_4 ,$P24_29_5 ,$P24_29_6 ,$P24_29_7 ,$P24_29_8 ,$P24_29_9 ,$P24_29_10 ,$P24_29_11 ,$P24_29_12 ,$P24_29_13 ,$P24_29_14
            ,$P24_30_1 ,$P24_30_2 ,$P24_30_3 ,$P24_30_4 ,$P24_30_5 ,$P24_30_6 ,$P24_30_7 ,$P24_30_8 ,$P24_30_9 ,$P24_30_10 ,$P24_30_11 ,$P24_30_12 ,$P24_30_13 ,$P24_30_14
            ,$P24_31_1 ,$P24_31_2 ,$P24_31_3 ,$P24_31_4 ,$P24_31_5 ,$P24_31_6 ,$P24_31_7 ,$P24_31_8 ,$P24_31_9 ,$P24_31_10 ,$P24_31_11 ,$P24_31_12 ,$P24_31_13 ,$P24_31_14
            ,$P24_32_1 ,$P24_32_2 ,$P24_32_3 ,$P24_32_4 ,$P24_32_5 ,$P24_32_6 ,$P24_32_7 ,$P24_32_8 ,$P24_32_9 ,$P24_32_10 ,$P24_32_11 ,$P24_32_12 ,$P24_32_13 ,$P24_32_14
            ,$P24_33_1 ,$P24_33_2 ,$P24_33_3 ,$P24_33_4 ,$P24_33_5 ,$P24_33_6 ,$P24_33_7 ,$P24_33_8 ,$P24_33_9 ,$P24_33_10 ,$P24_33_11 ,$P24_33_12 ,$P24_33_13 ,$P24_33_14
            ,$P24_34_1 ,$P24_34_2 ,$P24_34_3 ,$P24_34_4 ,$P24_34_5 ,$P24_34_6 ,$P24_34_7 ,$P24_34_8 ,$P24_34_9 ,$P24_34_10 ,$P24_34_11 ,$P24_34_12 ,$P24_34_13 ,$P24_34_14            
            ,$P25_1, $P25_1_1 ,$P25_1_2 ,$P25_1_3 ,$P25_2_1 ,$P25_2_2 ,$P25_2_3 ,$P25_3_1 ,$P25_3_2 ,$P25_3_3 ,$P25_4_1 ,$P25_4_2 ,$P25_4_3 ,$P25_5_1 ,$P25_5_2 ,$P25_5_3
            ,$P26_1, $P26_1_1 ,$P26_1_2 ,$P26_1_3 ,$P26_2_1 ,$P26_2_2 ,$P26_2_3 ,$P26_3_1 ,$P26_3_2 ,$P26_3_3 ,$P26_4_1 ,$P26_4_2 ,$P26_4_3 ,$P26_5_1 ,$P26_5_2 ,$P26_5_3
            ,$P27_1, $P27_1_1 ,$P27_1_2 ,$P27_1_3 ,$P27_2_1 ,$P27_2_2 ,$P27_2_3 ,$P27_3_1 ,$P27_3_2 ,$P27_3_3 ,$P27_4_1 ,$P27_4_2 ,$P27_4_3 ,$P27_5_1 ,$P27_5_2 ,$P27_5_3
    );
    
    $updatedatos_p2=$obj->ca_actualiza_boleta_productor_p2(	         
			 $docID
			,$P28_1 ,$P28_1_1 ,$P28_1_2 ,$P28_2_1 ,$P28_2_2 ,$P28_3_1 ,$P28_3_2 ,$P28_4_1 ,$P28_4_2 ,$P28_5_1 ,$P28_5_2			
			,$P29_1 ,$P29_1_1 ,$P29_1_2 ,$P29_2_1 ,$P29_2_2 ,$P29_3_1 ,$P29_3_2 ,$P29_4_1 ,$P29_4_2 ,$P29_5_1 ,$P29_5_2			
			,$P30_1 ,$P30_2 ,$P30_3 ,$P30_4 ,$P30_5 ,$P30_6  			
			,$P31_1 ,$P31_2 ,$P31_3  			
			,$P32 ,$P33 ,$P34 ,$P35 ,$P36			
			,$P37_1 ,$P37_1_1 ,$P37_1_2 ,$P37_2_1 ,$P37_2_2 ,$P37_3_1 ,$P37_3_2 ,$P37_4_1 ,$P37_4_2 ,$P37_5_1 ,$P37_5_2			
			,$P38_1_1 ,$P38_1_2 ,$P38_1_3 ,$P38_2_1 ,$P38_2_2 ,$P38_2_3 ,$P38_3_1 ,$P38_3_2 ,$P38_3_3 ,$P38_4_1 ,$P38_4_2 ,$P38_4_3
			,$P39_1_1 ,$P39_1_2 ,$P39_1_3 ,$P39_2_1 ,$P39_2_2 ,$P39_2_3 ,$P39_3_1 ,$P39_3_2 ,$P39_3_3 ,$P39_4_1 ,$P39_4_2 ,$P39_4_3 ,$P39_5_1 ,$P39_5_2 ,$P39_5_3  
			,$P39_6_1 ,$P39_6_2 ,$P39_6_3 ,$P39_7_1 ,$P39_7_2 ,$P39_7_3 ,$P39_8_1 ,$P39_8_2 ,$P39_8_3 ,$P39_9_1 ,$P39_9_2 ,$P39_9_3 ,$P39_10_1 ,$P39_10_2 ,$P39_10_3  
			,$P39_11_1 ,$P39_11_2 ,$P39_11_3 ,$P39_12_1 ,$P39_12_2 ,$P39_12_3 ,$P39_13_1 ,$P39_13_2 ,$P39_13_3 ,$P39_14_1 ,$P39_14_2 ,$P39_14_3 ,$P39_15_1 ,$P39_15_2  
			,$P39_15_3 ,$P39_16_1 ,$P39_16_2 ,$P39_16_3 ,$P39_17_1 ,$P39_17_2 ,$P39_17_3 ,$P39_18_1 ,$P39_18_2 ,$P39_18_3  
			,$P40 
			,$P41_1_1 ,$P41_1_2 ,$P41_1_3 ,$P41_2_1 ,$P41_2_2 ,$P41_2_3 ,$P41_3_1 ,$P41_3_2 ,$P41_3_3 ,$P41_4_1 ,$P41_4_2 ,$P41_4_3 ,$P41_5_1 ,$P41_5_2 
			,$P41_5_3 ,$P41_6_1 ,$P41_6_2 ,$P41_6_3 ,$P41_7_1 ,$P41_7_2 ,$P41_7_3 ,$P41_8_1 ,$P41_8_2 ,$P41_8_3 ,$P41_9_1 ,$P41_9_2 ,$P41_9_3 ,$P41_10_1 
			,$P41_10_2 ,$P41_10_3 ,$P41_11_1 ,$P41_11_2 ,$P41_11_3 ,$P41_12_1 ,$P41_12_2 ,$P41_12_3
			,$P42 ,$P43 ,$P44
			,$P45_1 ,$P45_2 ,$P45_3
			,$P46  
			,$P47_1 ,$P47_2 ,$P47_3
			,$P48  
			,$P49_1 ,$P49_2 ,$P49_3
			,$P50 
			,$P51_1_1 ,$P51_1_2 ,$P51_1_3 ,$P51_2_1 ,$P51_2_2 ,$P51_2_3 ,$P51_3_1 ,$P51_3_2 ,$P51_3_3 ,$P51_4_1 ,$P51_4_2 ,$P51_4_3
			,$P52_1 ,$P52_2 ,$P52_3  
			,$P53_1 ,$P53_2 ,$P53_3  
			,$P54  
			,$P55_1_1 ,$P55_1_2 ,$P55_1_3 ,$P55_1_4 ,$P55_1_5 ,$P55_2_1 ,$P55_2_2 ,$P55_2_3 ,$P55_2_4 ,$P55_2_5 ,$P55_3_1 ,$P55_3_2 ,$P55_3_3 ,$P55_3_4 ,$P55_3_5  
			,$P56  
			,$P57_1_1 ,$P57_1_2 ,$P57_1_3 ,$P57_2_1 ,$P57_2_2 ,$P57_2_3 ,$P57_3_1 ,$P57_3_2 ,$P57_3_3 ,$P57_4_1 ,$P57_4_2 ,$P57_4_3
			,$P58_1 ,$P58_2 ,$P58_3  
			,$P59  
			,$P60_1_1 ,$P60_1_2 ,$P60_1_3 ,$P60_2_1 ,$P60_2_2 ,$P60_2_3 ,$P60_3_1 ,$P60_3_2 ,$P60_3_3 ,$P60_4_1 ,$P60_4_2 ,$P60_4_3
			,$P61_1 ,$P61_2 ,$P61_3 
			,$P62 
			,$P63_1_1 ,$P63_1_2 ,$P63_1_3 ,$P63_1_4 ,$P63_2_1 ,$P63_2_2 ,$P63_2_3 ,$P63_2_4 ,$P63_3_1 ,$P63_3_2 ,$P63_3_3 ,$P63_3_4 ,$P63_4_1 ,$P63_4_2 ,$P63_4_3 ,$P63_4_4 
			,$P63_5_1 ,$P63_5_2 ,$P63_5_3 ,$P63_5_4 ,$P63_6_1 ,$P63_6_2 ,$P63_6_3 ,$P63_6_4 ,$P63_7_1 ,$P63_7_2 ,$P63_7_3 ,$P63_7_4 ,$P63_8_1 ,$P63_8_2 ,$P63_8_3 ,$P63_8_4 
			,$P63_9_1 ,$P63_9_2 ,$P63_9_3 ,$P63_9_4
			,$P64_1 ,$P64_2 ,$P64_3  
			,$P65_1 ,$P65_2 ,$P65_3  
			,$P66  
			,$P67_1_1 ,$P67_1_2 ,$P67_1_3 ,$P67_1_4 ,$P67_2_1 ,$P67_2_2 ,$P67_2_3 ,$P67_2_4 ,$P67_3_1 ,$P67_3_2 ,$P67_3_3 ,$P67_3_4 ,$P67_4_1 ,$P67_4_2 ,$P67_4_3 ,$P67_4_4  
			,$P67_5_1 ,$P67_5_2 ,$P67_5_3 ,$P67_5_4 ,$P67_6_1 ,$P67_6_2 ,$P67_6_3 ,$P67_6_4 ,$P67_7_1 ,$P67_7_2 ,$P67_7_3 ,$P67_7_4 ,$P67_8_1 ,$P67_8_2 ,$P67_8_3 ,$P67_8_4  
			,$P67_9_1 ,$P67_9_2 ,$P67_9_3 ,$P67_9_4
			,$P68_1 ,$P68_2 ,$P68_3  
			,$P69_1 ,$P69_2 ,$P69_3  
			,$P70_1 ,$P70_2 ,$P70_3 ,$P70_4 ,$P70_5
			,$P71_1 ,$P71_2 ,$P71_3  
			,$P72
			,$P73_1 ,$P73_2 ,$P73_3 ,$P73_4 ,$P73_5 ,$P73_6 ,$P73_7 ,$P73_8 ,$P73_9 ,$P73_10
			,$P74_1_1 ,$P74_1_2 ,$P74_1_3 ,$P74_2_1 ,$P74_2_2 ,$P74_2_3 ,$P74_3_1 ,$P74_3_2 ,$P74_3_3 ,$P74_4_1 ,$P74_4_2 ,$P74_4_3
			,$P75  
			,$P76_1 ,$P76_2 ,$P76_3 ,$P76_4
			,$P77_1 ,$P77_2 ,$P77_3  
			,$P78 
			,$P79_1 ,$P79_2
			,$P80  
			,$P81_1 ,$P81_2
			,$P82_1 ,$P82_2 ,$P82_3
			,$P83_1_1 ,$P83_1_2 ,$P83_2 ,$P83_3 ,$P83_4 ,$P83_5 ,$P83_6
			,$P84_1 ,$P84_2 
			,$P85_1 ,$P85_2 ,$P85_3
			,$P86_1_1 ,$P86_1_2 ,$P86_1_3 ,$P86_2_1 ,$P86_2_2 ,$P86_2_3 ,$P86_3_1 ,$P86_3_2 ,$P86_3_3 ,$P86_4_1 ,$P86_4_2 ,$P86_4_3 ,$P86_5_1 ,$P86_5_2 ,$P86_5_3 ,$P86_6_1 ,$P86_6_2  
			,$P86_6_3 ,$P86_7_1 ,$P86_7_2 ,$P86_7_3  
			,$P87_1_1 ,$P87_1_2 ,$P87_1_3 ,$P87_2_1 ,$P87_2_2 ,$P87_2_3
            ,$P88
			,$P89_1 ,$P89_2 ,$P89_3
			,$P90_1 ,$P90_2 ,$P90_3 ,$P90_4 ,$P90_5 ,$P90_6 ,$P90_7 ,$P90_8 ,$P90_9 ,$P90_10
			,$P91  
			,$P92_1 ,$P92_2 ,$P92_3 ,$P92_4
			,$P93_1 ,$P93_2  
			,$P94 ,$P95 
			,$P96_1_1 ,$P96_1_2 ,$P96_1_3 ,$P96_1_4 ,$P96_2_1 ,$P96_2_2 ,$P96_2_3 ,$P96_2_4 ,$P96_3_1 ,$P96_3_2 ,$P96_3_3 ,$P96_3_4 ,$P96_4_1 ,$P96_4_2 ,$P96_4_3    
			,$P96_4_4 ,$P96_5_1 ,$P96_5_2 ,$P96_5_3 ,$P96_5_4
			,$P97 
			,$P98_1_1 ,$P98_1_2 ,$P98_1_3 ,$P98_2_1 ,$P98_2_2 ,$P98_2_3 ,$P98_3_1 ,$P98_3_2 ,$P98_3_3 ,$P98_4_1 ,$P98_4_2 ,$P98_4_3
			,$P99_1 ,$P99_2  
			,$P100  
			,$P101_1_1 ,$P101_1_2 ,$P101_1_3 ,$P101_2_1 ,$P101_2_2 ,$P101_2_3 ,$P101_3_1 ,$P101_3_2 ,$P101_3_3 ,$P101_4_1 ,$P101_4_2 ,$P101_4_3
			,$P102_1 ,$P102_2 ,$P102_3  
			,$P103  
			,$P104_1 ,$P104_2 ,$P104_3 ,$P104_4
			,$P105_1 ,$P105_2 ,$P105_3  
			,$P106 
			,$P107_1_1 ,$P107_1_2 ,$P107_1_3 ,$P107_1_4 ,$P107_1_5 ,$P107_1_6 ,$P107_2_1 ,$P107_2_2 ,$P107_2_3 ,$P107_2_4  
			,$P107_2_5 ,$P107_2_6 ,$P107_3_1 ,$P107_3_2 ,$P107_3_3 ,$P107_3_4 ,$P107_3_5 ,$P107_3_6 ,$P107_4_1 ,$P107_4_2  
			,$P107_4_3 ,$P107_4_4 ,$P107_4_5 ,$P107_4_6 ,$P107_5_1 ,$P107_5_2 ,$P107_5_3 ,$P107_5_4 ,$P107_5_5 ,$P107_5_6
			,$P108 ,$P109  
			,$P110_1,$P110_2
			,$P111_1 ,$P111_2 ,$P111_3 ,$P111_4
			,$P112_1 ,$P112_2 ,$P112_3  
			,$P113 
			,$P114_1 ,$P114_2 ,$P114_3
			,$P115_1_1 ,$P115_1_2 ,$P115_1_3 ,$P115_2_1 ,$P115_2_2 ,$P115_2_3 ,$P115_3_1 ,$P115_3_2 ,$P115_3_3 ,$P115_4_1 ,$P115_4_2 ,$P115_4_3 ,$P115_5_1 ,$P115_5_2
			,$P115_5_3 ,$P115_6_1 ,$P115_6_2 ,$P115_6_3 ,$P115_7_1 ,$P115_7_2 ,$P115_7_3
			,$P116_1_1 ,$P116_1_2 ,$P116_1_3 ,$P116_2_1 ,$P116_2_2 ,$P116_2_3 ,$P116_3_1 ,$P116_3_2 ,$P116_3_3 ,$P116_4_1 ,$P116_4_2 ,$P116_4_3 ,$P116_5_1 ,$P116_5_2
			,$P116_5_3 ,$P116_6_1 ,$P116_6_2 ,$P116_6_3 ,$P116_7_1 ,$P116_7_2 ,$P116_7_3
			,$P117_1 ,$P117_2 ,$P117_3 ,$P117_4 ,$P117_5 ,$P117_6 ,$P117_7 ,$P117_8  
			,$P118 ,$P119 ,$P120 ,$P121 ,$P122  
			,$P123_1 ,$P123_2  
			,$P124_1  
			,$P124_1_1 ,$P124_1_2 ,$P124_1_3 ,$P124_2_1 ,$P124_2_2 ,$P124_2_3
			,$P125_1  
			,$P125_1_1 ,$P125_1_2 ,$P125_1_3 ,$P125_2_1 ,$P125_2_2 ,$P125_2_3
			,$P126 
			,$P127_1 ,$P127_2 ,$P127_3 ,$P127_4 ,$P127_5 ,$P127_6
			,$P128_1 ,$P128_2 ,$P128_3 ,$P128_4 
			,$P129_1_1 ,$P129_1_2 ,$P129_1_3 ,$P129_1_4 ,$P129_1_5 ,$P129_1_6 ,$P129_2_1 ,$P129_2_2 ,$P129_2_3 ,$P129_2_4 ,$P129_2_5 ,$P129_2_6 ,$P129_3_1 ,$P129_3_2 ,$P129_3_3 
			,$P129_3_4 ,$P129_3_5 ,$P129_3_6 ,$P129_4_1 ,$P129_4_2 ,$P129_4_3 ,$P129_4_4 ,$P129_4_5 ,$P129_4_6 ,$P129_5_1 ,$P129_5_2 ,$P129_5_3 ,$P129_5_4 ,$P129_5_5 ,$P129_5_6 
			,$P129_6_1 ,$P129_6_2 ,$P129_6_3 ,$P129_6_4 ,$P129_6_5 ,$P129_6_6 ,$P129_7_1 ,$P129_7_2 ,$P129_7_3 ,$P129_7_4 ,$P129_7_5 ,$P129_7_6 ,$P129_8_1 ,$P129_8_2 ,$P129_8_3 
			,$P129_8_4 ,$P129_8_5 ,$P129_8_6 ,$P129_9_1 ,$P129_9_2 ,$P129_9_3 ,$P129_9_4 ,$P129_9_5 ,$P129_9_6 ,$P129_10_1 ,$P129_10_2 ,$P129_10_3 ,$P129_10_4 ,$P129_10_5 ,$P129_10_6
			,$P130 
			,$P131_1_1 ,$P131_1_2 ,$P131_1_3 ,$P131_1_4 ,$P131_1_5 ,$P131_1_6 ,$P131_2_1 ,$P131_2_2 ,$P131_2_3 ,$P131_2_4 ,$P131_2_5 ,$P131_2_6 ,$P131_3_1 ,$P131_3_2 ,$P131_3_3
			,$P131_3_4 ,$P131_3_5 ,$P131_3_6 ,$P131_4_1 ,$P131_4_2 ,$P131_4_3 ,$P131_4_4 ,$P131_4_5 ,$P131_4_6 ,$P131_5_1 ,$P131_5_2 ,$P131_5_3 ,$P131_5_4 ,$P131_5_5 ,$P131_5_6
			,$P132  
    );   
}
?>	
													
<form action="" method="post" name="boleta_upa">
Pregunta: <input class="cuarenta_px" name="txtPregunta" id="txtPregunta" type="text" autofocus="autofocus"/>
<input type="button" name="0" id="0" value="Ir" onKeyDown="A(event,null);" onclick="enviar(this.form,'p<?php echo $_POST['txtPregunta']; ?>>')"  /><br />
<input type="button" name="0" id="0" value="Encabezado" onKeyDown="A(event,null);" onclick="enviar(this.form,'p0')"  />
<?php for ($j=15;$j<135;$j++){?>
		<input type="button" name="<?php echo $j; ?>" id="<?php echo $j; ?>" value="<?php echo $j; ?>" onKeyDown="A(event,null);" onclick="enviar(this.form,'p<?php echo $j; ?>')"  />
<?php }	?>
<input type="hidden" name="botPress" id="botPress" />
<input type="hidden" name="MM_update" value="form" />
    <table style="border: medium none ; width: 100%;" align="top">
	    <?php foreach ($datosArray_p1 as $row_datos):?>
        <tr>
            <td>
				<?php foreach ($arrayCabecera as $row_datos_ca):?>
                <div id="p0" style="display:<?php echo $p0; ?>">
                    <table>
                        <tr>	
                            <td>N&ordm; de brigada</td>
                            <td><input class="cuarenta_px" name="txtnum_brig" id="txtnum_brig" type="text" value="<?php echo $row_datos_ca['NumeroBrigada']; ?>" onKeyDown="A(event,this.form.txtnum_empa);" autofocus="autofocus"/></td>
                            <td>N &ordf; de empadronador</td>
                            <td><input class="cuarenta_px" name="txtnum_empa" id="txtnum_empa" type="text" value="<?php echo $row_datos['NumeroEmpadronador']; ?>" onKeyDown="A(event,this.form.txtnum_seg);"/></td>
                            <td>N&ordm; de segmento</td>
                            <td><input class="cuarenta_px" name="txtnum_seg" id="txtnum_seg" type="text" value="<?php echo $row_datos['NumeroSegmento']; ?>" onKeyDown="A(event,this.form.txtnum_control);"/></td>
                            <td>N&ordm; hoja de control</td>
                            <td><input class="cuarenta_px" name="txtnum_control" id="txtnum_control" type="text" value="<?php echo $row_datos['NumeroHojaControl']; ?>" onKeyDown="A(event,this.form.txtP1);"/></td>
                        </tr>
                    </table>
                    <label><strong>I. UBICACI&Oacute;N GEOGR&Aacute;FICA CENSAL DE LA UPA</strong></label>
                    <table>
                        <tr>
                            <td>1. Departamento censal</td>
                            <td><input class="cuarenta_px" name="txtP1" id="txtP1" type="text" value="<?php echo $row_datos_ca['CP01_CodigoDepartamento']; ?>" onKeyDown="A(event,this.form.txtP2);"/></td>
                        </tr>                                                                  
                        <tr>                                                                   
                            <td>2. Provincia censal</td>                                       
                            <td><input class="cuarenta_px" name="txtP2" id="txtP2" type="text" value="<?php echo $row_datos_ca['CP02_CodigoProvincia']; ?>" onKeyDown="A(event,this.form.txtP3);"/></td>
                        </tr>                                                                  
                        <tr>                                                                   
                            <td>3. Municipio censal</td>                                       
                            <td><input class="cuarenta_px" name="txtP3" id="txtP3" type="text" value="<?php echo $row_datos_ca['CP03_CodigoMunicipio']; ?>" onKeyDown="A(event,this.form.txtP4);"/></td>
                        </tr>                                                                  
                        <tr>                                                                   
                            <td>4. Area censal</td>                                            
                            <td><input class="cuarenta_px" name="txtP4" id="txtP4" type="text" value="<?php echo $row_datos_ca['CP04_CodigoArea']; ?>" onKeyDown="A(event,this.form.txtP5);"/></td>
                        </tr>                                                                  
                        <tr>                                                                   
                            <td>5. Cant&oacute;n censal</td>                                   
                            <td><input class="cuarenta_px" name="txtP5" id="txtP5" type="text" value="<?php echo $row_datos_ca['CP05_CodigoCanton']; ?>" onKeyDown="A(event,this.form.txtP6_1);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr align="right">
                            <td>6. Comunidad: ind&iacute;gena originario campesino, intercultural, afroboliviana</td>
							<td></td>
                        </tr>
                        <tr align="right">
                            <td>7. Comunidad: brecha, campo, colonia, faja, sindicato u otro </td>
							<td><input class="cuarenta_px" name="txtP6_1" id="txtP6_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos_ca['CP6y7']; ?>" onKeyDown="A(event,this.form.txtP6_2);"/></td>
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
                            <td><input class="cuarenta_px" name="txtP6_2" id="txtP6_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos_ca['NumeroOrdenComunidad']; ?>" onKeyDown="A(event,this.form.txtP12);"/></td>
							<td></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>12. Anote el nombre espec&iacute;fico correspondiente al c&oacute;digo marcado del 1 al 6.</td>
                        </tr>
                        <tr>
                            <td><input class="novecientos_px" name="txtP12" id="txtP12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos_ca['CP08_NombreComunidad']; ?>" onKeyDown="A(event,this.form.txtP13);"/></td>
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
                            <td><input class="cuarenta_px" name="txtP14" id="txtP14" type="text" value="<?php echo $row_datos['NumeroDistritoMunicipal']; ?>" onfocus="selecciona_value(this)" onKeyDown="A(event,this.form.btnP14_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td></td>
                            <td><input name="btnP14_siguiente" id="btnP14_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p15')"/></td>
							<td><input name="btnInsertar" id="btnInsertar" value="Insertar" type="hidden" onKeyDown="A(event,null);" onclick="enviar(this.form,'insertar')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
				<?php endforeach; ?>
				<hr /><!-- Linea abajo -->
            </td>
        </tr>		
        <tr>
            <td>        
                <div id="p15" style="display:<?php echo $p15; ?>">
                    <label><strong>II. CARACTER&Iacute;STICAS DEL PRODUCTOR(A)</strong></label>
                    <table>          
                        <tr>
                            <td colspan="2">15 A. Para Productor(a) que tiene o maneja la Unidad de Producci&oacute;n Agropecuaria de manera individual o en sociedad de hecho (socio principal)</td>
                        </tr>
                        <tr>
                            <td>Primer nombre</td>
                            <td>Segundo nombre</td>
                        </tr>
                        <tr>
                            <td><input class="trecientos_px" name="txtP15_1" id="txtP15_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P15_1']; ?>"  onKeyDown="A(event,this.form.txtP15_2);" autofocus="autofocus"/></td>
                            <td><input class="trecientos_px" name="txtP15_2" id="txtP15_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P15_2']; ?>"  onKeyDown="A(event,this.form.txtP15_3);"/></td>
                        </tr>
                        <tr>
                            <td>Apellido paterno</td>
                            <td>Apellido materno</td>
                        </tr>
                        <tr>
                            <td><input class="trecientos_px" name="txtP15_3" id="txtP15_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P15_3']; ?>" onKeyDown="A(event,this.form.txtP15_4);"/></td>
                            <td><input class="trecientos_px" name="txtP15_4" id="txtP15_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P15_4']; ?>" onKeyDown="A(event,this.form.txtP15_5);"/></td>
                        </tr>
                        <tr>
                            <td colspan="2">15 B. Para empresa, sociedad formal, cooperativa, entidad estatal, Comunidad ind&iacute;gena originario campesino</td>
                        </tr>
                        <tr>
                            <td colspan="2"><input class="novecientos_px" name="txtP15_5" id="txtP15_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P15_5']; ?>" onKeyDown="A(event,this.form.btnP15_siguiente);"/></td>
                        </tr>          
                    </table>
                    <table>          
                        <tr>
                            <td><input name="btnP15_anterior"  id="btnP15_anterior"  value="Anterior" type="button" onclick="enviar(this.form,'p0')"/></td>
                            <td><input name="btnP15_siguiente" id="btnP15_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p16')"/></td>
                        </tr>          
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p16" style="display:<?php echo $p16; ?>">
                    <table>          
                        <tr>
                            <td colspan="2">16. Persona entrevistada</td>
                        </tr>
                        <tr>
                            <td>Productor(a)</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>Informante calificado</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td>Informante no calificado o sin informante</td>
                            <td>3</td>
                            <td>-&gt; Pase a otra unidad censal</td>
                        </tr>
                        <tr>
                            <td align="right"><input class="cuarenta_px" name="txtP16" id="txtP16" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P16']; ?>" onKeyDown="A(event,this.form.btnP16_siguiente);" autofocus="autofocus"/></td>
                            <td></td>
                        </tr>          
                    </table>
                    <table>          
                        <tr>
                            <td><input name="btnP16_anterior"  id="btnP16_anterior"  value="Anterior" type="button" onclick="enviar(this.form,'p15')"/></td>
                            <td><input name="btnP16_siguiente" id="btnP16_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p17')"/></td>
                        </tr>          
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p17" style="display:<?php echo $p17; ?>">
                    <table>          
                        <tr>
                            <td colspan="2">17. S&oacute;lo si el Productor(a) es individual o sociedad de hecho, &iquest;d&oacute;nde naci&oacute;?</td>
                        </tr>
                        <tr>
                            <td align="right">En este minucipio</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td align="right">En otro municipio</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td>Nombre del otro municipio</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input class="quinientos_px" name="txtP17_1" id="txtP17_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P17_1']; ?>" onKeyDown="A(event,this.form.txtP17_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td align="right">En otro pa&iacute;s</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input class="cuarenta_px" name="txtP17_2" id="txtP17_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P17_2']; ?>" onKeyDown="A(event,this.form.btnP17_siguiente);"/></td>
                        </tr>          
                    </table>
                    <table>         
                        <tr>
                            <td><input name="btnP17_anterior"  id="btnP17_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p16')"/></td>
                            <td><input name="btnP17_siguiente" id="btnP17_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p18')"/></td>
                        </tr>          
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p18" style="display:<?php echo $p18; ?>">
                    <table>
                        <tr>
                            <td colspan="2">18. &iquest;Pertenece a alguna organizaci&oacute;n de producci&oacute;n agr&iacute;cola, cr&iacute;a de ganado, aves u otras especies, recursos forestales, recolecci&oacute;n o extracci&oacute;n de especies no maderables, caza o pesca?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP18" id="txtP18" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P18']; ?>" onKeyDown="A(event,this.form.btnP18_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP18_anterior" id="btnP18_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p17')"/></td>
                            <td><input name="btnP18_siguiente" id="btnP18_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p19')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p19" style="display:<?php echo $p19; ?>"> 
                    <label><strong>III. UNIDAD DE PRODUCCI&Oacute;N AGROPECUARIA</strong></label>
                    <table>
                        <tr>
                            <td colspan="2">19. &iquest;Cu&aacute;l es la condici&oacute;n jur&iacute;dica con relaci&oacute;n a la Unidad de Producci&oacute;n Agropecuaria?</td>
                        </tr>
                        <tr>
                            <td colspan="2">A. persona natural</td>
                        </tr>
                        <tr>
                            <td align="right">Individual</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td align="right">Sociedad de hecho</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td colspan="2">B. persona jur&iacute;dica</td>
                        </tr>
                        <tr>
                            <td align="right">Empresa unipersonal</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td align="right">Sociedad an&oacute;nima</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td align="right">Sociedad de responsabilidad limitada</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td align="right">Otras sociedades</td>
                            <td>6</td>
                        </tr>
                        <tr>
                            <td align="right">Cooperativa agropecuaria</td>
                            <td>7</td>
                        </tr>
                        <tr>
                            <td align="right">Del estado</td>
                            <td>8</td>
                        </tr>
                        <tr>
                            <td align="right">Comunidad</td>
                            <td>9</td>
                        </tr>
                        <tr>
                            <td align="right">Otros</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <td align="right"><input class="cuarenta_px" name="txtP19" id="txtP19" type="text" maxlength="2" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P19']; ?>" onKeyDown="A(event,this.form.btnP19_siguiente);" autofocus="autofocus"/></td>
                            <td></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP19_anterior"  id="btnP19_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p18')"/></td>
                            <td><input name="btnP19_siguiente" id="btnP19_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p20')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p20" style="display:<?php echo $p20; ?>">
                    <table>
                        <tr>
                            <td colspan="2">20. En esta Comunidad, periferia de ciudad o en &aacute;rea dispersa &iquest;tiene o trabaja parcelas o tierras, cu&aacute;ntas y cu&aacute;l es la superficie total de todas las parcelas o tierras?</td>
                        </tr>
                        <tr>
                            <td align="right">Si</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td align="right">No</td>
                            <td>2 -&gt; Pase al cap&iacute;tulo VI.</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input class="cuarenta_px" name="txtP20_1" id="txtP20_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P20_1']; ?>" onKeyDown="A(event,this.form.txtP20_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td align="right">N&uacute;mero de parcelas o tierras</td>
                            <td><input class="cuarenta_px" name="txtP20_2" id="txtP20_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P20_2']; ?>" onKeyDown="A(event,this.form.txtP20_3);"/></td>
                        </tr>
                        <tr>
                            <td>Superficie total</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td align="right">Enteros y decimales <input class="text-box" name="txtP20_3" id="txtP20_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P20_3']; ?>" onKeyDown="A(event,this.form.txtP20_4);"/></td>
                            <td>C&oacute;digo unidad de medida <input class="cuarenta_px" name="txtP20_4" id="txtP20_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P20_4']; ?>" onKeyDown="A(event,this.form.btnP20_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP20_anterior"  id="btnP20_anterior"  value="Anterior" type="button" onclick="enviar(this.form,'p19')"/></td>
                            <td><input name="btnP20_siguiente" id="btnP20_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p21')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p21" style="display:<?php echo $p21; ?>">
                    <table>
                        <tr>
                            <td colspan="2">21. En esta UPA &iquest;las parcelas o tierras que trabaja son&hellip;</td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td colspan="3" align="center">SUPERFICIE</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">Enteror y decimales </td>
                            <td>Cod. <br />unidad <br />de medida</td>
                        </tr>
                        <tr>
                            <td>1. en propiedad?</td>
                            <td><input class="text-box" name="txtP21_1_1" id="txtP21_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P21_1_1']; ?>" onKeyDown="A(event,this.form.txtP21_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px" name="txtP21_1_2" id="txtP21_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P21_1_2']; ?>" onKeyDown="A(event,this.form.txtP21_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2. cedida por la comunidad?</td>
                            <td><input class="text-box" name="txtP21_2_1" id="txtP21_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P21_2_1']; ?>" onKeyDown="A(event,this.form.txtP21_2_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP21_2_2" id="txtP21_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P21_2_2']; ?>" onKeyDown="A(event,this.form.txtP21_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3. en arriendo?</td>
                            <td><input class="text-box" name="txtP21_3_1" id="txtP21_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P21_3_1']; ?>" onKeyDown="A(event,this.form.txtP21_3_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP21_3_2" id="txtP21_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P21_3_2']; ?>" onKeyDown="A(event,this.form.txtP21_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>4. cuidada?</td>
                            <td><input class="text-box" name="txtP21_4_1" id="txtP21_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P21_4_1']; ?>" onKeyDown="A(event,this.form.txtP21_4_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP21_4_2" id="txtP21_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P21_4_2']; ?>" onKeyDown="A(event,this.form.txtP21_5_1);"/></td>
                        </tr>
                        <tr>
                            <td>5. al partir o al partido?</td>
                            <td><input class="text-box" name="txtP21_5_1" id="txtP21_5_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P21_5_1']; ?>" onKeyDown="A(event,this.form.txtP21_5_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP21_5_2" id="txtP21_5_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P21_5_2']; ?>" onKeyDown="A(event,this.form.btnP21_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP21_anterior"  id="btnP21_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p20')"/></td>
                            <td><input name="btnP21_siguiente" id="btnP21_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p22')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p22" style="display:<?php echo $p22; ?>">
                    <table>
                        <tr>
                            <td colspan="3">22. &iquest;Estas parcelas o tierras las obtuvo por ...</td>
                        </tr>
                        <tr>
                            <td>1. herencia?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP22_1" id="txtP22_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P22_1']; ?>" onKeyDown="A(event,this.form.txtP22_2);" autofocus="autofocus"/></td>
                        </tr>                                                                        
                        <tr>                                                                         
                            <td>2. compra?</td>                                                      
                            <td>Si 1</td>                                                            
                            <td>No 2</td>                                                            
                            <td><input class="cuarenta_px" name="txtP22_2" id="txtP22_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P22_2']; ?>" onKeyDown="A(event,this.form.txtP22_3);"/></td>
                        </tr>                                                                        
                        <tr>                                                                         
                            <td>3. dotaci&oacute;n?</td>                                             
                            <td>Si 1</td>                                                            
                            <td>No 2</td>                                                            
                            <td><input class="cuarenta_px" name="txtP22_3" id="txtP22_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P22_3']; ?>" onKeyDown="A(event,this.form.txtP22_4);"/></td>
                        </tr>                                                                        
                        <tr>                                                                         
                            <td>4. adjudicaci&oacute;n?</td>                                         
                            <td>Si 1</td>                                                            
                            <td>No 2</td>                                                            
                            <td><input class="cuarenta_px" name="txtP22_4" id="txtP22_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P22_4']; ?>" onKeyDown="A(event,this.form.btnP22_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP22_anterior"  id="btnP22_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p21')"/></td>
                            <td><input name="btnP22_siguiente" id="btnP22_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p23')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p23" style="display:<?php echo $p23; ?>; top: 350px; position: absolute;"> 
                    <label><strong>IV. USO DE LA TIERRA</strong></label>
                    <table>
                        <tr>
                            <td colspan="3">23. &iquest;Tuvo o manej&oacute; cultivos en la campa&ntilde;a de invierno 2012?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 24</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP23_1" id="txtP23_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_1']; ?>" onKeyDown="A(event,this.form.txtP23_1_1);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td rowspan="3"></td>
                            <td rowspan="3">(1)<br>N&ordm; <br />parcela</td>
                            <td rowspan="3">(2)<br>Nombre del cultivo por parcela</td>
                            <td colspan="2">(3)<br>Superficie sembrada</td>
                            <td>(4)<br>Riego</td>
                            <td rowspan="3">(5)<br>Mes de <br />siembra</td>
                            <td colspan="2">(6)<br>Cantidad cosechada</td>
                            <td rowspan="3">(7)<br>Mes de <br />cosecha</td>
                            <td colspan="3">(8)<br>Destino de la cosecha</td>
                        </tr>
                        <tr>
                            <td rowspan="2">Enteros y decimales</td>
                            <td rowspan="2">Codigo <br />unidad<br />de medida</td>
                            <td rowspan="2">1. con riego<br />2. sin riego</td>
                            <td rowspan="2">Enteros decimales</td>
                            <td rowspan="2">Codigo <br />unidad<br />de medida<br />peso</td>
                            <td>venta o<br />trueque</td>
                            <td>consumo <br />del hogar </td>
                            <td>otros</td>
                        </tr>
                        <tr>
                            <td>1. Si<br />2. No</td>
                            <td>1. Si<br />2. No</td>
                            <td>1. Si<br />2. No</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td><input class="cuarenta_px" name="txtP23_1_1" id="txtP23_1_1" type="text" onfocus="selecciona_value(this)"  value="<?php echo $row_datos['P23_1_1']; ?>" onKeyDown="A(event,this.form.txtP23_1_2);"/></td>
                            <td><input class="trecientos_px" name="txtP23_1_2" id="txtP23_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_1_2']; ?>" onKeyDown="A(event,this.form.txtP23_1_3);"/></td>
                            <td><input class="text-box" name="txtP23_1_3" id="txtP23_1_3" type="text"  onfocus="selecciona_value(this)"  value="<?php echo $row_datos['P23_1_3']; ?>" onKeyDown="A(event,this.form.txtP23_1_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_1_4" id="txtP23_1_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_1_4']; ?>" onKeyDown="A(event,this.form.txtP23_1_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_1_5" id="txtP23_1_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_1_5']; ?>" onKeyDown="A(event,this.form.txtP23_1_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_1_6" id="txtP23_1_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_1_6']; ?>" onKeyDown="A(event,this.form.txtP23_1_7);"/></td>
                            <td><input class="text-box" name="txtP23_1_7" id="txtP23_1_7" type="text"  onfocus="selecciona_value(this)"  value="<?php echo $row_datos['P23_1_7']; ?>" onKeyDown="A(event,this.form.txtP23_1_8);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_1_8" id="txtP23_1_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_1_8']; ?>" onKeyDown="A(event,this.form.txtP23_1_9);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_1_9" id="txtP23_1_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_1_9']; ?>" onKeyDown="A(event,this.form.txtP23_1_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_1_10" id="txtP23_1_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_1_10']; ?>" onKeyDown="A(event,this.form.txtP23_1_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_1_11" id="txtP23_1_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_1_11']; ?>" onKeyDown="A(event,this.form.txtP23_1_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_1_12" id="txtP23_1_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_1_12']; ?>" onKeyDown="A(event,this.form.txtP23_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><input class="cuarenta_px" name="txtP23_2_1" id="txtP23_2_1" type="text" onfocus="selecciona_value(this)"  value="<?php echo $row_datos['P23_2_1']; ?>" onKeyDown="A(event,this.form.txtP23_2_2);"/></td>
                            <td><input class="trecientos_px" name="txtP23_2_2" id="txtP23_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_2_2']; ?>" onKeyDown="A(event,this.form.txtP23_2_3);"/></td>
                            <td><input class="text-box" name="txtP23_2_3" id="txtP23_2_3" type="text"  onfocus="selecciona_value(this)"  value="<?php echo $row_datos['P23_2_3']; ?>" onKeyDown="A(event,this.form.txtP23_2_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_2_4" id="txtP23_2_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_2_4']; ?>" onKeyDown="A(event,this.form.txtP23_2_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_2_5" id="txtP23_2_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_2_5']; ?>" onKeyDown="A(event,this.form.txtP23_2_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_2_6" id="txtP23_2_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_2_6']; ?>" onKeyDown="A(event,this.form.txtP23_2_7);"/></td>
                            <td><input class="text-box" name="txtP23_2_7" id="txtP23_2_7" type="text"  onfocus="selecciona_value(this)"  value="<?php echo $row_datos['P23_2_7']; ?>" onKeyDown="A(event,this.form.txtP23_2_8);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_2_8"  id="txtP23_2_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_2_8']; ?>" onKeyDown="A(event,this.form.txtP23_2_9);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_2_9"  id="txtP23_2_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_2_9']; ?>" onKeyDown="A(event,this.form.txtP23_2_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_2_10" id="txtP23_2_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_2_10']; ?>" onKeyDown="A(event,this.form.txtP23_2_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_2_11" id="txtP23_2_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_2_11']; ?>" onKeyDown="A(event,this.form.txtP23_2_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_2_12" id="txtP23_2_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_2_12']; ?>" onKeyDown="A(event,this.form.txtP23_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><input class="cuarenta_px" name="txtP23_3_1" id="txtP23_3_1" type="text" onfocus="selecciona_value(this)"  value="<?php echo $row_datos['P23_3_1']; ?>" onKeyDown="A(event,this.form.txtP23_3_2);"/></td>
                            <td><input class="trecientos_px" name="txtP23_3_2" id="txtP23_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_3_2']; ?>" onKeyDown="A(event,this.form.txtP23_3_3);"/></td>
                            <td><input class="text-box" name="txtP23_3_3" id="txtP23_3_3" type="text"  onfocus="selecciona_value(this)"  value="<?php echo $row_datos['P23_3_3']; ?>" onKeyDown="A(event,this.form.txtP23_3_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_3_4" id="txtP23_3_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_3_4']; ?>" onKeyDown="A(event,this.form.txtP23_3_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_3_5" id="txtP23_3_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_3_5']; ?>" onKeyDown="A(event,this.form.txtP23_3_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_3_6" id="txtP23_3_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_3_6']; ?>" onKeyDown="A(event,this.form.txtP23_3_7);"/></td>
                            <td><input class="text-box" name="txtP23_3_7" id="txtP23_3_7" type="text"  onfocus="selecciona_value(this)"  value="<?php echo $row_datos['P23_3_7']; ?>" onKeyDown="A(event,this.form.txtP23_3_8);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_3_8"  id="txtP23_3_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_3_8']; ?>" onKeyDown="A(event,this.form.txtP23_3_9);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_3_9"  id="txtP23_3_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_3_9']; ?>" onKeyDown="A(event,this.form.txtP23_3_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_3_10" id="txtP23_3_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_3_10']; ?>" onKeyDown="A(event,this.form.txtP23_3_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_3_11" id="txtP23_3_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_3_11']; ?>" onKeyDown="A(event,this.form.txtP23_3_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_3_12" id="txtP23_3_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_3_12']; ?>" onKeyDown="A(event,this.form.txtP23_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><input class="cuarenta_px" name="txtP23_4_1" id="txtP23_4_1" type="text" onfocus="selecciona_value(this)"  value="<?php echo $row_datos['P23_4_1']; ?>" onKeyDown="A(event,this.form.txtP23_4_2);"/></td>
                            <td><input class="trecientos_px" name="txtP23_4_2" id="txtP23_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_4_2']; ?>" onKeyDown="A(event,this.form.txtP23_4_3);"/></td>
                            <td><input class="text-box" name="txtP23_4_3" id="txtP23_4_3" type="text"  onfocus="selecciona_value(this)"  value="<?php echo $row_datos['P23_4_3']; ?>" onKeyDown="A(event,this.form.txtP23_4_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_4_4" id="txtP23_4_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_4_4']; ?>" onKeyDown="A(event,this.form.txtP23_4_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_4_5" id="txtP23_4_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_4_5']; ?>" onKeyDown="A(event,this.form.txtP23_4_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_4_6" id="txtP23_4_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_4_6']; ?>" onKeyDown="A(event,this.form.txtP23_4_7);"/></td>
                            <td><input class="text-box" name="txtP23_4_7" id="txtP23_4_7" type="text"  onfocus="selecciona_value(this)"  value="<?php echo $row_datos['P23_4_7']; ?>" onKeyDown="A(event,this.form.txtP23_4_8);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_4_8"  id="txtP23_4_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_4_8']; ?>" onKeyDown="A(event,this.form.txtP23_4_9);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_4_9"  id="txtP23_4_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_4_9']; ?>" onKeyDown="A(event,this.form.txtP23_4_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_4_10" id="txtP23_4_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_4_10']; ?>" onKeyDown="A(event,this.form.txtP23_4_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_4_11" id="txtP23_4_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_4_11']; ?>" onKeyDown="A(event,this.form.txtP23_4_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_4_12" id="txtP23_4_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_4_12']; ?>" onKeyDown="A(event,this.form.txtP23_5_1);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><input class="cuarenta_px"   name="txtP23_5_1" id="txtP23_5_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_5_1']; ?>" onKeyDown="A(event,this.form.txtP23_5_2);"/></td>
                            <td><input class="trecientos_px" name="txtP23_5_2" id="txtP23_5_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_5_2']; ?>" onKeyDown="A(event,this.form.txtP23_5_3);"/></td>
                            <td><input class="text-box"      name="txtP23_5_3" id="txtP23_5_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_5_3']; ?>" onKeyDown="A(event,this.form.txtP23_5_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_5_4"  id="txtP23_5_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_5_4']; ?>" onKeyDown="A(event,this.form.txtP23_5_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_5_5"  id="txtP23_5_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_5_5']; ?>" onKeyDown="A(event,this.form.txtP23_5_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_5_6"  id="txtP23_5_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_5_6']; ?>" onKeyDown="A(event,this.form.txtP23_5_7);"/></td>
                            <td><input class="text-box"    name="txtP23_5_7"  id="txtP23_5_7" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_5_7']; ?>" onKeyDown="A(event,this.form.txtP23_5_8);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_5_8"  id="txtP23_5_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_5_8']; ?>" onKeyDown="A(event,this.form.txtP23_5_9);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_5_9"  id="txtP23_5_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_5_9']; ?>" onKeyDown="A(event,this.form.txtP23_5_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_5_10" id="txtP23_5_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_5_10']; ?>" onKeyDown="A(event,this.form.txtP23_5_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_5_11" id="txtP23_5_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_5_11']; ?>" onKeyDown="A(event,this.form.txtP23_5_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_5_12" id="txtP23_5_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_5_12']; ?>" onKeyDown="A(event,this.form.txtP23_6_1);"/></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td><input class="cuarenta_px"   name="txtP23_6_1" id="txtP23_6_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_6_1']; ?>"  onKeyDown="A(event,this.form.txtP23_6_2);"/></td>
                            <td><input class="trecientos_px" name="txtP23_6_2" id="txtP23_6_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_6_2']; ?>"  onKeyDown="A(event,this.form.txtP23_6_3);"/></td>
                            <td><input class="text-box"    name="txtP23_6_3"  id="txtP23_6_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_6_3']; ?>"  onKeyDown="A(event,this.form.txtP23_6_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_6_4"  id="txtP23_6_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_6_4']; ?>"  onKeyDown="A(event,this.form.txtP23_6_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_6_5"  id="txtP23_6_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_6_5']; ?>"  onKeyDown="A(event,this.form.txtP23_6_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_6_6"  id="txtP23_6_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_6_6']; ?>"  onKeyDown="A(event,this.form.txtP23_6_7);"/></td>
                            <td><input class="text-box"    name="txtP23_6_7"  id="txtP23_6_7" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_6_7']; ?>"  onKeyDown="A(event,this.form.txtP23_6_8);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_6_8"  id="txtP23_6_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_6_8']; ?>"  onKeyDown="A(event,this.form.txtP23_6_9);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_6_9"  id="txtP23_6_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_6_9']; ?>"  onKeyDown="A(event,this.form.txtP23_6_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_6_10" id="txtP23_6_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_6_10']; ?>" onKeyDown="A(event,this.form.txtP23_6_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_6_11" id="txtP23_6_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_6_11']; ?>" onKeyDown="A(event,this.form.txtP23_6_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_6_12" id="txtP23_6_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_6_12']; ?>" onKeyDown="A(event,this.form.txtP23_7_1);"/></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td><input class="cuarenta_px"   name="txtP23_7_1" id="txtP23_7_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_7_1']; ?>"  onKeyDown="A(event,this.form.txtP23_7_2);"/></td>
                            <td><input class="trecientos_px" name="txtP23_7_2" id="txtP23_7_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_7_2']; ?>"  onKeyDown="A(event,this.form.txtP23_7_3);"/></td>
                            <td><input class="text-box"    name="txtP23_7_3"  id="txtP23_7_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_7_3']; ?>"  onKeyDown="A(event,this.form.txtP23_7_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_7_4"  id="txtP23_7_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_7_4']; ?>"  onKeyDown="A(event,this.form.txtP23_7_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_7_5"  id="txtP23_7_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_7_5']; ?>"  onKeyDown="A(event,this.form.txtP23_7_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_7_6"  id="txtP23_7_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_7_6']; ?>"  onKeyDown="A(event,this.form.txtP23_7_7);"/></td>
                            <td><input class="text-box"    name="txtP23_7_7"  id="txtP23_7_7" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_7_7']; ?>"  onKeyDown="A(event,this.form.txtP23_7_8);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_7_8"  id="txtP23_7_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_7_8']; ?>"  onKeyDown="A(event,this.form.txtP23_7_9);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_7_9"  id="txtP23_7_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_7_9']; ?>"  onKeyDown="A(event,this.form.txtP23_7_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_7_10" id="txtP23_7_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_7_10']; ?>" onKeyDown="A(event,this.form.txtP23_7_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_7_11" id="txtP23_7_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_7_11']; ?>" onKeyDown="A(event,this.form.txtP23_7_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP23_7_12" id="txtP23_7_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P23_7_12']; ?>" onKeyDown="A(event,this.form.btnP23_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP23_anterior"  id="btnP23_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p22')"/></td>
                            <td><input name="btnP23_siguiente" id="btnP23_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p24')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p24" style="display:<?php echo $p24; ?>; top: 350px; position: absolute;">
                    <table>          
                        <tr>
                            <td colspan="3">24. &iquest;Tuvo cultivos de verano, de julio de 2012 a junio de 2013? <br>(incluya plantaciones de frutales en superficies regulares)</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 25</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP24_1" id="txtP24_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P']; ?>" onKeyDown="A(event,this.form.txtP24_1_1);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td rowspan="3"></td>
                            <td rowspan="3">(1)<br />N&ordm; <br />parcela</td>
                            <td rowspan="3">(2)<br />Nombre del cultivo por parcela</td>
                            <td rowspan="3">(3)<br />Tipo <br />de <br />cultivo</td>
                            <td colspan="2">(4)<br />Superficie sembrada</td>
                            <td>(5)<br />Riego</td>
                            <td rowspan="3">(6)<br />Mes de <br />siembra</td>
                            <td rowspan="3">(7)<br />A&ntilde;o de <br />plantaci&oacute;n <br />cultivos <br />permanettes</td>
                            <td colspan="2">(8)<br />Cantidad cosechada</td>
                            <td rowspan="3">(9)<br />Mes de <br />cosecha</td>
                            <td colspan="3">(10)<br />Destino de la cosecha</td>
                        </tr>
                        <tr>
                            <td rowspan="2">Enteros y decimales</td>
                            <td rowspan="2">Codigo <br />unidad<br />de medida</td>
                            <td rowspan="2">1. con riego<br />2. sin riego</td>
                            <td rowspan="2">Enteros decimales</td>
                            <td rowspan="2">Codigo <br />unidad<br />de medida<br />peso</td>
                            <td>venta o<br />trueque</td>
                            <td>consumo <br />del hogar </td>
                            <td>otros</td>
                        </tr>
                        <tr>
                            <td>1. Si<br />2. No</td>
                            <td>1. Si<br />2. No</td>
                            <td>1. Si<br />2. No</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td><input class="cuarenta_px"   name="txtP24_1_1" id="txtP24_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_1_1']; ?>" onKeyDown="A(event,this.form.txtP24_1_2);"/></td>
                            <td><input class="trecientos_px" name="txtP24_1_2" id="txtP24_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_1_2']; ?>" onKeyDown="A(event,this.form.txtP24_1_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP24_1_3" id="txtP24_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_1_3']; ?>" onKeyDown="A(event,this.form.txtP24_1_4);"/></td>
                            <td><input class="text-box"    name="txtP24_1_4"  id="txtP24_1_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_1_4']; ?>" onKeyDown="A(event,this.form.txtP24_1_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_1_5"  id="txtP24_1_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_1_5']; ?>" onKeyDown="A(event,this.form.txtP24_1_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_1_6"  id="txtP24_1_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_1_6']; ?>" onKeyDown="A(event,this.form.txtP24_1_7);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_1_7"  id="txtP24_1_7" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_1_7']; ?>" onKeyDown="A(event,this.form.txtP24_1_8);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_1_8"  id="txtP24_1_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_1_8']; ?>" onKeyDown="A(event,this.form.txtP24_1_9);"/></td>
                            <td><input class="text-box"    name="txtP24_1_9"  id="txtP24_1_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_1_9']; ?>" onKeyDown="A(event,this.form.txtP24_1_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_1_10" id="txtP24_1_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_1_10']; ?>" onKeyDown="A(event,this.form.txtP24_1_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_1_11" id="txtP24_1_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_1_11']; ?>" onKeyDown="A(event,this.form.txtP24_1_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_1_12" id="txtP24_1_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_1_12']; ?>" onKeyDown="A(event,this.form.txtP24_1_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_1_13" id="txtP24_1_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_1_13']; ?>" onKeyDown="A(event,this.form.txtP24_1_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_1_14" id="txtP24_1_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_1_14']; ?>" onKeyDown="A(event,this.form.txtP24_2_1);" /></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><input class="cuarenta_px"   name="txtP24_2_1" id="txtP24_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_2_1']; ?>"  onKeyDown="A(event,this.form.txtP24_2_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_2_2" id="txtP24_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_2_2']; ?>"  onKeyDown="A(event,this.form.txtP24_2_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_2_3" id="txtP24_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_2_3']; ?>"  onKeyDown="A(event,this.form.txtP24_2_4);" /></td>
                            <td><input class="text-box"    name="txtP24_2_4"  id="txtP24_2_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_2_4']; ?>"  onKeyDown="A(event,this.form.txtP24_2_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_2_5"  id="txtP24_2_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_2_5']; ?>"  onKeyDown="A(event,this.form.txtP24_2_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_2_6"  id="txtP24_2_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_2_6']; ?>"  onKeyDown="A(event,this.form.txtP24_2_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_2_7"  id="txtP24_2_7" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_2_7']; ?>"  onKeyDown="A(event,this.form.txtP24_2_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_2_8"  id="txtP24_2_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_2_8']; ?>"  onKeyDown="A(event,this.form.txtP24_2_9);" /></td>
                            <td><input class="text-box"    name="txtP24_2_9"  id="txtP24_2_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_2_9']; ?>"  onKeyDown="A(event,this.form.txtP24_2_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_2_10" id="txtP24_2_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_2_10']; ?>" onKeyDown="A(event,this.form.txtP24_2_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_2_11" id="txtP24_2_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_2_11']; ?>" onKeyDown="A(event,this.form.txtP24_2_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_2_12" id="txtP24_2_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_2_12']; ?>" onKeyDown="A(event,this.form.txtP24_2_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_2_13" id="txtP24_2_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_2_13']; ?>" onKeyDown="A(event,this.form.txtP24_2_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_2_14" id="txtP24_2_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_2_14']; ?>" onKeyDown="A(event,this.form.txtP24_3_1);" /></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><input class="cuarenta_px"   name="txtP24_3_1" id="txtP24_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_3_1']; ?>"  onKeyDown="A(event,this.form.txtP24_3_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_3_2" id="txtP24_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_3_2']; ?>"  onKeyDown="A(event,this.form.txtP24_3_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_3_3" id="txtP24_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_3_3']; ?>"  onKeyDown="A(event,this.form.txtP24_3_4);" /></td>
                            <td><input class="text-box"    name="txtP24_3_4"  id="txtP24_3_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_3_4']; ?>"  onKeyDown="A(event,this.form.txtP24_3_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_3_5"  id="txtP24_3_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_3_5']; ?>"  onKeyDown="A(event,this.form.txtP24_3_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_3_6"  id="txtP24_3_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_3_6']; ?>"  onKeyDown="A(event,this.form.txtP24_3_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_3_7"  id="txtP24_3_7" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_3_7']; ?>"  onKeyDown="A(event,this.form.txtP24_3_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_3_8"  id="txtP24_3_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_3_8']; ?>"  onKeyDown="A(event,this.form.txtP24_3_9);" /></td>
                            <td><input class="text-box"    name="txtP24_3_9"  id="txtP24_3_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_3_9']; ?>"  onKeyDown="A(event,this.form.txtP24_3_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_3_10" id="txtP24_3_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_3_10']; ?>" onKeyDown="A(event,this.form.txtP24_3_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_3_11" id="txtP24_3_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_3_11']; ?>" onKeyDown="A(event,this.form.txtP24_3_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_3_12" id="txtP24_3_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_3_12']; ?>" onKeyDown="A(event,this.form.txtP24_3_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_3_13" id="txtP24_3_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_3_13']; ?>" onKeyDown="A(event,this.form.txtP24_3_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_3_14" id="txtP24_3_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_3_14']; ?>" onKeyDown="A(event,this.form.txtP24_4_1);" /></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><input class="cuarenta_px"   name="txtP24_4_1" id="txtP24_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_4_1']; ?>" onKeyDown="A(event,this.form.txtP24_4_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_4_2" id="txtP24_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_4_2']; ?>" onKeyDown="A(event,this.form.txtP24_4_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_4_3" id="txtP24_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_4_3']; ?>" onKeyDown="A(event,this.form.txtP24_4_4);" /></td>
                            <td><input class="text-box"    name="txtP24_4_4"  id="txtP24_4_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_4_4']; ?>" onKeyDown="A(event,this.form.txtP24_4_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_4_5"  id="txtP24_4_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_4_5']; ?>" onKeyDown="A(event,this.form.txtP24_4_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_4_6"  id="txtP24_4_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_4_6']; ?>" onKeyDown="A(event,this.form.txtP24_4_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_4_7"  id="txtP24_4_7" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_4_7']; ?>" onKeyDown="A(event,this.form.txtP24_4_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_4_8"  id="txtP24_4_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_4_8']; ?>" onKeyDown="A(event,this.form.txtP24_4_9);" /></td>
                            <td><input class="text-box"    name="txtP24_4_9"  id="txtP24_4_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_4_9']; ?>" onKeyDown="A(event,this.form.txtP24_4_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_4_10" id="txtP24_4_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_4_10']; ?>" onKeyDown="A(event,this.form.txtP24_4_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_4_11" id="txtP24_4_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_4_11']; ?>" onKeyDown="A(event,this.form.txtP24_4_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_4_12" id="txtP24_4_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_4_12']; ?>" onKeyDown="A(event,this.form.txtP24_4_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_4_13" id="txtP24_4_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_4_13']; ?>" onKeyDown="A(event,this.form.txtP24_4_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_4_14" id="txtP24_4_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_4_14']; ?>" onKeyDown="A(event,this.form.txtP24_5_1);" /></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><input class="cuarenta_px"   name="txtP24_5_1" id="txtP24_5_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_5_1']; ?>"  onKeyDown="A(event,this.form.txtP24_5_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_5_2" id="txtP24_5_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_5_2']; ?>"  onKeyDown="A(event,this.form.txtP24_5_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_5_3" id="txtP24_5_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_5_3']; ?>"  onKeyDown="A(event,this.form.txtP24_5_4);" /></td>
                            <td><input class="text-box"    name="txtP24_5_4"  id="txtP24_5_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_5_4']; ?>"  onKeyDown="A(event,this.form.txtP24_5_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_5_5"  id="txtP24_5_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_5_5']; ?>"  onKeyDown="A(event,this.form.txtP24_5_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_5_6"  id="txtP24_5_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_5_6']; ?>"  onKeyDown="A(event,this.form.txtP24_5_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_5_7"  id="txtP24_5_7" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_5_7']; ?>"  onKeyDown="A(event,this.form.txtP24_5_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_5_8"  id="txtP24_5_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_5_8']; ?>"  onKeyDown="A(event,this.form.txtP24_5_9);" /></td>
                            <td><input class="text-box"    name="txtP24_5_9"  id="txtP24_5_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_5_9']; ?>"  onKeyDown="A(event,this.form.txtP24_5_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_5_10" id="txtP24_5_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_5_10']; ?>" onKeyDown="A(event,this.form.txtP24_5_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_5_11" id="txtP24_5_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_5_11']; ?>" onKeyDown="A(event,this.form.txtP24_5_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_5_12" id="txtP24_5_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_5_12']; ?>" onKeyDown="A(event,this.form.txtP24_5_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_5_13" id="txtP24_5_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_5_13']; ?>" onKeyDown="A(event,this.form.txtP24_5_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_5_14" id="txtP24_5_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_5_14']; ?>" onKeyDown="A(event,this.form.txtP24_6_1);" /></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td><input class="cuarenta_px"   name="txtP24_6_1" id="txtP24_6_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_6_1']; ?>"  onKeyDown="A(event,this.form.txtP24_6_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_6_2" id="txtP24_6_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_6_2']; ?>"  onKeyDown="A(event,this.form.txtP24_6_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_6_3" id="txtP24_6_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_6_3']; ?>"  onKeyDown="A(event,this.form.txtP24_6_4);" /></td>
                            <td><input class="text-box"    name="txtP24_6_4"  id="txtP24_6_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_6_4']; ?>"  onKeyDown="A(event,this.form.txtP24_6_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_6_5"  id="txtP24_6_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_6_5']; ?>"  onKeyDown="A(event,this.form.txtP24_6_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_6_6"  id="txtP24_6_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_6_6']; ?>"  onKeyDown="A(event,this.form.txtP24_6_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_6_7"  id="txtP24_6_7" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_6_7']; ?>"  onKeyDown="A(event,this.form.txtP24_6_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_6_8"  id="txtP24_6_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_6_8']; ?>"  onKeyDown="A(event,this.form.txtP24_6_9);" /></td>
                            <td><input class="text-box"    name="txtP24_6_9"  id="txtP24_6_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_6_9']; ?>"  onKeyDown="A(event,this.form.txtP24_6_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_6_10" id="txtP24_6_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_6_10']; ?>" onKeyDown="A(event,this.form.txtP24_6_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_6_11" id="txtP24_6_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_6_11']; ?>" onKeyDown="A(event,this.form.txtP24_6_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_6_12" id="txtP24_6_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_6_12']; ?>" onKeyDown="A(event,this.form.txtP24_6_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_6_13" id="txtP24_6_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_6_13']; ?>" onKeyDown="A(event,this.form.txtP24_6_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_6_14" id="txtP24_6_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_6_14']; ?>" onKeyDown="A(event,this.form.txtP24_7_1);" /></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td><input class="cuarenta_px"   name="txtP24_7_1" id="txtP24_7_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_7_1']; ?>"  onKeyDown="A(event,this.form.txtP24_7_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_7_2" id="txtP24_7_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_7_2']; ?>"  onKeyDown="A(event,this.form.txtP24_7_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_7_3" id="txtP24_7_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_7_3']; ?>"  onKeyDown="A(event,this.form.txtP24_7_4);" /></td>
                            <td><input class="text-box"    name="txtP24_7_4"  id="txtP24_7_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_7_4']; ?>"  onKeyDown="A(event,this.form.txtP24_7_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_7_5"  id="txtP24_7_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_7_5']; ?>"  onKeyDown="A(event,this.form.txtP24_7_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_7_6"  id="txtP24_7_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_7_6']; ?>"  onKeyDown="A(event,this.form.txtP24_7_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_7_7"  id="txtP24_7_7" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_7_7']; ?>"  onKeyDown="A(event,this.form.txtP24_7_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_7_8"  id="txtP24_7_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_7_8']; ?>"  onKeyDown="A(event,this.form.txtP24_7_9);" /></td>
                            <td><input class="text-box"    name="txtP24_7_9"  id="txtP24_7_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_7_9']; ?>"  onKeyDown="A(event,this.form.txtP24_7_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_7_10" id="txtP24_7_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_7_10']; ?>" onKeyDown="A(event,this.form.txtP24_7_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_7_11" id="txtP24_7_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_7_11']; ?>" onKeyDown="A(event,this.form.txtP24_7_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_7_12" id="txtP24_7_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_7_12']; ?>" onKeyDown="A(event,this.form.txtP24_7_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_7_13" id="txtP24_7_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_7_13']; ?>" onKeyDown="A(event,this.form.txtP24_7_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_7_14" id="txtP24_7_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_7_14']; ?>" onKeyDown="A(event,this.form.txtP24_8_1);" /></td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td><input class="cuarenta_px"   name="txtP24_8_1" id="txtP24_8_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_8_1']; ?>"  onKeyDown="A(event,this.form.txtP24_8_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_8_2" id="txtP24_8_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_8_2']; ?>"  onKeyDown="A(event,this.form.txtP24_8_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_8_3" id="txtP24_8_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_8_3']; ?>"  onKeyDown="A(event,this.form.txtP24_8_4);" /></td>
                            <td><input class="text-box"    name="txtP24_8_4"  id="txtP24_8_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_8_4']; ?>"  onKeyDown="A(event,this.form.txtP24_8_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_8_5"  id="txtP24_8_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_8_5']; ?>"  onKeyDown="A(event,this.form.txtP24_8_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_8_6"  id="txtP24_8_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_8_6']; ?>"  onKeyDown="A(event,this.form.txtP24_8_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_8_7"  id="txtP24_8_7" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_8_7']; ?>"  onKeyDown="A(event,this.form.txtP24_8_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_8_8"  id="txtP24_8_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_8_8']; ?>"  onKeyDown="A(event,this.form.txtP24_8_9);" /></td>
                            <td><input class="text-box"    name="txtP24_8_9"  id="txtP24_8_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_8_9']; ?>"  onKeyDown="A(event,this.form.txtP24_8_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_8_10" id="txtP24_8_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_8_10']; ?>" onKeyDown="A(event,this.form.txtP24_8_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_8_11" id="txtP24_8_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_8_11']; ?>" onKeyDown="A(event,this.form.txtP24_8_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_8_12" id="txtP24_8_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_8_12']; ?>" onKeyDown="A(event,this.form.txtP24_8_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_8_13" id="txtP24_8_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_8_13']; ?>" onKeyDown="A(event,this.form.txtP24_8_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_8_14" id="txtP24_8_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_8_14']; ?>" onKeyDown="A(event,this.form.txtP24_9_1);" /></td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td><input class="cuarenta_px"   name="txtP24_9_1" id="txtP24_9_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_9_1']; ?>"  onKeyDown="A(event,this.form.txtP24_9_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_9_2" id="txtP24_9_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_9_2']; ?>"  onKeyDown="A(event,this.form.txtP24_9_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_9_3" id="txtP24_9_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_9_3']; ?>"  onKeyDown="A(event,this.form.txtP24_9_4);" /></td>
                            <td><input class="text-box"    name="txtP24_9_4"  id="txtP24_9_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_9_4']; ?>"  onKeyDown="A(event,this.form.txtP24_9_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_9_5"  id="txtP24_9_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_9_5']; ?>"  onKeyDown="A(event,this.form.txtP24_9_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_9_6"  id="txtP24_9_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_9_6']; ?>"  onKeyDown="A(event,this.form.txtP24_9_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_9_7"  id="txtP24_9_7" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_9_7']; ?>"  onKeyDown="A(event,this.form.txtP24_9_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_9_8"  id="txtP24_9_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_9_8']; ?>"  onKeyDown="A(event,this.form.txtP24_9_9);" /></td>
                            <td><input class="text-box"    name="txtP24_9_9"  id="txtP24_9_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_9_9']; ?>"  onKeyDown="A(event,this.form.txtP24_9_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_9_10" id="txtP24_9_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_9_10']; ?>" onKeyDown="A(event,this.form.txtP24_9_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_9_11" id="txtP24_9_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_9_11']; ?>" onKeyDown="A(event,this.form.txtP24_9_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_9_12" id="txtP24_9_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_9_12']; ?>" onKeyDown="A(event,this.form.txtP24_9_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_9_13" id="txtP24_9_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_9_13']; ?>" onKeyDown="A(event,this.form.txtP24_9_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_9_14" id="txtP24_9_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_9_14']; ?>" onKeyDown="A(event,this.form.txtP24_10_1);" /></td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td><input class="cuarenta_px"   name="txtP24_10_1" id="txtP24_10_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_10_1']; ?>"  onKeyDown="A(event,this.form.txtP24_10_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_10_2" id="txtP24_10_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_10_2']; ?>"  onKeyDown="A(event,this.form.txtP24_10_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_10_3" id="txtP24_10_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_10_3']; ?>"  onKeyDown="A(event,this.form.txtP24_10_4);" /></td>
                            <td><input class="text-box"    name="txtP24_10_4"  id="txtP24_10_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_10_4']; ?>"  onKeyDown="A(event,this.form.txtP24_10_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_10_5"  id="txtP24_10_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_10_5']; ?>"  onKeyDown="A(event,this.form.txtP24_10_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_10_6"  id="txtP24_10_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_10_6']; ?>"  onKeyDown="A(event,this.form.txtP24_10_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_10_7"  id="txtP24_10_7" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_10_7']; ?>"  onKeyDown="A(event,this.form.txtP24_10_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_10_8"  id="txtP24_10_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_10_8']; ?>"  onKeyDown="A(event,this.form.txtP24_10_9);" /></td>
                            <td><input class="text-box"    name="txtP24_10_9"  id="txtP24_10_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_10_9']; ?>"  onKeyDown="A(event,this.form.txtP24_10_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_10_10" id="txtP24_10_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_10_10']; ?>" onKeyDown="A(event,this.form.txtP24_10_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_10_11" id="txtP24_10_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_10_11']; ?>" onKeyDown="A(event,this.form.txtP24_10_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_10_12" id="txtP24_10_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_10_12']; ?>" onKeyDown="A(event,this.form.txtP24_10_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_10_13" id="txtP24_10_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_10_13']; ?>" onKeyDown="A(event,this.form.txtP24_10_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_10_14" id="txtP24_10_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_10_14']; ?>" onKeyDown="A(event,this.form.txtP24_11_1);" /></td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td><input class="cuarenta_px"   name="txtP24_11_1" id="txtP24_11_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_11_1']; ?>"  onKeyDown="A(event,this.form.txtP24_11_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_11_2" id="txtP24_11_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_11_2']; ?>"  onKeyDown="A(event,this.form.txtP24_11_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_11_3" id="txtP24_11_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_11_3']; ?>"  onKeyDown="A(event,this.form.txtP24_11_4);" /></td>
                            <td><input class="text-box"    name="txtP24_11_4"  id="txtP24_11_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_11_4']; ?>"  onKeyDown="A(event,this.form.txtP24_11_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_11_5"  id="txtP24_11_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_11_5']; ?>"  onKeyDown="A(event,this.form.txtP24_11_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_11_6"  id="txtP24_11_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_11_6']; ?>"  onKeyDown="A(event,this.form.txtP24_11_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_11_7"  id="txtP24_11_7" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_11_7']; ?>"  onKeyDown="A(event,this.form.txtP24_11_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_11_8"  id="txtP24_11_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_11_8']; ?>"  onKeyDown="A(event,this.form.txtP24_11_9);" /></td>
                            <td><input class="text-box"    name="txtP24_11_9"  id="txtP24_11_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_11_9']; ?>"  onKeyDown="A(event,this.form.txtP24_11_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_11_10" id="txtP24_11_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_11_10']; ?>" onKeyDown="A(event,this.form.txtP24_11_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_11_11" id="txtP24_11_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_11_11']; ?>" onKeyDown="A(event,this.form.txtP24_11_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_11_12" id="txtP24_11_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_11_12']; ?>" onKeyDown="A(event,this.form.txtP24_11_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_11_13" id="txtP24_11_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_11_13']; ?>" onKeyDown="A(event,this.form.txtP24_11_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_11_14" id="txtP24_11_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_11_14']; ?>" onKeyDown="A(event,this.form.txtP24_12_1);" /></td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td><input class="cuarenta_px"   name="txtP24_12_1" id="txtP24_12_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_12_1']; ?>" onKeyDown="A(event,this.form.txtP24_12_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_12_2" id="txtP24_12_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_12_2']; ?>" onKeyDown="A(event,this.form.txtP24_12_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_12_3" id="txtP24_12_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_12_3']; ?>" onKeyDown="A(event,this.form.txtP24_12_4);" /></td>
                            <td><input class="text-box"    name="txtP24_12_4"  id="txtP24_12_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_12_4']; ?>" onKeyDown="A(event,this.form.txtP24_12_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_12_5"  id="txtP24_12_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_12_5']; ?>" onKeyDown="A(event,this.form.txtP24_12_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_12_6"  id="txtP24_12_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_12_6']; ?>" onKeyDown="A(event,this.form.txtP24_12_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_12_7"  id="txtP24_12_7" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_12_7']; ?>" onKeyDown="A(event,this.form.txtP24_12_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_12_8"  id="txtP24_12_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_12_8']; ?>" onKeyDown="A(event,this.form.txtP24_12_9);" /></td>
                            <td><input class="text-box"    name="txtP24_12_9"  id="txtP24_12_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_12_9']; ?>" onKeyDown="A(event,this.form.txtP24_12_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_12_10" id="txtP24_12_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_12_10']; ?>" onKeyDown="A(event,this.form.txtP24_12_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_12_11" id="txtP24_12_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_12_11']; ?>" onKeyDown="A(event,this.form.txtP24_12_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_12_12" id="txtP24_12_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_12_12']; ?>" onKeyDown="A(event,this.form.txtP24_12_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_12_13" id="txtP24_12_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_12_13']; ?>" onKeyDown="A(event,this.form.txtP24_12_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_12_14" id="txtP24_12_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_12_14']; ?>" onKeyDown="A(event,this.form.txtP24_13_1);" /></td>
                        </tr>
                        <tr>
                            <td>13</td>
                            <td><input class="cuarenta_px"   name="txtP24_13_1" id="txtP24_13_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_13_1']; ?>"  onKeyDown="A(event,this.form.txtP24_13_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_13_2" id="txtP24_13_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_13_2']; ?>"  onKeyDown="A(event,this.form.txtP24_13_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_13_3" id="txtP24_13_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_13_3']; ?>"  onKeyDown="A(event,this.form.txtP24_13_4);" /></td>
                            <td><input class="text-box"    name="txtP24_13_4"  id="txtP24_13_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_13_4']; ?>"  onKeyDown="A(event,this.form.txtP24_13_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_13_5"  id="txtP24_13_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_13_5']; ?>"  onKeyDown="A(event,this.form.txtP24_13_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_13_6"  id="txtP24_13_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_13_6']; ?>"  onKeyDown="A(event,this.form.txtP24_13_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_13_7"  id="txtP24_13_7" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_13_7']; ?>"  onKeyDown="A(event,this.form.txtP24_13_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_13_8"  id="txtP24_13_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_13_8']; ?>"  onKeyDown="A(event,this.form.txtP24_13_9);" /></td>
                            <td><input class="text-box"    name="txtP24_13_9"  id="txtP24_13_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_13_9']; ?>"  onKeyDown="A(event,this.form.txtP24_13_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_13_10" id="txtP24_13_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_13_10']; ?>" onKeyDown="A(event,this.form.txtP24_13_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_13_11" id="txtP24_13_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_13_11']; ?>" onKeyDown="A(event,this.form.txtP24_13_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_13_12" id="txtP24_13_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_13_12']; ?>" onKeyDown="A(event,this.form.txtP24_13_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_13_13" id="txtP24_13_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_13_13']; ?>" onKeyDown="A(event,this.form.txtP24_13_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_13_14" id="txtP24_13_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_13_14']; ?>" onKeyDown="A(event,this.form.txtP24_14_1);" /></td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td><input class="cuarenta_px"   name="txtP24_14_1" id="txtP24_14_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_14_1']; ?>"  onKeyDown="A(event,this.form.txtP24_14_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_14_2" id="txtP24_14_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_14_2']; ?>"  onKeyDown="A(event,this.form.txtP24_14_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_14_3" id="txtP24_14_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_14_3']; ?>"  onKeyDown="A(event,this.form.txtP24_14_4);" /></td>
                            <td><input class="text-box"    name="txtP24_14_4"  id="txtP24_14_4" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_14_4']; ?>"  onKeyDown="A(event,this.form.txtP24_14_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_14_5"  id="txtP24_14_5" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_14_5']; ?>"  onKeyDown="A(event,this.form.txtP24_14_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_14_6"  id="txtP24_14_6" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_14_6']; ?>"  onKeyDown="A(event,this.form.txtP24_14_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_14_7"  id="txtP24_14_7" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_14_7']; ?>"  onKeyDown="A(event,this.form.txtP24_14_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_14_8"  id="txtP24_14_8" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_14_8']; ?>"  onKeyDown="A(event,this.form.txtP24_14_9);" /></td>
                            <td><input class="text-box"    name="txtP24_14_9"  id="txtP24_14_9" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_14_9']; ?>"  onKeyDown="A(event,this.form.txtP24_14_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_14_10" id="txtP24_14_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_14_10']; ?>" onKeyDown="A(event,this.form.txtP24_14_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_14_11" id="txtP24_14_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_14_11']; ?>" onKeyDown="A(event,this.form.txtP24_14_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_14_12" id="txtP24_14_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_14_12']; ?>" onKeyDown="A(event,this.form.txtP24_14_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_14_13" id="txtP24_14_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_14_13']; ?>" onKeyDown="A(event,this.form.txtP24_14_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_14_14" id="txtP24_14_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_14_14']; ?>" onKeyDown="A(event,this.form.txtP24_15_1);" /></td>
                        </tr>
                        <tr>
                            <td>15</td>
                            <td><input class="cuarenta_px"   name="txtP24_15_1" id="txtP24_15_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_15_1']; ?>"  onKeyDown="A(event,this.form.txtP24_15_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_15_2" id="txtP24_15_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_15_2']; ?>"  onKeyDown="A(event,this.form.txtP24_15_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_15_3" id="txtP24_15_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_15_3']; ?>"  onKeyDown="A(event,this.form.txtP24_15_4);" /></td>
                            <td><input class="text-box"    name="txtP24_15_4"  id="txtP24_15_4"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_15_4']; ?>"  onKeyDown="A(event,this.form.txtP24_15_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_15_5"  id="txtP24_15_5"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_15_5']; ?>"  onKeyDown="A(event,this.form.txtP24_15_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_15_6"  id="txtP24_15_6"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_15_6']; ?>"  onKeyDown="A(event,this.form.txtP24_15_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_15_7"  id="txtP24_15_7"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_15_7']; ?>"  onKeyDown="A(event,this.form.txtP24_15_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_15_8"  id="txtP24_15_8"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_15_8']; ?>"  onKeyDown="A(event,this.form.txtP24_15_9);" /></td>
                            <td><input class="text-box"    name="txtP24_15_9"  id="txtP24_15_9"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_15_9']; ?>"  onKeyDown="A(event,this.form.txtP24_15_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_15_10" id="txtP24_15_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_15_10']; ?>" onKeyDown="A(event,this.form.txtP24_15_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_15_11" id="txtP24_15_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_15_11']; ?>" onKeyDown="A(event,this.form.txtP24_15_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_15_12" id="txtP24_15_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_15_12']; ?>" onKeyDown="A(event,this.form.txtP24_15_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_15_13" id="txtP24_15_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_15_13']; ?>" onKeyDown="A(event,this.form.txtP24_15_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_15_14" id="txtP24_15_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_15_14']; ?>" onKeyDown="A(event,this.form.txtP24_16_1);" /></td>
                        </tr>
                        <tr>
                            <td>16</td>
                            <td><input class="cuarenta_px"   name="txtP24_16_1" id="txtP24_16_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_16_1']; ?>"  onKeyDown="A(event,this.form.txtP24_16_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_16_2" id="txtP24_16_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_16_2']; ?>"  onKeyDown="A(event,this.form.txtP24_16_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_16_3" id="txtP24_16_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_16_3']; ?>"  onKeyDown="A(event,this.form.txtP24_16_4);" /></td>
                            <td><input class="text-box"    name="txtP24_16_4"  id="txtP24_16_4"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_16_4']; ?>"  onKeyDown="A(event,this.form.txtP24_16_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_16_5"  id="txtP24_16_5"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_16_5']; ?>"  onKeyDown="A(event,this.form.txtP24_16_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_16_6"  id="txtP24_16_6"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_16_6']; ?>"  onKeyDown="A(event,this.form.txtP24_16_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_16_7"  id="txtP24_16_7"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_16_7']; ?>"  onKeyDown="A(event,this.form.txtP24_16_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_16_8"  id="txtP24_16_8"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_16_8']; ?>"  onKeyDown="A(event,this.form.txtP24_16_9);" /></td>
                            <td><input class="text-box"    name="txtP24_16_9"  id="txtP24_16_9"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_16_9']; ?>"  onKeyDown="A(event,this.form.txtP24_16_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_16_10" id="txtP24_16_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_16_10']; ?>" onKeyDown="A(event,this.form.txtP24_16_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_16_11" id="txtP24_16_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_16_11']; ?>" onKeyDown="A(event,this.form.txtP24_16_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_16_12" id="txtP24_16_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_16_12']; ?>" onKeyDown="A(event,this.form.txtP24_16_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_16_13" id="txtP24_16_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_16_13']; ?>" onKeyDown="A(event,this.form.txtP24_16_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_16_14" id="txtP24_16_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_16_14']; ?>" onKeyDown="A(event,this.form.txtP24_17_1);" /></td>
                        </tr>
                        <tr>
                            <td>17</td>
                            <td><input class="cuarenta_px"   name="txtP24_17_1" id="txtP24_17_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_17_1']; ?>"  onKeyDown="A(event,this.form.txtP24_17_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_17_2" id="txtP24_17_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_17_2']; ?>"  onKeyDown="A(event,this.form.txtP24_17_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_17_3" id="txtP24_17_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_17_3']; ?>"  onKeyDown="A(event,this.form.txtP24_17_4);" /></td>
                            <td><input class="text-box"    name="txtP24_17_4"  id="txtP24_17_4"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_17_4']; ?>"  onKeyDown="A(event,this.form.txtP24_17_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_17_5"  id="txtP24_17_5"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_17_5']; ?>"  onKeyDown="A(event,this.form.txtP24_17_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_17_6"  id="txtP24_17_6"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_17_6']; ?>"  onKeyDown="A(event,this.form.txtP24_17_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_17_7"  id="txtP24_17_7"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_17_7']; ?>"  onKeyDown="A(event,this.form.txtP24_17_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_17_8"  id="txtP24_17_8"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_17_8']; ?>"  onKeyDown="A(event,this.form.txtP24_17_9);" /></td>
                            <td><input class="text-box"    name="txtP24_17_9"  id="txtP24_17_9"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_17_9']; ?>"  onKeyDown="A(event,this.form.txtP24_17_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_17_10" id="txtP24_17_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_17_10']; ?>" onKeyDown="A(event,this.form.txtP24_17_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_17_11" id="txtP24_17_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_17_11']; ?>" onKeyDown="A(event,this.form.txtP24_17_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_17_12" id="txtP24_17_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_17_12']; ?>" onKeyDown="A(event,this.form.txtP24_17_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_17_13" id="txtP24_17_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_17_13']; ?>" onKeyDown="A(event,this.form.txtP24_17_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_17_14" id="txtP24_17_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_17_14']; ?>" onKeyDown="A(event,this.form.txtP24_18_1);" /></td>
                        </tr>
                        <tr>
                            <td>18</td>
                            <td><input class="cuarenta_px"   name="txtP24_18_1" id="txtP24_18_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_18_1']; ?>"  onKeyDown="A(event,this.form.txtP24_18_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_18_2" id="txtP24_18_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_18_2']; ?>"  onKeyDown="A(event,this.form.txtP24_18_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_18_3" id="txtP24_18_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_18_3']; ?>"  onKeyDown="A(event,this.form.txtP24_18_4);" /></td>
                            <td><input class="text-box"    name="txtP24_18_4"  id="txtP24_18_4"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_18_4']; ?>"  onKeyDown="A(event,this.form.txtP24_18_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_18_5"  id="txtP24_18_5"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_18_5']; ?>"  onKeyDown="A(event,this.form.txtP24_18_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_18_6"  id="txtP24_18_6"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_18_6']; ?>"  onKeyDown="A(event,this.form.txtP24_18_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_18_7"  id="txtP24_18_7"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_18_7']; ?>"  onKeyDown="A(event,this.form.txtP24_18_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_18_8"  id="txtP24_18_8"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_18_8']; ?>"  onKeyDown="A(event,this.form.txtP24_18_9);" /></td>
                            <td><input class="text-box"    name="txtP24_18_9"  id="txtP24_18_9"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_18_9']; ?>"  onKeyDown="A(event,this.form.txtP24_18_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_18_10" id="txtP24_18_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_18_10']; ?>" onKeyDown="A(event,this.form.txtP24_18_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_18_11" id="txtP24_18_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_18_11']; ?>" onKeyDown="A(event,this.form.txtP24_18_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_18_12" id="txtP24_18_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_18_12']; ?>" onKeyDown="A(event,this.form.txtP24_18_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_18_13" id="txtP24_18_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_18_13']; ?>" onKeyDown="A(event,this.form.txtP24_18_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_18_14" id="txtP24_18_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_18_14']; ?>" onKeyDown="A(event,this.form.txtP24_19_1);" /></td>
                        </tr>
                        <tr>
                            <td>19</td>
                            <td><input class="cuarenta_px"   name="txtP24_19_1" id="txtP24_19_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_19_1']; ?>"  onKeyDown="A(event,this.form.txtP24_19_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_19_2" id="txtP24_19_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_19_2']; ?>"  onKeyDown="A(event,this.form.txtP24_19_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_19_3" id="txtP24_19_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_19_3']; ?>"  onKeyDown="A(event,this.form.txtP24_19_4);" /></td>
                            <td><input class="text-box"    name="txtP24_19_4"  id="txtP24_19_4"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_19_4']; ?>"  onKeyDown="A(event,this.form.txtP24_19_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_19_5"  id="txtP24_19_5"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_19_5']; ?>"  onKeyDown="A(event,this.form.txtP24_19_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_19_6"  id="txtP24_19_6"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_19_6']; ?>"  onKeyDown="A(event,this.form.txtP24_19_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_19_7"  id="txtP24_19_7"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_19_7']; ?>"  onKeyDown="A(event,this.form.txtP24_19_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_19_8"  id="txtP24_19_8"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_19_8']; ?>"  onKeyDown="A(event,this.form.txtP24_19_9);" /></td>
                            <td><input class="text-box"    name="txtP24_19_9"  id="txtP24_19_9"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_19_9']; ?>"  onKeyDown="A(event,this.form.txtP24_19_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_19_10" id="txtP24_19_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_19_10']; ?>" onKeyDown="A(event,this.form.txtP24_19_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_19_11" id="txtP24_19_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_19_11']; ?>" onKeyDown="A(event,this.form.txtP24_19_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_19_12" id="txtP24_19_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_19_12']; ?>" onKeyDown="A(event,this.form.txtP24_19_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_19_13" id="txtP24_19_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_19_13']; ?>" onKeyDown="A(event,this.form.txtP24_19_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_19_14" id="txtP24_19_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_19_14']; ?>" onKeyDown="A(event,this.form.txtP24_20_1);" /></td>
                        </tr>
                        <tr>
                            <td>20</td>
                            <td><input class="cuarenta_px"   name="txtP24_20_1" id="txtP24_20_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_20_1']; ?>"  onKeyDown="A(event,this.form.txtP24_20_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_20_2" id="txtP24_20_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_20_2']; ?>"  onKeyDown="A(event,this.form.txtP24_20_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_20_3" id="txtP24_20_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_20_3']; ?>"  onKeyDown="A(event,this.form.txtP24_20_4);" /></td>
                            <td><input class="text-box"    name="txtP24_20_4"  id="txtP24_20_4"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_20_4']; ?>"  onKeyDown="A(event,this.form.txtP24_20_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_20_5"  id="txtP24_20_5"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_20_5']; ?>"  onKeyDown="A(event,this.form.txtP24_20_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_20_6"  id="txtP24_20_6"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_20_6']; ?>"  onKeyDown="A(event,this.form.txtP24_20_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_20_7"  id="txtP24_20_7"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_20_7']; ?>"  onKeyDown="A(event,this.form.txtP24_20_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_20_8"  id="txtP24_20_8"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_20_8']; ?>"  onKeyDown="A(event,this.form.txtP24_20_9);" /></td>
                            <td><input class="text-box"    name="txtP24_20_9"  id="txtP24_20_9"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_20_9']; ?>"  onKeyDown="A(event,this.form.txtP24_20_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_20_10" id="txtP24_20_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_20_10']; ?>" onKeyDown="A(event,this.form.txtP24_20_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_20_11" id="txtP24_20_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_20_11']; ?>" onKeyDown="A(event,this.form.txtP24_20_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_20_12" id="txtP24_20_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_20_12']; ?>" onKeyDown="A(event,this.form.txtP24_20_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_20_13" id="txtP24_20_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_20_13']; ?>" onKeyDown="A(event,this.form.txtP24_20_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_20_14" id="txtP24_20_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_20_14']; ?>" onKeyDown="A(event,this.form.txtP24_21_1);" /></td>
                        </tr>
                        <tr>
                            <td>21</td>
                            <td><input class="cuarenta_px"   name="txtP24_21_1" id="txtP24_21_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_21_1']; ?>"  onKeyDown="A(event,this.form.txtP24_21_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_21_2" id="txtP24_21_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_21_2']; ?>"  onKeyDown="A(event,this.form.txtP24_21_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_21_3" id="txtP24_21_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_21_3']; ?>"  onKeyDown="A(event,this.form.txtP24_21_4);" /></td>
                            <td><input class="text-box"    name="txtP24_21_4"  id="txtP24_21_4"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_21_4']; ?>"  onKeyDown="A(event,this.form.txtP24_21_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_21_5"  id="txtP24_21_5"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_21_5']; ?>"  onKeyDown="A(event,this.form.txtP24_21_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_21_6"  id="txtP24_21_6"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_21_6']; ?>"  onKeyDown="A(event,this.form.txtP24_21_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_21_7"  id="txtP24_21_7"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_21_7']; ?>"  onKeyDown="A(event,this.form.txtP24_21_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_21_8"  id="txtP24_21_8"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_21_8']; ?>"  onKeyDown="A(event,this.form.txtP24_21_9);" /></td>
                            <td><input class="text-box"    name="txtP24_21_9"  id="txtP24_21_9"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_21_9']; ?>"  onKeyDown="A(event,this.form.txtP24_21_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_21_10" id="txtP24_21_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_21_10']; ?>" onKeyDown="A(event,this.form.txtP24_21_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_21_11" id="txtP24_21_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_21_11']; ?>" onKeyDown="A(event,this.form.txtP24_21_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_21_12" id="txtP24_21_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_21_12']; ?>" onKeyDown="A(event,this.form.txtP24_21_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_21_13" id="txtP24_21_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_21_13']; ?>" onKeyDown="A(event,this.form.txtP24_21_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_21_14" id="txtP24_21_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_21_14']; ?>" onKeyDown="A(event,this.form.txtP24_22_1);" /></td>
                        </tr>
                        <tr>
                            <td>22</td>
                            <td><input class="cuarenta_px"   name="txtP24_22_1" id="txtP24_22_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_22_1']; ?>"  onKeyDown="A(event,this.form.txtP24_22_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_22_2" id="txtP24_22_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_22_2']; ?>"  onKeyDown="A(event,this.form.txtP24_22_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_22_3" id="txtP24_22_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_22_3']; ?>"  onKeyDown="A(event,this.form.txtP24_22_4);" /></td>
                            <td><input class="text-box"    name="txtP24_22_4"  id="txtP24_22_4"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_22_4']; ?>"  onKeyDown="A(event,this.form.txtP24_22_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_22_5"  id="txtP24_22_5"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_22_5']; ?>"  onKeyDown="A(event,this.form.txtP24_22_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_22_6"  id="txtP24_22_6"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_22_6']; ?>"  onKeyDown="A(event,this.form.txtP24_22_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_22_7"  id="txtP24_22_7"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_22_7']; ?>"  onKeyDown="A(event,this.form.txtP24_22_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_22_8"  id="txtP24_22_8"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_22_8']; ?>"  onKeyDown="A(event,this.form.txtP24_22_9);" /></td>
                            <td><input class="text-box"    name="txtP24_22_9"  id="txtP24_22_9"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_22_9']; ?>"  onKeyDown="A(event,this.form.txtP24_22_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_22_10" id="txtP24_22_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_22_10']; ?>" onKeyDown="A(event,this.form.txtP24_22_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_22_11" id="txtP24_22_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_22_11']; ?>" onKeyDown="A(event,this.form.txtP24_22_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_22_12" id="txtP24_22_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_22_12']; ?>" onKeyDown="A(event,this.form.txtP24_22_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_22_13" id="txtP24_22_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_22_13']; ?>" onKeyDown="A(event,this.form.txtP24_22_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_22_14" id="txtP24_22_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_22_14']; ?>" onKeyDown="A(event,this.form.txtP24_23_1);" /></td>
                        </tr>
                        <tr>
                            <td>23</td>
                            <td><input class="cuarenta_px"   name="txtP24_23_1" id="txtP24_23_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_23_1']; ?>"  onKeyDown="A(event,this.form.txtP24_23_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_23_2" id="txtP24_23_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_23_2']; ?>"  onKeyDown="A(event,this.form.txtP24_23_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_23_3" id="txtP24_23_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_23_3']; ?>"  onKeyDown="A(event,this.form.txtP24_23_4);" /></td>
                            <td><input class="text-box"    name="txtP24_23_4"  id="txtP24_23_4"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_23_4']; ?>"  onKeyDown="A(event,this.form.txtP24_23_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_23_5"  id="txtP24_23_5"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_23_5']; ?>"  onKeyDown="A(event,this.form.txtP24_23_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_23_6"  id="txtP24_23_6"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_23_6']; ?>"  onKeyDown="A(event,this.form.txtP24_23_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_23_7"  id="txtP24_23_7"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_23_7']; ?>"  onKeyDown="A(event,this.form.txtP24_23_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_23_8"  id="txtP24_23_8"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_23_8']; ?>"  onKeyDown="A(event,this.form.txtP24_23_9);" /></td>
                            <td><input class="text-box"    name="txtP24_23_9"  id="txtP24_23_9"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_23_9']; ?>"  onKeyDown="A(event,this.form.txtP24_23_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_23_10" id="txtP24_23_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_23_10']; ?>" onKeyDown="A(event,this.form.txtP24_23_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_23_11" id="txtP24_23_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_23_11']; ?>" onKeyDown="A(event,this.form.txtP24_23_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_23_12" id="txtP24_23_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_23_12']; ?>" onKeyDown="A(event,this.form.txtP24_23_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_23_13" id="txtP24_23_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_23_13']; ?>" onKeyDown="A(event,this.form.txtP24_23_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_23_14" id="txtP24_23_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_23_14']; ?>" onKeyDown="A(event,this.form.txtP24_24_1);" /></td>
                        </tr>
                        <tr>
                            <td>24</td>
                            <td><input class="cuarenta_px"   name="txtP24_24_1" id="txtP24_24_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_24_1']; ?>"  onKeyDown="A(event,this.form.txtP24_24_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_24_2" id="txtP24_24_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_24_2']; ?>"  onKeyDown="A(event,this.form.txtP24_24_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_24_3" id="txtP24_24_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_24_3']; ?>"  onKeyDown="A(event,this.form.txtP24_24_4);" /></td>
                            <td><input class="text-box"    name="txtP24_24_4"  id="txtP24_24_4"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_24_4']; ?>"  onKeyDown="A(event,this.form.txtP24_24_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_24_5"  id="txtP24_24_5"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_24_5']; ?>"  onKeyDown="A(event,this.form.txtP24_24_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_24_6"  id="txtP24_24_6"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_24_6']; ?>"  onKeyDown="A(event,this.form.txtP24_24_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_24_7"  id="txtP24_24_7"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_24_7']; ?>"  onKeyDown="A(event,this.form.txtP24_24_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_24_8"  id="txtP24_24_8"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_24_8']; ?>"  onKeyDown="A(event,this.form.txtP24_24_9);" /></td>
                            <td><input class="text-box"    name="txtP24_24_9"  id="txtP24_24_9"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_24_9']; ?>"  onKeyDown="A(event,this.form.txtP24_24_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_24_10" id="txtP24_24_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_24_10']; ?>" onKeyDown="A(event,this.form.txtP24_24_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_24_11" id="txtP24_24_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_24_11']; ?>" onKeyDown="A(event,this.form.txtP24_24_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_24_12" id="txtP24_24_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_24_12']; ?>" onKeyDown="A(event,this.form.txtP24_24_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_24_13" id="txtP24_24_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_24_13']; ?>" onKeyDown="A(event,this.form.txtP24_24_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_24_14" id="txtP24_24_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_24_14']; ?>" onKeyDown="A(event,this.form.txtP24_25_1);" /></td>
                        </tr>
                        <tr>
                            <td>25</td>
                            <td><input class="cuarenta_px"   name="txtP24_25_1" id="txtP24_25_1"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_25_1']; ?>"  onKeyDown="A(event,this.form.txtP24_25_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_25_2" id="txtP24_25_2"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_25_2']; ?>"  onKeyDown="A(event,this.form.txtP24_25_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_25_3" id="txtP24_25_3"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_25_3']; ?>"  onKeyDown="A(event,this.form.txtP24_25_4);" /></td>
                            <td><input class="text-box"    name="txtP24_25_4"   id="txtP24_25_4"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_25_4']; ?>" onKeyDown="A(event,this.form.txtP24_25_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_25_5"   id="txtP24_25_5"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_25_5']; ?>" onKeyDown="A(event,this.form.txtP24_25_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_25_6"   id="txtP24_25_6"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_25_6']; ?>" onKeyDown="A(event,this.form.txtP24_25_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_25_7"   id="txtP24_25_7"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_25_7']; ?>" onKeyDown="A(event,this.form.txtP24_25_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_25_8"   id="txtP24_25_8"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_25_8']; ?>" onKeyDown="A(event,this.form.txtP24_25_9);" /></td>
                            <td><input class="text-box"    name="txtP24_25_9"   id="txtP24_25_9"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_25_9']; ?>" onKeyDown="A(event,this.form.txtP24_25_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_25_10"  id="txtP24_25_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_25_10']; ?>" onKeyDown="A(event,this.form.txtP24_25_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_25_11"  id="txtP24_25_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_25_11']; ?>" onKeyDown="A(event,this.form.txtP24_25_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_25_12"  id="txtP24_25_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_25_12']; ?>" onKeyDown="A(event,this.form.txtP24_25_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_25_13"  id="txtP24_25_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_25_13']; ?>" onKeyDown="A(event,this.form.txtP24_25_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_25_14"  id="txtP24_25_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_25_14']; ?>" onKeyDown="A(event,this.form.txtP24_26_1);" /></td>
                        </tr>
                        <tr>
                            <td>26</td>
                            <td><input class="cuarenta_px"   name="txtP24_26_1" id="txtP24_26_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_26_1']; ?>"  onKeyDown="A(event,this.form.txtP24_26_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_26_2" id="txtP24_26_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_26_2']; ?>"  onKeyDown="A(event,this.form.txtP24_26_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_26_3" id="txtP24_26_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_26_3']; ?>"  onKeyDown="A(event,this.form.txtP24_26_4);" /></td>
                            <td><input class="text-box"    name="txtP24_26_4"  id="txtP24_26_4"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_26_4']; ?>"  onKeyDown="A(event,this.form.txtP24_26_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_26_5"  id="txtP24_26_5"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_26_5']; ?>"  onKeyDown="A(event,this.form.txtP24_26_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_26_6"  id="txtP24_26_6"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_26_6']; ?>"  onKeyDown="A(event,this.form.txtP24_26_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_26_7"  id="txtP24_26_7"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_26_7']; ?>"  onKeyDown="A(event,this.form.txtP24_26_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_26_8"  id="txtP24_26_8"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_26_8']; ?>"  onKeyDown="A(event,this.form.txtP24_26_9);" /></td>
                            <td><input class="text-box"    name="txtP24_26_9"  id="txtP24_26_9"  type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_26_9']; ?>"  onKeyDown="A(event,this.form.txtP24_26_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_26_10" id="txtP24_26_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_26_10']; ?>" onKeyDown="A(event,this.form.txtP24_26_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_26_11" id="txtP24_26_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_26_11']; ?>" onKeyDown="A(event,this.form.txtP24_26_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_26_12" id="txtP24_26_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_26_12']; ?>" onKeyDown="A(event,this.form.txtP24_26_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_26_13" id="txtP24_26_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_26_13']; ?>" onKeyDown="A(event,this.form.txtP24_26_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_26_14" id="txtP24_26_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_26_14']; ?>" onKeyDown="A(event,this.form.txtP24_27_1);" /></td>
                        </tr>
                        <tr>
                            <td>27</td>
                            <td><input class="cuarenta_px"   name="txtP24_27_1" id="txtP24_27_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_27_1']; ?>"  onKeyDown="A(event,this.form.txtP24_27_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_27_2" id="txtP24_27_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_27_2']; ?>"  onKeyDown="A(event,this.form.txtP24_27_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_27_3" id="txtP24_27_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_27_3']; ?>"  onKeyDown="A(event,this.form.txtP24_27_4);" /></td>
                            <td><input class="text-box"    name="txtP24_27_4"  id="txtP24_27_4" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_27_4']; ?>"  onKeyDown="A(event,this.form.txtP24_27_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_27_5"  id="txtP24_27_5" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_27_5']; ?>"  onKeyDown="A(event,this.form.txtP24_27_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_27_6"  id="txtP24_27_6" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_27_6']; ?>"  onKeyDown="A(event,this.form.txtP24_27_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_27_7"  id="txtP24_27_7" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_27_7']; ?>"  onKeyDown="A(event,this.form.txtP24_27_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_27_8"  id="txtP24_27_8" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_27_8']; ?>"  onKeyDown="A(event,this.form.txtP24_27_9);" /></td>
                            <td><input class="text-box"    name="txtP24_27_9"  id="txtP24_27_9" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_27_9']; ?>"  onKeyDown="A(event,this.form.txtP24_27_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_27_10" id="txtP24_27_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_27_10']; ?>" onKeyDown="A(event,this.form.txtP24_27_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_27_11" id="txtP24_27_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_27_11']; ?>" onKeyDown="A(event,this.form.txtP24_27_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_27_12" id="txtP24_27_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_27_12']; ?>" onKeyDown="A(event,this.form.txtP24_27_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_27_13" id="txtP24_27_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_27_13']; ?>" onKeyDown="A(event,this.form.txtP24_27_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_27_14" id="txtP24_27_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_27_14']; ?>" onKeyDown="A(event,this.form.txtP24_28_1);" /></td>
                        </tr>
                        <tr>
                            <td>28</td>
                            <td><input class="cuarenta_px"   name="txtP24_28_1" id="txtP24_28_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_28_1']; ?>"  onKeyDown="A(event,this.form.txtP24_28_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_28_2" id="txtP24_28_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_28_2']; ?>"  onKeyDown="A(event,this.form.txtP24_28_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_28_3" id="txtP24_28_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_28_3']; ?>"  onKeyDown="A(event,this.form.txtP24_28_4);" /></td>
                            <td><input class="text-box"    name="txtP24_28_4"  id="txtP24_28_4" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_28_4']; ?>"  onKeyDown="A(event,this.form.txtP24_28_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_28_5"  id="txtP24_28_5" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_28_5']; ?>"  onKeyDown="A(event,this.form.txtP24_28_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_28_6"  id="txtP24_28_6" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_28_6']; ?>"  onKeyDown="A(event,this.form.txtP24_28_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_28_7"  id="txtP24_28_7" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_28_7']; ?>"  onKeyDown="A(event,this.form.txtP24_28_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_28_8"  id="txtP24_28_8" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_28_8']; ?>"  onKeyDown="A(event,this.form.txtP24_28_9);" /></td>
                            <td><input class="text-box"    name="txtP24_28_9"  id="txtP24_28_9" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_28_9']; ?>"  onKeyDown="A(event,this.form.txtP24_28_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_28_10" id="txtP24_28_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_28_10']; ?>" onKeyDown="A(event,this.form.txtP24_28_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_28_11" id="txtP24_28_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_28_11']; ?>" onKeyDown="A(event,this.form.txtP24_28_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_28_12" id="txtP24_28_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_28_12']; ?>" onKeyDown="A(event,this.form.txtP24_28_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_28_13" id="txtP24_28_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_28_13']; ?>" onKeyDown="A(event,this.form.txtP24_28_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_28_14" id="txtP24_28_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_28_14']; ?>" onKeyDown="A(event,this.form.txtP24_29_1);" /></td>
                        </tr>
                        <tr>
                            <td>29</td>
                            <td><input class="cuarenta_px"   name="txtP24_29_1" id="txtP24_29_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_29_1']; ?>"  onKeyDown="A(event,this.form.txtP24_29_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_29_2" id="txtP24_29_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_29_2']; ?>"  onKeyDown="A(event,this.form.txtP24_29_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_29_3" id="txtP24_29_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_29_3']; ?>"  onKeyDown="A(event,this.form.txtP24_29_4);" /></td>
                            <td><input class="text-box"    name="txtP24_29_4"  id="txtP24_29_4" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_29_4']; ?>"  onKeyDown="A(event,this.form.txtP24_29_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_29_5"  id="txtP24_29_5" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_29_5']; ?>"  onKeyDown="A(event,this.form.txtP24_29_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_29_6"  id="txtP24_29_6" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_29_6']; ?>"  onKeyDown="A(event,this.form.txtP24_29_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_29_7"  id="txtP24_29_7" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_29_7']; ?>"  onKeyDown="A(event,this.form.txtP24_29_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_29_8"  id="txtP24_29_8" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_29_8']; ?>"  onKeyDown="A(event,this.form.txtP24_29_9);" /></td>
                            <td><input class="text-box"    name="txtP24_29_9"  id="txtP24_29_9" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_29_9']; ?>"  onKeyDown="A(event,this.form.txtP24_29_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_29_10" id="txtP24_29_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_29_10']; ?>" onKeyDown="A(event,this.form.txtP24_29_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_29_11" id="txtP24_29_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_29_11']; ?>" onKeyDown="A(event,this.form.txtP24_29_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_29_12" id="txtP24_29_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_29_12']; ?>" onKeyDown="A(event,this.form.txtP24_29_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_29_13" id="txtP24_29_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_29_13']; ?>" onKeyDown="A(event,this.form.txtP24_29_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_29_14" id="txtP24_29_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_29_14']; ?>" onKeyDown="A(event,this.form.txtP24_30_1);" /></td>
                        </tr>
                        <tr>
                            <td>30</td>
                            <td><input class="cuarenta_px"   name="txtP24_30_1" id="txtP24_30_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_30_1']; ?>"  onKeyDown="A(event,this.form.txtP24_30_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_30_2" id="txtP24_30_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_30_2']; ?>"  onKeyDown="A(event,this.form.txtP24_30_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_30_3" id="txtP24_30_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_30_3']; ?>"  onKeyDown="A(event,this.form.txtP24_30_4);" /></td>
                            <td><input class="text-box"    name="txtP24_30_4"  id="txtP24_30_4" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_30_4']; ?>"  onKeyDown="A(event,this.form.txtP24_30_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_30_5"  id="txtP24_30_5" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_30_5']; ?>"  onKeyDown="A(event,this.form.txtP24_30_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_30_6"  id="txtP24_30_6" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_30_6']; ?>"  onKeyDown="A(event,this.form.txtP24_30_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_30_7"  id="txtP24_30_7" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_30_7']; ?>"  onKeyDown="A(event,this.form.txtP24_30_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_30_8"  id="txtP24_30_8" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_30_8']; ?>"  onKeyDown="A(event,this.form.txtP24_30_9);" /></td>
                            <td><input class="text-box"    name="txtP24_30_9"  id="txtP24_30_9" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_30_9']; ?>"  onKeyDown="A(event,this.form.txtP24_30_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_30_10" id="txtP24_30_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_30_10']; ?>" onKeyDown="A(event,this.form.txtP24_30_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_30_11" id="txtP24_30_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_30_11']; ?>" onKeyDown="A(event,this.form.txtP24_30_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_30_12" id="txtP24_30_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_30_12']; ?>" onKeyDown="A(event,this.form.txtP24_30_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_30_13" id="txtP24_30_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_30_13']; ?>" onKeyDown="A(event,this.form.txtP24_30_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_30_14" id="txtP24_30_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_30_14']; ?>" onKeyDown="A(event,this.form.txtP24_31_1);" /></td>
                        </tr>
                        <tr>
                            <td>31</td>
                            <td><input class="cuarenta_px"   name="txtP24_31_1" id="txtP24_31_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_31_1']; ?>"  onKeyDown="A(event,this.form.txtP24_31_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_31_2" id="txtP24_31_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_31_2']; ?>"  onKeyDown="A(event,this.form.txtP24_31_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_31_3" id="txtP24_31_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_31_3']; ?>"  onKeyDown="A(event,this.form.txtP24_31_4);" /></td>
                            <td><input class="text-box"    name="txtP24_31_4"  id="txtP24_31_4" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_31_4']; ?>"  onKeyDown="A(event,this.form.txtP24_31_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_31_5"  id="txtP24_31_5" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_31_5']; ?>"  onKeyDown="A(event,this.form.txtP24_31_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_31_6"  id="txtP24_31_6" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_31_6']; ?>"  onKeyDown="A(event,this.form.txtP24_31_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_31_7"  id="txtP24_31_7" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_31_7']; ?>"  onKeyDown="A(event,this.form.txtP24_31_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_31_8"  id="txtP24_31_8" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_31_8']; ?>"  onKeyDown="A(event,this.form.txtP24_31_9);" /></td>
                            <td><input class="text-box"    name="txtP24_31_9"  id="txtP24_31_9" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_31_9']; ?>"  onKeyDown="A(event,this.form.txtP24_31_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_31_10" id="txtP24_31_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_31_10']; ?>" onKeyDown="A(event,this.form.txtP24_31_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_31_11" id="txtP24_31_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_31_11']; ?>" onKeyDown="A(event,this.form.txtP24_31_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_31_12" id="txtP24_31_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_31_12']; ?>" onKeyDown="A(event,this.form.txtP24_31_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_31_13" id="txtP24_31_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_31_13']; ?>" onKeyDown="A(event,this.form.txtP24_31_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_31_14" id="txtP24_31_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_31_14']; ?>" onKeyDown="A(event,this.form.txtP24_32_1);" /></td>
                        </tr>
                        <tr>
                            <td>32</td>
                            <td><input class="cuarenta_px"   name="txtP24_32_1" id="txtP24_32_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_32_1']; ?>"  onKeyDown="A(event,this.form.txtP24_32_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_32_2" id="txtP24_32_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_32_2']; ?>"  onKeyDown="A(event,this.form.txtP24_32_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_32_3" id="txtP24_32_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_32_3']; ?>"  onKeyDown="A(event,this.form.txtP24_32_4);" /></td>
                            <td><input class="text-box"    name="txtP24_32_4"  id="txtP24_32_4" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_32_4']; ?>"  onKeyDown="A(event,this.form.txtP24_32_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_32_5"  id="txtP24_32_5" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_32_5']; ?>"  onKeyDown="A(event,this.form.txtP24_32_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_32_6"  id="txtP24_32_6" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_32_6']; ?>"  onKeyDown="A(event,this.form.txtP24_32_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_32_7"  id="txtP24_32_7" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_32_7']; ?>"  onKeyDown="A(event,this.form.txtP24_32_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_32_8"  id="txtP24_32_8" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_32_8']; ?>"  onKeyDown="A(event,this.form.txtP24_32_9);" /></td>
                            <td><input class="text-box"    name="txtP24_32_9"  id="txtP24_32_9" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_32_9']; ?>"  onKeyDown="A(event,this.form.txtP24_32_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_32_10" id="txtP24_32_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_32_10']; ?>" onKeyDown="A(event,this.form.txtP24_32_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_32_11" id="txtP24_32_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_32_11']; ?>" onKeyDown="A(event,this.form.txtP24_32_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_32_12" id="txtP24_32_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_32_12']; ?>" onKeyDown="A(event,this.form.txtP24_32_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_32_13" id="txtP24_32_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_32_13']; ?>" onKeyDown="A(event,this.form.txtP24_32_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_32_14" id="txtP24_32_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_32_14']; ?>" onKeyDown="A(event,this.form.txtP24_33_1);" /></td>
                        </tr>
                        <tr>
                            <td>33</td>
                            <td><input class="cuarenta_px"   name="txtP24_33_1" id="txtP24_33_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_33_1']; ?>"  onKeyDown="A(event,this.form.txtP24_33_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_33_2" id="txtP24_33_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_33_2']; ?>"  onKeyDown="A(event,this.form.txtP24_33_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_33_3" id="txtP24_33_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_33_3']; ?>"  onKeyDown="A(event,this.form.txtP24_33_4);" /></td>
                            <td><input class="text-box"    name="txtP24_33_4"  id="txtP24_33_4" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_33_4']; ?>"  onKeyDown="A(event,this.form.txtP24_33_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_33_5"  id="txtP24_33_5" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_33_5']; ?>"  onKeyDown="A(event,this.form.txtP24_33_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_33_6"  id="txtP24_33_6" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_33_6']; ?>"  onKeyDown="A(event,this.form.txtP24_33_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_33_7"  id="txtP24_33_7" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_33_7']; ?>"  onKeyDown="A(event,this.form.txtP24_33_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_33_8"  id="txtP24_33_8" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_33_8']; ?>"  onKeyDown="A(event,this.form.txtP24_33_9);" /></td>
                            <td><input class="text-box"    name="txtP24_33_9"  id="txtP24_33_9" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_33_9']; ?>"  onKeyDown="A(event,this.form.txtP24_33_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_33_10" id="txtP24_33_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_33_10']; ?>" onKeyDown="A(event,this.form.txtP24_33_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_33_11" id="txtP24_33_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_33_11']; ?>" onKeyDown="A(event,this.form.txtP24_33_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_33_12" id="txtP24_33_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_33_12']; ?>" onKeyDown="A(event,this.form.txtP24_33_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_33_13" id="txtP24_33_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_33_13']; ?>" onKeyDown="A(event,this.form.txtP24_33_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_33_14" id="txtP24_33_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_33_14']; ?>" onKeyDown="A(event,this.form.txtP24_34_1);" /></td>
                        </tr>
                        <tr>
                            <td>34</td>
                            <td><input class="cuarenta_px"   name="txtP24_34_1" id="txtP24_34_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_34_1']; ?>"  onKeyDown="A(event,this.form.txtP24_34_2);" /></td>
                            <td><input class="trecientos_px" name="txtP24_34_2" id="txtP24_34_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_34_2']; ?>"  onKeyDown="A(event,this.form.txtP24_34_3);" /></td>
                            <td><input class="cuarenta_px"   name="txtP24_34_3" id="txtP24_34_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_34_3']; ?>"  onKeyDown="A(event,this.form.txtP24_34_4);" /></td>
                            <td><input class="text-box"    name="txtP24_34_4"  id="txtP24_34_4" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_34_4']; ?>"  onKeyDown="A(event,this.form.txtP24_34_5);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_34_5"  id="txtP24_34_5" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_34_5']; ?>"  onKeyDown="A(event,this.form.txtP24_34_6);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_34_6"  id="txtP24_34_6" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_34_6']; ?>"  onKeyDown="A(event,this.form.txtP24_34_7);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_34_7"  id="txtP24_34_7" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_34_7']; ?>"  onKeyDown="A(event,this.form.txtP24_34_8);" /></td>
                            <td><input class="cuarenta_px" name="txtP24_34_8"  id="txtP24_34_8" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_34_8']; ?>"  onKeyDown="A(event,this.form.txtP24_34_9);" /></td>
                            <td><input class="text-box"    name="txtP24_34_9"  id="txtP24_34_9" type="text"  onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_34_9']; ?>"  onKeyDown="A(event,this.form.txtP24_34_10);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_34_10" id="txtP24_34_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_34_10']; ?>" onKeyDown="A(event,this.form.txtP24_34_11);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_34_11" id="txtP24_34_11" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_34_11']; ?>" onKeyDown="A(event,this.form.txtP24_34_12);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_34_12" id="txtP24_34_12" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_34_12']; ?>" onKeyDown="A(event,this.form.txtP24_34_13);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_34_13" id="txtP24_34_13" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_34_13']; ?>" onKeyDown="A(event,this.form.txtP24_34_14);"/></td>
                            <td><input class="cuarenta_px" name="txtP24_34_14" id="txtP24_34_14" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P24_34_14']; ?>" onKeyDown="A(event,this.form.btnP24_siguiente);" /></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP24_anterior"  id="btnP24_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p23')"/></td>
                            <td><input name="btnP24_siguiente" id="btnP24_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p25')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p25" style="display:<?php echo $p25; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">25. &iquest;En sus cultivos, tiene alguna superficie destinada <br />exclusivamente a la producci&oacute;n de semilla?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>                
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 26</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP25_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P25_1']; ?>" onKeyDown="A(event,this.form.txtP25_1_1);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">Nombre</td>
                            <td colspan="2">Superficie</td>
                        </tr>
                        <tr>
                            <td>Enteros y decimales</td>
                            <td>Codigo <br/>unidad<br/>de medida</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td><input class="trecientos_px" name="txtP25_1_1" id="txtP25_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P25_1_1']; ?>" onKeyDown="A(event,this.form.txtP25_1_2);"/></td>
                            <td><input class="text-box"      name="txtP25_1_2" id="txtP25_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P25_1_2']; ?>" onKeyDown="A(event,this.form.txtP25_1_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP25_1_3" id="txtP25_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P25_1_3']; ?>" onKeyDown="A(event,this.form.txtP25_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><input class="trecientos_px" name="txtP25_2_1" id="txtP25_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P25_2_1']; ?>" onKeyDown="A(event,this.form.txtP25_2_2);"/></td>
                            <td><input class="text-box"      name="txtP25_2_2" id="txtP25_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P25_2_2']; ?>" onKeyDown="A(event,this.form.txtP25_2_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP25_2_3" id="txtP25_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P25_2_3']; ?>" onKeyDown="A(event,this.form.txtP25_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><input class="trecientos_px" name="txtP25_3_1" id="txtP25_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P25_3_1']; ?>" onKeyDown="A(event,this.form.txtP25_3_2);"/></td>
                            <td><input class="text-box"      name="txtP25_3_2" id="txtP25_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P25_3_2']; ?>" onKeyDown="A(event,this.form.txtP25_3_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP25_3_3" id="txtP25_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P25_3_3']; ?>" onKeyDown="A(event,this.form.txtP25_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><input class="trecientos_px" name="txtP25_4_1" id="txtP25_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P25_4_1']; ?>" onKeyDown="A(event,this.form.txtP25_4_2);"/></td>
                            <td><input class="text-box"      name="txtP25_4_2" id="txtP25_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P25_4_2']; ?>" onKeyDown="A(event,this.form.txtP25_4_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP25_4_3" id="txtP25_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P25_4_3']; ?>" onKeyDown="A(event,this.form.txtP25_5_1);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><input class="trecientos_px" name="txtP25_5_1" id="txtP25_5_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P25_5_1']; ?>" onKeyDown="A(event,this.form.txtP25_5_2);"/></td>
                            <td><input class="text-box"      name="txtP25_5_2" id="txtP25_5_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P25_5_2']; ?>" onKeyDown="A(event,this.form.txtP25_5_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP25_5_3" id="txtP25_5_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P25_5_3']; ?>" onKeyDown="A(event,this.form.btnP25_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP25_anterior"  id="btnP25_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p24')"/></td>
                            <td><input name="btnP25_siguiente" id="btnP25_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p26')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p26" style="display:<?php echo $p26; ?> ; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">26. &iquest;Tiene pastos cultivados?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 27</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP26_1" id="txtP26_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P26_1']; ?>" onKeyDown="A(event,this.form.txtP26_1_1);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">Nombre de pastos cultivados</td>
                            <td colspan="2">Superficie</td>
                        </tr>
                        <tr>
                            <td>Enteros y decimales</td>
                            <td>Codigo <br/>unidad<br/>de medida</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td><input class="trecientos_px" name="txtP26_1_1" id="txtP26_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P26_1_1']; ?>" onKeyDown="A(event,this.form.txtP26_1_2);"/></td>
                            <td><input class="text-box"      name="txtP26_1_2" id="txtP26_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P26_1_2']; ?>" onKeyDown="A(event,this.form.txtP26_1_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP26_1_3" id="txtP26_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P26_1_3']; ?>" onKeyDown="A(event,this.form.txtP26_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><input class="trecientos_px" name="txtP26_2_1" id="txtP26_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P26_2_1']; ?>" onKeyDown="A(event,this.form.txtP26_2_2);"/></td>
                            <td><input class="text-box"      name="txtP26_2_2" id="txtP26_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P26_2_2']; ?>" onKeyDown="A(event,this.form.txtP26_2_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP26_2_3" id="txtP26_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P26_2_3']; ?>" onKeyDown="A(event,this.form.txtP26_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><input class="trecientos_px" name="txtP26_3_1" id="txtP26_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P26_3_1']; ?>" onKeyDown="A(event,this.form.txtP26_3_2);"/></td>
                            <td><input class="text-box"      name="txtP26_3_2" id="txtP26_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P26_3_2']; ?>" onKeyDown="A(event,this.form.txtP26_3_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP26_3_3" id="txtP26_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P26_3_3']; ?>" onKeyDown="A(event,this.form.txtP26_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><input class="trecientos_px" name="txtP26_4_1" id="txtP26_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P26_4_1']; ?>" onKeyDown="A(event,this.form.txtP26_4_2);"/></td>
                            <td><input class="text-box"      name="txtP26_4_2" id="txtP26_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P26_4_2']; ?>" onKeyDown="A(event,this.form.txtP26_4_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP26_4_3" id="txtP26_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P26_4_3']; ?>" onKeyDown="A(event,this.form.txtP26_5_1);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><input class="trecientos_px" name="txtP26_5_1" id="txtP26_5_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P26_5_1']; ?>" onKeyDown="A(event,this.form.txtP26_5_2);"/></td>
                            <td><input class="text-box"      name="txtP26_5_2" id="txtP26_5_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P26_5_2']; ?>" onKeyDown="A(event,this.form.txtP26_5_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP26_5_3" id="txtP26_5_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P26_5_3']; ?>" onKeyDown="A(event,this.form.btnP26_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP26_anterior"  id="btnP26_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p25')"/></td>
                            <td><input name="btnP26_siguiente" id="btnP26_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p27')"></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p27" style="display:<?php echo $p27; ?> ; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">27. &iquest;Tiene plantaciones forestales maderables?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 28</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP27_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P27_1']; ?>" onKeyDown="A(event,this.form.txtP27_1_1);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">Nombre de especies forestales maderables</td>
                            <td colspan="2">Superficie</td>
                        </tr>
                        <tr>
                            <td>Enteros y decimales</td>
                            <td>Codigo <br/>unidad<br/>de medida</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td><input class="trecientos_px" name="txtP27_1_1" id="txtP27_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P27_1_1']; ?>" onKeyDown="A(event,this.form.txtP27_1_2);"/></td>
                            <td><input class="text-box"      name="txtP27_1_2" id="txtP27_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P27_1_2']; ?>" onKeyDown="A(event,this.form.txtP27_1_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP27_1_3" id="txtP27_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P27_1_3']; ?>" onKeyDown="A(event,this.form.txtP27_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><input class="trecientos_px" name="txtP27_2_1" id="txtP27_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P27_2_1']; ?>" onKeyDown="A(event,this.form.txtP27_2_2);"/></td>
                            <td><input class="text-box"      name="txtP27_2_2" id="txtP27_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P27_2_2']; ?>" onKeyDown="A(event,this.form.txtP27_2_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP27_2_3" id="txtP27_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P27_2_3']; ?>" onKeyDown="A(event,this.form.txtP27_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><input class="trecientos_px" name="txtP27_3_1" id="txtP27_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P27_3_1']; ?>" onKeyDown="A(event,this.form.txtP27_3_2);"/></td>
                            <td><input class="text-box"      name="txtP27_3_2" id="txtP27_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P27_3_2']; ?>" onKeyDown="A(event,this.form.txtP27_3_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP27_3_3" id="txtP27_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P27_3_3']; ?>" onKeyDown="A(event,this.form.txtP27_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><input class="trecientos_px" name="txtP27_4_1" id="txtP27_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P27_4_1']; ?>" onKeyDown="A(event,this.form.txtP27_4_2);"/></td>
                            <td><input class="text-box"      name="txtP27_4_2" id="txtP27_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P27_4_2']; ?>" onKeyDown="A(event,this.form.txtP27_4_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP27_4_3" id="txtP27_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P27_4_3']; ?>" onKeyDown="A(event,this.form.txtP27_5_1);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><input class="trecientos_px" name="txtP27_5_1" id="txtP27_5_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P27_5_1']; ?>" onKeyDown="A(event,this.form.txtP27_5_2);"/></td>
                            <td><input class="text-box"      name="txtP27_5_2" id="txtP27_5_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P27_5_2']; ?>" onKeyDown="A(event,this.form.txtP27_5_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP27_5_3" id="txtP27_5_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P27_5_3']; ?>" onKeyDown="A(event,this.form.btnP27_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP27_anterior"  id="btnP27_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p26')"/></td>
                            <td><input name="btnP27_siguiente" id="btnP27_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p28')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
		<?php endforeach;?>
		<?php  foreach ($datosArray_p2 as $row_datos):?>
        <tr>
            <td>
                <div id="p28" style="display:<?php echo $p28; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">28. &iquest;Tiene parcelas o tierras en barbecho, descanso, pastos naturales, <br/> bosques o montes u otras parcelas o tierras que no sean aptas para el cultivo?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 29</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP28_1" id="txtP28_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P28_1']; ?>" onKeyDown="A(event,this.form.txtP28_1_1);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">Otros usos de la tierra</td>
                            <td colspan="2">Superficie</td>
                        </tr>
                        <tr>
                            <td>Enteros y decimales</td>
                            <td>Codigo <br/>unidad<br/>de medida</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Tierras de barbecho</td>
                            <td><input class="text-box"    name="txtP28_1_1" id="txtP28_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P28_1_1']; ?>" onKeyDown="A(event,this.form.txtP28_1_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP28_1_2" id="txtP28_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P28_1_2']; ?>" onKeyDown="A(event,this.form.txtP28_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Tierras de descanso</td>
                            <td><input class="text-box"    name="txtP28_2_1" id="txtP28_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P28_2_1']; ?>" onKeyDown="A(event,this.form.txtP28_2_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP28_2_2" id="txtP28_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P28_2_2']; ?>" onKeyDown="A(event,this.form.txtP28_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Pastos naturales</td>
                            <td><input class="text-box"    name="txtP28_3_1" id="txtP28_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P28_3_1']; ?>" onKeyDown="A(event,this.form.txtP28_3_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP28_3_2" id="txtP28_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P28_3_2']; ?>" onKeyDown="A(event,this.form.txtP28_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Bosques o montes</td>
                            <td><input class="text-box"    name="txtP28_4_1" id="txtP28_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P28_4_1']; ?>" onKeyDown="A(event,this.form.txtP28_4_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP28_4_2" id="txtP28_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P28_4_2']; ?>" onKeyDown="A(event,this.form.txtP28_5_1);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Otras tierras </td>
                            <td><input class="text-box"    name="txtP28_5_1" id="txtP28_5_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P28_5_1']; ?>" onKeyDown="A(event,this.form.txtP28_5_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP28_5_2" id="txtP28_5_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P28_5_2']; ?>" onKeyDown="A(event,this.form.btnP28_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP28_anterior"  id="btnP28_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p27')"/></td>
                            <td><input name="btnP28_siguiente" id="btnP28_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p29')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p29" style="display:<?php echo $p29; ?>; top: 350px; position: absolute;">
                    <table>          
                        <tr>
                            <td colspan="3">29. &iquest;Tiene &aacute;rboles frutales dispersos en su Unidad de Producci&oacute;n Agropecuaria?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 30</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP29_1" id="txtP29_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P29_1']; ?>" onKeyDown="A(event,this.form.txtP29_1_1);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td></td>
                            <td>Principales especies de frutales dispersos</td>
                            <td>N&uacute;mero <br />de<br />plantas</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td><input class="trecientos_px" name="txtP29_1_1" id="txtP29_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P29_1_1']; ?>" onKeyDown="A(event,this.form.txtP29_1_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP29_1_2" id="txtP29_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P29_1_2']; ?>" onKeyDown="A(event,this.form.txtP29_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><input class="trecientos_px" name="txtP29_2_1" id="txtP29_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P29_2_1']; ?>" onKeyDown="A(event,this.form.txtP29_2_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP29_2_2" id="txtP29_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P29_2_2']; ?>" onKeyDown="A(event,this.form.txtP29_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><input class="trecientos_px" name="txtP29_3_1" id="txtP29_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P29_3_1']; ?>" onKeyDown="A(event,this.form.txtP29_3_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP29_3_2" id="txtP29_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P29_3_2']; ?>" onKeyDown="A(event,this.form.txtP29_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><input class="trecientos_px" name="txtP29_4_1" id="txtP29_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P29_4_1']; ?>" onKeyDown="A(event,this.form.txtP29_4_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP29_4_2" id="txtP29_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P29_4_2']; ?>" onKeyDown="A(event,this.form.txtP29_5_1);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><input class="trecientos_px" name="txtP29_5_1" id="txtP29_5_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P29_5_1']; ?>" onKeyDown="A(event,this.form.txtP29_5_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP29_5_2" id="txtP29_5_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P29_5_2']; ?>" onKeyDown="A(event,this.form.btnP29_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP29_anterior"  id="btnP29_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p28')"/></td>
                            <td><input name="btnP29_siguiente" id="btnP29_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p30')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p30" style="display:<?php echo $p30; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">30. &iquest;Tiene plantas medicinales en su Unidad de Producci&oacute;n Agropecuaria?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 31</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP30_1" id="txtP30_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P30_1']; ?>" onKeyDown="A(event,this.form.txtP30_2);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td></td>
                            <td>Principales especies de plantas medicinales</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td><input class="trecientos_px" name="txtP30_2" id="txtP30_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P30_2']; ?>" onKeyDown="A(event,this.form.txtP30_3);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><input class="trecientos_px" name="txtP30_3" id="txtP30_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P30_3']; ?>" onKeyDown="A(event,this.form.txtP30_4);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><input class="trecientos_px" name="txtP30_4" id="txtP30_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P30_4']; ?>" onKeyDown="A(event,this.form.txtP30_5);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><input class="trecientos_px" name="txtP30_5" id="txtP30_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P30_5']; ?>" onKeyDown="A(event,this.form.txtP30_6);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><input class="trecientos_px" name="txtP30_6" id="txtP30_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P30_6']; ?>" onKeyDown="A(event,this.form.btnP30_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP30_anterior"  id="btnP30_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p29')"/></td>
                            <td><input name="btnP30_siguiente" id="btnP30_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p31')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p31" style="display:<?php echo $p31; ?>; top: 350px; position: absolute;"> 
                    <label><strong>V. PRINCIPALES USOS Y PR&Aacute;CTICAS AGR&Iacute;COLAS</strong></label>
                    <table>
                        <tr>
                            <td colspan="3">31. &iquest;La semilla que utiliza es...</td>
                        </tr>
                        <tr>
                            <td>1. criolla?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP31_1" id="txtP31_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P31_1']; ?>" onKeyDown="A(event,this.form.txtP31_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. mejorada?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP31_2" id="txtP31_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P31_2']; ?>" onKeyDown="A(event,this.form.txtP31_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. certificada?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP31_3" id="txtP31_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P31_3']; ?>" onKeyDown="A(event,this.form.btnP31_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP31_anterior"  id="btnP31_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p30')"/></td>
                            <td><input name="btnP31_siguiente" id="btnP31_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p32')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p32" style="display:<?php echo $p32; ?>; top: 350px; position: absolute;">
                    <table>          
                        <tr>
                            <td colspan="2">32. &iquest;Aplica abono org&aacute;nico como esti&eacute;rcol, gallinaza u otros abonos naturales en sus cultivos?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP32" id="txtP32" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P32']; ?>" onKeyDown="A(event,this.form.btnP32_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>          
                    </table>
                    <table>          
                        <tr>
                            <td><input name="btnP32_snterior"  id="btnP32_snterior" value="Anterior" type="button" onclick="enviar(this.form,'p31')"/></td>
                            <td><input name="btnP32_siguiente" id="btnP32_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p33')"/></td>
                        </tr>          
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p33" style="display:<?php echo $p33; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="2">33. &iquest;Aplica abonos qu&iacute;micos (fertilizantes) en sus cultivos?</td>
                        </tr>
                        <tr>
                        </tr>

                    </table>
                    <table>
                        <tr align="right">
                            <td>Si</td>
                            <td>1</td>
                        </tr>
                        <tr align="right">
                            <td>No</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td><input class="cuarenta_px" name="txtP33" id="txtP33" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P33']; ?>" onKeyDown="A(event,this.form.btnP33_siguiente);" autofocus="autofocus" autofocus="autofocus"/></td>
                            <td></td>
                        </tr>
                    </table>
                    <table>    
                        <tr>
                            <td><input name="btnP33_anterior"  id="btnP33_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p32')"/></td>
                            <td><input name="btnP33_siguiente" id="btnP33_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p34')"/></td>
                        </tr>            
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p34" style="display:<?php echo $p34; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td colspan="2">34. &iquest;Utiliza productos qu&iacute;micos para el control de plagas y enfermedades en sus cultivos?</td>
                        </tr>
                        <tr>
                        </tr>    
                    </table>
                    <table>    
                        <tr align="right">
                            <td>Si</td>
                            <td>1</td>
                        </tr>
                        <tr align="right">
                            <td>No</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td><input class="cuarenta_px" name="txtP34" id="txtP34" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P34']; ?>" onKeyDown="A(event,this.form.btnP34_siguiente);" autofocus="autofocus" autofocus="autofocus"/></td>
                            <td></td>
                        </tr>    
                    </table>
                    <table>    
                        <tr>
                            <td><input name="btnP34_anterior"  id="btnP34_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p33')"/></td>
                            <td><input name="btnP34_siguiente" id="btnP34_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p35')"/></td>
                        </tr>    
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p35" style="display:<?php echo $p35; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td colspan="2">35. &iquest;Aplica el control biol&oacute;gico en sus cultivos? (insectos, hongos, bacterias, ranas y otros)</td>
                        </tr>
                        <tr>
                        </tr>    
                    </table>
                    <table>    
                        <tr align="right">
                            <td>Si</td>
                            <td>1</td>
                        </tr>
                        <tr align="right">
                            <td>No</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td><input class="cuarenta_px" name="txtP35" id="txtP35" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P35']; ?>" onKeyDown="A(event,this.form.btnP35_siguiente);" autofocus="autofocus" autofocus="autofocus"/></td>
                            <td></td>
                        </tr>    
                    </table>
                    <table>    
                        <tr>
                            <td><input name="btnP35_anterior"  id="btnP35_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p34')"/></td>
                            <td><input name="btnP35_siguiente" id="btnP35_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p36')"/></td>
                        </tr>    
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p36" style="display:<?php echo $p36; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="2">36. &iquest;Utiliza productos naturales para el control de plagas y enfermedades en sus cultivos?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP36" id="txtP36" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P36']; ?>" onKeyDown="A(event,this.form.btnP36_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP36_anterior"  id="btnP36_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p35')"/></td>
                            <td><input name="btnP36_siguiente" id="btnP36_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p37')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p37" style="display:<?php echo $p37; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">37. &iquest;Tiene cultivos org&aacute;nicos?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>

                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; pase a la pregunta 38</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP37_1" id="txtP37_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P37_1']; ?>" onKeyDown="A(event,this.form.txtP37_1_1);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table border="1">    
                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">Principales cultivos org&aacute;nicos</td>
                            <td colspan="2">&iquest;Tiene <br />certificaci&oacute;n?</td>
                        </tr>
                        <tr>
                            <td>Si 1<br />No 2</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td><input class="trecientos_px" name="txtP37_1_1" id="txtP37_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P37_1_1']; ?>" onKeyDown="A(event,this.form.txtP37_1_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP37_1_2" id="txtP37_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P37_1_2']; ?>" onKeyDown="A(event,this.form.txtP37_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><input class="trecientos_px" name="txtP37_2_1" id="txtP37_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P37_2_1']; ?>" onKeyDown="A(event,this.form.txtP37_2_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP37_2_2" id="txtP37_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P37_2_2']; ?>" onKeyDown="A(event,this.form.txtP37_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><input class="trecientos_px" name="txtP37_3_1" id="txtP37_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P37_3_1']; ?>" onKeyDown="A(event,this.form.txtP37_3_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP37_3_2" id="txtP37_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P37_3_2']; ?>" onKeyDown="A(event,this.form.txtP37_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><input class="trecientos_px" name="txtP37_4_1" id="txtP37_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P37_4_1']; ?>" onKeyDown="A(event,this.form.txtP37_4_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP37_4_2" id="txtP37_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P37_4_2']; ?>" onKeyDown="A(event,this.form.txtP37_5_1);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><input class="trecientos_px" name="txtP37_5_1" id="txtP37_5_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P37_5_1']; ?>" onKeyDown="A(event,this.form.txtP37_5_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP37_5_2" id="txtP37_5_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P37_5_2']; ?>" onKeyDown="A(event,this.form.btnP37_siguiente);"/></td>
                        </tr>    
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP37_anterior"  id="btnP37_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p36')"/></td>
                            <td><input name="btnP37_siguiente" id="btnP37_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p38')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p38" style="display:<?php echo $p38; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td>38. &iquest;Al d&iacute;a de hoy, cu&aacute;l es la cantidad de construcciones e instalaciones que tiene? (anote el
                                a&ntilde;o de la primera y &uacute;ltima construcci&oacute;n)
                            </td>
                        </tr>    
                    </table>
                    <table border="1">    
                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">Principales cultivos org&aacute;nicos</td>
                        </tr>
                        <tr>
                            <td>Cantidad</td>
                            <td>Primer <br />A&ntilde;o</td>
                            <td>Segundo<br />A&ntilde;o</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Silos o pirwas</td>
                            <td><input class="cuarenta_px" name="txtP38_1_1" id="txtP38_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P38_1_1']; ?>" onKeyDown="A(event,this.form.txtP38_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px" name="txtP38_1_2" id="txtP38_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P38_1_2']; ?>" onKeyDown="A(event,this.form.txtP38_1_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP38_1_3" id="txtP38_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P38_1_3']; ?>" onKeyDown="A(event,this.form.txtP38_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Secadoras de grano o cachis</td>
                            <td><input class="cuarenta_px" name="txtP38_2_1" id="txtP38_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P38_2_1']; ?>" onKeyDown="A(event,this.form.txtP38_2_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP38_2_2" id="txtP38_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P38_2_2']; ?>" onKeyDown="A(event,this.form.txtP38_2_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP38_2_3" id="txtP38_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P38_2_3']; ?>" onKeyDown="A(event,this.form.txtP38_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Invernaderos</td>
                            <td><input class="cuarenta_px" name="txtP38_3_1" id="txtP38_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P38_3_1']; ?>" onKeyDown="A(event,this.form.txtP38_3_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP38_3_2" id="txtP38_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P38_3_2']; ?>" onKeyDown="A(event,this.form.txtP38_3_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP38_3_3" id="txtP38_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P38_3_3']; ?>" onKeyDown="A(event,this.form.txtP38_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Carpas solares, walipinis</td>
                            <td><input class="cuarenta_px" name="txtP38_4_1" id="txtP38_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P38_4_1']; ?>" onKeyDown="A(event,this.form.txtP38_4_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP38_4_2" id="txtP38_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P38_4_2']; ?>" onKeyDown="A(event,this.form.txtP38_4_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP38_4_3" id="txtP38_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P38_4_3']; ?>" onKeyDown="A(event,this.form.btnP38_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP38_anterior"  id="btnP38_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p37')"/></td>
                            <td><input name="btnP38_siguiente" id="btnP38_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p39')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p39" style="display:<?php echo $p39; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td>39. &iquest;Al d&iacute;a de hoy, cu&aacute;l es la cantidad de maquinaria, equipos e implementos agr&iacute;colas que
                                tiene? (anote el a&ntilde;o de la primera y &uacute;ltima compra)
                            </td>
                        </tr>    
                    </table>
                    <table border="1">    
                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">Principales cultivos org&aacute;nicos</td>
                        </tr>
                        <tr>
                            <td>Cantidad</td>
                            <td>Primer <br />A&ntilde;o</td>
                            <td>Segundo<br />A&ntilde;o</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Tractores</td>
                            <td><input class="cuarenta_px" name="txtP39_1_1" id="txtP39_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_1_1']; ?>" onKeyDown="A(event,this.form.txtP39_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px" name="txtP39_1_2" id="txtP39_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_1_2']; ?>" onKeyDown="A(event,this.form.txtP39_1_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_1_3" id="txtP39_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_1_3']; ?>" onKeyDown="A(event,this.form.txtP39_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Trilladoras con motor</td>
                            <td><input class="cuarenta_px" name="txtP39_2_1" id="txtP39_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_2_1']; ?>" onKeyDown="A(event,this.form.txtP39_2_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_2_2" id="txtP39_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_2_2']; ?>" onKeyDown="A(event,this.form.txtP39_2_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_2_3" id="txtP39_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_2_3']; ?>" onKeyDown="A(event,this.form.txtP39_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Cosechadoras con motor</td>
                            <td><input class="cuarenta_px" name="txtP39_3_1" id="txtP39_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_3_1']; ?>" onKeyDown="A(event,this.form.txtP39_3_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_3_2" id="txtP39_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_3_2']; ?>" onKeyDown="A(event,this.form.txtP39_3_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_3_3" id="txtP39_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_3_3']; ?>" onKeyDown="A(event,this.form.txtP39_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Enfardadoras con motor</td>
                            <td><input class="cuarenta_px" name="txtP39_4_1" id="txtP39_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_4_1']; ?>" onKeyDown="A(event,this.form.txtP39_4_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_4_2" id="txtP39_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_4_2']; ?>" onKeyDown="A(event,this.form.txtP39_4_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_4_3" id="txtP39_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_4_3']; ?>" onKeyDown="A(event,this.form.txtP39_5_1);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Trilladoras manuales</td>
                            <td><input class="cuarenta_px" name="txtP39_5_1" id="txtP39_5_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_5_1']; ?>" onKeyDown="A(event,this.form.txtP39_5_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_5_2" id="txtP39_5_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_5_2']; ?>" onKeyDown="A(event,this.form.txtP39_5_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_5_3" id="txtP39_5_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_5_3']; ?>" onKeyDown="A(event,this.form.txtP39_6_1);"/></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Cosechadoras manuales</td>
                            <td><input class="cuarenta_px" name="txtP39_6_1" id="txtP39_6_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_6_1']; ?>" onKeyDown="A(event,this.form.txtP39_6_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_6_2" id="txtP39_6_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_6_2']; ?>" onKeyDown="A(event,this.form.txtP39_6_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_6_3" id="txtP39_6_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_6_3']; ?>" onKeyDown="A(event,this.form.txtP39_7_1);"/></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Enfardadoras manuales</td>
                            <td><input class="cuarenta_px" name="txtP39_7_1" id="txtP39_7_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_7_1']; ?>" onKeyDown="A(event,this.form.txtP39_7_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_7_2" id="txtP39_7_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_7_2']; ?>" onKeyDown="A(event,this.form.txtP39_7_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_7_3" id="txtP39_7_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_7_3']; ?>" onKeyDown="A(event,this.form.txtP39_8_1);"/></td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Motocultores</td>
                            <td><input class="cuarenta_px" name="txtP39_8_1" id="txtP39_8_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_8_1']; ?>" onKeyDown="A(event,this.form.txtP39_8_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_8_2" id="txtP39_8_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_8_2']; ?>" onKeyDown="A(event,this.form.txtP39_8_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_8_3" id="txtP39_8_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_8_3']; ?>" onKeyDown="A(event,this.form.txtP39_9_1);"/></td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Equipor de fumigaci&oacute;n<br />(manual y mec&aacute;nico)</td>
                            <td><input class="cuarenta_px" name="txtP39_9_1" id="txtP39_9_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_9_1']; ?>" onKeyDown="A(event,this.form.txtP39_9_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_9_2" id="txtP39_9_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_9_2']; ?>" onKeyDown="A(event,this.form.txtP39_9_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_9_3" id="txtP39_9_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_9_3']; ?>" onKeyDown="A(event,this.form.txtP39_10_1);"/></td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Segadoras o cortadoras</td>
                            <td><input class="cuarenta_px" name="txtP39_10_1" id="txtP39_10_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_10_1']; ?>" onKeyDown="A(event,this.form.txtP39_10_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_10_2" id="txtP39_10_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_10_2']; ?>" onKeyDown="A(event,this.form.txtP39_10_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_10_3" id="txtP39_10_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_10_3']; ?>" onKeyDown="A(event,this.form.txtP39_11_1);"/></td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td>Arados de hierro de tracci&oacute;n<br />animal</td>
                            <td><input class="cuarenta_px" name="txtP39_11_1" id="txtP39_11_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_11_1']; ?>" onKeyDown="A(event,this.form.txtP39_11_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_11_2" id="txtP39_11_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_11_2']; ?>" onKeyDown="A(event,this.form.txtP39_11_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_11_3" id="txtP39_11_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_11_3']; ?>" onKeyDown="A(event,this.form.txtP39_12_1);"/></td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>Arados de madera de <br />tracci&oacute;n animal</td>
                            <td><input class="cuarenta_px" name="txtP39_12_1" id="txtP39_12_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_12_1']; ?>" onKeyDown="A(event,this.form.txtP39_12_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_12_2" id="txtP39_12_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_12_2']; ?>" onKeyDown="A(event,this.form.txtP39_12_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_12_3" id="txtP39_12_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_12_3']; ?>" onKeyDown="A(event,this.form.txtP39_13_1);"/></td>
                        </tr>
                        <tr>
                            <td>13</td>
                            <td>Arados de todo tipo de <br />tracci&oacute;n mec&aacute;nica</td>
                            <td><input class="cuarenta_px" name="txtP39_13_1" id="txtP39_13_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_13_1']; ?>" onKeyDown="A(event,this.form.txtP39_13_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_13_2" id="txtP39_13_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_13_2']; ?>" onKeyDown="A(event,this.form.txtP39_13_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_13_3" id="txtP39_13_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_13_3']; ?>" onKeyDown="A(event,this.form.txtP39_14_1);"/></td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td>Carros de arrastre (de todo<br />tipo)</td>
                            <td><input class="cuarenta_px" name="txtP39_14_1" id="txtP39_14_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_14_1']; ?>" onKeyDown="A(event,this.form.txtP39_14_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_14_2" id="txtP39_14_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_14_2']; ?>" onKeyDown="A(event,this.form.txtP39_14_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_14_3" id="txtP39_14_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_14_3']; ?>" onKeyDown="A(event,this.form.txtP39_15_1);"/></td>
                        </tr>
                        <tr>
                            <td>15</td>
                            <td>Rastras</td>
                            <td><input class="cuarenta_px" name="txtP39_15_1" id="txtP39_15_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_15_1']; ?>" onKeyDown="A(event,this.form.txtP39_15_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_15_2" id="txtP39_15_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_15_2']; ?>" onKeyDown="A(event,this.form.txtP39_15_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_15_3" id="txtP39_15_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_15_3']; ?>" onKeyDown="A(event,this.form.txtP39_16_1);"/></td>
                        </tr>
                        <tr>
                            <td>16</td>
                            <td>Tolvas abonadoras</td>
                            <td><input class="cuarenta_px" name="txtP39_16_1" id="txtP39_16_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_16_1']; ?>" onKeyDown="A(event,this.form.txtP39_16_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_16_2" id="txtP39_16_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_16_2']; ?>" onKeyDown="A(event,this.form.txtP39_16_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_16_3" id="txtP39_16_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_16_3']; ?>" onKeyDown="A(event,this.form.txtP39_17_1);"/></td>
                        </tr>
                        <tr>
                            <td>17</td>
                            <td>Sembradoras de todo tipo</td>
                            <td><input class="cuarenta_px" name="txtP39_17_1" id="txtP39_17_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_17_1']; ?>" onKeyDown="A(event,this.form.txtP39_17_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_17_2" id="txtP39_17_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_17_2']; ?>" onKeyDown="A(event,this.form.txtP39_17_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_17_3" id="txtP39_17_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_17_3']; ?>" onKeyDown="A(event,this.form.txtP39_18_1);"/></td>
                        </tr>
                        <tr>
                            <td>18</td>
                            <td>Lavadora de ortalizas</td>
                            <td><input class="cuarenta_px" name="txtP39_18_1" id="txtP39_18_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_18_1']; ?>" onKeyDown="A(event,this.form.txtP39_18_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_18_2" id="txtP39_18_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_18_2']; ?>" onKeyDown="A(event,this.form.txtP39_18_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP39_18_3" id="txtP39_18_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P39_18_3']; ?>" onKeyDown="A(event,this.form.btnP39_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP39_anterior"  id="btnP39_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p38')"/></td>
                            <td><input name="btnP39_siguiente" id="btnP39_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p40')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p40" style="display:<?php echo $p40; ?>; top: 350px; position: absolute;"> 
                    <label><strong>VI. GANADER&Iacute;A Y AVES</strong></label>
                    <table>
                        <tr>
                            <td colspan="3">40. &iquest;Tiene o maneja ganado bovino?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>

                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 48</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP40" id="txtP40" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P40']; ?>" onKeyDown="A(event,this.form.btnP40_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>

                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP40_anterior"  id="btnP40_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p39')"/></td>
                            <td><input name="btnP40_siguiente" id="btnP40_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p41')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p41" style="display:<?php echo $p41; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td>41. &iquest;Cu&aacute;ntas cabezas de ganado bovino, seg&uacute;n sexo y grupo de edades, tiene o maneja?</td>
                        </tr>    
                    </table>
                    <table border="1">

                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">Sexo y grupo <br />de edades </td>
                            <td colspan="3">Cabezas de ganado bobino</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>Especialidad<br />de leche</td>
                            <td>Especialidad<br />de carne</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>TOTAL</td>
                            <td><input class="cuarenta_px" name="txtP41_1_1" id="txtP41_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_1_1']; ?>" onKeyDown="A(event,this.form.txtP41_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px" name="txtP41_1_2" id="txtP41_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_1_2']; ?>" onKeyDown="A(event,this.form.txtP41_1_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_1_3" id="txtP41_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_1_3']; ?>" onKeyDown="A(event,this.form.txtP41_2_1);"/></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Total machos</td>
                            <td><input class="cuarenta_px" name="txtP41_2_1" id="txtP41_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_2_1']; ?>" onKeyDown="A(event,this.form.txtP41_2_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_2_2" id="txtP41_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_2_2']; ?>" onKeyDown="A(event,this.form.txtP41_2_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_2_3" id="txtP41_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_2_3']; ?>" onKeyDown="A(event,this.form.txtP41_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Machos menores <br />a un a&ntilde;o</td>
                            <td><input class="cuarenta_px" name="txtP41_3_1" id="txtP41_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_3_1']; ?>" onKeyDown="A(event,this.form.txtP41_3_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_3_2" id="txtP41_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_3_2']; ?>" onKeyDown="A(event,this.form.txtP41_3_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_3_3" id="txtP41_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_3_3']; ?>" onKeyDown="A(event,this.form.txtP41_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Machos de 1 a<br />menos de 2 a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP41_4_1" id="txtP41_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_4_1']; ?>" onKeyDown="A(event,this.form.txtP41_4_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_4_2" id="txtP41_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_4_2']; ?>" onKeyDown="A(event,this.form.txtP41_4_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_4_3" id="txtP41_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_4_3']; ?>" onKeyDown="A(event,this.form.txtP41_5_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Machos de 2 a<br />menos de 3 a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP41_5_1" id="txtP41_5_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_5_1']; ?>" onKeyDown="A(event,this.form.txtP41_5_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_5_2" id="txtP41_5_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_5_2']; ?>" onKeyDown="A(event,this.form.txtP41_5_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_5_3" id="txtP41_5_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_5_3']; ?>" onKeyDown="A(event,this.form.txtP41_6_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Machos de 3 o<br />m&aacute;s a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP41_6_1" id="txtP41_6_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_6_1']; ?>" onKeyDown="A(event,this.form.txtP41_6_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_6_2" id="txtP41_6_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_6_2']; ?>" onKeyDown="A(event,this.form.txtP41_6_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_6_3" id="txtP41_6_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_6_3']; ?>" onKeyDown="A(event,this.form.txtP41_7_1);"/></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Total hembras</td>
                            <td><input class="cuarenta_px" name="txtP41_7_1" id="txtP41_7_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_7_1']; ?>" onKeyDown="A(event,this.form.txtP41_7_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_7_2" id="txtP41_7_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_7_2']; ?>" onKeyDown="A(event,this.form.txtP41_7_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_7_3" id="txtP41_7_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_7_3']; ?>" onKeyDown="A(event,this.form.txtP41_8_1);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Hembras menores<br />a 1 a&ntilde;o </td>
                            <td><input class="cuarenta_px" name="txtP41_8_1" id="txtP41_8_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_8_1']; ?>" onKeyDown="A(event,this.form.txtP41_8_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_8_2" id="txtP41_8_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_8_2']; ?>" onKeyDown="A(event,this.form.txtP41_8_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_8_3" id="txtP41_8_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_8_3']; ?>" onKeyDown="A(event,this.form.txtP41_9_1);"/></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Hembras de 1 a<br />menos de 2 a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP41_9_1" id="txtP41_9_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_9_1']; ?>" onKeyDown="A(event,this.form.txtP41_9_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_9_2" id="txtP41_9_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_9_2']; ?>" onKeyDown="A(event,this.form.txtP41_9_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_9_3" id="txtP41_9_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_9_3']; ?>" onKeyDown="A(event,this.form.txtP41_10_1);"/></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Hembras de 2 a<br />menos de 3 a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP41_10_1" id="txtP41_10_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_10_1']; ?>" onKeyDown="A(event,this.form.txtP41_10_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_10_2" id="txtP41_10_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_10_2']; ?>" onKeyDown="A(event,this.form.txtP41_10_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_10_3" id="txtP41_10_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_10_3']; ?>" onKeyDown="A(event,this.form.txtP41_11_1);"/></td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Hembras de 3 o<br />m&aacute;s a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP41_11_1" id="txtP41_11_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_11_1']; ?>" onKeyDown="A(event,this.form.txtP41_11_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_11_2" id="txtP41_11_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_11_2']; ?>" onKeyDown="A(event,this.form.txtP41_11_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_11_3" id="txtP41_11_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_11_3']; ?>" onKeyDown="A(event,this.form.txtP41_12_1);"/></td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Bueyes <br />o chi&ntilde;ueleros</td>
                            <td><input class="cuarenta_px" name="txtP41_12_1" id="txtP41_12_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_12_1']; ?>" onKeyDown="A(event,this.form.txtP41_12_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_12_2" id="txtP41_12_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_12_2']; ?>" onKeyDown="A(event,this.form.txtP41_12_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP41_12_3" id="txtP41_12_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P41_12_3']; ?>" onKeyDown="A(event,this.form.btnP41_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP41_anterior"  id="btnP41_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p40')"/></td>
                            <td><input name="btnP41_siguiente" id="btnP41_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p42')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p42" style="display:<?php echo $p42; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>42. &iquest;Cu&aacute;ntas de sus vacas han sido orde&ntilde;adas el d&iacute;a de ayer?</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td align="right">N&uacute;mero de vacas orde&ntilde;adas</td>
                            <td><input class="cuarenta_px" name="txtP42" id="txtP42" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P42']; ?>" onKeyDown="A(event,this.form.btnP42_siguiente);" autofocus="autofocus"/></td>
                            <td>si es 0 pase a la pregunta 47</td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP42_anterior"  id="btnP42_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p41')"/></td>
                            <td><input name="btnP42_siguiente" id="btnP42_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p43')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p43" style="display:<?php echo $p43; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>43. &iquest;Cu&aacute;ntas orde&ntilde;as realiza al d&iacute;a?</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td align="right">N&uacute;mero de orde&ntilde;as</td>
                            <td><input class="cuarenta_px" name="txtP43" id="txtP43" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P43']; ?>" onKeyDown="A(event,this.form.btnP43_siguiente);" autofocus="autofocus"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP43_anterior"  id="btnP43_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p42')"/></td>
                            <td><input name="btnP43_siguiente" id="btnP43_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p44')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p44" style="display:<?php echo $p44; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>44. &iquest;Cu&aacute;nto fue la producci&oacute;n de leche de sus vacas orde&ntilde;adas ayer?</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td align="right">Litros de leche</td>
                            <td><input class="cuarenta_px" name="txt44" id="txt44" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P44']; ?>" onKeyDown="A(event,this.form.btnP44_siguiente);" autofocus="autofocus"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP44_anterior"  id="btnP44_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p43')"/></td>
                            <td><input name="btnP44_siguiente" id="btnP44_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p45')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p45" style="display:<?php echo $p45; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">45. &iquest;La leche se destina a...</td>
                        </tr>
                        <tr>
                            <td>1. venta?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP45_1" id="txtP45_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P45_1']; ?>" onKeyDown="A(event,this.form.txtP45_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. consumo de hogar?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP45_2" id="txtP45_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P45_2']; ?>" onKeyDown="A(event,this.form.txtP45_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. otros?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP45_3" id="txtP45_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P45_3']; ?>" onKeyDown="A(event,this.form.btnP45_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP45_anterior"  id="btnP45_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p44')"/></td>
                            <td><input name="btnP45_siguiente" id="btnP45_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p46')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p46" style="display:<?php echo $p46; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">46. &iquest;El orde&ntilde;o de sus vacas principalmente es?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Manual</td>
                                        <td>1</td>
                                    </tr>
                                    <tr align="right">
                                        <td>Mec&aacute;nico</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><input class="cuarenta_px" name="txtP46" id="txtP46" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P46']; ?>" onKeyDown="A(event,this.form.btnP46_siguiente);" autofocus="autofocus"/></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP46_anterior"  id="btnP46_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p45')"/></td>
                            <td><input name="btnP46_siguiente" id="btnP46_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p47')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p47" style="display:<?php echo $p47; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">47. &iquest;El ganado bovino se destina a...</td>
                        </tr>
                        <tr>
                            <td>1. venta?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP47_1" id="txtP47_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P47_1']; ?>" onKeyDown="A(event,this.form.txtP47_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. consumo de hogar?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP47_2" id="txtP47_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P47_2']; ?>" onKeyDown="A(event,this.form.txtP47_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. otros?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP47_3" id="txtP47_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P47_3']; ?>" onKeyDown="A(event,this.form.btnP47_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP47_anterior"  id="btnP47_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p46')"/></td>
                            <td><input name="btnP47_siguiente" id="btnP47_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p48')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p48" style="display:<?php echo $p48; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">48. &iquest;Tiene o maneja b&uacute;falos?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 50</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP48" id="txtP48" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P48']; ?>" onKeyDown="A(event,this.form.btnP48_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP48_anterior"  id="btnP48_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p47')"/></td>
                            <td><input name="btnP48_siguiente" id="btnP48_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p49')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p49" style="display:<?php echo $p49; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>49. &iquest;Cu&aacute;ntas cabezas de b&uacute;falo por sexo tiene o maneja?</td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td rowspan="3">B&uacute;falos</td>
                            <td colspan="3">Cabezas de b&uacute;falos</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>Machos</td>
                            <td>Hembras</td>
                        </tr>
                        <tr>
                            <td> <input class="cuarenta_px" name="txtP49_1" id="txtP49_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P49_1']; ?>" onKeyDown="A(event,this.form.txtP49_2);" autofocus="autofocus"/></td>
                            <td> <input class="cuarenta_px" name="txtP49_2" id="txtP49_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P49_2']; ?>" onKeyDown="A(event,this.form.txtP49_3);"/></td>
                            <td> <input class="cuarenta_px" name="txtP49_3" id="txtP49_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P49_3']; ?>" onKeyDown="A(event,this.form.btnP49_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP49_anterior"  id="btnP49_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p48')"/></td>
                            <td><input name="btnP49_siguiente" id="btnP49_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p50')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p50" style="display:<?php echo $p50; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">50. &iquest;Tiene o maneja ganado ovino?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 54</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP50" id="txtP50" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P50']; ?>" onKeyDown="A(event,this.form.btnP50_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP50_anterior"  id="btnP50_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p49')"/></td>
                            <td><input name="btnP50_siguiente" id="btnP50_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p51')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p51" style="display:<?php echo $p51; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>51. &iquest;Cu&aacute;ntas cabezas de ganado ovino, por sexo, seg&uacute;n grupo de edades, tiene o maneja?</td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td rowspan="3"></td>
                            <td rowspan="2">Grupos <br />de edades</td>
                            <td colspan="3">Cabezas de ganado ovino</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>Machos</td>
                            <td>Hembras</td>
                        </tr>
                        <tr>
                            <td>TOTAL</td>
                            <td><input class="cuarenta_px" name="txtP51_1_1" id="txtP51_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P51_1_1']; ?>" onKeyDown="A(event,this.form.txtP51_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px" name="txtP51_1_2" id="txtP51_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P51_1_2']; ?>" onKeyDown="A(event,this.form.txtP51_1_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP51_1_3" id="txtP51_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P51_1_3']; ?>" onKeyDown="A(event,this.form.txtP51_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Menores de<br />1 a&ntilde;o</td>
                            <td><input class="cuarenta_px" name="txtP51_2_1" id="txtP51_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P51_2_1']; ?>" onKeyDown="A(event,this.form.txtP51_2_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP51_2_2" id="txtP51_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P51_2_2']; ?>" onKeyDown="A(event,this.form.txtP51_2_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP51_2_3" id="txtP51_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P51_2_3']; ?>" onKeyDown="A(event,this.form.txtP51_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>De 1 a menos<br />de 2 a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP51_3_1" id="txtP51_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P51_3_1']; ?>" onKeyDown="A(event,this.form.txtP51_3_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP51_3_2" id="txtP51_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P51_3_2']; ?>" onKeyDown="A(event,this.form.txtP51_3_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP51_3_3" id="txtP51_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P51_3_3']; ?>" onKeyDown="A(event,this.form.txtP51_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>De 2 o mas<br />a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP51_4_1" id="txtP51_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P51_4_1']; ?>" onKeyDown="A(event,this.form.txtP51_4_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP51_4_2" id="txtP51_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P51_4_2']; ?>" onKeyDown="A(event,this.form.txtP51_4_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP51_4_3" id="txtP51_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P51_4_3']; ?>" onKeyDown="A(event,this.form.btnP51_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP51_anterior"  id="btnP51_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p51')"/></td>
                            <td><input name="btnP51_siguiente" id="btnP51_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p52')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p52" style="display:<?php echo $p52; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">52. &iquest;El ganado ovino se destina a...</td>
                        </tr>
                        <tr>
                            <td>1. venta?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP52_1" id="txtP52_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P52_1']; ?>" onKeyDown="A(event,this.form.txtP52_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. consumo de hogar?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP52_2" id="txtP52_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P52_2']; ?>" onKeyDown="A(event,this.form.txtP52_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. otros?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP52_3" id="txtP52_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P52_3']; ?>" onKeyDown="A(event,this.form.btnP52_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP52_anterior"  id="btnP52_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p51')"/></td>
                            <td><input name="btnP52_siguiente" id="btnP52_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p53')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p53" style="display:<?php echo $p53; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">53. &iquest;La lana esquilada de ovinos se
                                destina a...</td>
                        </tr>
                        <tr>
                            <td>1. venta?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP53_1" id="txtP53_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P53_1']; ?>" onKeyDown="A(event,this.form.txtP53_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. consumo de hogar?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP53_2" id="txtP53_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P53_2']; ?>" onKeyDown="A(event,this.form.txtP53_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. otros?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP53_3" id="txtP53_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P53_3']; ?>" onKeyDown="A(event,this.form.btnP53_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP53_anterior"  id="btnP53_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p52')"/></td>
                            <td><input name="btnP53_siguiente" id="btnP53_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p54')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p54" style="display:<?php echo $p54; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">54.&iquest;Tiene o maneja ganado porcino de granja?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 56</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP54" id="txtP54" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P54']; ?>" onKeyDown="A(event,this.form.btnP54_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP54_anterior"  id="btnP54_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p53')"/></td>
                            <td><input name="btnP54_siguiente" id="btnP54_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p55')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p55" style="display:<?php echo $p55; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>55. &iquest;Cu&aacute;ntas cabezas de ganado porcino, por sexo, seg&uacute;n grupo de edades, tiene o maneja?</td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">Grupo <br />de edades</td>
                            <td colspan="5" align="center">Cabezas de ganado bobino</td>
                        </tr>
                        <tr>
                            <td rowspan="2">Total</td>
                            <td colspan="2" align="center">Machos</td>
                            <td colspan="2" align="center">Hembras</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>TOTAL</td>
                            <td>Padrillos o<br />reproductores</td>
                            <td>Engorde</td>
                            <td>Vientres o<br />reproductoras</td>
                            <td>Engorde</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Menores de<br />un a&ntilde;o</td>
                            <td><input class="cuarenta_px" name="txtP55_1_1" id="txtP55_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P55_1_1']; ?>" onKeyDown="A(event,this.form.txtP55_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px" name="txtP55_1_2" id="txtP55_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P55_1_2']; ?>" onKeyDown="A(event,this.form.txtP55_1_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP55_1_3" id="txtP55_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P55_1_3']; ?>" onKeyDown="A(event,this.form.txtP55_1_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP55_1_4" id="txtP55_1_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P55_1_4']; ?>" onKeyDown="A(event,this.form.txtP55_1_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP55_1_5" id="txtP55_1_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P55_1_5']; ?>" onKeyDown="A(event,this.form.txtP55_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>De 1 a menos<br />de 2 a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP55_2_1" id="txtP55_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P55_2_1']; ?>" onKeyDown="A(event,this.form.txtP55_2_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP55_2_2" id="txtP55_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P55_2_2']; ?>" onKeyDown="A(event,this.form.txtP55_2_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP55_2_3" id="txtP55_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P55_2_3']; ?>" onKeyDown="A(event,this.form.txtP55_2_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP55_2_4" id="txtP55_2_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P55_2_4']; ?>" onKeyDown="A(event,this.form.txtP55_2_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP55_2_5" id="txtP55_2_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P55_2_5']; ?>" onKeyDown="A(event,this.form.txtP55_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>De 2 o m&aacute;s<br />a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP55_3_1" id="txtP55_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P55_3_1']; ?>" onKeyDown="A(event,this.form.txtP55_3_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP55_3_2" id="txtP55_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P55_3_2']; ?>" onKeyDown="A(event,this.form.txtP55_3_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP55_3_3" id="txtP55_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P55_3_3']; ?>" onKeyDown="A(event,this.form.txtP55_3_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP55_3_4" id="txtP55_3_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P55_3_4']; ?>" onKeyDown="A(event,this.form.txtP55_3_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP55_3_5" id="txtP55_3_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P55_3_5']; ?>" onKeyDown="A(event,this.form.btnP55_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP55_anterior"  id="btnP55_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p54')"/></td>
                            <td><input name="btnP55_siguiente" id="btnP55_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p56')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p56" style="display:<?php echo $p56; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">56.&iquest;Tiene o maneja ganado porcino de corral?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>

                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 59</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP56" id="txtP56" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P56']; ?>" onKeyDown="A(event,this.form.btnP56_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP56_anterior"  id="btnP56_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p55')"/></td>
                            <td><input name="btnP56_siguiente" id="btnP56_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p57')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p57" style="display:<?php echo $p57; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>57. &iquest;Cu&aacute;ntas cabezas de ganado porcino, por sexo, seg&uacute;n grupo de edades, tiene o maneja?</td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">Grupo <br />de edades</td>
                            <td colspan="3" align="center">Cabezas de ganado bobino</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td align="center">Machos</td>
                            <td align="center">Hembras</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>TOTAL</td>
                            <td><input class="cuarenta_px" name="txtP57_1_1" id="txtP57_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P57_1_1']; ?>" onKeyDown="A(event,this.form.txtP57_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px" name="txtP57_1_2" id="txtP57_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P57_1_2']; ?>" onKeyDown="A(event,this.form.txtP57_1_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP57_1_3" id="txtP57_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P57_1_3']; ?>" onKeyDown="A(event,this.form.txtP57_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Menores de<br />un a&ntilde;o</td>
                            <td><input class="cuarenta_px" name="txtP57_2_1" id="txtP57_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P57_2_1']; ?>" onKeyDown="A(event,this.form.txtP57_2_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP57_2_2" id="txtP57_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P57_2_2']; ?>" onKeyDown="A(event,this.form.txtP57_2_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP57_2_3" id="txtP57_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P57_2_3']; ?>" onKeyDown="A(event,this.form.txtP57_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>De 1 a menos<br />de 2 a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP57_3_1" id="txtP57_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P57_3_1']; ?>" onKeyDown="A(event,this.form.txtP57_3_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP57_3_2" id="txtP57_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P57_3_2']; ?>" onKeyDown="A(event,this.form.txtP57_3_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP57_3_3" id="txtP57_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P57_3_3']; ?>" onKeyDown="A(event,this.form.txtP57_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>De 2 o m&aacute;s<br />a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP57_4_1" id="txtP57_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P57_4_1']; ?>" onKeyDown="A(event,this.form.txtP57_4_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP57_4_2" id="txtP57_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P57_4_2']; ?>" onKeyDown="A(event,this.form.txtP57_4_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP57_4_3" id="txtP57_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P57_4_3']; ?>" onKeyDown="A(event,this.form.btnP57_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP57_anterior"  id="btnP57_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p56')"/></td>
                            <td><input name="btnP57_siguiente" id="btnP57_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p58')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p58" style="display:<?php echo $p58; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">58. &iquest;El ganado porcino de corral se destina a...</td>
                        </tr>
                        <tr>
                            <td>1. venta?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP58_1" id="txtP58_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P58_1']; ?>" onKeyDown="A(event,this.form.txtP58_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. consumo de hogar?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP58_2" id="txtP58_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P58_2']; ?>" onKeyDown="A(event,this.form.txtP58_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. otros?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP58_3" id="txtP58_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P58_3']; ?>" onKeyDown="A(event,this.form.btnP58_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP58_anterior"  id="btnP58_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p57')"/></td>
                            <td><input name="btnP58_siguiente" id="btnP58_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p59')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p59" style="display:<?php echo $p59; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">59.&iquest;Tiene o maneja ganado caprino?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 62</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP59" id="txtP59" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P59']; ?>" onKeyDown="A(event,this.form.btnP59_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP59_anterior"  id="btnP59_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p58')"/></td>
                            <td><input name="btnP59_siguiente" id="btnP59_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p60')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p60" style="display:<?php echo $p60; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>60. &iquest;Cu&aacute;ntas cabezas de ganado caprino, por sexo, seg&uacute;n grupo de edades, tiene o maneja?</td>
                        </tr>
                    </table>
                    <table border="1">

                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">Grupo <br />de edades</td>
                            <td colspan="3" align="center">Cabezas de ganado caprino</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td align="center">Machos</td>
                            <td align="center">Hembras</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>TOTAL</td>
                            <td><input class="cuarenta_px" name="txtP60_1_1" id="txtP60_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P60_1_1']; ?>" onKeyDown="A(event,this.form.txtP60_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px" name="txtP60_1_2" id="txtP60_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P60_1_2']; ?>" onKeyDown="A(event,this.form.txtP60_1_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP60_1_3" id="txtP60_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P60_1_3']; ?>" onKeyDown="A(event,this.form.txtP60_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Menores de<br />un a&ntilde;o</td>
                            <td><input class="cuarenta_px" name="txtP60_2_1" id="txtP60_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P60_2_1']; ?>" onKeyDown="A(event,this.form.txtP60_2_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP60_2_2" id="txtP60_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P60_2_2']; ?>" onKeyDown="A(event,this.form.txtP60_2_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP60_2_3" id="txtP60_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P60_2_3']; ?>" onKeyDown="A(event,this.form.txtP60_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>De 1 a menos<br />de 2 a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP60_3_1" id="txtP60_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P60_3_1']; ?>" onKeyDown="A(event,this.form.txtP60_3_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP60_3_2" id="txtP60_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P60_3_2']; ?>" onKeyDown="A(event,this.form.txtP60_3_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP60_3_3" id="txtP60_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P60_3_3']; ?>" onKeyDown="A(event,this.form.txtP60_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>De 2 o m&aacute;s<br />a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP60_4_1" id="txtP60_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P60_4_1']; ?>" onKeyDown="A(event,this.form.txtP60_4_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP60_4_2" id="txtP60_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P60_4_2']; ?>" onKeyDown="A(event,this.form.txtP60_4_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP60_4_3" id="txtP60_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P60_4_3']; ?>" onKeyDown="A(event,this.form.btnP60_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP60_anterior"  id="btnP60_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p59')"/></td>
                            <td><input name="btnP60_siguiente" id="btnP60_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p61')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p61" style="display:<?php echo $p61; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">61. &iquest;El ganado caprino se destina a...</td>
                        </tr>
                        <tr>
                            <td>1. venta?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP61_1" id="txtP61_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P61_1']; ?>" onKeyDown="A(event,this.form.txtP61_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. consumo de hogar?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP61_2" id="txtP61_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P61_2']; ?>" onKeyDown="A(event,this.form.txtP61_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. otros?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP61_3" id="txtP61_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P61_3']; ?>" onKeyDown="A(event,this.form.btnP61_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP61_anterior"  id="btnP61_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p60')"/></td>
                            <td><input name="btnP61_siguiente" id="btnP61_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p62')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p62" style="display:<?php echo $p62; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">62. &iquest;Tiene o maneja llamas?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 66</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP62" id="txtP62" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P62']; ?>" onKeyDown="A(event,this.form.btnP62_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP62_anterior"  id="btnP62_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p61')"/></td>
                            <td><input name="btnP62_siguiente" id="btnP62_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p63')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p63" style="display:<?php echo $p63; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>63. &iquest;Cu&aacute;ntas cabezas de llamas, seg&uacute;n sexo y grupos de edades, tiene o maneja?</td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">Sexo y grupos <br />de edades</td>
                            <td colspan="4" align="center">Cabezas de llamas</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td align="center">Q'aras</td>
                            <td align="center">T'ampullis</td>
                            <td align="center">Intermedio</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>TOTAL</td>
                            <td><input class="cuarenta_px" name="txtP63_1_1" id="txtP63_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_1_1']; ?>" onKeyDown="A(event,this.form.txtP63_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px" name="txtP63_1_2" id="txtP63_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_1_2']; ?>" onKeyDown="A(event,this.form.txtP63_1_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_1_3" id="txtP63_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_1_3']; ?>" onKeyDown="A(event,this.form.txtP63_1_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_1_4" id="txtP63_1_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_1_4']; ?>" onKeyDown="A(event,this.form.txtP63_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>Total machos</td>
                            <td><input class="cuarenta_px" name="txtP63_2_1" id="txtP63_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_2_1']; ?>" onKeyDown="A(event,this.form.txtP63_2_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_2_2" id="txtP63_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_2_2']; ?>" onKeyDown="A(event,this.form.txtP63_2_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_2_3" id="txtP63_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_2_3']; ?>" onKeyDown="A(event,this.form.txtP63_2_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_2_4" id="txtP63_2_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_2_4']; ?>" onKeyDown="A(event,this.form.txtP63_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Machos <br />menores de<br />un a&ntilde;o</td>
                            <td><input class="cuarenta_px" name="txtP63_3_1" id="txtP63_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_3_1']; ?>" onKeyDown="A(event,this.form.txtP63_3_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_3_2" id="txtP63_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_3_2']; ?>" onKeyDown="A(event,this.form.txtP63_3_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_3_3" id="txtP63_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_3_3']; ?>" onKeyDown="A(event,this.form.txtP63_3_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_3_4" id="txtP63_3_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_3_4']; ?>" onKeyDown="A(event,this.form.txtP63_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Machos de 1 <br />a menos de 3<br />a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP63_4_1" id="txtP63_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_4_1']; ?>" onKeyDown="A(event,this.form.txtP63_4_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_4_2" id="txtP63_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_4_2']; ?>" onKeyDown="A(event,this.form.txtP63_4_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_4_3" id="txtP63_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_4_3']; ?>" onKeyDown="A(event,this.form.txtP63_4_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_4_4" id="txtP63_4_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_4_4']; ?>" onKeyDown="A(event,this.form.txtP63_5_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Machos de 3 o <br />m&aacute;s a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP63_5_1" id="txtP63_5_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_5_1']; ?>" onKeyDown="A(event,this.form.txtP63_5_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_5_2" id="txtP63_5_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_5_2']; ?>" onKeyDown="A(event,this.form.txtP63_5_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_5_3" id="txtP63_5_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_5_3']; ?>" onKeyDown="A(event,this.form.txtP63_5_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_5_4" id="txtP63_5_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_5_4']; ?>" onKeyDown="A(event,this.form.txtP63_6_1);"/></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>Total hembras</td>
                            <td><input class="cuarenta_px" name="txtP63_6_1" id="txtP63_6_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_6_1']; ?>" onKeyDown="A(event,this.form.txtP63_6_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_6_2" id="txtP63_6_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_6_2']; ?>" onKeyDown="A(event,this.form.txtP63_6_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_6_3" id="txtP63_6_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_6_3']; ?>" onKeyDown="A(event,this.form.txtP63_6_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_6_4" id="txtP63_6_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_6_4']; ?>" onKeyDown="A(event,this.form.txtP63_7_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Hembras<br />menores de<br />un a&ntilde;o</td>
                            <td><input class="cuarenta_px" name="txtP63_7_1" id="txtP63_7_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_7_1']; ?>" onKeyDown="A(event,this.form.txtP63_7_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_7_2" id="txtP63_7_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_7_2']; ?>" onKeyDown="A(event,this.form.txtP63_7_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_7_3" id="txtP63_7_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_7_3']; ?>" onKeyDown="A(event,this.form.txtP63_7_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_7_4" id="txtP63_7_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_7_4']; ?>" onKeyDown="A(event,this.form.txtP63_8_1);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Hembras de 1<br />a menos de 3<br />a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP63_8_1" id="txtP63_8_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_8_1']; ?>" onKeyDown="A(event,this.form.txtP63_8_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_8_2" id="txtP63_8_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_8_2']; ?>" onKeyDown="A(event,this.form.txtP63_8_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_8_3" id="txtP63_8_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_8_3']; ?>" onKeyDown="A(event,this.form.txtP63_8_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_8_4" id="txtP63_8_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_8_4']; ?>" onKeyDown="A(event,this.form.txtP63_9_1);"/></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Hembras de 3<br />o m&aacute;s a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP63_9_1" id="txtP63_9_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_9_1']; ?>" onKeyDown="A(event,this.form.txtP63_9_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_9_2" id="txtP63_9_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_9_2']; ?>" onKeyDown="A(event,this.form.txtP63_9_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_9_3" id="txtP63_9_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_9_3']; ?>" onKeyDown="A(event,this.form.txtP63_9_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP63_9_4" id="txtP63_9_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P63_9_4']; ?>" onKeyDown="A(event,this.form.btnP63_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP63_anterior"  id="btnP63_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p62')"/></td>
                            <td><input name="btnP63_siguiente" id="btnP63_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p64')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p64" style="display:<?php echo $p64; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">64. &iquest;Las llamas se destinan a...</td>
                        </tr>
                        <tr>
                            <td>1. venta?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP64_1" id="txtP64_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P64_1']; ?>" onKeyDown="A(event,this.form.txtP64_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. consumo de hogar?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP64_2" id="txtP64_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P64_2']; ?>" onKeyDown="A(event,this.form.txtP64_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. otros?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP64_3" id="txtP64_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P64_3']; ?>" onKeyDown="A(event,this.form.btnP64_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP64_anterior"  id="btnP64_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p63')"/></td>
                            <td><input name="btnP64_siguiente" id="btnP64_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p65')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p65" style="display:<?php echo $p65; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">65. &iquest;La fibra esquilada de llama se destina a...</td>
                        </tr>
                        <tr>
                            <td>1. venta?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP65_1" id="txtP65_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P65_1']; ?>" onKeyDown="A(event,this.form.txtP65_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. uso del hogar?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP65_2" id="txtP65_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P65_2']; ?>" onKeyDown="A(event,this.form.txtP65_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. otros?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP65_3" id="txtP65_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P65_3']; ?>" onKeyDown="A(event,this.form.btnP65_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP65_anterior"  id="btnP65_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p64')"/></td>
                            <td><input name="btnP65_siguiente" id="btnP65_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p66')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p66" style="display:<?php echo $p66; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">66.&iquest;Tiene o maneja alpacas?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 70</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP66" id="txtP66" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P66']; ?>" onKeyDown="A(event,this.form.btnP66_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP66_anterior"  id="btnP66_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p65')"/></td>
                            <td><input name="btnP66_siguiente" id="btnP66_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p67')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p67" style="display:<?php echo $p67; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>67.&iquest;Cu&aacute;ntas cabezas de alpacas, seg&uacute;n sexo y grupo de edades, tiene o maneja?</td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">Sexo y grupos <br />de edades</td>
                            <td colspan="4" align="center">Cabezas de alpacas</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td align="center">Suri</td>
                            <td align="center">Huacaya</td>
                            <td align="center">Intermedio</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>TOTAL</td>
                            <td><input class="cuarenta_px" name="txtP67_1_1" id="txtP67_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_1_1']; ?>" onKeyDown="A(event,this.form.txtP67_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px" name="txtP67_1_2" id="txtP67_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_1_2']; ?>" onKeyDown="A(event,this.form.txtP67_1_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_1_3" id="txtP67_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_1_3']; ?>" onKeyDown="A(event,this.form.txtP67_1_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_1_4" id="txtP67_1_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_1_4']; ?>" onKeyDown="A(event,this.form.txtP67_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>Total machos</td>
                            <td><input class="cuarenta_px" name="txtP67_2_1" id="txtP67_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_2_1']; ?>" onKeyDown="A(event,this.form.txtP67_2_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_2_2" id="txtP67_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_2_2']; ?>" onKeyDown="A(event,this.form.txtP67_2_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_2_3" id="txtP67_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_2_3']; ?>" onKeyDown="A(event,this.form.txtP67_2_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_2_4" id="txtP67_2_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_2_4']; ?>" onKeyDown="A(event,this.form.txtP67_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Machos <br />menores de<br />un a&ntilde;o</td>
                            <td><input class="cuarenta_px" name="txtP67_3_1" id="txtP67_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_3_1']; ?>" onKeyDown="A(event,this.form.txtP67_3_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_3_2" id="txtP67_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_3_2']; ?>" onKeyDown="A(event,this.form.txtP67_3_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_3_3" id="txtP67_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_3_3']; ?>" onKeyDown="A(event,this.form.txtP67_3_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_3_4" id="txtP67_3_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_3_4']; ?>" onKeyDown="A(event,this.form.txtP67_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Machos de 1 <br />a menos de 3<br />a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP67_4_1" id="txtP67_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_4_1']; ?>" onKeyDown="A(event,this.form.txtP67_4_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_4_2" id="txtP67_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_4_2']; ?>" onKeyDown="A(event,this.form.txtP67_4_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_4_3" id="txtP67_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_4_3']; ?>" onKeyDown="A(event,this.form.txtP67_4_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_4_4" id="txtP67_4_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_4_4']; ?>" onKeyDown="A(event,this.form.txtP67_5_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Machos de 3 o <br />m&aacute;s a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP67_5_1" id="txtP67_5_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_5_1']; ?>" onKeyDown="A(event,this.form.txtP67_5_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_5_2" id="txtP67_5_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_5_2']; ?>" onKeyDown="A(event,this.form.txtP67_5_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_5_3" id="txtP67_5_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_5_3']; ?>" onKeyDown="A(event,this.form.txtP67_5_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_5_4" id="txtP67_5_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_5_4']; ?>" onKeyDown="A(event,this.form.txtP67_6_1);"/></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>Total hembras</td>
                            <td><input class="cuarenta_px" name="txtP67_6_1" id="txtP67_6_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_6_1']; ?>" onKeyDown="A(event,this.form.txtP67_6_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_6_2" id="txtP67_6_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_6_2']; ?>" onKeyDown="A(event,this.form.txtP67_6_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_6_3" id="txtP67_6_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_6_3']; ?>" onKeyDown="A(event,this.form.txtP67_6_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_6_4" id="txtP67_6_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_6_4']; ?>" onKeyDown="A(event,this.form.txtP67_7_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Hembras<br />menores de<br />un a&ntilde;o</td>
                            <td><input class="cuarenta_px" name="txtP67_7_1" id="txtP67_7_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_7_1']; ?>" onKeyDown="A(event,this.form.txtP67_7_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_7_2" id="txtP67_7_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_7_2']; ?>" onKeyDown="A(event,this.form.txtP67_7_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_7_3" id="txtP67_7_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_7_3']; ?>" onKeyDown="A(event,this.form.txtP67_7_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_7_4" id="txtP67_7_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_7_4']; ?>" onKeyDown="A(event,this.form.txtP67_8_1);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Hembras de 1<br />a menos de 3<br />a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP67_8_1" id="txtP67_8_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_8_1']; ?>" onKeyDown="A(event,this.form.txtP67_8_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_8_2" id="txtP67_8_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_8_2']; ?>" onKeyDown="A(event,this.form.txtP67_8_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_8_3" id="txtP67_8_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_8_3']; ?>" onKeyDown="A(event,this.form.txtP67_8_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_8_4" id="txtP67_8_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_8_4']; ?>" onKeyDown="A(event,this.form.txtP67_9_1);"/></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Hembras de 3<br />o m&aacute;s a&ntilde;os</td>
                            <td><input class="cuarenta_px" name="txtP67_9_1" id="txtP67_9_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_9_1']; ?>" onKeyDown="A(event,this.form.txtP67_9_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_9_2" id="txtP67_9_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_9_2']; ?>" onKeyDown="A(event,this.form.txtP67_9_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_9_3" id="txtP67_9_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_9_3']; ?>" onKeyDown="A(event,this.form.txtP67_9_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP67_9_4" id="txtP67_9_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P67_9_4']; ?>" onKeyDown="A(event,this.form.btnP67_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP67_anterior"  id="btnP67_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p66')"/></td>
                            <td><input name="btnP67_siguiente" id="btnP67_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p68')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p68" style="display:<?php echo $p68; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">68. &iquest;Las alpacas se destinan a...</td>
                        </tr>
                        <tr>
                            <td>1. venta?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP68_1" id="txtP68_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P68_1']; ?>" onKeyDown="A(event,this.form.txtP68_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. consumo del hogar?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP68_2" id="txtP68_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P68_2']; ?>" onKeyDown="A(event,this.form.txtP68_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. otros?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP68_3" id="txtP68_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P68_3']; ?>" onKeyDown="A(event,this.form.btnP68_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP68_anterior"  id="btnP68_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p67')"/></td>
                            <td><input name="btnP68_siguiente" id="btnP68_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p69')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p69" style="display:<?php echo $p69; ?>; top: 350px; position: absolute;">
                    <table>

                        <tr>
                            <td colspan="3">69. &iquest;La fibra esquilada de alpaca se destina a...</td>
                        </tr>
                        <tr>
                            <td>1. venta?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP69_1" id="txtP69_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P69_1']; ?>" onKeyDown="A(event,this.form.txtP69_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. uso del hogar?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP69_2" id="txtP69_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P69_2']; ?>" onKeyDown="A(event,this.form.txtP69_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. otros?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP69_3" id="txtP69_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P69_3']; ?>" onKeyDown="A(event,this.form.btnP69_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP69_anterior"  id="btnP69_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p68')"/></td>
                            <td><input name="btnP69_siguiente" id="btnP69_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p70')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p70" style="display:<?php echo $p70; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>70. &iquest;Cu&aacute;ntas cabezas de otras especies de ganado, tiene o maneja?</td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td></td>
                            <td>Otras especies<br />de ganado</td>
                            <td>Cantidad</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Caballos</td>
                            <td><input class="cuarenta_px" name="txtP70_1" id="txtP70_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P70_1']; ?>" onKeyDown="A(event,this.form.txtP70_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Mulas</td>
                            <td><input class="cuarenta_px" name="txtP70_2" id="txtP70_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P70_2']; ?>" onKeyDown="A(event,this.form.txtP70_3);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Asnos</td>
                            <td><input class="cuarenta_px" name="txtP70_3" id="txtP70_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P70_3']; ?>" onKeyDown="A(event,this.form.txtP70_4);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Conejos</td>
                            <td><input class="cuarenta_px" name="txtP70_4" id="txtP70_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P70_4']; ?>" onKeyDown="A(event,this.form.txtP70_5);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Cuyes</td>
                            <td><input class="cuarenta_px" name="txtP70_5" id="txtP70_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P70_5']; ?>" onKeyDown="A(event,this.form.btnP70_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP70_anterior"  id="btnP70_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p69')"/></td>
                            <td><input name="btnP70_siguiente" id="btnP70_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p71')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p71" style="display:<?php echo $p71; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">Solo para los que contestaron que tienen conejos o cuyes <br />71. &iquest;Los conejos o cuyes se destinan a...</td>
                        </tr>
                        <tr>
                            <td>1. venta?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP71_1" id="txtP71_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P71_1']; ?>" onKeyDown="A(event,this.form.txtP71_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. uso del hogar?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP71_2" id="txtP71_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P71_2']; ?>" onKeyDown="A(event,this.form.txtP71_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. otros?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP71_3" id="txtP71_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P71_3']; ?>" onKeyDown="A(event,this.form.btnP71_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP71_anterior"  id="btnP71_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p70')"/></td>
                            <td><input name="btnP71_siguiente" id="btnP71_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p72')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p72" style="display:<?php echo $p72; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">72. &iquest;Tiene aves de granja?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si en actividad</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>Si en descanso</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 74</td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>3</td>
                                        <td>-&gt; Pase a la pregunta 75</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP72" id="txtP72" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P72']; ?>" onKeyDown="A(event,this.form.btnP72_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP72_anterior"  id="btnP72_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p71')"/></td>
                            <td><input name="btnP72_siguiente" id="btnP72_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p73')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p73" style="display:<?php echo $p73; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>73. &iquest;Cu&aacute;ntas aves de granja, tiene o maneja?</td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td></td>
                            <td>Aves de granja</td>
                            <td>Cantidad</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Pollos parrilleros</td>
                            <td><input class="cuarenta_px" name="txtP73_1" id="txtP73_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P73_1']; ?>" onKeyDown="A(event,this.form.txtP73_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Gallinas de postura</td>
                            <td><input class="cuarenta_px" name="txtP73_2" id="txtP73_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P73_2']; ?>" onKeyDown="A(event,this.form.txtP73_3);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Gallinas de cria</td>
                            <td><input class="cuarenta_px" name="txtP73_3" id="txtP73_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P73_3']; ?>" onKeyDown="A(event,this.form.txtP73_4);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Gallinas reproductoras</td>
                            <td><input class="cuarenta_px" name="txtP73_4" id="txtP73_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P73_4']; ?>" onKeyDown="A(event,this.form.txtP73_5);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Gallos</td>
                            <td><input class="cuarenta_px" name="txtP73_5" id="txtP73_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P73_5']; ?>" onKeyDown="A(event,this.form.txtP73_6);"/></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Pollitos beb&eacute;s</td>
                            <td><input class="cuarenta_px" name="txtP73_6" id="txtP73_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P73_6']; ?>" onKeyDown="A(event,this.form.txtP73_7);"/></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Patos</td>
                            <td><input class="cuarenta_px" name="txtP73_7" id="txtP73_7" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P73_7']; ?>" onKeyDown="A(event,this.form.txtP73_8);"/></td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Pavos</td>
                            <td><input class="cuarenta_px" name="txtP73_8" id="txtP73_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P73_8']; ?>" onKeyDown="A(event,this.form.txtP73_9);"/></td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Codornices</td>
                            <td><input class="cuarenta_px" name="txtP73_9" id="txtP73_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P73_9']; ?>" onKeyDown="A(event,this.form.txtP73_10);"/></td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Avestruces</td>
                            <td><input class="cuarenta_px" name="txtP73_10" id="txtP73_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P73_10']; ?>" onKeyDown="A(event,this.form.btnP73_siguiente);"/></td>
                        </tr>    
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP73_anterior"  id="btnP73_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p72')"/></td>
                            <td><input name="btnP73_siguiente" id="btnP73_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p74')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p74" style="display:<?php echo $p74; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>74. &iquest;Al d&iacute;a de hoy, cu&aacute;l es la cantidad de construcciones y equipos av&iacute;colas que tiene?<br />
                                (anote el a&ntilde;o de la primera y &uacute;ltima construcci&oacute;n o compra)
                            </td>
                        </tr>    
                    </table>
                    <table border="1">

                        <tr>
                            <td></td>
                            <td>Descripci&oacute;n</td>
                            <td>Cantidad</td>
                            <td>Primer<br />a&ntilde;o</td>
                            <td>Segundo<br />a&ntilde;o</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Galpones av&iacute;colas</td>
                            <td><input class="cuarenta_px" name="txtP74_1_1" id="txtP74_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P74_1_1']; ?>" onKeyDown="A(event,this.form.txtP74_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px" name="txtP74_1_2" id="txtP74_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P74_1_2']; ?>" onKeyDown="A(event,this.form.txtP74_1_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP74_1_3" id="txtP74_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P74_1_3']; ?>" onKeyDown="A(event,this.form.txtP74_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Equipos av&iacute;colas para<br />gallinas reproductoras </td>
                            <td><input class="cuarenta_px" name="txtP74_2_1" id="txtP74_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P74_2_1']; ?>" onKeyDown="A(event,this.form.txtP74_2_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP74_2_2" id="txtP74_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P74_2_2']; ?>" onKeyDown="A(event,this.form.txtP74_2_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP74_2_3" id="txtP74_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P74_2_3']; ?>" onKeyDown="A(event,this.form.txtP74_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Equipos av&iacute;colas para<br />pollos parrileros</td>
                            <td><input class="cuarenta_px" name="txtP74_3_1" id="txtP74_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P74_3_1']; ?>" onKeyDown="A(event,this.form.txtP74_3_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP74_3_2" id="txtP74_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P74_3_2']; ?>" onKeyDown="A(event,this.form.txtP74_3_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP74_3_3" id="txtP74_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P74_3_3']; ?>" onKeyDown="A(event,this.form.txtP74_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Incubadoras av&iacute;colas</td>
                            <td><input class="cuarenta_px" name="txtP74_4_1" id="txtP74_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P74_4_1']; ?>" onKeyDown="A(event,this.form.txtP74_4_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP74_4_2" id="txtP74_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P74_4_2']; ?>" onKeyDown="A(event,this.form.txtP74_4_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP74_4_3" id="txtP74_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P74_4_3']; ?>" onKeyDown="A(event,this.form.btnP74_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP74_anterior"  id="btnP74_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p73')"/></td>
                            <td><input name="btnP74_siguiente" id="btnP74_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p75')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p75" style="display:<?php echo $p75; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">75. &iquest;Tiene aves de corral o de traspatio?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 78</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP75" id="txtP75" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P75']; ?>" onKeyDown="A(event,this.form.btnP75_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP75_anterior"  id="btnP75_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p74')"/></td>
                            <td><input name="btnP75_siguiente" id="btnP75_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p76')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p76" style="display:<?php echo $p76; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>76. &iquest;Cu&aacute;ntas aves de corral o de traspatio, tiene o maneja?</td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td></td>
                            <td>Aves de corral</td>
                            <td>Cantidad</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Gallinas</td>
                            <td><input class="cuarenta_px" name="txtP76_1" id="txtP76_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P76_1']; ?>" onKeyDown="A(event,this.form.txtP76_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Pavos</td>
                            <td><input class="cuarenta_px" name="txtP76_2" id="txtP76_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P76_2']; ?>" onKeyDown="A(event,this.form.txtP76_3);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Patos</td>
                            <td><input class="cuarenta_px" name="txtP76_3" id="txtP76_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P76_3']; ?>" onKeyDown="A(event,this.form.txtP76_4);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Codornices</td>
                            <td><input class="cuarenta_px" name="txtP76_4" id="txtP76_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P76_4']; ?>" onKeyDown="A(event,this.form.btnP76_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP76_anterior"  id="btnP76_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p75')"/></td>
                            <td><input name="btnP76_siguiente" id="btnP76_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p77')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p77" style="display:<?php echo $p77; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">77. &iquest;Las aves de corral se destinan a...</td>
                        </tr>
                        <tr>
                            <td>1. venta?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP77_1" id="txtP77_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P77_1']; ?>" onKeyDown="A(event,this.form.txtP77_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. consumo del hogar?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP77_2" id="txtP77_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P77_2']; ?>" onKeyDown="A(event,this.form.txtP77_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. otros?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP77_3" id="txtP77_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P77_3']; ?>" onKeyDown="A(event,this.form.btnP77_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP77_anterior"  id="btnP77_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p76')"/></td>
                            <td><input name="btnP77_siguiente" id="btnP77_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p78')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p78" style="display:<?php echo $p78; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">78 &iquest;Recolecta miel de abeja?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 83</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP78" id="txtP78" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P78']; ?>" onKeyDown="A(event,this.form.btnP78_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP78_anterior"  id="btnP78_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p77')"/></td>
                            <td><input name="btnP78_siguiente" id="btnP78_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p79')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p79" style="display:<?php echo $p79; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">79. &iquest;La recolecci&oacute;n es de...</td>
                        </tr>
                        <tr>
                            <td>1. colmenas naturales?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP79_1" id="txtP79_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P79_1']; ?>" onKeyDown="A(event,this.form.txtP79_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. colmenas artificiales (cajon)?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP79_2" id="txtP79_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P79_2']; ?>" onKeyDown="A(event,this.form.btnP79_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP79_anterior"  id="btnP79_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p78')"/></td>
                            <td><input name="btnP79_siguiente" id="btnP79_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p80')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p80" style="display:<?php echo $p80; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>80. &iquest;Si la recolecci&oacute;n es de colmenas artificiales, cu&aacute;ntas cajas tiene o maneja?</td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input class="cuarenta_px" name="txtP80" id="txtP80" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P80']; ?>" onKeyDown="A(event,this.form.btnP80_siguiente);" autofocus="autofocus"/></td>
                            <td>N&uacute;mero</td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP80_anterior"  id="btnP80_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p79')"/></td>
                            <td><input name="btnP80_siguiente" id="btnP80_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p81')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p81" style="display:<?php echo $p81; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>81. &iquest;Cu&aacute;l fue su producci&oacute;n de miel en los &uacute;ltimos 12 meses?</td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td>Cantidad</td>
                            <td>C&oacute;digo<br />unidad de<br />medida</td>
                        </tr>
                        <tr>
                            <td><input class="text-box"    name="txtP81_1" id="txtP81_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P81_1']; ?>" onKeyDown="A(event,this.form.txtP81_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px" name="txtP81_2" id="txtP81_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P81_2']; ?>" onKeyDown="A(event,this.form.btnP81_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP81_anterior"  id="btnP81_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p80')"/></td>
                            <td><input name="btnP81_siguiente" id="btnP81_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p82')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p82" style="display:<?php echo $p82; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">82. &iquest;La miel producida se destina a...</td>
                        </tr>
                        <tr>
                            <td>1. venta?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP82_1" id="txtP82_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P82_1']; ?>" onKeyDown="A(event,this.form.txtP82_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. consumo del hogar?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP82_2" id="txtP82_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P82_2']; ?>" onKeyDown="A(event,this.form.txtP82_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. otros?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP82_3" id="txtP82_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P82_3']; ?>" onKeyDown="A(event,this.form.btnP82_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP82_anterior"  id="btnP82_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p81')"/></td>
                            <td><input name="btnP82_siguiente" id="btnP82_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p83')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p83" style="display:<?php echo $p83; ?>; top: 350px; position: absolute;"> 
                    <label><strong>VII. PRINCIPALES USOS Y PR&Aacute;CTICAS EN EL GANADO Y AVES</strong></label>
                    <table>
                        <tr>
                            <td>83. &iquest;En los &uacute;ltimos doce meses al d&iacute;a de hoy, vacun&oacute; a su(s)...</td>
                        </tr>
                    </table>
                    <table style="border: 1px solid ;">
                        <tr>
                            <td>1. ganado bovino?</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>a) contra la aftosa</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP83_1" id="txtP83_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P83_1']; ?>" onKeyDown="A(event,this.form.txtP83_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>b) contra otras enfermedades</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP83_2" id="txtP83_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P83_2']; ?>" onKeyDown="A(event,this.form.txtP83_3);"/></td>
                        </tr>
                    </table>
                    <br />
                    <table style="border: 1px solid ;">
                        <tr>
                            <td>2. ganado ovino?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP83_3" id="txtP83_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P83_3']; ?>" onKeyDown="A(event,this.form.txtP83_4);"/></td>
                        </tr>
                        <tr>
                            <td>3. ganado caprino?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP83_4" id="txtP83_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P83_4']; ?>" onKeyDown="A(event,this.form.txtP83_5);"/></td>
                        </tr>
                        <tr>
                            <td>4. ganado porcino?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP83_5" id="txtP83_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P83_5']; ?>" onKeyDown="A(event,this.form.txtP83_6);"/></td>
                        </tr>
                        <tr>
                            <td>5. ganado cam&eacute;lido?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP83_6" id="txtP83_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P83_6']; ?>" onKeyDown="A(event,this.form.txtP83_7);"/></td>
                        </tr>
                        <tr>
                            <td>6. aves?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP83_7" id="txtP83_7" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P83_7']; ?>" onKeyDown="A(event,this.form.btnP83_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP83_anterior"  id="btnP83_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p82')"/></td>
                            <td><input name="btnP83_siguiente" id="btnP83_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p84')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p84" style="display:<?php echo $p84; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td colspan="3">84. &iquest;Realiza la desparasitaci&oacute;n de su(s)&hellip;</td>
                        </tr>
                        <tr>
                            <td>1. ganado?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP84_1" id="txtP84_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P84_1']; ?>" onKeyDown="A(event,this.form.txtP84_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. aves?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP84_2" id="txtP84_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P84_2']; ?>" onKeyDown="A(event,this.form.btnP84_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP84_anterior"  id="btnP84_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p83')"/></td>
                            <td><input name="btnP84_siguiente" id="btnP84_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p85')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p85" style="display:<?php echo $p85; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">85. &iquest;Realiza inseminaci&oacute;n artificial en su ganado...</td>
                        </tr>
                        <tr>
                            <td>1. bovino?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP85_1" id="txtP85_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P85_1']; ?>" onKeyDown="A(event,this.form.txtP85_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. ovino?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP85_2" id="txtP85_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P85_2']; ?>" onKeyDown="A(event,this.form.txtP85_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. porcino?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP85_3" id="txtP85_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P85_3']; ?>" onKeyDown="A(event,this.form.btnP85_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP85_anterior"  id="btnP85_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p84')"/></td>
                            <td><input name="btnP85_siguiente" id="btnP85_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p86')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p86" style="display:<?php echo $p86; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>86. &iquest;Al d&iacute;a de hoy, cu&aacute;l es la cantidad de construcciones e instalaciones que tiene para su ganado de todo tipo? <br /> (anote el a&ntilde;o de la primera y &uacute;ltima construcci&oacute;n)</td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td></td>
                            <td>Descripci&oacute;n</td>
                            <td>Cantidad</td>
                            <td>Primer<br />a&ntilde;o</td>
                            <td>Segundo<br />a&ntilde;o</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Galpones o establos</td>
                            <td><input class="cuarenta_px" name="txtP86_1_1" id="txtP86_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_1_1']; ?>" onKeyDown="A(event,this.form.txtP86_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px" name="txtP86_1_2" id="txtP86_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_1_2']; ?>" onKeyDown="A(event,this.form.txtP86_1_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP86_1_3" id="txtP86_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_1_3']; ?>" onKeyDown="A(event,this.form.txtP86_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Salas de orde&ntilde;o </td>
                            <td><input class="cuarenta_px" name="txtP86_2_1" id="txtP86_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_2_1']; ?>" onKeyDown="A(event,this.form.txtP86_2_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP86_2_2" id="txtP86_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_2_2']; ?>" onKeyDown="A(event,this.form.txtP86_2_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP86_2_3" id="txtP86_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_2_3']; ?>" onKeyDown="A(event,this.form.txtP86_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Chiqueros o porquerisas</td>
                            <td><input class="cuarenta_px" name="txtP86_3_1" id="txtP86_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_3_1']; ?>" onKeyDown="A(event,this.form.txtP86_3_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP86_3_2" id="txtP86_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_3_2']; ?>" onKeyDown="A(event,this.form.txtP86_3_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP86_3_3" id="txtP86_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_3_3']; ?>" onKeyDown="A(event,this.form.txtP86_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Corrales</td>
                            <td><input class="cuarenta_px" name="txtP86_4_1" id="txtP86_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_4_1']; ?>" onKeyDown="A(event,this.form.txtP86_4_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP86_4_2" id="txtP86_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_4_2']; ?>" onKeyDown="A(event,this.form.txtP86_4_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP86_4_3" id="txtP86_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_4_3']; ?>" onKeyDown="A(event,this.form.txtP86_5_1);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Bebederos</td>
                            <td><input class="cuarenta_px" name="txtP86_5_1" id="txtP86_5_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_5_1']; ?>" onKeyDown="A(event,this.form.txtP86_5_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP86_5_2" id="txtP86_5_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_5_2']; ?>" onKeyDown="A(event,this.form.txtP86_5_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP86_5_3" id="txtP86_5_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_5_3']; ?>" onKeyDown="A(event,this.form.txtP86_6_1);"/></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Ba&ntilde;os antiparacitarios</td>
                            <td><input class="cuarenta_px" name="txtP86_6_1" id="txtP86_6_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_6_1']; ?>" onKeyDown="A(event,this.form.txtP86_6_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP86_6_2" id="txtP86_6_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_6_2']; ?>" onKeyDown="A(event,this.form.txtP86_6_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP86_6_3" id="txtP86_6_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_6_3']; ?>" onKeyDown="A(event,this.form.txtP86_7_1);"/></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Bretes o mangas</td>
                            <td><input class="cuarenta_px" name="txtP86_7_1" id="txtP86_7_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_7_1']; ?>" onKeyDown="A(event,this.form.txtP86_7_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP86_7_2" id="txtP86_7_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_7_2']; ?>" onKeyDown="A(event,this.form.txtP86_7_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP86_7_3" id="txtP86_7_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P86_7_3']; ?>" onKeyDown="A(event,this.form.btnP86_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP86_anterior"  id="btnP86_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p85')"/></td>
                            <td><input name="btnP86_siguiente" id="btnP86_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p87')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p87" style="display:<?php echo $p87; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td>87. &iquest;Al d&iacute;a de hoy, cu&aacute;l es la cantidad de equipos e implementos que tiene para su ganado de todo tipo? <br />
                                (anote el a&ntilde;o de la primera y &uacute;ltima compra) 
                            </td>
                        </tr>    
                    </table>
                    <table border="1">
                        <tr>
                            <td></td>
                            <td>Descripci&oacute;n</td>
                            <td>Cantidad</td>
                            <td>Primer<br />a&ntilde;o</td>
                            <td>Segundo<br />a&ntilde;o</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Orde&ntilde;adoras</td>
                            <td><input class="cuarenta_px" name="txtP87_1_1" id="txtP87_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P87_1_1']; ?>" onKeyDown="A(event,this.form.txtP87_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px" name="txtP87_1_2" id="txtP87_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P87_1_2']; ?>" onKeyDown="A(event,this.form.txtP87_1_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP87_1_3" id="txtP87_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P87_1_3']; ?>" onKeyDown="A(event,this.form.txtP87_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Tanques enfriadores de leche </td>
                            <td><input class="cuarenta_px" name="txtP87_2_1" id="txtP87_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P87_2_1']; ?>" onKeyDown="A(event,this.form.txtP87_2_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP87_2_2" id="txtP87_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P87_2_2']; ?>" onKeyDown="A(event,this.form.txtP87_2_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP87_2_3" id="txtP87_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P87_2_3']; ?>" onKeyDown="A(event,this.form.btnP87_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP87_anterior"  id="btnP87_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p86')"/></td>
                            <td><input name="btnP87_siguiente" id="btnP87_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p88')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p88" style="display:<?php echo $p88; ?>; top: 350px; position: absolute;"> 
                    <label><strong>VIII. FUENTES DE AGUA PARA RIEGO Y CONSUMO ANIMAL</strong></label>
                    <table>    
                        <tr>
                            <td colspan="3">88. &iquest;Utiliza alg&uacute;n m&eacute;todo de riego?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 90</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP88" id="txtP88" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P88']; ?>" onKeyDown="A(event,this.form.btnP88_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP88_anterior"  id="btnP88_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p87')"/></td>
                            <td><input name="btnP88_siguiente" id="btnP88_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p89')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p89" style="display:<?php echo $p89; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td colspan="3">89.&iquest;El m&eacute;todo de riego que usa es por...</td>
                        </tr>
                        <tr>
                            <td>1. gravedad?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP89_1" id="txtP89_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P89_1']; ?>" onKeyDown="A(event,this.form.txtP89_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. aspersi&oacute;n?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP89_2" id="txtP89_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P89_2']; ?>" onKeyDown="A(event,this.form.txtP89_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. goteo?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP89_3" id="txtP89_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P89_3']; ?>" onKeyDown="A(event,this.form.btnP89_siguiente);"/></td>
                        </tr>    
                    </table>
                    <table>    
                        <tr>
                            <td><input name="btnP89_anterior"  id="btnP89_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p88')"/></td>
                            <td><input name="btnP89_siguiente" id="btnP89_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p90')"/></td>
                        </tr>    
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p90" style="display:<?php echo $p90; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td>90.&iquest;Cu&aacute;les son las fuentes o almacenamiento de agua que utiliza para regar sus cultivos o para el consumo de su ganado...</td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>1. represa?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP90_1" id="txtP90_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P90_1']; ?>" onKeyDown="A(event,this.form.txtP90_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. pozo artesanal o noria?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP90_2" id="txtP90_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P90_2']; ?>" onKeyDown="A(event,this.form.txtP90_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. pozo perforado?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP90_3" id="txtP90_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P90_3']; ?>" onKeyDown="A(event,this.form.txtP90_4);"/></td>
                        </tr>
                        <tr>
                            <td>4. tanque de agua o noque?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP90_4" id="txtP90_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P90_4']; ?>" onKeyDown="A(event,this.form.txtP90_5);"/></td>
                        </tr>
                        <tr>
                            <td>5. vertiente o pa&uacute;ro?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP90_5" id="txtP90_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P90_5']; ?>" onKeyDown="A(event,this.form.txtP90_6);"/></td>
                        </tr>
                        <tr>
                            <td>6. rio?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP90_6" id="txtP90_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P90_6']; ?>" onKeyDown="A(event,this.form.txtP90_7);"/></td>
                        </tr>
                        <tr>
                            <td>7. lago o laguna?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP90_7" id="txtP90_7" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P90_7']; ?>" onKeyDown="A(event,this.form.txtP90_8);"/></td>
                        </tr>
                        <tr>
                            <td>8. embalse?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP90_8" id="txtP90_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P90_8']; ?>" onKeyDown="A(event,this.form.txtP90_9);"/></td>
                        </tr>
                        <tr>
                            <td>9. atajado, qota&ntilde;a?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP90_9" id="txtP90_9" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P90_9']; ?>" onKeyDown="A(event,this.form.txtP90_10);"/></td>
                        </tr>
                        <tr>
                            <td>10. curichi, bofedal?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP90_10" id="txtP90_10" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P90_10']; ?>" onKeyDown="A(event,this.form.btnP90_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP90_anterior"  id="btnP90_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p89')"/></td>
                            <td><input name="btnP90_siguiente" id="btnP90_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p91')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p91" style="display:<?php echo $p91; ?>; top: 350px; position: absolute;"> 
                    <label><strong>IX. BOSQUES O MONTES</strong></label>
                    <table>    
                        <tr>
                            <td colspan="3">91. &iquest;Realiza actividades de extracci&oacute;n de especies maderables en bosques o montes?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 95</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP91" id="txtP91" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P91']; ?>" onKeyDown="A(event,this.form.btnP91_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP91_anterior"  id="btnP91_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p90')"/></td>
                            <td><input name="btnP91_siguiente" id="btnP91_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p92')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p92" style="display:<?php echo $p92; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td colspan="3">92. &iquest;En el bosque o monte, cu&aacute;les son las principales especies maderables que extrae?</td>
                        </tr>    
                    </table>
                    <table border="1">

                        <tr>
                            <td>1</td>
                            <td><input class="trecientos_px" name="txtP92_1" id="txtP92_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P92_1']; ?>" onKeyDown="A(event,this.form.txtP92_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><input class="trecientos_px" name="txtP92_2" id="txtP92_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P92_2']; ?>" onKeyDown="A(event,this.form.txtP92_3);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><input class="trecientos_px" name="txtP92_3" id="txtP92_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P92_3']; ?>" onKeyDown="A(event,this.form.txtP92_4);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><input class="trecientos_px" name="txtP92_4" id="txtP92_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P92_4']; ?>" onKeyDown="A(event,this.form.btnP92_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP92_anterior"  id="btnP92_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p91')"/></td>
                            <td><input name="btnP92_siguiente" id="btnP92_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p93')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p93" style="display:<?php echo $p93; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td colspan="3">93. &iquest;Las especies maderables que extrae son para...</td>
                        </tr>
                        <tr>
                            <td>1. uso propio?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP93_1" id="txtP93_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P93_1']; ?>" onKeyDown="A(event,this.form.txtP93_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. venta?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP93_2" id="txtP93_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P93_2']; ?>" onKeyDown="A(event,this.form.btnP93_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP93_anterior"  id="btnP93_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p92')"/></td>
                            <td><input name="btnP93_siguiente" id="btnP93_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p94')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p94" style="display:<?php echo $p94; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td colspan="3">94. &iquest;Realiza la reforestaci&oacute;n?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP94" id="txtP94" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P94']; ?>" onKeyDown="A(event,this.form.btnP94_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>

                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP94_anterior"  id="btnP94_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p93')"/></td>
                            <td><input name="btnP94_siguiente" id="btnP94_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p95')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p95" style="display:<?php echo $p95; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td colspan="3">95. &iquest;Recolecta o extrae productos no maderables? <br /> (casta&ntilde;a, goma, uruc&uacute;, cacao o chocolate, otros</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 97</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP95" id="txtP95" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P95']; ?>" onKeyDown="A(event,this.form.btnP95_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP95_anterior"  id="btnP95_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p94')"/></td>
                            <td><input name="btnP95_siguiente" id="btnP95_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p96')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p96" style="display:<?php echo $p96; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td colspan="3">96. &iquest;Cu&aacute;les son los principales productos no maderables que recolecta o <br /> extrae y cu&aacute;l fue la cantidad en el a&ntilde;o agr&iacute;cola de julio 2012 a junio 2013?</td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">Producto</td>
                        </tr>
                        <tr>
                            <td>Cantidad</td>
                            <td>C&oacute;digo<br />unidad<br />de <br />medida</td>
                            <td>Consumo<br />del hogar</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td><input class="trecientos_px" name="txtP96_1_1" id="txtP96_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P96_1_1']; ?>" onKeyDown="A(event,this.form.txtP96_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px"   name="txtP96_1_2" id="txtP96_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P96_1_2']; ?>" onKeyDown="A(event,this.form.txtP96_1_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP96_1_3" id="txtP96_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P96_1_3']; ?>" onKeyDown="A(event,this.form.txtP96_1_4);"/></td>
                            <td><input class="cuarenta_px"   name="txtP96_1_4" id="txtP96_1_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P96_1_4']; ?>" onKeyDown="A(event,this.form.txtP96_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><input class="trecientos_px" name="txtP96_2_1" id="txtP96_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P96_2_1']; ?>" onKeyDown="A(event,this.form.txtP96_2_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP96_2_2" id="txtP96_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P96_2_2']; ?>" onKeyDown="A(event,this.form.txtP96_2_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP96_2_3" id="txtP96_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P96_2_3']; ?>" onKeyDown="A(event,this.form.txtP96_2_4);"/></td>
                            <td><input class="cuarenta_px"   name="txtP96_2_4" id="txtP96_2_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P96_2_4']; ?>" onKeyDown="A(event,this.form.txtP96_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><input class="trecientos_px" name="txtP96_3_1" id="txtP96_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P96_3_1']; ?>" onKeyDown="A(event,this.form.txtP96_3_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP96_3_2" id="txtP96_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P96_3_2']; ?>" onKeyDown="A(event,this.form.txtP96_3_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP96_3_3" id="txtP96_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P96_3_3']; ?>" onKeyDown="A(event,this.form.txtP96_3_4);"/></td>
                            <td><input class="cuarenta_px"   name="txtP96_3_4" id="txtP96_3_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P96_3_4']; ?>" onKeyDown="A(event,this.form.txtP96_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><input class="trecientos_px" name="txtP96_4_1" id="txtP96_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P96_4_1']; ?>" onKeyDown="A(event,this.form.txtP96_4_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP96_4_2" id="txtP96_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P96_4_2']; ?>" onKeyDown="A(event,this.form.txtP96_4_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP96_4_3" id="txtP96_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P96_4_3']; ?>" onKeyDown="A(event,this.form.txtP96_4_4);"/></td>
                            <td><input class="cuarenta_px"   name="txtP96_4_4" id="txtP96_4_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P96_4_4']; ?>" onKeyDown="A(event,this.form.txtP96_5_1);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><input class="trecientos_px" name="txtP96_5_1" id="txtP96_5_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P96_5_1']; ?>" onKeyDown="A(event,this.form.txtP96_5_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP96_5_2" id="txtP96_5_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P96_5_2']; ?>" onKeyDown="A(event,this.form.txtP96_5_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP96_5_3" id="txtP96_5_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P96_5_3']; ?>" onKeyDown="A(event,this.form.txtP96_5_4);"/></td>
                            <td><input class="cuarenta_px"   name="txtP96_5_4" id="txtP96_5_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P96_5_4']; ?>" onKeyDown="A(event,this.form.btnP96_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP96_anterior"  id="btnP96_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p95')"/></td>
                            <td><input name="btnP96_siguiente" id="btnP96_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p97')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p97" style="display:<?php echo $p97; ?>; top: 350px; position: absolute;"> 
                    <label><strong>X. CAZA Y PESCA</strong></label>
                    <table>    
                        <tr>
                            <td colspan="3">97. &iquest;Caza animales silvestres?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 100</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP97" id="txtP97" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P97']; ?>" onKeyDown="A(event,this.form.btnP97_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP97_anterior"  id="btnP97_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p96')"/></td>
                            <td><input name="btnP97_siguiente" id="btnP97_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p98')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p98" style="display:<?php echo $p98; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td colspan="3">98.&iquest;Cu&aacute;les son las principales especies que caza?</td>
                        </tr>    
                    </table>
                    <table border="1">
                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">Especie</td>
                        </tr>
                        <tr>
                            <td colspan="2">Periodo de <br /> caza (meses)</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td><input class="trecientos_px" name="txtP98_1_1" id="txtP98_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P98_1_1']; ?>" onKeyDown="A(event,this.form.txtP98_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px"   name="txtP98_1_2" id="txtP98_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P98_1_2']; ?>" onKeyDown="A(event,this.form.txtP98_1_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP98_1_3" id="txtP98_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P98_1_3']; ?>" onKeyDown="A(event,this.form.txtP98_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><input class="trecientos_px" name="txtP98_2_1" id="txtP98_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P98_2_1']; ?>" onKeyDown="A(event,this.form.txtP98_2_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP98_2_2" id="txtP98_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P98_2_2']; ?>" onKeyDown="A(event,this.form.txtP98_2_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP98_2_3" id="txtP98_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P98_2_3']; ?>" onKeyDown="A(event,this.form.txtP98_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><input class="trecientos_px" name="txtP98_3_1" id="txtP98_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P98_3_1']; ?>" onKeyDown="A(event,this.form.txtP98_3_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP98_3_2" id="txtP98_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P98_3_2']; ?>" onKeyDown="A(event,this.form.txtP98_3_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP98_3_3" id="txtP98_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P98_3_3']; ?>" onKeyDown="A(event,this.form.txtP98_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><input class="trecientos_px" name="txtP98_4_1" id="txtP98_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P98_4_1']; ?>" onKeyDown="A(event,this.form.txtP98_4_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP98_4_2" id="txtP98_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P98_4_2']; ?>" onKeyDown="A(event,this.form.txtP98_4_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP98_4_3" id="txtP98_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P98_4_3']; ?>" onKeyDown="A(event,this.form.btnP98_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>    
                        <tr>
                            <td><input name="btnP98_anterior"  id="btnP98_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p97')"/></td>
                            <td><input name="btnP98_siguiente" id="btnP98_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p99')"/></td>
                        </tr>    
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p99" style="display:<?php echo $p99; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td colspan="3">99. &iquest;Las especies que caza se destinan a...</td>
                        </tr>
                        <tr>
                            <td>1. consumo del hogar?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP99_1" id="txtP99_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P99_1']; ?>" onKeyDown="A(event,this.form.txtP99_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. otros?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP99_2" id="txtP99_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P99_2']; ?>" onKeyDown="A(event,this.form.btnP99_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP99_anterior"  id="btnP99_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p98')"/></td>
                            <td><input name="btnP99_siguiente" id="btnP99_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p100')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p100" style="display:<?php echo $p100; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">100. &iquest;Realiza actividades de pesca?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 103</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP100" id="txtP100" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P100']; ?>" onKeyDown="A(event,this.form.btnP100_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP100_anterior"  id="btnP100_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p99')"/></td>
                            <td><input name="btnP100_siguiente" id="btnP100_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p101')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p101" style="display:<?php echo $p101; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">101. &iquest;Cu&aacute;les son las principales especies que pesca?</td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">Especie</td>
                        </tr>
                        <tr>
                            <td colspan="2">Periodo de <br />pesca (meses)</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td><input class="trecientos_px" name="txtP101_1_1" id="txtP101_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P101_1_1']; ?>" onKeyDown="A(event,this.form.txtP101_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px"   name="txtP101_1_2" id="txtP101_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P101_1_2']; ?>" onKeyDown="A(event,this.form.txtP101_1_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP101_1_3" id="txtP101_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P101_1_3']; ?>" onKeyDown="A(event,this.form.txtP101_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><input class="trecientos_px" name="txtP101_2_1" id="txtP101_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P101_2_1']; ?>" onKeyDown="A(event,this.form.txtP101_2_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP101_2_2" id="txtP101_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P101_2_2']; ?>" onKeyDown="A(event,this.form.txtP101_2_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP101_2_3" id="txtP101_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P101_2_3']; ?>" onKeyDown="A(event,this.form.txtP101_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><input class="trecientos_px" name="txtP101_3_1" id="txtP101_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P101_3_1']; ?>" onKeyDown="A(event,this.form.txtP101_3_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP101_3_2" id="txtP101_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P101_3_2']; ?>" onKeyDown="A(event,this.form.txtP101_3_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP101_3_3" id="txtP101_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P101_3_3']; ?>" onKeyDown="A(event,this.form.txtP101_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><input class="trecientos_px" name="txtP101_4_1" id="txtP101_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P102_4_1']; ?>" onKeyDown="A(event,this.form.txtP101_4_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP101_4_2" id="txtP101_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P102_4_2']; ?>" onKeyDown="A(event,this.form.txtP101_4_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP101_4_3" id="txtP101_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P102_4_3']; ?>" onKeyDown="A(event,this.form.btnP101_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP101_anterior"  id="btnP101_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p100')"/></td>
                            <td><input name="btnP101_siguiente" id="btnP101_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p102')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p102" style="display:<?php echo $p102; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td colspan="3">102. &iquest;Las especies que pesca las destina a...</td>
                        </tr>
                        <tr>
                            <td>1. venta?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP102_1" id="txtP102_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P102_1']; ?>" onKeyDown="A(event,this.form.txtP102_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. consumo del hogar?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP102_2" id="txtP102_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P102_2']; ?>" onKeyDown="A(event,this.form.txtP102_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. otros?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP102_3" id="txtP102_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P102_3']; ?>"onKeyDown="A(event,this.form.btnP102_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP102_anterior"  id="btnP102_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p101')"/></td>
                            <td><input name="btnP102_siguiente" id="btnP102_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p103')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p103" style="display:<?php echo $p103; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td colspan="3">103. &iquest;Realiza otras actividades de cr&iacute;a de especies acu&aacute;ticas? <br /> (Incluye peces, tortugas, caimanes, lagartos, cangrejos, camarones, ranas y otros)</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 106</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP103" id="txtP103" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P103']; ?>" onKeyDown="A(event,this.form.btnP103_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP103_anterior"  id="btnP103_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p102')"/></td>
                            <td><input name="btnP103_siguiente" id="btnP103_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p104')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p104" style="display:<?php echo $p104; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td colspan="3">104. &iquest;Cu&aacute;les son las principales especies que cr&iacute;a?</td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td>1</td>
                            <td><input class="trecientos_px" name="txtP104_1" id="txtP104_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P104_1']; ?>" onKeyDown="A(event,this.form.txtP104_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><input class="trecientos_px" name="txtP104_2" id="txtP104_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P104_2']; ?>" onKeyDown="A(event,this.form.txtP104_3);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><input class="trecientos_px" name="txtP104_3" id="txtP104_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P104_3']; ?>" onKeyDown="A(event,this.form.txtP104_4);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><input class="trecientos_px" name="txtP104_4" id="txtP104_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P104_4']; ?>" onKeyDown="A(event,this.form.btnP104_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>    
                        <tr>
                            <td><input name="btnP104_anterior"  id="btnP104_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p103')"/></td>
                            <td><input name="btnP104_siguiente" id="btnP104_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p105')"/></td>
                        </tr>    
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p105" style="display:<?php echo $p105; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td>105. &iquest;Las especies acu&aacute;ticas que cr&iacute;a se destinan a...</td>
                        </tr>
                        <tr>
                            <td>1. venta?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP105_1" id="txtP105_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P105_1']; ?>" onKeyDown="A(event,this.form.txtP105_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. consumo del hogar?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP105_2" id="txtP105_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P105_2']; ?>" onKeyDown="A(event,this.form.txtP105_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. otros?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP105_3" id="txtP105_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P105_3']; ?>" onKeyDown="A(event,this.form.btnP105_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP105_anterior"  id="btnP105_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p104')"/></td>
                            <td><input name="btnP105_siguiente" id="btnP105_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p106')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p106" style="display:<?php echo $p106; ?>; top: 350px; position: absolute;"> 
                    <label><strong>XI. ASISTENCIA O APOYO RECIBIDO, CR&Eacute;DITO Y SEGURO</strong></label>
                    <table>
                        <tr>
                            <td>106. &iquest;En los &uacute;ltimos tres a&ntilde;os, recibi&oacute; asistencia o apoyo para su actividad agr&iacute;cola, <br /> 
                                cr&iacute;a de ganado, aves u otras especies, recursos forestales, recolecci&oacute;n o extracci&oacute;n <br /> de especies no maderables, caza o pesca?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 108</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP106" id="txtP106" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P106']; ?>" onKeyDown="A(event,this.form.btnP106_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP106_anterior"  id="btnP106_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p105')"/></td>
                            <td><input name="btnP106_siguiente" id="btnP106_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p107')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p107" style="display:<?php echo $p107; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>107. &iquest;La asistencia o apoyo recibido, fue de...</td>
                        </tr>

                    </table>
                    <table border="1">
                        <tr>
                            <td rowspan="2">&nbsp;</td>
                            <td rowspan="2">Tipo de<br />asistencia o<br />apoyo<br />recibido</td>
                            <td colspan="6">Instituci&oacute;n</td>
                        </tr>
                        <tr>
                            <td>Gobierno<br />central</td>
                            <td>Gobernaci&oacute;n<br />o municipio </td>
                            <td>Federaciones<br />o asociaciones</td>
                            <td>Fundaciones<br />u ONG</td>
                            <td>Empresas<br />privadas</td>
                            <td>Instituciones<br />academicas</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>herramientas y <br />equipos?</td>
                            <td><input class="cuarenta_px" name="txtP107_1_1" id="txtP107_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_1_1']; ?>" onKeyDown="A(event,this.form.txtP107_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px" name="txtP107_1_2" id="txtP107_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_1_2']; ?>" onKeyDown="A(event,this.form.txtP107_1_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_1_3" id="txtP107_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_1_3']; ?>" onKeyDown="A(event,this.form.txtP107_1_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_1_4" id="txtP107_1_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_1_4']; ?>" onKeyDown="A(event,this.form.txtP107_1_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_1_5" id="txtP107_1_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_1_5']; ?>" onKeyDown="A(event,this.form.txtP107_1_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_1_6" id="txtP107_1_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_1_6']; ?>" onKeyDown="A(event,this.form.txtP107_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>maquinaria?</td>
                            <td><input class="cuarenta_px" name="txtP107_2_1" id="txtP107_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_2_1']; ?>" onKeyDown="A(event,this.form.txtP107_2_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_2_2" id="txtP107_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_2_2']; ?>" onKeyDown="A(event,this.form.txtP107_2_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_2_3" id="txtP107_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_2_3']; ?>" onKeyDown="A(event,this.form.txtP107_2_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_2_4" id="txtP107_2_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_2_4']; ?>" onKeyDown="A(event,this.form.txtP107_2_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_2_5" id="txtP107_2_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_2_5']; ?>" onKeyDown="A(event,this.form.txtP107_2_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_2_6" id="txtP107_2_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_2_6']; ?>" onKeyDown="A(event,this.form.txtP107_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>insumos?</td>
                            <td><input class="cuarenta_px" name="txtP107_3_1" id="txtP107_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_3_1']; ?>" onKeyDown="A(event,this.form.txtP107_3_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_3_2" id="txtP107_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_3_2']; ?>" onKeyDown="A(event,this.form.txtP107_3_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_3_3" id="txtP107_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_3_3']; ?>" onKeyDown="A(event,this.form.txtP107_3_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_3_4" id="txtP107_3_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_3_4']; ?>" onKeyDown="A(event,this.form.txtP107_3_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_3_5" id="txtP107_3_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_3_5']; ?>" onKeyDown="A(event,this.form.txtP107_3_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_3_6" id="txtP107_3_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_3_6']; ?>" onKeyDown="A(event,this.form.txtP107_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>asistencia t&eacute;cnica?</td>
                            <td><input class="cuarenta_px" name="txtP107_4_1" id="txtP107_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_4_1']; ?>" onKeyDown="A(event,this.form.txtP107_4_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_4_2" id="txtP107_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_4_2']; ?>" onKeyDown="A(event,this.form.txtP107_4_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_4_3" id="txtP107_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_4_3']; ?>" onKeyDown="A(event,this.form.txtP107_4_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_4_4" id="txtP107_4_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_4_4']; ?>" onKeyDown="A(event,this.form.txtP107_4_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_4_5" id="txtP107_4_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_4_5']; ?>" onKeyDown="A(event,this.form.txtP107_4_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_4_6" id="txtP107_4_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_4_6']; ?>" onKeyDown="A(event,this.form.txtP107_5_1);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>cursos o talleres?</td>
                            <td><input class="cuarenta_px" name="txtP107_5_1" id="txtP107_5_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_5_1']; ?>" onKeyDown="A(event,this.form.txtP107_5_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_5_2" id="txtP107_5_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_5_2']; ?>" onKeyDown="A(event,this.form.txtP107_5_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_5_3" id="txtP107_5_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_5_3']; ?>" onKeyDown="A(event,this.form.txtP107_5_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_5_4" id="txtP107_5_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_5_4']; ?>" onKeyDown="A(event,this.form.txtP107_5_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_5_5" id="txtP107_5_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_5_5']; ?>" onKeyDown="A(event,this.form.txtP107_5_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP107_5_6" id="txtP107_5_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P107_5_6']; ?>" onKeyDown="A(event,this.form.btnP107_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP107_anterior"  id="btnP107_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p106')"/></td>
                            <td><input name="btnP107_siguiente" id="btnP107_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p108')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p108" style="display:<?php echo $p108; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>108.&iquest;En los &uacute;ltimos tres a&ntilde;os, solicit&oacute; cr&eacute;dito para la actividad agr&iacute;cola, <br />
                                cr&iacute;a de ganado, aves u otras especies, recursos forestales, <br /> recolecci&oacute;n o extracci&oacute;n de especies no maderables, caza o pesca?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 113</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP108" id="txtP108" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P108']; ?>" onKeyDown="A(event,this.form.btnP108_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP108_anterior"  id="btnP108_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p107')"/></td>
                            <td><input name="btnP108_siguiente" id="btnP108_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p109')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p109" style="display:<?php echo $p109; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>109. &iquest;Obtuvo el cr&eacute;dito solicitado?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 112</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP109" id="txtP109" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P109']; ?>" onKeyDown="A(event,this.form.btnP109_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP109_anterior"  id="btnP109_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p108')"/></td>
                            <td><input name="btnP109_siguiente" id="btnP109_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p110')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p110" style="display:<?php echo $p110; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td>110. &iquest;El cr&eacute;dito que obtuvo fue de car&aacute;cter...</td>
                        </tr>
                        <tr>
                            <td>1. individual?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP110_1" id="txtP110_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P110_1']; ?>" onKeyDown="A(event,this.form.txtP110_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. asociativo?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP110_2" id="txtP110_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P110_2']; ?>" onKeyDown="A(event,this.form.btnP110_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP110_anterior"  id="btnP110_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p109')"/></td>
                            <td><input name="btnP110_siguiente" id="btnP110_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p111')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p111" style="display:<?php echo $p111; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td>111.&iquest;El cr&eacute;dito lo obtuvo en...</td>
                        </tr>
                        <tr>
                            <td>1. entidad financiera con<br />fondo del Banco de<br />Desarrollo Productivo?(BDP)</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP111_1" id="txtP111_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P111_1']; ?>" onKeyDown="A(event,this.form.txtP111_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. entidad financiera con<br />otros fondos?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP111_2" id="txtP111_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P111_2']; ?>" onKeyDown="A(event,this.form.txtP111_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. prestamista local?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP111_3" id="txtP111_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P111_3']; ?>" onKeyDown="A(event,this.form.txtP111_4);"/></td>
                        </tr>
                        <tr>
                            <td>4. empresa privada?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP111_4" id="txtP111_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P111_4']; ?>" onKeyDown="A(event,this.form.btnP111_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP111_anterior"  id="btnP111_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p110')"/></td>
                            <td><input name="btnP111_siguiente" id="btnP111_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p112')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p112" style="display:<?php echo $p112; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>S&oacute;lo para los que respondieron que no obtuvieron el cr&eacute;dito solicitado <br />
                                112.&iquest;Las causas o motivos por los que no obtuvo cr&eacute;dito son...</td>
                        </tr>
                        <tr>
                            <td>1. falta de garantia?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP112_1" id="txtP112_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P112_1']; ?>" onKeyDown="A(event,this.form.txtP112_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. falta de documentaci&oacute;n?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP112_2" id="txtP112_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P112_2']; ?>" onKeyDown="A(event,this.form.txtP112_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. deuda pendiente?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP112_3" id="txtP112_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P112_3']; ?>" onKeyDown="A(event,this.form.btnP112_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP112_anterior"  id="btnP112_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p111')"/></td>
                            <td><input name="btnP112_siguiente" id="btnP112_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p113')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p113" style="display:<?php echo $p113; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>113.&iquest;Cuenta con Seguro Agr&iacute;cola?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 115</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP113" id="txtP113" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P113']; ?>" onKeyDown="A(event,this.form.btnP113_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP113_anterior"  id="btnP113_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p112')"/></td>
                            <td><input name="btnP113_siguiente" id="btnP113_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p114')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
			</td>
        </tr>
        <tr>
            <td>
                <div id="p114" style="display:<?php echo $p114; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>114. &iquest;A qu&eacute; cultivo(s) se aplica este seguro?</td>
                        </tr>    
                    </table>
                    <table border="1">
                        <tr>
                            <td>1</td>
                            <td><input class="trecientos_px" name="txtP114_1" id="txtP114_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P114_1']; ?>" onKeyDown="A(event,this.form.txtP114_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><input class="trecientos_px" name="txtP114_2" id="txtP114_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P114_2']; ?>" onKeyDown="A(event,this.form.txtP114_3);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><input class="trecientos_px" name="txtP114_3" id="txtP114_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P114_3']; ?>" onKeyDown="A(event,this.form.btnP114_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP114_anterior"  id="btnP114_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p113')"/></td>
                            <td><input name="btnP114_siguiente" id="btnP114_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p115')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p115" style="display:<?php echo $p115; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td>115. &iquest;Al d&iacute;a de hoy, cu&aacute;l es la cantidad de construcciones e instalaciones que tiene? <br />
                                (anote el a&ntilde;o de la primera y &uacute;ltima construcci&oacute;n)
                            </td>
                        </tr>
                    </table>
                    <table border="1">    
                        <tr>
                            <td></td>
                            <td>Descripci&oacute;n</td>
                            <td>Cantidad</td>
                            <td>Primer<br />a&ntilde;o</td>
                            <td>&Uacute;ltimo<br />a&ntilde;o</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Viviendas</td>
                            <td><input class="cuarenta_px" name="txtP115_1_1" id="txtP115_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_1_1']; ?>" onKeyDown="A(event,this.form.txtP115_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px" name="txtP115_1_2" id="txtP115_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_1_2']; ?>" onKeyDown="A(event,this.form.txtP115_1_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP115_1_3" id="txtP115_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_1_3']; ?>" onKeyDown="A(event,this.form.txtP115_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Almaceneso dep&oacute;sitos </td>
                            <td><input class="cuarenta_px" name="txtP115_2_1" id="txtP115_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_2_1']; ?>" onKeyDown="A(event,this.form.txtP115_2_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP115_2_2" id="txtP115_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_2_2']; ?>" onKeyDown="A(event,this.form.txtP115_2_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP115_2_3" id="txtP115_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_2_3']; ?>" onKeyDown="A(event,this.form.txtP115_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Tanques de agua o noques</td>
                            <td><input class="cuarenta_px" name="txtP115_3_1" id="txtP115_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_3_1']; ?>" onKeyDown="A(event,this.form.txtP115_3_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP115_3_2" id="txtP115_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_3_2']; ?>" onKeyDown="A(event,this.form.txtP115_3_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP115_3_3" id="txtP115_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_3_3']; ?>" onKeyDown="A(event,this.form.txtP115_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Tanques de combustible</td>
                            <td><input class="cuarenta_px" name="txtP115_4_1" id="txtP115_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_4_1']; ?>" onKeyDown="A(event,this.form.txtP115_4_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP115_4_2" id="txtP115_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_4_2']; ?>" onKeyDown="A(event,this.form.txtP115_4_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP115_4_3" id="txtP115_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_4_3']; ?>" onKeyDown="A(event,this.form.txtP115_5_1);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Alambrados por hect&aacute;rea<br />lineal (potreros)</td>
                            <td><input class="cuarenta_px" name="txtP115_5_1" id="txtP115_5_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_5_1']; ?>" onKeyDown="A(event,this.form.txtP115_5_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP115_5_2" id="txtP115_5_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_5_2']; ?>" onKeyDown="A(event,this.form.txtP115_5_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP115_5_3" id="txtP115_5_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_5_3']; ?>" onKeyDown="A(event,this.form.txtP115_6_1);"/></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Cerca el&eacute;ctrica por kil&oacute;metro</td>
                            <td><input class="cuarenta_px" name="txtP115_6_1" id="txtP115_6_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_6_1']; ?>" onKeyDown="A(event,this.form.txtP115_6_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP115_6_2" id="txtP115_6_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_6_2']; ?>" onKeyDown="A(event,this.form.txtP115_6_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP115_6_3" id="txtP115_6_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_6_3']; ?>" onKeyDown="A(event,this.form.txtP115_7_1);"/></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Instalaciones de electricidad</td>
                            <td><input class="cuarenta_px" name="txtP115_7_1" id="txtP115_7_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_7_1']; ?>" onKeyDown="A(event,this.form.txtP115_7_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP115_7_2" id="txtP115_7_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_7_2']; ?>" onKeyDown="A(event,this.form.txtP115_7_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP115_7_3" id="txtP115_7_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P115_7_3']; ?>" onKeyDown="A(event,this.form.btnP115_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP115_anterior"  id="btnP115_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p114')"/></td>
                            <td><input name="btnP115_siguiente" id="btnP115_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p116')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p116" style="display:<?php echo $p116; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td>116. &iquest;Al d&iacute;a de hoy, cu&aacute;l es la cantidad de maquinaria, equipos e <br />
                                implementos que tiene? (anote el a&ntilde;o de la primera y &uacute;ltima compra)
                            </td>
                        </tr>    
                    </table>
                    <table border="1">
                        <tr>
                            <td></td>
                            <td>Descripci&oacute;n</td>
                            <td>Cantidad</td>
                            <td>Primer<br />a&ntilde;o</td>
                            <td>&Uacute;ltimo<br />a&ntilde;o</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Camiones o camionetas</td>
                            <td><input class="cuarenta_px" name="txtP116_1_1" id="txtP116_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_1_1']; ?>" onKeyDown="A(event,this.form.txtP116_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px" name="txtP116_1_2" id="txtP116_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_1_2']; ?>" onKeyDown="A(event,this.form.txtP116_1_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP116_1_3" id="txtP116_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_1_3']; ?>" onKeyDown="A(event,this.form.txtP116_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Bombas de agua el&eacute;ctrica</td>
                            <td><input class="cuarenta_px" name="txtP116_2_1" id="txtP116_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_2_1']; ?>" onKeyDown="A(event,this.form.txtP116_2_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP116_2_2" id="txtP116_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_2_2']; ?>" onKeyDown="A(event,this.form.txtP116_2_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP116_2_3" id="txtP116_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_2_3']; ?>" onKeyDown="A(event,this.form.txtP116_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Bombas de agua manual</td>
                            <td><input class="cuarenta_px" name="txtP116_3_1" id="txtP116_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_3_1']; ?>" onKeyDown="A(event,this.form.txtP116_3_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP116_3_2" id="txtP116_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_3_2']; ?>" onKeyDown="A(event,this.form.txtP116_3_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP116_3_3" id="txtP116_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_3_3']; ?>" onKeyDown="A(event,this.form.txtP116_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Motores el&eacute;ctricos</td>
                            <td><input class="cuarenta_px" name="txtP116_4_1" id="txtP116_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_4_1']; ?>" onKeyDown="A(event,this.form.txtP116_4_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP116_4_2" id="txtP116_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_4_2']; ?>" onKeyDown="A(event,this.form.txtP116_4_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP116_4_3" id="txtP116_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_4_3']; ?>" onKeyDown="A(event,this.form.txtP116_5_1);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Motosierras</td>
                            <td><input class="cuarenta_px" name="txtP116_5_1" id="txtP116_5_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_5_1']; ?>" onKeyDown="A(event,this.form.txtP116_5_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP116_5_2" id="txtP116_5_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_5_2']; ?>" onKeyDown="A(event,this.form.txtP116_5_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP116_5_3" id="txtP116_5_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_5_3']; ?>" onKeyDown="A(event,this.form.txtP116_6_1);"/></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Pulverizadoras o <br />nebulizadoras</td>
                            <td><input class="cuarenta_px" name="txtP116_6_1" id="txtP116_6_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_6_1']; ?>" onKeyDown="A(event,this.form.txtP116_6_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP116_6_2" id="txtP116_6_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_6_2']; ?>" onKeyDown="A(event,this.form.txtP116_6_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP116_6_3" id="txtP116_6_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_6_3']; ?>" onKeyDown="A(event,this.form.txtP116_7_1);"/></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Paneles solares</td>
                            <td><input class="cuarenta_px" name="txtP116_7_1" id="txtP116_7_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_7_1']; ?>" onKeyDown="A(event,this.form.txtP116_7_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP116_7_2" id="txtP116_7_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_7_2']; ?>" onKeyDown="A(event,this.form.txtP116_7_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP116_7_3" id="txtP116_7_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P116_7_3']; ?>" onKeyDown="A(event,this.form.btnP116_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP116_anterior"  id="btnP116_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p115')"/></td>
                            <td><input name="btnP116_siguiente" id="btnP116_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p117')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p117" style="display:<?php echo $p117; ?>; top: 350px; position: absolute;"> 
                    <label><strong>XIII. USO DE ELECTRICIDAD, GAS NATURAL, TRACCI&Oacute;N ANIMAL Y MAQUINARIA AGROPECUARIA</strong></label>
                    <table>    
                        <tr>
                            <td>117.&iquest;Cu&aacute;les son las fuentes o almacenamiento de agua que utiliza <br />
                                para regar sus cultivos o para el consumo de su ganado...
                            </td>
                        </tr>    
                    </table>
                    <table>
                        <tr>
                            <td>1. energia el&eacute;ctrica de red?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP117_1" id="txtP117_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P117_1']; ?>" onKeyDown="A(event,this.form.txtP117_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. gas natural comprimido?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP117_2" id="txtP117_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P117_2']; ?>" onKeyDown="A(event,this.form.txtP117_3);"/></td>
                        </tr>
                        <tr>
                            <td>3. gas licuado de petroleo?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP117_3" id="txtP117_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P117_3']; ?>" onKeyDown="A(event,this.form.txtP117_4);"/></td>
                        </tr>
                        <tr>
                            <td>4. diesel?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP117_4" id="txtP117_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P117_4']; ?>" onKeyDown="A(event,this.form.txtP117_5);"/></td>
                        </tr>
                        <tr>
                            <td>5. gasolina?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP117_5" id="txtP117_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P117_5']; ?>" onKeyDown="A(event,this.form.txtP117_6);"/></td>
                        </tr>
                        <tr>
                            <td>6. le&ntilde;a?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP117_6" id="txtP117_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P117_6']; ?>" onKeyDown="A(event,this.form.txtP117_7);"/></td>
                        </tr>
                        <tr>
                            <td>7. residuos agopecuarios?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP117_7" id="txtP117_7" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P117_7']; ?>" onKeyDown="A(event,this.form.txtP117_8);"/></td>
                        </tr>
                        <tr>
                            <td>8. energia e&oacute;lica?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP117_8" id="txtP117_8" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P117_8']; ?>" onKeyDown="A(event,this.form.btnP117_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP117_anterior"  id="btnP117_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p116')"/></td>
                            <td><input name="btnP117_siguiente" id="btnP117_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p118')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p118" style="display:<?php echo $p118; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td>118. &iquest;Utiliza animales de tiro para sus actividades agropecuarias?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP118" id="txtP118" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P118']; ?>" onKeyDown="A(event,this.form.btnP118_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP118_anterior"  id="btnP118_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p117')"/></td>
                            <td><input name="btnP118_siguiente" id="btnP118_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p119')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p119" style="display:<?php echo $p119; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>119. &iquest;Utiliza tractor(es) para sus trabajos agropecuarios?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 121</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP119" id="txtP119" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P119']; ?>" onKeyDown="A(event,this.form.btnP119_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP119_anterior"  id="btnP119_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p118')"/></td>
                            <td><input name="btnP119_siguiente" id="btnP119_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p120')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p120" style="display:<?php echo $p120; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>120. &iquest;Los tractores que utiliza principalmente, son?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Propios</td>
                                        <td>1</td>
                                    </tr>
                                    <tr align="right">
                                        <td>Alquilados</td>
                                        <td>2</td>
                                    </tr>
                                    <tr align="right">
                                        <td>Prestados</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP120" id="txtP120" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P120']; ?>" onKeyDown="A(event,this.form.btnP120_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP120_anterior"  id="btnP120_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p119')"/></td>
                            <td><input name="btnP120_siguiente" id="btnP120_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p121')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p121" style="display:<?php echo $p121; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td>121. &iquest;Utiliza cosechadoras para sus trabajos agr&iacute;colas?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 123</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP121" id="txtP121" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P121']; ?>" onKeyDown="A(event,this.form.btnP121_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP121_anterior"  id="btnP121_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p120')"/></td>
                            <td><input name="btnP121_siguiente" id="btnP121_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p122')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p122" style="display:<?php echo $p122; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>122. &iquest;Las cosechadoras que utiliza principalmente, son?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>          
                                    <tr align="right">
                                        <td>Propias</td>
                                        <td>1</td>
                                    </tr>
                                    <tr align="right">
                                        <td>Alquiladas</td>
                                        <td>2</td>
                                    </tr>
                                    <tr align="right">
                                        <td>Prestadas</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP122" id="txtP122" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P122']; ?>" onKeyDown="A(event,this.form.btnP122_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>          
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP122_anterior"  id="btnP122_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p121')"/></td>
                            <td><input name="btnP122_siguiente" id="btnP122_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p123')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p123" style="display:<?php echo $p123; ?>; top: 350px; position: absolute;"> 
                    <label><strong>XIV. PERSONAL OCUPADO EN LA UPA</strong></label>
                    <table>    
                        <tr>
                            <td>123. &iquest;Durante el a&ntilde;o agr&iacute;cola, particip&oacute; de sistemas de trabajo como...</td>
                        </tr>
                        <tr>
                            <td>1. minka o ayni?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP123_1" id="txtP123_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P123_1']; ?>" onKeyDown="A(event,this.form.txtP123_2);" autofocus="autofocus"/></td>
                        </tr>
                        <tr>
                            <td>2. comunitario, colectivo o familiar?</td>
                            <td>Si 1</td>
                            <td>No 2</td>
                            <td><input class="cuarenta_px" name="txtP123_2" id="txtP123_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P123_2']; ?>" onKeyDown="A(event,this.form.btnP123_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP123_anterior"  id="btnP123_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p122')"/></td>
                            <td><input name="btnP123_siguiente" id="btnP123_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p124')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p124" style="display:<?php echo $p124; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td>124. &iquest;Durante el a&ntilde;o agr&iacute;cola, emple&oacute; personal remunerado en dinero o en especie?<br>
                                    (Incluya a trabajadores como : obreros, empleados, administrativos y otros. No incluya a los trabajadores del hogar)
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table>          
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 125</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP124" id="txtP124" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P124_1']; ?>" onKeyDown="A(event,this.form.txtP124_1_1);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>          
                                </table>
                            </td>
                        </tr>    
                    </table>
                    <table border="1">
                        <tr>
                            <td rowspan="2">Actividades</td>
                            <td colspan="3" align="center">Cantidad</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td align="center">Hombres</td>
                            <td align="center">Mujeres</td>
                        </tr>
                        <tr>
                            <td>Agricola</td>
                            <td><input class="cuarenta_px" name="txtP124_1_1" id="txtP124_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P124_1_1']; ?>" onKeyDown="A(event,this.form.txtP124_1_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP124_1_2" id="txtP124_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P124_1_2']; ?>" onKeyDown="A(event,this.form.txtP124_1_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP124_1_3" id="txtP124_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P124_1_3']; ?>" onKeyDown="A(event,this.form.txtP124_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>Ganadera</td>
                            <td><input class="cuarenta_px" name="txtP124_2_1" id="txtP124_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P124_2_1']; ?>" onKeyDown="A(event,this.form.txtP124_2_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP124_2_2" id="txtP124_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P124_2_2']; ?>" onKeyDown="A(event,this.form.txtP124_2_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP124_2_3" id="txtP124_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P124_2_3']; ?>" onKeyDown="A(event,this.form.btnP124_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP124_anterior"  id="btnP124_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p123')"/></td>
                            <td><input name="btnP124_siguiente" id="btnP124_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p125')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p125" style="display:<?php echo $p125; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td>125.&iquest;Durante el a&ntilde;o agr&iacute;cola, emple&oacute; personal no remunerado? <br />
                                (familiares u otros no remunerados)
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table>          
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 126</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP125_1" id="txtP125_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P125_1']; ?>" onKeyDown="A(event,this.form.txtP125_1_1);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>          
                                </table>
                            </td>
                        </tr>    
                    </table>
                    <table border="1">    
                        <tr>
                            <td rowspan="2">Actividades</td>
                            <td colspan="3" align="center">Cantidad</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td align="center">Hombres</td>
                            <td align="center">Mujeres</td>
                        </tr>
                        <tr>
                            <td>Agricola</td>
                            <td><input class="cuarenta_px" name="txtP125_1_1" id="txtP125_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P125_1_1']; ?>" onKeyDown="A(event,this.form.txtP125_1_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP125_1_2" id="txtP125_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P125_1_2']; ?>" onKeyDown="A(event,this.form.txtP125_1_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP125_1_3" id="txtP125_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P125_1_3']; ?>" onKeyDown="A(event,this.form.txtP125_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>Ganadera</td>
                            <td><input class="cuarenta_px" name="txtP125_2_1" id="txtP125_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P125_1_1']; ?>" onKeyDown="A(event,this.form.txtP125_2_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP125_2_2" id="txtP125_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P125_1_2']; ?>" onKeyDown="A(event,this.form.txtP125_2_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP125_2_3" id="txtP125_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P125_1_3']; ?>" onKeyDown="A(event,this.form.btnP125_siguiente);"/></td>
                        </tr>    
                    </table>
                    <table>    
                        <tr>
                            <td><input name="btnP125_anterior"  id="btnP125_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p124')"/></td>
                            <td><input name="btnP125_siguiente" id="btnP125_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p126')"/></td>
                        </tr>    
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p126" style="display:<?php echo $p126; ?>; top: 350px; position: absolute;"> 
                    <label><strong>XV. OTROS DATOS DEL PRODUCTOR(A)</strong></label>
                    <table>    
                        <tr>
                            <td>126. Solo para UPAs en Comunidad &iquest;tiene o trabaja otras parcelas fuera de la Comunidad ?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 129</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP126" id="txtP126" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P126']; ?>" onKeyDown="A(event,this.form.btnP126_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>    
                        <tr>
                            <td><input name="btnP126_anterior"  id="btnP126_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p125')"/></td>
                            <td><input name="btnP126_siguiente" id="btnP126_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p127')"/></td>
                        </tr>    
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p127" style="display:<?php echo $p127; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td>127. &iquest;Estas parcelas se encuentran ubicadas en...<br /> A. este municipio?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP127_1" id="txtP127_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P127_1']; ?>" onKeyDown="A(event,this.form.txtP127_2);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                                <table>          
                                    <tr>
                                        <td>Nombre de la comunidad(es)</td>
                                    </tr>
                                    <tr>
                                        <td><input class="trecientos_px" name="txtP127_2" id="txtP127_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P127_2']; ?>" onKeyDown="A(event,this.form.txtP127_3);"/></td>
                                    </tr>
                                    <tr>
                                        <td><input class="trecientos_px" name="txtP127_3" id="txtP127_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P127_3']; ?>" onKeyDown="A(event,this.form.txtP127_4);"/></td>
                                    </tr>          
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>B. otros municipios?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP127_4" id="txtP127_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P127_4']; ?>" onKeyDown="A(event,this.form.txtP127_5);"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                                <table>
                                    <tr>
                                        <td>Nombre de los otros municipios</td>
                                    </tr>
                                    <tr>
                                        <td><input class="quinientos_px" name="txtP127_5" id="txtP127_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P127_5']; ?>" onKeyDown="A(event,this.form.txtP127_6);"/></td>
                                    </tr>
                                    <tr>
                                        <td><input class="quinientos_px" name="txtP127_6" id="txtP127_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P127_6']; ?>" onKeyDown="A(event,this.form.btnP127_siguiente);"/></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP127_anterior"  id="btnP127_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p126')"/></td>
                            <td><input name="btnP127_siguiente" id="btnP127_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p128')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p128" style="display:<?php echo $p128; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td>128. Solo para UPAs en &aacute;reas dispersas o periferia de ciudad &iquest;tiene o trabaja otras parcelas fuera del municipio?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Si</td>
                                        <td>1</td>
                                        <td></td>
                                    </tr>
                                    <tr align="right">
                                        <td>No</td>
                                        <td>2</td>
                                        <td>-&gt; Pase a la pregunta 129</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP128_1" id="txtP128_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P128_1']; ?>" onKeyDown="A(event,this.form.txtP128_2);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                                <table>
                                    <tr>
                                        <td>Nombre de los otros municipios</td>
                                    </tr>
                                    <tr>
                                        <td><input class="quinientos_px" name="txtP128_2" id="txtP128_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P128_2']; ?>" onKeyDown="A(event,this.form.txtP128_3);"/></td>
                                    </tr>
                                    <tr>
                                        <td><input class="quinientos_px" name="txtP128_3" id="txtP128_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P128_3']; ?>" onKeyDown="A(event,this.form.txtP128_4);"/></td>
                                    </tr>
                                    <tr>
                                        <td><input class="quinientos_px" name="txtP128_4" id="txtP128_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P128_4']; ?>" onKeyDown="A(event,this.form.btnP128_siguiente);"/></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP128_anterior"  id="btnP128_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p127')"/></td>
                            <td><input name="btnP128_siguiente" id="btnP128_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p129')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p129" style="display:<?php echo $p129; ?>; top: 350px; position: absolute;">
                    <table>    
                        <tr>
                            <td>129. S&oacute;lo si el Productor(a) es persona individual o sociedad de hecho. Incluya al Productor(a), <br />
                                al c&oacute;nyuge, a los hijos dependientes y otros parientes dependientes del Productor(a).
                            </td>
                        </tr>    
                    </table>
                    <table border="1">    
                        <tr>
                            <td></td>
                            <td>(1)<br />Componentes de la familia del<br />productor(a)<br />(incluya s&oacute;lo a mayores de 7 a&ntilde;os)</td>
                            <td>(2)<br />&iquest;Qu&eacute;<br />edad<br />tiene?<br />(a&ntilde;os<br />cumplidos)</td>
                            <td>(3)<br />Sexo<br /><br />1. Hombre<br />2. Mujer</td>
                            <td>(4)<br />&iquest;Cu&aacute;ntos a&ntilde;os de<br />estudio tiene en la<br />educaci&oacute;n formal?<br /><br />Acumule todos los&nbsp; a&ntilde;os<br />desde el nivel escolar<br />hasta el &uacute;ltimo curso<br />aprobado</td>
                            <td>(5)<br />&iquest;En qu&eacute;<br />actividades<br />participa<br />principalmente?<br /><br />
                                1. Agr&iacute;cola<br />
                                2. Ganadera<br />3. Avicola<br />
                                4. Forestal<br />
                                5. Extracci&oacute;n<br />
                                6. Recolecci&oacute;n<br />
                                7. Caza<br />
                                8. Piscicola<br /><br />
                                9. No participa<br />(pase a otra <br />persona) </td>
                            <td>(6)<br>El tiempo que<br />dedica a esta<br />actividad es:<br /><br />1- Permanente<br />
                                    (pase a otra<br />persona)<br /><br />2. No permanente<br /></td>
                            <td>(7)<br>&iquest;Cu&aacute;l es la otra<br />actividad a la que<br />se dedica?<br /><br />
                                    (Si es m&aacute;s de una<br />
                                    anote la<br />
                                    principal)<br /><br />
                                    1. Mineria<br />
                                    2. Industria manufacturera<br />
                                    3. Construcci&oacute;n<br />
                                    4. Comercio<br />
                                    5. Transporte<br />
                                    6. Otros servicios<br /><br />
                                    7. Ninguna</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Productor(a)</td>
                            <td><input class="cuarenta_px" name="txtP129_1_1" id="txtP129_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_1_1']; ?>" onKeyDown="A(event,this.form.txtP129_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px" name="txtP129_1_2" id="txtP129_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_1_2']; ?>" onKeyDown="A(event,this.form.txtP129_1_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_1_3" id="txtP129_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_1_3']; ?>" onKeyDown="A(event,this.form.txtP129_1_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_1_4" id="txtP129_1_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_1_4']; ?>" onKeyDown="A(event,this.form.txtP129_1_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_1_5" id="txtP129_1_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_1_5']; ?>" onKeyDown="A(event,this.form.txtP129_1_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_1_6" id="txtP129_1_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_1_6']; ?>" onKeyDown="A(event,this.form.txtP129_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>C&oacute;nyuge</td>
                            <td><input class="cuarenta_px" name="txtP129_2_1" id="txtP129_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_2_1']; ?>" onKeyDown="A(event,this.form.txtP129_2_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_2_2" id="txtP129_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_2_2']; ?>" onKeyDown="A(event,this.form.txtP129_2_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_2_3" id="txtP129_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_2_3']; ?>" onKeyDown="A(event,this.form.txtP129_2_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_2_4" id="txtP129_2_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_2_4']; ?>" onKeyDown="A(event,this.form.txtP129_2_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_2_5" id="txtP129_2_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_2_5']; ?>" onKeyDown="A(event,this.form.txtP129_2_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_2_6" id="txtP129_2_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_2_6']; ?>" onKeyDown="A(event,this.form.txtP129_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Hijo(a) dependiente del productor(a)</td>
                            <td><input class="cuarenta_px" name="txtP129_3_1" id="txtP129_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_3_1']; ?>" onKeyDown="A(event,this.form.txtP129_3_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_3_2" id="txtP129_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_3_2']; ?>" onKeyDown="A(event,this.form.txtP129_3_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_3_3" id="txtP129_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_3_3']; ?>" onKeyDown="A(event,this.form.txtP129_3_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_3_4" id="txtP129_3_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_3_4']; ?>" onKeyDown="A(event,this.form.txtP129_3_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_3_5" id="txtP129_3_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_3_5']; ?>" onKeyDown="A(event,this.form.txtP129_3_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_3_6" id="txtP129_3_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_3_6']; ?>" onKeyDown="A(event,this.form.txtP129_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Hijo(a) dependiente del productor(a)</td>
                            <td><input class="cuarenta_px" name="txtP129_4_1" id="txtP129_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_4_1']; ?>" onKeyDown="A(event,this.form.txtP129_4_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_4_2" id="txtP129_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_4_2']; ?>" onKeyDown="A(event,this.form.txtP129_4_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_4_3" id="txtP129_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_4_3']; ?>" onKeyDown="A(event,this.form.txtP129_4_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_4_4" id="txtP129_4_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_4_4']; ?>" onKeyDown="A(event,this.form.txtP129_4_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_4_5" id="txtP129_4_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_4_5']; ?>" onKeyDown="A(event,this.form.txtP129_4_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_4_6" id="txtP129_4_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_4_6']; ?>" onKeyDown="A(event,this.form.txtP129_5_1);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Hijo(a) dependiente del productor(a)</td>
                            <td><input class="cuarenta_px" name="txtP129_5_1" id="txtP129_5_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_5_1']; ?>" onKeyDown="A(event,this.form.txtP129_5_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_5_2" id="txtP129_5_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_5_2']; ?>" onKeyDown="A(event,this.form.txtP129_5_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_5_3" id="txtP129_5_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_5_3']; ?>" onKeyDown="A(event,this.form.txtP129_5_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_5_4" id="txtP129_5_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_5_4']; ?>" onKeyDown="A(event,this.form.txtP129_5_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_5_5" id="txtP129_5_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_5_5']; ?>" onKeyDown="A(event,this.form.txtP129_5_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_5_6" id="txtP129_5_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_5_6']; ?>" onKeyDown="A(event,this.form.txtP129_6_1);"/></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Hijo(a) dependiente del productor(a)</td>
                            <td><input class="cuarenta_px" name="txtP129_6_1" id="txtP129_6_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_6_1']; ?>" onKeyDown="A(event,this.form.txtP129_6_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_6_2" id="txtP129_6_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_6_2']; ?>" onKeyDown="A(event,this.form.txtP129_6_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_6_3" id="txtP129_6_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_6_3']; ?>" onKeyDown="A(event,this.form.txtP129_6_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_6_4" id="txtP129_6_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_6_4']; ?>" onKeyDown="A(event,this.form.txtP129_6_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_6_5" id="txtP129_6_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_6_5']; ?>" onKeyDown="A(event,this.form.txtP129_6_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_6_6" id="txtP129_6_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_6_6']; ?>" onKeyDown="A(event,this.form.txtP129_7_1);"/></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Hijo(a) dependiente del productor(a)</td>
                            <td><input class="cuarenta_px" name="txtP129_7_1" id="txtP129_7_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_7_1']; ?>" onKeyDown="A(event,this.form.txtP129_7_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_7_2" id="txtP129_7_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_7_2']; ?>" onKeyDown="A(event,this.form.txtP129_7_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_7_3" id="txtP129_7_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_7_3']; ?>" onKeyDown="A(event,this.form.txtP129_7_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_7_4" id="txtP129_7_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_7_4']; ?>" onKeyDown="A(event,this.form.txtP129_7_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_7_5" id="txtP129_7_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_7_5']; ?>" onKeyDown="A(event,this.form.txtP129_7_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_7_6" id="txtP129_7_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_7_6']; ?>" onKeyDown="A(event,this.form.txtP129_8_1);"/></td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Otro pariente dependiente del productor(a)</td>
                            <td><input class="cuarenta_px" name="txtP129_8_1" id="txtP129_8_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_8_1']; ?>" onKeyDown="A(event,this.form.txtP129_8_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_8_2" id="txtP129_8_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_8_2']; ?>" onKeyDown="A(event,this.form.txtP129_8_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_8_3" id="txtP129_8_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_8_3']; ?>" onKeyDown="A(event,this.form.txtP129_8_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_8_4" id="txtP129_8_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_8_4']; ?>" onKeyDown="A(event,this.form.txtP129_8_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_8_5" id="txtP129_8_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_8_5']; ?>" onKeyDown="A(event,this.form.txtP129_8_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_8_6" id="txtP129_8_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_8_6']; ?>" onKeyDown="A(event,this.form.txtP129_9_1);"/></td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Otro pariente dependiente del productor(a)</td>
                            <td><input class="cuarenta_px" name="txtP129_9_1" id="txtP129_9_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_9_1']; ?>" onKeyDown="A(event,this.form.txtP129_9_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_9_2" id="txtP129_9_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_9_2']; ?>" onKeyDown="A(event,this.form.txtP129_9_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_9_3" id="txtP129_9_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_9_3']; ?>" onKeyDown="A(event,this.form.txtP129_9_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_9_4" id="txtP129_9_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_9_4']; ?>" onKeyDown="A(event,this.form.txtP129_9_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_9_5" id="txtP129_9_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_9_5']; ?>" onKeyDown="A(event,this.form.txtP129_9_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_9_6" id="txtP129_9_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_9_6']; ?>" onKeyDown="A(event,this.form.txtP129_10_1);"/></td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Otro pariente dependiente del productor(a)</td>
                            <td><input class="cuarenta_px" name="txtP129_10_1" id="txtP129_10_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_10_1']; ?>" onKeyDown="A(event,this.form.txtP129_10_2);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_10_2" id="txtP129_10_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_10_2']; ?>" onKeyDown="A(event,this.form.txtP129_10_3);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_10_3" id="txtP129_10_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_10_3']; ?>" onKeyDown="A(event,this.form.txtP129_10_4);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_10_4" id="txtP129_10_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_10_4']; ?>" onKeyDown="A(event,this.form.txtP129_10_5);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_10_5" id="txtP129_10_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_10_5']; ?>" onKeyDown="A(event,this.form.txtP129_10_6);"/></td>
                            <td><input class="cuarenta_px" name="txtP129_10_6" id="txtP129_10_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P129_10_6']; ?>" onKeyDown="A(event,this.form.btnP129_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP129_anterior"  id="btnP129_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p128')"/></td>
                            <td><input name="btnP129_siguiente" id="btnP129_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p130')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p130" style="display:<?php echo $p130; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>130. S&oacute;lo si el Productor(a) adem&aacute;s de trabajar en la UPA, tiene alguna otra actividad: &iquest;de d&oacute;nde proviene su mayor ingreso?</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>De trabajar en la UPA</td>
                                        <td>1</td>
                                    </tr>
                                    <tr align="right">
                                        <td>De la(s) otra(s) actividad(es)</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td><input class="cuarenta_px" name="txtP130" id="txtP130" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P130']; ?>" onKeyDown="A(event,this.form.btnP130_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP130_anterior"  id="btnP130_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p129')"/></td>
                            <td><input name="btnP130_siguiente" id="btnP130_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p131')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p131" style="display:<?php echo $p131; ?>; top: 350px; position: absolute;" > 
                    <label><strong>XVI. TABLA DE EQUIVALENCIAS</strong></label>
                    <table>                  
                        <tr>
                            <td>131. (No incluya las unidades convencionales sombreadas en la tabla de equivalencias)</td>
                        </tr>
                    </table>
                    <table border="1">
                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">Nombre usual de la<br />unidad de medida</td>
                            <td colspan="1" rowspan="2">Codigo de<br />unidad de <br />medida</td>
                            <td colspan="1" rowspan="2">1. Superficie<br />2. Peso<br />3. Volumen </td>
                            <td colspan="1" rowspan="2">Nombre del producto al<br />que se le aplica</td>
                            <td colspan="2" rowspan="1">Equivalencias</td>
                        </tr>
                        <tr>
                            <td>Cantidad (decimales)</td>
                            <td>Unidad de<br />medida</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td><input class="trecientos_px" name="txtP131_1_1" id="txtP131_1_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_1_1']; ?>" onKeyDown="A(event,this.form.txtP131_1_2);" autofocus="autofocus"/></td>
                            <td><input class="cuarenta_px"   name="txtP131_1_2" id="txtP131_1_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_1_2']; ?>" onKeyDown="A(event,this.form.txtP131_1_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP131_1_3" id="txtP131_1_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_1_3']; ?>" onKeyDown="A(event,this.form.txtP131_1_4);"/></td>
                            <td><input class="trecientos_px" name="txtP131_1_4" id="txtP131_1_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_1_4']; ?>" onKeyDown="A(event,this.form.txtP131_1_5);"/></td>
                            <td><input class="text-box"      name="txtP131_1_5" id="txtP131_1_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_1_5']; ?>" onKeyDown="A(event,this.form.txtP131_1_6);"/></td>
                            <td><input class="cuarenta_px"   name="txtP131_1_6" id="txtP131_1_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_1_6']; ?>" onKeyDown="A(event,this.form.txtP131_2_1);"/></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><input class="trecientos_px" name="txtP131_2_1" id="txtP131_2_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_2_1']; ?>" onKeyDown="A(event,this.form.txtP131_2_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP131_2_2" id="txtP131_2_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_2_2']; ?>" onKeyDown="A(event,this.form.txtP131_2_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP131_2_3" id="txtP131_2_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_2_3']; ?>" onKeyDown="A(event,this.form.txtP131_2_4);"/></td>
                            <td><input class="trecientos_px" name="txtP131_2_4" id="txtP131_2_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_2_4']; ?>" onKeyDown="A(event,this.form.txtP131_2_5);"/></td>
                            <td><input class="text-box"      name="txtP131_2_5" id="txtP131_2_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_2_5']; ?>" onKeyDown="A(event,this.form.txtP131_2_6);"/></td>
                            <td><input class="cuarenta_px"   name="txtP131_2_6" id="txtP131_2_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_2_6']; ?>" onKeyDown="A(event,this.form.txtP131_3_1);"/></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><input class="trecientos_px" name="txtP131_3_1" id="txtP131_3_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_3_1']; ?>" onKeyDown="A(event,this.form.txtP131_3_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP131_3_2" id="txtP131_3_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_3_2']; ?>" onKeyDown="A(event,this.form.txtP131_3_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP131_3_3" id="txtP131_3_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_3_3']; ?>" onKeyDown="A(event,this.form.txtP131_3_4);"/></td>
                            <td><input class="trecientos_px" name="txtP131_3_4" id="txtP131_3_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_3_4']; ?>" onKeyDown="A(event,this.form.txtP131_3_5);"/></td>
                            <td><input class="text-box"      name="txtP131_3_5" id="txtP131_3_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_3_5']; ?>" onKeyDown="A(event,this.form.txtP131_3_6);"/></td>
                            <td><input class="cuarenta_px"   name="txtP131_3_6" id="txtP131_3_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_3_6']; ?>" onKeyDown="A(event,this.form.txtP131_4_1);"/></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><input class="trecientos_px" name="txtP131_4_1" id="txtP131_4_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_4_1']; ?>" onKeyDown="A(event,this.form.txtP131_4_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP131_4_2" id="txtP131_4_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_4_2']; ?>" onKeyDown="A(event,this.form.txtP131_4_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP131_4_3" id="txtP131_4_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_4_3']; ?>" onKeyDown="A(event,this.form.txtP131_4_4);"/></td>
                            <td><input class="trecientos_px" name="txtP131_4_4" id="txtP131_4_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_4_4']; ?>" onKeyDown="A(event,this.form.txtP131_4_5);"/></td>
                            <td><input class="text-box"      name="txtP131_4_5" id="txtP131_4_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_4_5']; ?>" onKeyDown="A(event,this.form.txtP131_4_6);"/></td>
                            <td><input class="cuarenta_px"   name="txtP131_4_6" id="txtP131_4_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_4_6']; ?>" onKeyDown="A(event,this.form.txtP131_5_1);"/></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><input class="trecientos_px" name="txtP131_5_1" id="txtP131_5_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_5_1']; ?>" onKeyDown="A(event,this.form.txtP131_5_2);"/></td>
                            <td><input class="cuarenta_px"   name="txtP131_5_2" id="txtP131_5_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_5_2']; ?>" onKeyDown="A(event,this.form.txtP131_5_3);"/></td>
                            <td><input class="cuarenta_px"   name="txtP131_5_3" id="txtP131_5_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_5_3']; ?>" onKeyDown="A(event,this.form.txtP131_5_4);"/></td>
                            <td><input class="trecientos_px" name="txtP131_5_4" id="txtP131_5_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_5_4']; ?>" onKeyDown="A(event,this.form.txtP131_5_5);"/></td>
                            <td><input class="text-box"      name="txtP131_5_5" id="txtP131_5_5" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_5_5']; ?>" onKeyDown="A(event,this.form.txtP131_5_6);"/></td>
                            <td><input class="cuarenta_px"   name="txtP131_5_6" id="txtP131_5_6" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P131_5_6']; ?>" onKeyDown="A(event,this.form.btnP131_siguiente);"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP131_anterior"  id="btnP131_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p130')"/></td>
                            <td><input name="btnP131_siguiente" id="btnP131_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p132')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p132" style="display:<?php echo $p132; ?>; top: 350px; position: absolute;" >
                    <table>
                        <tr>
                            <td>132. SITUACI&Oacute;N DE LA ENTREVISTA</td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr align="right">
                                        <td>Entrevista completa</td>
                                        <td>1</td>
                                    </tr>
                                    <tr align="right">
                                        <td>Entrevista incompleta</td>
                                        <td>2</td>
                                    </tr>
                                    <tr align="right">
                                        <td>Rechazo</td>
                                        <td>3</td>
                                    </tr>
                                    <tr align="right">
                                        <td><input class="cuarenta_px" name="txtP132" id="txtP132" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['P132']; ?>" onKeyDown="A(event,this.form.btnP132_siguiente);" autofocus="autofocus"/></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnP132_anterior"  id="btnP132_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p131')"/></td>
                            <td><input name="btnP132_siguiente" id="btnP132_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p133')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p133" style="display:<?php echo $p133; ?>; top: 350px; position: absolute;" >
                    <table>
                        <tr>
                            <td>Si el entrevistado es un informante calificado (pregunta 16) anote el nombre.</td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>Nombre del informante<br />calificado</td>
                            <td><input class="novecientos_px" name="txtInformante_1" id="txtInformante_1" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['InformanteCalificado']; ?>" onKeyDown="A(event,this.form.txtInformante_2);" autofocus="autofocus"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>D&iacute;a</td>
                            <td><input class="cuarenta_px" name="txtInformante_2" id="txtInformante_2" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['Dia']; ?>" onKeyDown="A(event,this.form.txtInformante_3);"/></td>
                            <td>Mes</td>
                            <td><input class="cuarenta_px" name="txtInformante_3" id="txtInformante_3" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['Mes']; ?>" onKeyDown="A(event,this.form.txtInformante_4);"/></td>
                            <td>A&ntilde;o</td>
                            <td><input class="text-box" name="txtInformante_4" id="txtInformante_4" type="text" onfocus="selecciona_value(this)" value="<?php echo $row_datos['Anio']; ?>" onKeyDown="A(event,this.form.btnInformante_siguiente);" autofocus="autofocus"/></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><input name="btnInformante_anterior"  id="btnInformante_anterior" value="Anterior" type="button" onclick="enviar(this.form,'p131')"/></td>
                            <td><input name="btnInformante_siguiente" id="btnInformante_siguiente" value="Siguiente" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p134')"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="p134" style="display:<?php echo $p134; ?>; top: 350px; position: absolute;">
                    <table>
                        <tr>
                            <td>OBSERVACIONES: (Anote cualquier informaci&oacute;n adicional que pudiera resultar de inter&eacute;s para el Censo Agropecuario)</td>
                        </tr>
                        <tr>
                            <td><textarea class="novecientos_px" name="txtObservaciones" id="txtObservaciones" cols="20" rows="5" value="<?php echo $row_datos['Observaciones']; ?>"></textarea></td>
                        </tr>
                    </table>
					<table>
                        <tr>
                            <td><input name="btnObs_siguiente" id="btnObs_siguiente" value="Nueva Boleta" type="button" onKeyDown="A(event,null);" onclick="enviar(this.form,'p0')"/></td>
                            <td><input name="btnSalir" id="btnSalir" value="Salir" type="button"/></td>
                        </tr>
                    </table>
					<input type="hidden" name="MM_update" value="form" />					
                </div>
            </td>
        </tr>
		<?php endforeach;?>
    </table>    
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
<?php
mysql_free_result($Recordset1);

mysql_free_result($permisos);

mysql_free_result($listamenu);
?>
