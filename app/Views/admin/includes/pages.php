<?php 
$siteDetails = get_site_details(); // Get site details
 echo view("admin/includes/header", ['siteDetails' => $siteDetails]); 
 echo view($page); 
 echo view("admin/includes/footer"); 
 ?>