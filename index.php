<?
/*----------------------------------------------------------------------
Painel Player Versão 0.4
Desenvolvidor Por: Mak (sirmakloud@gmail.com)
Editado Por: Jiraya (richard.cva21@hotmail.com(
----------------------------------------------------------------------*/
ob_start('ob_gzhandler');

session_start();

header('p3p: CP="CAO PSA OUR"');
//$erro=error_reporting(0);
include_once "incluir/configura.php";
include_once "injection.php";
header("Content-Type: text/html; charset=ISO-8859-1", true); 

include_once "verifica_tempo.php";



if($_GET['sess']=="logout")
{
 session_destroy();
   /* $_SESSION["charDir"]='';
    $_SESSION["charNum"]='';
    $_SESSION["charID"]='';
    $_SESSION["charName"]='';
    $_SESSION["charLevel"]='';
    $_SESSION["charClass"]='';*/
    header("location: index.php");
}

//Segurança para o PHP

//foreach ($_GET as $key=>$getvar){ $_GET[$key] = mssql_escape($getvar); } 
//foreach ($_POST as $key=>$postvar){ $_POST[$key] = mssql_escape($postvar); } 


function escapestrings($string)
{
    //se magic_quotes não estiver ativado, escapa a string
    if (!get_magic_quotes_gpc())
    {
        return mysql_escape_string($string); // função nativa do php para escapar variáveis.
    }
    else
    {
        // caso contrario
        return $string; // retorna a variável sem necessidade de escapar duas vezes
    }
}



if(!$_SESSION["ID"])
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<script language="JavaScript" type="text/JavaScript">
<!--
function disabledBttn(formname)
{
    if (document.all || document.getElementById) {
        for (i=0;i<formname.length;i++) {
            var bttn=formname.elements[i];
            if(bttn.type.toLowerCase()=="submit" || bttn.type.toLowerCase()=="reset" || bttn.type.toLowerCase()=="button")
                bttn.disabled=true;
        }
    }
}
//-->
function click() {
if (event.button==2||event.button==3) {
oncontextmenu='return false';
  }
}
document.onmousedown=click
document.oncontextmenu = new Function("return false;")

</script>
<title><?=$version?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="imgs/Icon.ico">
<link href="css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function disabledBttn(formname)
{
    if (document.all || document.getElementById) {
        for (i=0;i<formname.length;i++) {
            var bttn=formname.elements[i];
            if(bttn.type.toLowerCase()=="submit" || bttn.type.toLowerCase()=="reset" || bttn.type.toLowerCase()=="button")
                bttn.disabled=true;
        }
    }
}
//-->
</script>

<style type="text/css">
<!--
.style12 {font-size: 10px}
.style13 {color: #006699}
-->
</style>
</head>

<body bgcolor="transparent" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" allowtransparency="true">

<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
      <table width="448" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><img src="imgs/topo_contas.png" alt="Editado By Jiraya" width="448"></td>
        </tr>
      </table>
   <table width="448" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" background="imgs/fundo_textura1.gif" class="padding_all" style="border-bottom: solid 1px #cecece; border-top: solid 1px #cecece; border-left: solid 1px #cecece; border-right: solid 1px #cecece">
<?
    if($_POST['action']!="Logar")
    {
	require	'gerarrand.php';
	$strRand = gerar_string_randonica();
?>  
            <form method="post" onSubmit="disabledBttn(this)" action="index.php">
            <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
              <tr>
                <td colspan="2"><strong><font color="#000000">Entre com seus dados de acesso:</font></strong></td>
              </tr>
              <tr>
                      <td width="49%"><div align="right"><font color="#000000" class="black"><strong>ID: </strong></font></div></td>
                      <td width="51%"><span class="branco">
                        <input name="username" size="20" maxlength="15" type="text">
                      </span></td>
                    </tr>
                    <tr>
                      <td><div align="right"><span class="branco"><font color="#000000" class="black"><strong>Senha (Password):</strong></font></span></div></td>
                      <td><span class="branco">
                        <input name="password" size="20" maxlength="15" type="password">
                      </span></td>
                    </tr>
              <tr>
                <td colspan="2" align="center"><input type="submit" class="button" value="Logar"></td>
              </tr>
              <tr>
                <td colspan="2" align="right"><p><strong><img src="imgs/setaINF.png" width="11" height="11"><a href="cadtermos.php"> <font color="black">CRIAR UMA CONTA</font></a></strong></p></td>
              </tr>
			  <tr>
                <td colspan="2" align="right"><p><strong><img src="imgs/setaINF.png" width="11" height="11"><a href="recsenha.php"> <font color="black">ESQUECEU SUA SENHA?</font></a></strong></p></td>
              </tr>
            </table>
            <input type="hidden" name="action" value="Logar">
            </form>
<?
    }
    else
    {
        $required=array(
            "Seu ID"=>$_POST[username],
            "Sua Senha"=>$_POST[password],
        );

//Obtendo login e senha
$usuarioAPT = anti_sqli(escapestrings($_POST['username']));
$senhaAPT = anti_sqli(escapestrings($_POST['password']));
$usuarioAPT = trim($usuarioAPT);
$senhaAPT = trim($senhaAPT);


if (anti_sql($usuarioAPT) != 0 || anti_sql($senhaAPT) != 0 ) {
echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php'>";
} else {


        for($i=0;$i<count($required);$i++)
        {
            list($key,$value)=each($required);

            if(!$value)
                echo "Você esqueceu de informar <b>$key</b>.<br>";
            else
                $chkArr[]=true;
        }

        if(count($chkArr)==count($required))
        {
		
            $connection = odbc_connect( $connection_string, $user, $pass );
			
            $querysenha = "SELECT * FROM [accountdb].[dbo].[AllPersonalMember] WHERE [Userid]='$usuarioAPT'";
            $qsenha = odbc_exec($connection, $querysenha);

            $qtsenha = odbc_do($connection, $querysenha);
            $i2 = 0;
            while(odbc_fetch_row($qtsenha)) $i2++;
                        $email=odbc_result($qtsenha,12);

            if($i2>0)
            {

            $usernameP=anti_sqli($_POST[username]);
            $query = "SELECT * FROM [accountdb].[dbo].[".( strtoupper($usernameP[0]) ) ."GameUser] WHERE [userid]='$usuarioAPT' AND [Passwd]='$senhaAPT'";
            $q = odbc_exec($connection, $query);

            $qt = odbc_do($connection, $query);
            $i = 0;
            while(odbc_fetch_row($qt)) $i++;
                        $email=odbc_result($qt,12);

            if($i>0)
            {

		///////////////////////////////
                session_register("usercode");
                $farr = odbc_fetch_array($q);

                $_SESSION["ID"]=$farr[userid];

      echo "<table width=423 border=0 cellspacing=0 cellpadding=0>
  <tr>
    <td height=100 align=center><b><font color='black'>Carregando...<br><img src='imgs/loading.gif' width='20' height='20' /><br> </b></td>
  </tr>
</table>";
            }
            else
       echo "<table width=423 border=0 cellspacing=0 cellpadding=0>
  <tr>
    <td height=100 align=center><b><font color='black'>ID ou Senha incorretos!<br><img src='imgs/loading.gif' width='20' height='20' /><br></b></td>
  </tr>
</table>";

        } else {
	
	echo "<table width=423 border=0 cellspacing=0 cellpadding=0>
  <tr>
    <td height=100 align=center><b><font color='black'>ID ou Senha incorretos!<br><img src='imgs/loading.gif' width='20' height='20' /><br></b></td>
  </tr>
</table>";
}

        echo "<meta HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php'>";



    }
    //} Verifica pela GD fechamento
    }
	}


?>
</td>
      </table>
      </table>
      <div align="center"><strong><font color="red">&copy;  Painel de Controle - <? echo $nomedoserver; ?></font></strong><br>
<font color="red">Painel desenvolvido por Mak editado por Jiraya</font></div>
</body>
</html>


<?
exit;
}
require "index2.php";
ob_end_flush();
?>
