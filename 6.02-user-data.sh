#!/bin/bash
# Student: <your_GitHub_username>
# Lab 3 EC2 User Data – minimal plus personal comments (keeps grading compatibility)
  dnf install -y httpd
  systemctl enable httpd
  systemctl start httpd
# Preserve EXACT required line for grader below:
  echo '<html><h1>  Hello from <student_name>'s server. Today it’s a simple page; tomorrow I’ll architect cloud-native solutions.</h1></html>' > /var/www/html/index.html
