<?php 
//$siteDetails = get_site_details(); // Get site details
 //echo view("frontend/includes/header", ['siteDetails' => $siteDetails]); 
 echo view("frontend/includes/header",['categoryMenu' => $categoryMenu]); 
 echo view($page); 
 echo view("frontend/includes/footer"); 
 ?>