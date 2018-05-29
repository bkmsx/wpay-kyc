<?php
require __DIR__ . '/vendor/autoload.php';

function updateSheet($values, $row){
	$client = new Google_Client();
	
	$client->setApplicationName('BeepBeepNation');
	$client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
	$client->setAccessType('online');

	$client->setAuthConfig(__DIR__ . '/beepbeepnation_sheet.json');

	$sheets = new Google_Service_Sheets($client);

	$spreadsheetId = "1OG8AeNO4NLZN2ru1u57W0eH1KokO8Fxn545cPYamuM8";

	$updateRange = 'emails!A'.$row.':H'.$row;
	$updateBody = new Google_Service_Sheets_ValueRange([
	    'majorDimension' => 'ROWS',
	    'values' => [$values],
	]);

	$sheets->spreadsheets_values->update(
	    $spreadsheetId,
	    $updateRange,
	    $updateBody,
	    ['valueInputOption' => 'USER_ENTERED']
	);	
}

?>