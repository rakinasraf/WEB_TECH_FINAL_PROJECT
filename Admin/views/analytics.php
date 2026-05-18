<h2>📈 Extended Platform Performance Charts Matrix</h2>
<p style="margin-bottom:20px; color:#7f8c8d;">.</p>

<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:20px;">
    <div style="background:#fff; padding:25px; border-radius:8px; box-shadow:0 2px 4px rgba(0,0,0,0.05);">
        <h4 style="color:#475569; margin-bottom:15px;">Gross Revenue Allocations</h4>
        <div style="height:15px; width:100%; background:#e2e8f0; border-radius:10px; overflow:hidden;">
            <div style="width:78%; height:100%; background:#3498db;"></div>
        </div>
        <p style="margin-top:10px; font-size:14px; color:#64748b;">৳<?php echo number_format($revenueStats['gv'] ?? 0, 2); ?> total calculated processing value.</p>
    </div>
    
    <div style="background:#fff; padding:25px; border-radius:8px; box-shadow:0 2px 4px rgba(0,0,0,0.05);">
        <h4 style="color:#475569; margin-bottom:15px;">Platform Commission Intake Split</h4>
        <div style="height:15px; width:100%; background:#e2e8f0; border-radius:10px; overflow:hidden;">
            <div style="width:22%; height:100%; background:#2ecc71;"></div>
        </div>
        <p style="margin-top:10px; font-size:14px; color:#64748b;">৳<?php echo number_format($revenueStats['platform_commission'] ?? 0, 2); ?> net administration cut.</p>
    </div>
</div>
