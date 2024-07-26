
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<h2>Administrator Login</h2>

<form method="post" action="index.php">
    <?php echo $message; ?><br>
    <input type="hidden" name = "action" value="checkLogin">
    <label for="email">E-Mail:</label>
    <input type="email" id="email" name="email" value="Vasilascuvasile@gmail.com" required>
    <br>
    <label for="password"  >Passwort:</label>
    <input type="password" id="password" name="password"  value="12" required>
    <br>
    <button type="submit">Login</button>
</form>
</body>
</html>
