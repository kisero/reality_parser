<?php

	$html=file($argv[1]);

	$i=0;
	foreach($html as $line) {

		$i++;
		if ( preg_match("/a title.*href=\"inzerat\/(.*)\"><img.*/",$line,$matches) ) {
			#print_r($matches);

			if ( !empty($matches[1]) ) {
				$uri=$matches[1];
				echo "https://www.reality.sk/inzerat/$uri,";
				
				#10 lines after i have the area
				$area_line=$i+9;
				if ( preg_match("/\"type\"><span>(.*)<\/span> <span class=\"area\">(.*)<\/span>/",$html[$area_line],$matches_area) ) {

					if ( !empty($matches_area[1]) ) {
						$izb=$matches_area[1];
						echo "$izb,";
					}

					if ( !empty($matches_area[2]) ) {
						$m2=$matches_area[2];
						$m2=preg_replace("/\,\d+\d+$/","",$m2);
						echo "$m2,";
					}
				}
				
				#12 lines after i have the street name 
				$ulica_line=$i+11;
				if ( preg_match("/<span>(.*)<\/span>/",$html[$ulica_line],$matches_ulica) ) {
					
					if ( !empty($matches_ulica[1]) ){ 
						$ulica=$matches_ulica[1];	
						echo "$ulica,";
					}
				}
				
				#17 lines after i have the price / m2
				$cena_line=$i+16;
				if ( preg_match("/<span>(.*)<\/span>/",$html[$cena_line],$matches_cena) ) {
					
					if ( !empty($matches_cena[1]) ){ 
						$cena=$matches_cena[1];	
						$cena=preg_replace("/ €\/m2/","",$cena);	
						$cena=preg_replace("/\,\d+\d+$/","",$cena);
						$cena = preg_replace("/[^0-9.]/", "", $cena);
						echo "$cena";
					}
				}

				echo "\n";
			}
		}
	}

?>
