<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Document</title>
</head>

<body>
    <div class="feed">
    <?php dd_instagram('instagram',10); ?>
    </div>
</body>

</html>

<?php


function dd_instagram($AccessToken, $feed = null)
{
  $timestamp = mktime(date('H'), date('i'), 0, date('n'), date('j') - 1, date('Y'));
  $AccessToken = '';
  //link para obter o ID https://graph.instagram.com/me?fields=id,username&access_token={tokenaqui}
  
  $instagram_user_id = '4888851684507423';
  $url = 'https://graph.instagram.com/' . $instagram_user_id . '/media?access_token=' . $AccessToken;
  $counter = 0;

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Instagram Gallery');

  $result = curl_exec($ch);

  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  $result = json_decode($result);

  foreach ($result->data as $media_id) {
    $id = $media_id->id;;

    $counter++;
    if ($counter <= $feed) {

      if ($id) {
        $url = 'https://graph.instagram.com/' . $id . '?fields=id,media_type,media_url,username,timestamp,permalink&access_token=' . $AccessToken;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Instagram Gallery');
        $result_image = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $result_image = json_decode($result_image);
        echo '<a href="' . $result_image->permalink . '" target="_blank"><img class="img" src="' . $result_image->media_url . '"/></a>';
      }
    }
  }
}

?>