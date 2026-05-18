<?php

class ReportModel extends Model
{
    /* =========================
    AGENT REPORT
    ========================= */

    public function getAgentReport()
    {
        return mysqli_query(

            $this->db->conn,

            "SELECT

            u.name,

            COUNT(d.id)
            AS total_deliveries,

            SUM(

            CASE

            WHEN d.delivery_status='Delivered'

            THEN 1

            ELSE 0

            END

            ) AS completed_deliveries,

            SUM(

            CASE

            WHEN d.delivery_status='Failed'

            THEN 1

            ELSE 0

            END

            ) AS failed_deliveries,

            SUM(

            CASE

            WHEN d.delivery_status='In Transit'

            OR d.delivery_status='Picked Up'

            OR d.delivery_status='assigned'

            THEN 1

            ELSE 0

            END

            ) AS active_deliveries,

            AVG(

            TIMESTAMPDIFF(
                HOUR,
                d.created_at,
                d.updated_at
            )

            ) AS avg_delivery_time

            FROM deliveries d

            JOIN delivery_agents da
            ON d.agent_id = da.id

            JOIN users u
            ON da.user_id = u.id

            GROUP BY d.agent_id"
        );
    }

    /* =========================
    ZONE REPORT
    ========================= */

    public function getZoneReport()
    {
        return mysqli_query(

            $this->db->conn,

            "SELECT

            z.zone_name,

            z.delivery_fee,

            z.estimated_days,

            COUNT(d.id)
            AS total_deliveries,

            SUM(

            CASE

            WHEN d.delivery_status='Delivered'

            THEN 1

            ELSE 0

            END

            ) AS successful_deliveries,

            SUM(

            CASE

            WHEN d.delivery_status='Failed'

            THEN 1

            ELSE 0

            END

            ) AS failed_deliveries,

            AVG(

            TIMESTAMPDIFF(
                HOUR,
                d.created_at,
                d.updated_at
            )

            ) AS avg_delivery_time

            FROM deliveries d

            JOIN orders o
            ON d.order_id = o.id

            JOIN delivery_zones z
            ON o.delivery_zone_id = z.id

            GROUP BY z.id"
        );
    }
}

?>