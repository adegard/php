<?php
echo "<h1>IG MARKET SENTIMENTS DASHBOARD using Curl and PHP</h1></br>";
echo "<h2>Example of Web-Scraping in PHP</h2> </br>";
echo "<b>DON'T USE THE FOLLOWING INFORMATIONS FOR TRADING!</b></br>";
echo "<p>The current PHP extract IG pages results for Market sentiment (italian webpages) </br> Using Curl in PHP and returning results in HTML table it's give a friendly Dashboard for Marketing Monitoring of Indexes, Forex, cryptocurrencies...</p> </br>";
echo "<p>Source code on Github: <a href='https://github.com/adegard/php/blob/master/curl.php'>https://github.com/adegard/php/blob/master/curl.php</a></p> </br></br>";

echo "
<style type='text/css'>
.tg  {border-collapse:collapse;border-spacing:0;border-color:#aabcfe;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#aabcfe;color:#669;background-color:#e8edff;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#aabcfe;color:#039;background-color:#b9c9fe;}
.tg .tg-us36{border-color:inherit;vertical-align:top}
.tg .tg-yw4l{vertical-align:top}
</style>
<table class='tg'>
";

echo "
  <tr>
    <th class='tg-us36'>Symbol</th>
    <th class='tg-us36'>MENU1</th>
    <th class='tg-us36'>MENU2</th>
    <th class='tg-us36'>Order text</th>
    <th class='tg-yw4l'>%</th>
    <th class='tg-yw4l'>Action</th>
  </tr>
  ";

	include "simple_html_dom.php";
	
	$url = array("https://www.ig.com/it/indici/mercati-indici/germany-30",
				"https://www.ig.com/it/indici/mercati-indici/france-40", 
				"https://www.ig.com/it/indici/mercati-indici/italy-40",
				"https://www.ig.com/it/indici/mercati-indici/ftse-100",
				"https://www.ig.com/it/indici/mercati-indici/us-spx-500",
				"https://www.ig.com/it/indici/mercati-indici/spain-35-future",
				"https://www.ig.com/it/materie-prime/mercati-materie-prime/gold", 
				"https://www.ig.com/it/materie-prime/mercati-materie-prime/argento-spot-5000oz",
				"https://www.ig.com/it/forex/mercati-forex/forex-spot-eur-usd",
				"https://www.ig.com/it/forex/mercati-forex/forex-spot-gbp-usd",
				"https://www.ig.com/it/forex/mercati-forex/forex-spot-aud-usd",
				"https://www.ig.com/it/forex/mercati-forex/forex-spot-usd-jpy",
				"https://www.ig.com/it/marketanalysis/ig-forex/forex-spot-eur-chf",
				"https://www.ig.com/it/marketanalysis/ig-forex/forex-spot-eur-gbp",
				"https://www.ig.com/it/marketanalysis/ig-forex/forex-spot-gbp-eur",
				"https://www.ig.com/it/forex/mercati-forex/bitcoin-cash-usd",
				"https://www.ig.com/it/forex/mercati-forex/ether-usd"
				);
	
for ($x = 0; $x <= count($url)-1; $x++) {



	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url[$x]);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	$response = curl_exec($ch);
	curl_close($ch);

	$html = new simple_html_dom();
	$html->load($response);

	echo "  <tr>";
	echo "<td class='tg-us36'>";
	foreach($html->find('.ma__title') as $symbol)
			echo "<a href='$url[$x]' target='_blank'>". $symbol->plaintext ."</a>";
	echo "</td>";
	
	$symbol=$symbol->plaintext;
	
	//MENU1
	echo "<td class='tg-us36'>";
		if (strpos($url[$x], 'indici') !== false)    echo 'Indici';
		else if (strpos($url[$x], 'materie-prime') !== false)    echo 'Materie prime';
		else if (strpos($url[$x], 'forex-spot') !== false)    echo 'FX';
		else    echo 'Criptovalute';
		
	echo "</td>";

	//MENU2
	echo "<td class='tg-us36'>";
		if (strpos($url[$x], 'indici') !== false)    echo $symbol;
		else if (strpos($url[$x], 'materie-prime') !== false)    echo $symbol;
		else if (strpos($symbol, '/') !== false)    echo $symbol;
		else    echo 'Criptovalute';
		
	echo "</td>";
	
	//Test to find in Orders list
	echo "<td class='tg-us36'>";
		if (strpos($symbol, '/') !== false)    echo $symbol.' Mini';
		//gestione eccezioni:
		else if (strpos($symbol, 'Spot Gold') !== false)    echo 'Spot Gold (E1 Contract)';
		else if (strpos($symbol, 'Argento Spot (5000oz)') !== false)    echo 'Contratto Mini Argento Spot (500oz)';
		else if (strpos($symbol, 'Bitcoin Cash (USD)') !== false)    echo 'Bitcoin Cash';
		else if (strpos($symbol, 'Ether (USD)') !== false)    echo 'Ether';
		
		else if (strpos($url[$x], 'materie-prime') !== false)    echo $symbol;
		else if (strpos($url[$x], 'indici') !== false)    echo $symbol;
		else    echo 'TBD';
		
	echo "</td>";

	//Percent
	echo "<td class='tg-yw4l'>";
	foreach($html->find('.price-ticket__percent') as $precent)
			$precent=substr($precent->plaintext, 0, 2);
			echo $precent; //->plaintext;

	echo "</td>";
	
	
	echo "<td class='tg-yw4l'>";
	foreach($html->find('.information-popup strong') as $result) {
			if ($precent<71) {echo 'CLOSE';}
			else{
				if ($result->plaintext == 'ha posizioni short') echo '<b>SELL</b>';
				if ($result->plaintext == 'ha posizioni long') echo '<b>BUY</b>';
				}
			}
	echo "</td>";
	echo "  </tr>";
} 	
	echo "</table>";

	
	echo "Le informazioni contenute nel presente sito non sono dirette a soggetti residenti negli Stati Uniti d'America o in Belgio. Le informazioni contenute nel presente sito non sono destinate né intese alla distribuzione, o all'utilizzo da parte di soggetti residenti in una giurisdizione o paese in cui tale utilizzo o distribuzione sarebbero contrari alla legge o normativa locale applicabile.";
?>

