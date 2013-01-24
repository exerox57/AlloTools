<?php

	require_once('/class.Dao.php');
	require_once('/class.DBFactory.php');
	require_once('/class.Assets.php');
	require_once('/class.AssetsDAO.php');

	//Test avec BDD
		$aDAO = new AssetsDAO();
		//var $i;
		$tx='';
		$tt = array(array('id'=>0, 'lib'=>'page 1'), array('id'=>1, 'lib'=>'page 2'),array('id'=>2, 'lib'=>'page 3'));
		
		for($i = 3; $i < 15; $i++){
			$a = $aDAO->read($i);
			$n = $a->getName();
			$tt = array('id'=>".$i.", 'lib'=>$n);
		}
	
		
		echo $tt;
	//echo 'Je suis une valeur de la base Joomla : Tadaaa !';

?>