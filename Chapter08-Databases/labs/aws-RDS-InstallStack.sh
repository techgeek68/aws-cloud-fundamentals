sudo dnf update -y
sudo dnf install -y httpd php php-mysqlnd
sudo systemctl enable httpd && sudo systemctl start httpd
