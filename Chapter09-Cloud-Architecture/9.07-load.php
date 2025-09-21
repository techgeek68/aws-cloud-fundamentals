<?php
// Simulate CPU load for N seconds (default 4s). Adjust via ?s=5 to increase load.
$loadSeconds = isset($_GET['s']) ? max(1, min(10, intval($_GET['s']))) : 4;
$start = microtime(true);
while ((microtime(true) - $start) < $loadSeconds) {
    // Tight loop to create CPU pressure
    sqrt(mt_rand());
}

// Helper to fetch IMDSv2 metadata; returns null on failure
function imdsv2_get($path) {
    $tokenCh = curl_init('http://169.254.169.254/latest/api/token');
    curl_setopt_array($tokenCh, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => 'PUT',
        CURLOPT_HTTPHEADER     => ['X-aws-ec2-metadata-token-ttl-seconds: 21600'],
        CURLOPT_CONNECTTIMEOUT => 1,
        CURLOPT_TIMEOUT        => 2
    ]);
    $token = curl_exec($tokenCh);
    curl_close($tokenCh);
    if (!$token) return null;

    $ch = curl_init("http://169.254.169.254/latest/meta-data/$path");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => ["X-aws-ec2-metadata-token: $token"],
        CURLOPT_CONNECTTIMEOUT => 1,
        CURLOPT_TIMEOUT        => 2
    ]);
    $resp = curl_exec($ch);
    curl_close($ch);
    return $resp ?: null;
}

$instanceId = imdsv2_get('instance-id');
$az         = imdsv2_get('placement/availability-zone');
$serverIp   = $_SERVER['SERVER_ADDR'] ?? 'Unknown';
$nowUtc     = gmdate('Y-m-d H:i:s') . ' UTC';

// Read auto-refresh preference from query (default: on)
$auto = isset($_GET['auto']) ? ($_GET['auto'] === '0' ? 0 : 1) : 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cloud Foundations Lab — Load Test</title>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="/css/styles.css" rel="stylesheet" />
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Ccircle cx='32' cy='32' r='28' fill='%235f85ff'/%3E%3Cpath d='M18 34h28M24 26h16' stroke='[...]"/>
</head>
<body>
  <div class="page">
    <header class="header">
      <div class="brand">
        <div class="logo">CF</div>
        <div class="titles">
          <h1>Cloud Foundations Lab</h1>
          <p class="subtitle">Scalable Load-Balanced Architecture</p>
        </div>
      </div>

      <div class="pill <?php echo $auto ? 'ok' : 'muted'; ?>">
        <span class="dot"></span>
        <span><?php echo $auto ? 'Auto refresh: On' : 'Auto refresh: Off'; ?></span>
      </div>
    </header>

    <main class="container">
      <section class="hero card">
        <div class="hero-text">
          <h2>Simulated CPU Load</h2>
          <p class="lead">
            This instance is intentionally running under CPU load to exercise your Auto Scaling policy and ALB health checks.
          </p>
        </div>
        <div class="stats">
          <div class="stat">
            <span class="label">Instance ID</span>
            <span class="value"><?php echo htmlspecialchars($instanceId ?? 'Unknown'); ?></span>
          </div>
          <div class="stat">
            <span class="label">Availability Zone</span>
            <span class="value"><?php echo htmlspecialchars($az ?? 'Unknown'); ?></span>
          </div>
          <div class="stat">
            <span class="label">Server IP</span>
            <span class="value"><?php echo htmlspecialchars($serverIp); ?></span>
          </div>
          <div class="stat">
            <span class="label">Now (UTC)</span>
            <span class="value"><?php echo htmlspecialchars($nowUtc); ?></span>
          </div>
        </div>
      </section>

      <section class="controls card">
        <div class="control-row">
          <div class="control">
            <label for="seconds">Load duration</label>
            <div class="range-wrap">
              <input id="seconds" type="range" min="1" max="10" step="1" value="<?php echo (int)$loadSeconds; ?>">
              <div class="range-value"><span id="secVal"><?php echo (int)$loadSeconds; ?></span>s</div>
            </div>
            <p class="hint">Adjust how long each request burns CPU. 1–10 seconds.</p>
          </div>

          <div class="control">
            <label>Auto refresh</label>
            <div class="switch">
              <input id="autorefresh" type="checkbox" <?php echo $auto ? 'checked' : ''; ?>>
              <span class="slider"></span>
            </div>
            <p class="hint">Refresh every 5 seconds to create continuous load.</p>
          </div>

          <div class="actions">
            <button id="apply" class="btn primary">Apply</button>
            <a class="btn ghost" href="/health.php" target="_blank" rel="noopener">Health check</a>
          </div>
        </div>
      </section>

      <section class="status card">
        <div class="status-row">
          <div class="status-icon pulse"></div>
          <div class="status-text">
            <h3>Under High CPU Load</h3>
            <p>This request burned <strong><?php echo (int)$loadSeconds; ?>s</strong> of CPU time. Page <?php echo $auto ? 'auto-refreshes every 5s' : 'does not auto-refresh'; ?>.</p>
          </div>
        </div>
      </section>
    </main>

    <footer class="footer">
      <p>Application Load Balancer distributes requests across instances. Auto Scaling adjusts capacity when CPU > target.</p>
    </footer>
  </div>

  <script>
    (function () {
      const qs = new URLSearchParams(window.location.search);
      const range = document.getElementById('seconds');
      const secVal = document.getElementById('secVal');
      const auto = document.getElementById('autorefresh');
      const apply = document.getElementById('apply');

      // Update label when slider moves
      range.addEventListener('input', () => {
        secVal.textContent = range.value;
      });

      // Persist current settings to the URL and reload
      function applySettings() {
        const s = Math.max(1, Math.min(10, parseInt(range.value, 10) || 4));
        qs.set('s', String(s));
        qs.set('auto', auto.checked ? '1' : '0');
        window.location.search = qs.toString();
      }
      apply.addEventListener('click', applySettings);

      // Simple auto-refresh loop (default on)
      let timer = null;
      function setAutoRefresh(enabled) {
        if (timer) { clearInterval(timer); timer = null; }
        if (enabled) { timer = setInterval(() => window.location.reload(), 5000); }
      }
      setAutoRefresh(<?php echo $auto ? 'true' : 'false'; ?>);

      // Toggle auto-refresh without immediate reload; reflect in URL on next Apply
      auto.addEventListener('change', () => setAutoRefresh(auto.checked));
    })();
  </script>
</body>
</html>
