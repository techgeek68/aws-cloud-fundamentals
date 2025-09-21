#!/bin/bash
sudo dnf update -y
sudo dnf install -y httpd php-cli php-fpm php-mysqlnd php-common php-gd php-xml php-opcache
sudo systemctl enable --now php-fpm httpd
