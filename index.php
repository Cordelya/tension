<html>
<head>
<title>Slack Chat Log Converter</title>
<!--
Slack Chat Log Converter
========================

This document assumes that you are providing two files via submission form:
1. the exported chat log
2. the users data

JSON data structures
==================
users.json is organized as follows:

id, team_id, name, deleted, color, real_name, tz, tz_label, tz_offset,
profile (first_name, last_name, avatar_hash, real_name, real_name_normalized,
image_24 (...32, 48, 72, 192, 512), is_admin, is_owner, is_primary_owner,
is_restricted, is_ultra_restricted, is_bot, updated)

chat.json is organized as follows:
type, user (keyed to "id" in users.json), text, ts

-->
</head>
<body>
  <h1>Tension</h1>
<h2>Slack Archives to HTML Converter</h2>
<form id="chat" action="index.php" enctype="multipart/form-data" method="post">
  <label for="users">Select the users file: </label>
  <input type="file" name="users.json" id="users"></input>
<!--<textarea name="users" id="users"></textarea>-->
<br/>
<label for "chat">Select a chat log file: </label>
<input type="file" name="chat.json" id="chat"></input>
<!--<textarea name="chat" id="chat"></textarea>-->
<input type="submit" value="Submit"/>
</form>

<?php

if ($_FILES) {

$users = json_decode(file_get_contents($_FILES['users_json']['tmp_name']), true);

$chat = file_get_contents($_FILES['chat_json']['tmp_name']);

$users_bracketed = $users;

for ($i = 0; $i < count($users_bracketed); $i++) {
$id = $users_bracketed[$i]['id'];
$tmp = '<';
$tmp .= $id;
$tmp .= '>';
$users_bracketed[$i]['id'] = $tmp;
}
/* This stuff does not work
foreach ($users as $user) {
str_replace($user['id'], $user['name'], $chat);

}
*/

$chat = json_decode($chat, true);

    foreach($chat as $row) { // loop through each chat log record and replace user id with username
    echo "<p><b>"; // open a paragraph and prepare to display username

    $id = $row['user'];
        $name = null;

        foreach ($users as $user) {
              if ($user["id"] == $id) {
                $name = $user["name"];
                break;
                }
              }






    echo $name;
    echo":</b><br/>";
    echo $row["text"];
    echo "<br/>";
    echo "<small>";
    echo date('m/d/y g:i:s a', $row["ts"]);
    echo "</small></p>";
    echo "<hr/>";
  }
}






 ?>
</body>

</html>
