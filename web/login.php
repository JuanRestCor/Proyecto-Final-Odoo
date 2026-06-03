<?php
require_once 'config_ldap.php';

$user = trim($_POST['user'] ?? '');
$pass = $_POST['pass'] ?? '';

if (empty($user) || empty($pass)) {
    die("<h2>Usuario y contrasena son requeridos.</h2>");
}

$ldapconn = ldap_connect($ldap_host, $ldap_port);
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

$authenticated = false;
$role = "";

foreach ($ous as $ou) {
    $dn = "uid=$user,ou=$ou,$ldap_dn";
    if (@ldap_bind($ldapconn, $dn, $pass)) {
        $authenticated = true;
        $role = $ou;
        break;
    }
}

ldap_close($ldapconn);

$user = htmlspecialchars($user);
$role = htmlspecialchars($role);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $authenticated ? "Bienvenido" : "Error" ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #1a1a2e; min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
        }
        .card {
            background: #16213e; border-radius: 12px;
            padding: 40px; width: 400px; text-align: center;
        }
        .icon { font-size: 56px; margin-bottom: 20px; }
        h1 { font-size: 26px; margin-bottom: 12px; }
        p  { color: #aaa; font-size: 15px; line-height: 1.6; }
        .success { border: 1px solid #27ae60; }
        .success h1 { color: #2ecc71; }
        .error { border: 1px solid #e94560; }
        .error h1 { color: #e94560; }
        .badge {
            display: inline-block; background: #0f3460;
            color: #7ecfff; padding: 6px 18px;
            border-radius: 20px; font-size: 13px; margin: 14px 0;
        }
        a {
            display: inline-block; margin-top: 24px;
            padding: 10px 28px; background: #e94560;
            color: #fff; border-radius: 8px; text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="card <?= $authenticated ? 'success' : 'error' ?>">
        <?php if ($authenticated): ?>
            <div class="icon">OK</div>
            <h1>Bienvenido, <?= $user ?></h1>
            <div class="badge">Area: <?= $role ?></div>
            <p>Autenticacion exitosa - Dominio: <strong style="color:#fff"><?= $ldap_dn ?></strong></p>
        <?php else: ?>
            <div class="icon">X</div>
            <h1>Error de autenticacion</h1>
            <p>Usuario o contrasena incorrectos.</p>
        <?php endif; ?>
        <a href="index.html">Volver</a>
    </div>
</body>
</html>
