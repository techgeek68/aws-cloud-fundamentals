#!/bin/bash
# Student: <Full_Name>
# Lab 3 EC2

# Install Apache web server
sudo dnf install -y httpd                         # Use sudo to ensure sufficient privileges

# Enable and start the Apache service
sudo systemctl enable httpd                       # Enable Apache to start on boot
sudo systemctl start httpd                        # Start the Apache web server

# Create a simple index page
echo '<h1>Hello from my web server, hosted on the AWS cloud!</h1>' | sudo tee /var/www/html/index.html > /dev/null
