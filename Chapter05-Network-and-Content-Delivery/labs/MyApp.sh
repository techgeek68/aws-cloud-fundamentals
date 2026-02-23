#!/bin/bash
set -euo pipefail

sudo dnf -y update
# Optional: enable newer PHP stream
# sudo dnf module reset -y php
# sudo dnf module enable -y php:8.2

sudo dnf install -y httpd php php-mysqlnd mariadb-server curl jq firewalld policycoreutils-python-utils

# enable & start services
sudo systemctl enable --now firewalld httpd mariadb || true
sudo firewall-cmd --permanent --add-service=http
sudo firewall-cmd --reload

# SELinux: allow Apache outbound network
sudo setsebool -P httpd_can_network_connect on

# write a minimal PHP metadata page (IMDSv2)
sudo tee /var/www/html/index.php > /dev/null <<'PHP'
<?php
function md($p){
  $t = trim(shell_exec("curl -s -X PUT http://169.254.169.254/latest/api/token -H 'X-aws-ec2-metadata-token-ttl-seconds:60'"));
  if (!$t) return 'N/A';
  $v = trim(shell_exec("curl -s -H 'X-aws-ec2-metadata-token: $t' http://169.254.169.254/latest/meta-data/$p"));
  return $v ? htmlspecialchars($v) : 'N/A';
}
$meta = [
  'Instance ID'=>md('instance-id'),
  'Instance Type'=>md('instance-type'),
  'Availability Zone'=>md('placement/availability-zone'),
  'Private IP'=>md('local-ipv4'),
  'Public Hostname'=>md('public-hostname'),
  'Public IPv4'=>md('public-ipv4'),
];
?>
<!doctype html><html><head><meta charset="utf-8"><title>AWS Lab</title>
<style>body{font-family:Arial;margin:30px;background:#f5f7fa}.box{background:#fff;padding:12px;border-radius:6px}</style>
</head><body><h1>AWS Lab Web App</h1><div class="box"><h2>Instance Metadata</h2><table><?php foreach($meta as $k=>$v){echo "<tr><td>$k</td><td>$v</td></tr>";}?></table>
<p>GitHub Username: <strong>techgeek68</strong></p></div><footer style="margin-top:20px;font-size:12px">&copy; <?=date('Y')?> AWS Lab Demo</footer></body></html>
PHP

sudo chown apache:apache /var/www/html/index.php
sudo chmod 644 /var/www/html/index.php

echo "User data script complete" | sudo tee /var/log/user-data-status.txt
