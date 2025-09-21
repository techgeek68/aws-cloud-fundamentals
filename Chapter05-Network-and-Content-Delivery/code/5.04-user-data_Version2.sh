#!/bin/bash
set -xe

# 1. System update
sudo dnf -y update

# 2. (Optional) Ensure a suitable PHP stream (uncomment if you need a newer version)
# sudo dnf module reset -y php
# sudo dnf module enable -y php:8.2

# 3. Install packages
sudo dnf install -y httpd php php-mysqlnd mariadb-server curl jq firewalld policycoreutils-python-utils

# 4. Enable and start firewalld, then allow HTTP
sudo systemctl enable firewalld
sudo systemctl start firewalld
sudo firewall-cmd --permanent --add-service=http
sudo firewall-cmd --reload

# 5. Enable and start Apache & MariaDB (MariaDB optional)
sudo systemctl enable httpd
sudo systemctl start httpd
sudo systemctl enable mariadb
sudo systemctl start mariadb || true

# 6. Allow Apache outbound network (SELinux)
sudo setsebool -P httpd_can_network_connect on

# 7. Obtain IMDSv2 token for logging (page fetches its own live token anyway)
TOKEN=$(curl -s -X PUT "http://169.254.169.254/latest/api/token" \
  -H "X-aws-ec2-metadata-token-ttl-seconds: 21600" || true)

# 8. Create a PHP metadata page
sudo tee /var/www/html/index.php > /dev/null <<'PHPFILE'
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
PHPFILE

# 9. Permissions & restart
sudo chown apache:apache /var/www/html/index.php
sudo chmod 644 /var/www/html/index.php
sudo systemctl restart httpd

echo "User data script complete" | sudo tee /var/log/user-data-status.txt
