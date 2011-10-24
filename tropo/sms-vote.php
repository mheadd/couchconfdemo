<?php 

// CouchDB settings
define("COUCH_HOST", "");
define("COUCH_PORT", "");
define("COUCH_DB_NAME", "");
define("COUCH_USER", "");
define("COUCH_PASS", "");

// Function to save vote.
function saveVote($id, $vote) {

	$doc = json_encode(array("selection" => $vote));
	$url = COUCH_HOST.":".COUCH_DB_PORT."/".COUCH_DB_NAME."/$id";
	
	$putData = tmpfile();
	fwrite($putData, $doc);
	fseek($putData, 0);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_PUT, true);
	curl_setopt($ch, CURLOPT_INFILE, $putData);
	curl_setopt($ch, CURLOPT_INFILESIZE, strlen($doc));
	curl_setopt($ch, CURLOPT_USERPWD, COUCH_USER . ":" . COUCH_PASS);
	curl_exec($ch);
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	// Conflict update means someone tried to vote twice. :-(
	if ($code != '201') {
		_log("*** HTTP response code: $code ***");
		return false;
	}
	return true;

}

// If the caller uses the voice channel, there is no initialText.
if(!$currentCall->initialText) {
	$vote = ask("Please enter the number of the selection you wish to vote for.", array("choices" => "1,2,3,4,5,6", "attempts" => 3));
}

// If the text channel is used, initialText is used to complete ask();
else {
	$vote = ask("", array("choices" => "[ANY]", "attempts" => 1));
}

// Save the vote.
if(saveVote($currentCall->callerID, $vote->value)) {
  if($currentCall->channel == "VOICE") {
	say("Thank you, your vote has been recorded.");
  } 
  else {
	_log("*** Vote recorded for " . $currentCall->callerID . " ***");
  }
} else {
	say("Sorry, there was a problem saving your vote.");
}

?>
