<?php
// Acquire IMDSv2 token (trimmed)
$token = trim(shell_exec("curl -s -X PUT http://169.254.169.254/latest/api/token -H 'X-aws-ec2-metadata-token-ttl-seconds: 60'"));

function md_safe($path, $token) {
    if ($token === '') return "N/A";
    $cmd = "curl -s -H 'X-aws-ec2-metadata-token: $token' http://169.254.169.254/latest/meta-data/$path";
    $val = shell_exec($cmd);
    if ($val === null || $val === false) return "N/A";
    $val = trim($val);
    return $val === '' ? 'N/A' : htmlspecialchars($val);
}

$iid     = md_safe("instance-id", $token);
$itype   = md_safe("instance-type", $token);
$az      = md_safe("placement/availability-zone", $token);
$localip = md_safe("local-ipv4", $token);
$pubhost = md_safe("public-hostname", $token);
$pubip   = md_safe("public-ipv4", $token);
?>
<!DOCTYPE html>
<html>
<head>
  <title>AWS Lab Web App</title>
  <style>
    body { font-family: Arial, sans-serif; margin:40px; background:#f5f7fa; }
    h1 { color:#232f3e; }
    .meta { background:#fff; padding:15px; border-radius:8px; box-shadow:0 2px 4px rgba(0,0,0,0.1); }
    table { border-collapse: collapse; }
    td { padding:6px 12px; border-bottom:1px solid #ddd; }
    .footer { margin-top:30px; font-size:12px; color:#555; }
    img { max-width:200px; }
  </style>
</head>
<body>
  <h1>AWS Lab Web App</h1>
  <img src="https://a0.awsstatic.com/libra-css/images/logos/aws_logo_smile_1200x630.png" alt="AWS Logo">
  <div class="meta">
    <h2>Instance Metadata (Live IMDSv2)</h2>
    <table>
      <tr><td>Instance ID</td><td><?php echo $iid; ?></td></tr>
      <tr><td>Instance Type</td><td><?php echo $itype; ?></td></tr>
      <tr><td>Availability Zone</td><td><?php echo $az; ?></td></tr>
      <tr><td>Private IP</td><td><?php echo $localip; ?></td></tr>
      <tr><td>Public Hostname</td><td><?php echo $pubhost; ?></td></tr>
      <tr><td>Public IPv4</td><td><?php echo $pubip; ?></td></tr>
    </table>
    <h2>Lab Owner</h2>
    <p>GitHub Username: <strong>techgeek68</strong></p>
    <p>Provisioned automatically via user data (RHEL variant with SELinux fix).</p>
  </div>
  <div class="footer">
    &copy; <?php echo date('Y'); ?> AWS Lab Demo
  </div>
</body>
</html>