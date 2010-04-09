<?
$ip = $_SERVER['REMOTE_ADDR'];
$query = "http://ipinfodb.com/ip_query.php?ip=$ip&timezone=false";
$s = curl_init($query);
curl_setopt($s, CURLOPT_RETURNTRANSFER, true);
$xml = curl_exec($s);
$data = simplexml_load_string($xml);
?>
{
"coords": {
	"latitude": "<? echo $data->Latitude; ?>",
	"longitude": "<? echo $data->Longitude; ?>"
	}
}