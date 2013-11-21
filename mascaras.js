<script type="text/javascript">
        jQuery(function ($) {

            $("#<%= txtFechaLLenadoFormulario.ClientID %>").mask("99/99/9999");

            $.mask.definitions['g'] = '[AaBbCcDdEeFfGgHhIiJjKkLlMmNnOo]'; //deficinion de caracteres para la mascara g
            $("#<%= txtFolioFormularioActualizar.ClientID %>").mask("99999999?g");

            $.mask.definitions['f'] = '[ADad]';//definicion de caracteres de la mascara f
            $("#<%= txtNumeroCarpetaActualizar.ClientID %>").mask("99999999-f");
            $("#<%= txtManzanaActualizar.ClientID %>").mask("9999?9");//definicion cuatro numeros del 0000 al 9999 y al final un numero del 0 al 9

            $("#<%= txtCodigoActualizador.ClientID %>").numeric({allow: "aAsSvVtT"});//allow -> aumentar caracteres

            $("#<%= txtCodDepartamento.ClientID %>").mask("99");
            $("#<%= txtCodProvincia.ClientID %>").mask("99");
            $("#<%= txtCodMunicipio.ClientID %>").mask("99");
            $("#<%= txtCodCiudad.ClientID %>").mask("999");
            $("#<%= txtNomCiudad.ClientID %>").alphanumeric({ allow: "%_-() " });
            $("#<%= txtCodDistritoMunicipal.ClientID %>").mask("99");
            $("#<%= txtCodCantonEstadistico.ClientID %>").mask("99");
            $("#<%= txtNomCantonEstadistico.ClientID %>").alphanumeric({ allow: "%_-() " });
            $("#<%= txtNomZonaUnidadVecinal.ClientID %>").alphanumeric({ allow: "%_-() " });
            $("#<%= txtCodZonaUnidadVecinal.ClientID %>").mask("999");//numeros de 000 al 999 en cualquier combinacion

            $("#<%= txtNumeroVivienda.ClientID %>").numeric();
            $("#<%= txtLadoManzana.ClientID %>").alpha();
            $("#<%= txtNroOrdenPredio.ClientID %>").numeric();
            $("#<%= txtNroPuertaPredio.ClientID %>").alphanumeric({ allow: "-_ " });
            $("#<%= txtCodigoPredio.ClientID %>").alphanumeric({ ichars: "_- */" });

            $("#<%= txtNroPiso.ClientID %>").alphanumeric({ allow: "_- " });
            $("#<%= txtNroDepartamento.ClientID %>").alphanumeric({ allow: "-_ " });
            $("#<%= txtUsoEdificacion.ClientID %>").numeric({ ichars: '6780' });//ichars -> excluir caracteres
            $("#<%= txtNombreVivienda.ClientID %>").alphanumeric({ allow: "%_-() " });//allow -> incluir caracteres

            $("#<%= txtCantidadPersonas.ClientID %>").numeric();
            $("#<%= txtCapacidadTotal.ClientID %>").numeric();
        });
    </script>