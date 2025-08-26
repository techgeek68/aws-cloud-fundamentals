# Lab: Build Your VPC and Launch a Web Server

## Lab Overview and Objectives

In this hands-on lab, you will:
- Design and build a custom VPC with public and private subnets in multiple Availability Zones.
- Configure route tables, internet gateway, and NAT gateway for secure network access.
- Create a security group to allow HTTP traffic.
- Launch an EC2 instance in your public subnet and configure it as a web server.

**Objectives:**
- Create a VPC and subnets
- Configure networking components (route tables, IGW, NAT GW)
- Create and configure a security group
- Launch and verify a web server EC2 instance
  
---

## Scenario & Architecture

You will build:
- A VPC (`lab-vpc`) in `us-east-1` with CIDR `10.0.0.0/16`
- Two public (`10.0.0.0/24`, `10.0.2.0/24`) and two private subnets (`10.0.1.0/24`, `10.0.3.0/24`) in two AZs
- Route tables for public/private subnets
- Internet Gateway and NAT Gateway
- Security group for web server
- EC2 instance in public subnet running Apache-based web app

---

## Lab Design (Target State Checklist)

| Component | Desired State |
|-----------|---------------|
| Region | us-east-1 (N. Virginia) |
| VPC | lab-vpc (CIDR 10.0.0.0/16) |
| Subnets | Public Subnet 1 (10.0.0.0/24, us-east-1a) • Private Subnet 1 (10.0.1.0/24, us-east-1a) • Public Subnet 2 (10.0.2.0/24, us-east-1b) • Private Subnet 2 (10.0.3.0/24, us-east-1b) |
| Internet Components | 1 Internet Gateway (lab-igw) + 1 NAT Gateway (lab-nat-gw) in Public Subnet 1 with an Elastic IP |
| Route Tables | lab-public-rt → 0.0.0.0/0 to IGW (associates to both public subnets); lab-private-rt → 0.0.0.0/0 to NAT Gateway (associates to both private subnets) |
| Security Group | Web Security Group: Inbound HTTP (80) from 0.0.0.0/0; outbound all |
| Key Pair | vockey |
| EC2 Instance | Web Server 1 (RHEL), t2.micro, Public Subnet 2 (us-east-1b), auto-assigned public IP, user data sets up Apache/PHP page with metadata + GitHub username `techgeek68` |
| Result | Browsing to the instance public DNS shows metadata table fields populated |

Cost Note: A NAT Gateway and Elastic IP accrue hourly + data processing charges. Delete resources when done.

---

**Complete Architecture**:
<img width="1536" height="1024" alt="image" src="https://github.com/user-attachments/assets/7902e623-ded4-4f08-bc39-50765c09599c" />

---

## 1. Set Region

1. Sign in to the AWS Console.
2. Region selector (top-right): choose “US East (N. Virginia)” (us-east-1).
3. Confirm the region indicator shows N. Virginia.

---

## 2. Create the VPC

1. Open the VPC service.
2. Left nav: “Your VPCs” → “Create VPC”.
3. Choose “VPC only”.
4. Name tag: `lab-vpc`
5. IPv4 CIDR block: `10.0.0.0/16`
6. IPv6: No IPv6 CIDR block.
7. Tenancy: Default.
8. Create VPC → View VPC to confirm.

---

## 3. Create Subnets

Path: VPC Console → Subnets → Create subnet (repeat per subnet).

### Public Subnet 1
- VPC: `lab-vpc`
- Subnet name: `Public Subnet 1`
- AZ: `us-east-1a`
- IPv4 Subnet CIDR: `10.0.0.0/24`
- Create
- Select it → Actions → Edit subnet settings → Enable “Auto-assign public IPv4” → Save.

### Private Subnet 1
- VPC: `lab-vpc`
- Name: `Private Subnet 1`
- AZ: `us-east-1a`
- IPv4 Subnet CIDR: `10.0.1.0/24`
- Create (leave auto-assign public IPv4 disabled).

### Public Subnet 2
- VPC: `lab-vpc`
- Name: `Public Subnet 2`
- AZ: `us-east-1b`
- IPv4 Subnet CIDR: `10.0.2.0/24`
- Create
- Enable auto-assign public IPv4 (same steps as first public subnet).

### Private Subnet 2
- VPC: `lab-vpc`
- Name: `Private Subnet 2`
- AZ: `us-east-1b`
- IPv4 Subnet CIDR: `10.0.3.0/24`
- Create (auto-assign public IPv4 stays disabled).

Verification: Public Subnet 1 & 2 show auto-assign public IPv4 enabled; the two private subnets do not.

---

## 4. Internet Gateway

1. Left nav: Internet gateways → Create internet gateway.
2. Name: `lab-igw` → Create.
3. Select `lab-igw` → Actions → Attach to VPC → choose `lab-vpc` → Attach.

---

## 5. Elastic IP (for NAT Gateway)

1. Left nav: Elastic IP addresses → Allocate Elastic IP address.
2. Tag Name:`lab-nat-eip`; OK; → Allocate.

---

## 6. NAT Gateway

1. Left nav: NAT gateways → Create NAT gateway.
2. Subnet: `Public Subnet 1`
3. Connectivity type: Public.
4. Elastic IP: Choose the allocated EIP.
5. Name tag: `lab-nat-gw`
6. Create.
7. Wait until Status = Available before creating private routes.

---

## 7. Public Route Table

1. Route tables → Create a route table.
2. Name: `lab-public-rt` | VPC: `lab-vpc` → Create.
3. Select `lab-public-rt` → Routes tab → Edit routes → Add route:
   - Destination: `0.0.0.0/0`
   - Target: Internet Gateway (`lab-igw`)
   → Save.
4. Subnet associations → Edit → select `Public Subnet 1` and `Public Subnet 2` → Save.

---

## 8. Private Route Table

1. Create a route table.
2. Name: `lab-private-rt` | VPC: `lab-vpc` → Create.
3. Select it → Routes → Edit routes → Add:
   - Destination: `0.0.0.0/0`
   - Target: NAT Gateway (`lab-nat-gw`)
   → Save.
4. Subnet associations → Edit → select `Private Subnet 1` and `Private Subnet 2` → Save.
   
---
Quick Check:
- lab-public-rt has 0.0.0.0/0 → igw-...
- lab-private-rt has 0.0.0.0/0 → nat-...

---
**Complete Resource Map**:
<img width="1121" height="398" alt="Screenshot 2025-08-24 at 9 00 09 AM" src="https://github.com/user-attachments/assets/50a30893-6664-49d7-b6f3-ba35a31f93d7" />

---

## 9. Security Group

1. Security groups → Create a security group.
2. Name: `Web Security Group`
3. Description: `Allow HTTP from anywhere`
4. VPC: `lab-vpc`
5. Inbound rule:
   - Type: HTTP
   - Source: 0.0.0.0/0
6. Outbound: leave default (All traffic).
7. Create.

---

## 10. Key Pair

1. EC2 → Key pairs → Create key pair.
2. Name: `MyLoginKey`
3. Type: RSA; Format: `.pem` (unless you need `.ppk` for PuTTY).
4. Create & store securely.

---

## 11. Launch EC2 Instance (Web Server 1 – RHEL)

Note: If a “RHEL 10” AMI isn’t available, pick the latest RHEL 9 image. This script is compatible with both.

1. EC2 → Instances → Launch instances.
2. Name: `MyApp`
3. Application and OS Image: Search “Red Hat Enterprise Linux” → select the latest official RHEL (HVM, x86_64).
4. Instance type: `t2.micro`.
5. Key pair: `MyLoginKey`.
6. Network settings (Edit):
   - VPC: `lab-vpc`
   - Subnet: `Public Subnet 2 (us-east-1b)`
   - Auto-assign public IP: Enable
   - Firewall: Select existing security group → `Web Security Group`
7. Storage: Leave default (8–10 GiB gp3).
8. Advanced details → User data → paste the script below.
9. Launch instance → open Instance ID when the success banner appears.

### User Data Script (RHEL + Fixed Metadata Retrieval)

This script:
- Installs dependencies
- Opens HTTP in firewalld
- Enables SELinux boolean for Apache outbound network (needed for live metadata)
- Trims IMDSv2 token
- Creates a PHP page that safely fetches metadata with each request

```bash
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
```

---

## 12. Verify Instance

1. Wait for Instance state: `running` and Status checks: `2/2`.
2. In “Details” pane: note Public IPv4 DNS and Public IPv4 address.

---

## 13. Test Web App

1. Browser → `http://<Public-DNS>` (or `http://<Public-IP>`).
2. You should see:
   - Title: AWS Lab Web App
   - AWS logo
   - Table with: Instance ID, Instance Type, AZ, Private IP, Public Hostname, Public IPv4
   - GitHub Username: `techgeek68`

If any field shows “N/A”, refresh once (the token might have briefly failed).

----
**Output**:
<img width="1085" height="640" alt="Screenshot 2025-08-24 at 11 02 01 AM" src="https://github.com/user-attachments/assets/df53b6f4-9e86-4ed7-bd31-0dda5bbbdcd0" />

---

## 15. Optional Tagging 

Apply tags like `Project=lab` to:
- VPC
- Subnets
- Route tables
- Internet Gateway
- NAT Gateway
- Security Group
- Elastic IP
- EC2 Instance

*Improves cost visibility.*

---

## 16. Cleanup (Teardown Order)

1. Terminate the EC2 instance.
2. Delete NAT Gateway (wait until deleted).
3. Release Elastic IP.
4. Detach then delete Internet Gateway (`lab-igw`).
5. Delete subnets (must be empty).
6. Delete route tables (`lab-public-rt`, `lab-private-rt`) (not the main).
7. Delete security group (if no dependencies).
8. Delete VPC `lab-vpc`.
9. Delete key pair if no longer needed.

---

## Troubleshooting

| Symptom | Likely Cause | Fix |
|---------|--------------|-----|
| Browser timeout | Wrong route or missing public IP | Confirm subnet association to public route table + instance has public IP |
| Blank metadata fields | SELinux blocking or token not trimmed | Ensure `setsebool -P httpd_can_network_connect on`; code uses `trim()`; restart httpd |
| HTTP 403 / test page only | PHP page not in correct name | Ensure `/var/www/html/index.php` exists and permissions 644 |
| PHP code displayed raw | PHP not installed / module mismatch | Reinstall: `sudo dnf install -y php php-mysqlnd` & restart httpd |
| Connection refused | httpd not running | `sudo systemctl status httpd` → start/restart |
| Port 80 blocked internally | firewalld not updated | Run: `sudo firewall-cmd --permanent --add-service=http && sudo firewall-cmd --reload` |

Logs & Diagnostics:
- User data output: `/var/log/cloud-init-output.log`
- Custom flag: `/var/log/user-data-status.txt`
- Apache error log: `/var/log/httpd/error_log`
- SELinux denials: `sudo ausearch -m AVC -ts recent` (if auditd installed)

---

## Security Notes

- Allowing Apache outbound (SELinux boolean) is required only because the page fetches live metadata. A static snapshot variant could omit that and avoid enabling the outbound network.
- Security Group currently allows HTTP from everywhere—tighten for production (e.g., your IP only) and enable HTTPS (ALB or Let’s Encrypt) if exposing publicly.

---

**Deleting a VPC (Virtual Private Cloud):**


### **Step 1: Prepare for Deletion**
- **Backup any necessary data** or configurations.
- **Verify dependencies:** Ensure no production workloads depend on this VPC. Identify connected resources (EC2, RDS, ELB, etc.).

---

### **Step 2: Delete VPC Dependencies**
Before you can delete the VPC, you must remove all its dependent resources:

1. **Terminate EC2 Instances:**  
   - Go to EC2 Dashboard → Instances.
   - Select and terminate all instances in the VPC.

2. **Delete Security Groups (except default):**  
   - Go to VPC → Security Groups.
   - Delete custom security groups.

3. **Delete Subnets:**  
   - Go to VPC → Subnets.
   - Delete all subnets in the VPC.

4. **Release Elastic IPs:**  
   - Go to EC2 → Elastic IPs.
   - Release any allocated Elastic IPs associated with the VPC.

5. **Delete Internet Gateway:**  
   - Go to VPC → Internet Gateways.
   - Detach and then delete the Internet Gateway.

6. **Delete NAT Gateways:**  
   - Go to VPC → NAT Gateways.
   - Delete any NAT Gateway in the VPC.

7. **Delete Route Tables (except main):**  
   - Go to VPC → Route Tables.
   - Delete custom route tables.

8. **Delete Network ACLs (except default):**  
   - Go to VPC → Network ACLs.
   - Delete custom ACLs.

9. **Delete Endpoints, Peering Connections, VPN Gateways:**  
   - Go to VPC → Endpoints, Peering Connections, VPN Gateways.
   - Delete these resources if present.

10. **Delete RDS Instances, ELB, Redshift, etc.:**  
    - Go to the respective services and delete resources associated with the VPC.

---

### **Step 3: Delete the VPC**
- Go to **VPC Dashboard** → **Your VPCs**.
- Select the VPC you wish to delete.
- Click **Actions** → **Delete VPC**.
- Confirm the deletion.

---

### **Step 4: Verify Deletion**
- Ensure the VPC no longer appears in the VPC Dashboard.
- Confirm that all associated resources have been deleted.

---

## **Notes**
- **AWS CLI:** You can also perform these steps using the AWS CLI by listing and deleting resources (`aws ec2 terminate-instances`, `aws ec2 delete-subnet`, etc.), then `aws ec2 delete-vpc`.
- **IAM Permissions:** Ensure you have adequate permissions to delete resources.
- **Irrecoverable:** VPC deletion is permanent. There’s no way to restore a deleted VPC.
---

