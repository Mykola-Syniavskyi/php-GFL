<html>
<head>
	<title>%TITLE%</title>
</head>
<body>
<div><h2>%TITLE%</h2></div>

<form action="" method="post">
    <div style="color: #FF0000; font-size: 15px;"><strong>%SACCESS%</strong></div>
    <div style="color: #FF0000; font-size: 15px;"><strong>%ERROR_NAME%</strong></div>
    <input type="text" name="name" value="%NAME%"> &nbsp your FistLastName<br><br>
    <div style="color: #FF0000; font-size: 15px;"><strong>%ERROR_EMAIL%</strong></div>
    <input type="email" name="email" value="%EMAIL%"> &nbsp your email<br><br>
    <div style="color: #FF0000; font-size: 15px;"><strong>%ERROR_SELECT%</strong></div>    
    <select name="select">
        <option value="selected" disabled>please choose</option>
        <option value="php">php</option>
        <option value="js">js</option>
    </select> your subject<br><br>
    <div style="color: #FF0000; font-size: 15px;"><strong>%ERROR_TEXT%</strong></div>    
    <textarea name="text" cols="30" rows="5" size="50" value="%TEXT%"></textarea><br>
    <input type="submit" value="send">
</form>

</body>
</html>
