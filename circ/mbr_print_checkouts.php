<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
  
  $ini_array = parse_ini_file("../Mails/config.ini"); // Für die DB-Verbindung
 
  require_once("../shared/common.php");
  $tab = "circulation";
  $nav = "view";
  $focus_form_name = "barcodesearch";
  $focus_form_field = "barcodeNmbr";

  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Member.php");
  require_once("../classes/MemberQuery.php");
  require_once("../classes/BiblioSearch.php");
  require_once("../classes/BiblioSearchQuery.php");
  require_once("../classes/DmQuery.php");
  require_once("../shared/get_form_vars.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Retrieving get var
  #****************************************************************************
  $mbrid = $_GET["mbrid"];
  if (isset($_GET["msg"])) {
    $msg = "<font class=\"error\">".H($_GET["msg"])."</font><br><br>";
  } else {
    $msg = "";
  }

  #****************************************************************************
  #*  Loading a few domain tables into associative arrays
  #****************************************************************************
  $dmQ = new DmQuery();
  $dmQ->connect();
  $mbrClassifyDm = $dmQ->getAssoc("mbr_classify_dm");
  $materialTypeDm = $dmQ->getAssoc("material_type_dm");
  $materialImageFiles = $dmQ->getAssoc("material_type_dm", "image_file");
  $dmQ->close();

  #****************************************************************************
  #*  Search database for member
  #****************************************************************************
  $mbrQ = new MemberQuery();
  $mbrQ->connect();
  $mbr = $mbrQ->get($mbrid);
  $mbrQ->close();

  #**************************************************************************
  #*  Show member checkouts
  #**************************************************************************
?>
<html>
<head>
<style type="text/css">
  <?php include("../css/style.php");?>
</style>
<meta name="description" content="OpenBiblio Library Automation System">
<title>Checkouts for <?php echo H($mbr->getFirstLastName());?></title>

</head>
<body bgcolor="<?php echo H(OBIB_PRIMARY_BG);?>" topmargin="5" bottommargin="5" leftmargin="5" rightmargin="5" marginheight="5" marginwidth="5" onLoad="self.focus();self.print();">

<font class="primary">
<table class="primary" width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td width="100%" class="noborder" valign="top">
      <h1><?php echo $loc->getText("mbrPrintCheckoutsTitle",array("mbrName"=>$mbr->getFirstLastName())); ?></h1>
    </td>
	<td width="100%" class="title" valign="top">
       <img align="middle" src="../images/Logo.png" border="0">    
	</td>
	<?php
	/**
	
	Programmierer: Roman Sheetz
	
	Java Script entfernt
	 <td class="noborder" valign="top" nowrap="yes"><font class="small"><a href="javascript:window.close()"><?php echo $loc->getText("mbrPrintCloseWindow"); ?></font></a>&nbsp;&nbsp;</font></td>
	 
	  
	*/
	?>
 
  </tr>
</table>
<br>
<table class="primary" width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td class="noborder" valign="top"><?php echo $loc->getText("mbrPrintCheckoutsHdr1");?></td>
    <td width="100%" class="noborder" valign="top"><?php echo H(date("F j, Y, g:i a"));?></td>
  </tr>
  <tr>
    <td class="noborder" valign="top" nowrap><?php echo $loc->getText("mbrPrintCheckoutsHdr2");?></td>
    <td class="noborder" valign="top"><?php echo H($mbr->getFirstLastName());?></td>
  </tr>
  <tr>
    <td class="noborder" valign="top" nowrap><?php echo $loc->getText("mbrPrintCheckoutsHdr3");?></td>
    <td class="noborder" valign="top"><?php echo H($mbr->getBarcodeNmbr());?></td>
  </tr>
  <tr>
    <td class="noborder" valign="top" nowrap><?php echo $loc->getText("mbrPrintCheckoutsHdr4");?></td>
    <td class="noborder" valign="top"><?php echo H($mbrClassifyDm[$mbr->getClassification()]);?></td>
  </tr>
</table>
<br>
<table class="primary">
  <tr>
    <td class="primary" valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("mbrViewOutHdr1"); ?>
    </th>
    <td class="primary" valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("Beschreibung"); ?>
    </th>
    <td class="primary" valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("Barcodenummer"); ?>
    </th>
	 <td class="primary" valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("Inhalt"); ?>
    </th>
   <?php 
	/**
	Programmierer: Roman Sheetz
	
	Autor entfernt
	<td class="primary" valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("mbrViewOutHdr5"); ?>
    </th>
	*/
  ?> 
   
    <td class="primary" valign="top" nowrap="yes" align="left">
      <?php echo $loc->getText("mbrViewOutHdr6"); ?>
    </th>
    <td class="primary" valign="top" align="left">
      <?php echo $loc->getText("mbrViewOutHdr7"); ?>
    </th>
  </tr>

<?php

  #****************************************************************************
  #*  Search database for BiblioStatus data
  #*
  #*	Hinzufügen einer DB Verbindung um an die Exemplar Felder 
  #*	für Bemerkung und Inhalt zu kommen
  #*
  #*	Komplett überarbeitet: 27.07.2022
  #*
  #****************************************************************************
  
  	$pdo = new PDO('mysql:host=localhost;dbname=openbiblio', $ini_array["dbuser"], $ini_array["dbpassword"]);
  	$sql_Lieferschein = "SELECT biblio_copy.status_begin_dt, biblio_copy.copy_desc ,biblio_copy.barcode_nmbr, biblio_copy_fields.data, biblio_copy.due_back_dt  FROM (biblio_copy LEFT JOIN member ON biblio_copy.mbrid = member.mbrid ) INNER JOIN biblio_copy_fields ON biblio_copy.copyid=biblio_copy_fields.copyid WHERE status_cd = 'out' and biblio_copy.mbrid=$mbrid and biblio_copy_fields.code='Inhalt';";
	
	foreach ($pdo->query($sql_Lieferschein) as $row)
	{
	?>	
	<tr>
	<td class="primary" valign="top" >
      <?php echo $row['status_begin_dt'];?>
    </td>
	<td class="primary" valign="top" >
      <?php echo $row['copy_desc'];?>
    </td>
	<td class="primary" valign="top" >
      <?php echo $row['barcode_nmbr'];?>
    </td>
	<td class="primary" valign="top" >
      <?php echo $row['data'];?>
    </td>
	<td class="primary" valign="top" >
      <?php echo $row['due_back_dt'];?>
    </td>
	<td class="primary" valign="top" >
      <?php echo $row['due_back_dt']-$row['status_begin_dt']; // Ermittelung ob des Objekt dieser im Verzug ist ?> 
    </td>
	</tr>
	<?php
	}
  
/*#*****************************************************************************

  $biblioQ = new BiblioSearchQuery();
  $biblioQ->connect();
  if ($biblioQ->errorOccurred()) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  if (!$biblioQ->doQuery(OBIB_STATUS_OUT,$mbrid)) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  if ($biblioQ->getRowCount() == 0) {
?>
  <tr>
    <td class="primary" align="center" colspan="6">
      <?php echo $loc->getText("mbrViewNoCheckouts"); ?>
    </td>
  </tr>
<?php
  } else {
    while ($biblio = $biblioQ->fetchRow()) {
?>
  <tr>
    <td class="primary" valign="top" nowrap>
      <?php echo H($biblio->getStatusBeginDt());?>
    </td>
    <td class="primary" valign="top" nowrap>
      <img src="../images/<?php echo HURL($materialImageFiles[$biblio->getMaterialCd()]);?>" width="20" height="20" border="0" align="middle" alt="<?php echo H($materialTypeDm[$biblio->getMaterialCd()]);?>">
      <?php echo H($materialTypeDm[$biblio->getMaterialCd()]);?>
    </td>
    <td class="primary" valign="top" >
      <?php echo H($biblio->getTitle());?>
    </td>
	<?php
	/**
	Programmierer: Roman Sheetz

	Autor entfernt
	<td class="primary" valign="top" >
      <?php echo H($biblio->getAuthor());?>
    </td>
	
	?>
	
    <td class="primary" valign="top" nowrap="yes">
      <?php echo H($biblio->getDueBackDt());?>
    </td>
    <td class="primary" valign="top" >
      <?php echo H($biblio->getDaysLate());?>
    </td>
  </tr>
<?php
    }
  }
  $biblioQ->close();
  */
?>

</table>
</body>
</html>