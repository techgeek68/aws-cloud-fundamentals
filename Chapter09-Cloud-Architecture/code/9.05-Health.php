<?php
// Lightweight health endpoint for ALB Target Group
http_response_code(200);
header('Content-Type: text/plain');
echo "OK";
