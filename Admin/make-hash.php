<?php
// Force your local PHP engine to compile the target string natively
echo "<h3>Copy the hash string below:</h3>";
echo "<p style='background:#eee; padding:10px; font-family:monospace; display:inline-block;'>";
echo password_hash('admin123', PASSWORD_BCRYPT);
echo "</p>";