<?php

class DeliveryModel extends Model
{
    /* =========================
    READY ORDERS
    ========================= */

    public function getReadyOrders()
    {
        return mysqli_query(

            $this->db->conn,

            "SELECT 
            orders.*,

            u.name AS customer_name,

            delivery_zones.zone_name

            FROM orders

            JOIN users u
            ON orders.customer_id = u.id

            JOIN delivery_zones
            ON orders.delivery_zone_id =
            delivery_zones.id

            LEFT JOIN deliveries d
            ON d.order_id = orders.id

            WHERE orders.status
            IN ('confirmed','shipped')

            AND d.id IS NULL

            ORDER BY orders.created_at DESC"
        );
    }

    /* =========================
    ACTIVE AGENTS
    ========================= */

    public function getActiveAgents()
    {
        return mysqli_query(

            $this->db->conn,

            "SELECT
            delivery_agents.*,
            users.name

            FROM delivery_agents

            JOIN users
            ON delivery_agents.user_id =
            users.id

            WHERE delivery_agents.is_active = 1"
        );
    }

    /* =========================
    ASSIGN ORDER
    ========================= */

    public function assignOrder(
        $order_id,
        $agent_id
    )
    {
        mysqli_query(

            $this->db->conn,

            "UPDATE orders

            SET assigned_agent_id='$agent_id'

            WHERE id='$order_id'"
        );

        mysqli_query(

            $this->db->conn,

            "INSERT INTO deliveries(

                order_id,
                agent_id,
                delivery_status,
                created_at,
                updated_at

            )

            VALUES(

                '$order_id',
                '$agent_id',
                'assigned',
                NOW(),
                NOW()
            )"
        );

        $delivery_id =
            mysqli_insert_id(
                $this->db->conn
            );

        $agent_query =
            mysqli_query(

                $this->db->conn,

                "SELECT user_id

                FROM delivery_agents

                WHERE id='$agent_id'"
            );

        $agent_row =
            mysqli_fetch_assoc(
                $agent_query
            );

        $agent_user_id =
            $agent_row['user_id'];

        mysqli_query(

            $this->db->conn,

            "INSERT INTO notifications(

                user_id,
                title,
                message,
                order_id,
                delivery_id,
                is_read,
                created_at

            )

            VALUES(

                '$agent_user_id',

                'New Delivery Assigned',

                'A new order has been assigned.',

                '$order_id',

                '$delivery_id',

                0,

                NOW()
            )"
        );

        mysqli_query(

            $this->db->conn,

            "INSERT INTO delivery_status_logs(

                delivery_id,
                status,
                changed_at

            )

            VALUES(

                '$delivery_id',
                'assigned',
                NOW()
            )"
        );
    }

    /* =========================
    ACTIVE DELIVERIES
    ========================= */

    public function getActiveDeliveries()
    {
        return mysqli_query(

            $this->db->conn,

            "SELECT

            d.*,

            o.id AS order_id,

            u1.name AS customer_name,

            z.zone_name,

            u2.name AS agent_name,

            da.phone,

            da.vehicle_type,

            TIMESTAMPDIFF(
                HOUR,
                d.created_at,
                NOW()
            ) AS assigned_hours

            FROM deliveries d

            JOIN orders o
            ON d.order_id = o.id

            JOIN users u1
            ON o.customer_id = u1.id

            JOIN delivery_agents da
            ON d.agent_id = da.id

            JOIN users u2
            ON da.user_id = u2.id

            JOIN delivery_zones z
            ON o.delivery_zone_id = z.id

            WHERE d.delivery_status!='Delivered'

            AND d.delivery_status!='Failed'

            ORDER BY d.created_at DESC"
        );
    }

    /* =========================
    UPDATE DELIVERY STATUS
    ========================= */

    public function updateDeliveryStatus(
        $id,
        $status
    )
    {
        mysqli_query(

            $this->db->conn,

            "UPDATE deliveries

            SET delivery_status='$status',

            updated_at=NOW()

            WHERE id='$id'"
        );

        mysqli_query(

            $this->db->conn,

            "INSERT INTO delivery_status_logs(

                delivery_id,
                status,
                changed_at

            )

            VALUES(

                '$id',
                '$status',
                NOW()
            )"
        );
    }

    /* =========================
    FAILED DELIVERY
    ========================= */

    public function failedDelivery(
        $id,
        $reason
    )
    {
        mysqli_query(

            $this->db->conn,

            "UPDATE deliveries

            SET delivery_status='Failed',

            failed_reason='$reason',

            updated_at=NOW()

            WHERE id='$id'"
        );

        mysqli_query(

            $this->db->conn,

            "INSERT INTO delivery_status_logs(

                delivery_id,
                status,
                changed_at

            )

            VALUES(

                '$id',
                'Failed',
                NOW()
            )"
        );
    }

    /* =========================
    DELIVERY HISTORY
    ========================= */

    public function getDeliveryHistory()
    {
        return mysqli_query(

            $this->db->conn,

            "SELECT

            d.*,

            o.id AS order_id,

            u1.name AS customer_name,

            u2.name AS agent_name,

            z.zone_name

            FROM deliveries d

            JOIN orders o
            ON d.order_id = o.id

            JOIN users u1
            ON o.customer_id = u1.id

            JOIN delivery_agents da
            ON d.agent_id = da.id

            JOIN users u2
            ON da.user_id = u2.id

            JOIN delivery_zones z
            ON o.delivery_zone_id = z.id

            ORDER BY d.updated_at DESC"
        );
    }

    /* =========================
    GET DELIVERY BY ID
    ========================= */

    public function getDeliveryById($id)
    {
        $query = mysqli_query(

            $this->db->conn,

            "SELECT *

            FROM deliveries

            WHERE id='$id'"
        );

        return mysqli_fetch_assoc($query);
    }

    /* =========================
    REASSIGN AGENTS
    ========================= */

    public function getReassignAgents(
        $current_agent
    )
    {
        return mysqli_query(

            $this->db->conn,

            "SELECT

            delivery_agents.*,

            users.name

            FROM delivery_agents

            JOIN users
            ON delivery_agents.user_id =
            users.id

            WHERE delivery_agents.is_active=1

            AND delivery_agents.id!='$current_agent'"
        );
    }

    /* =========================
    REASSIGN DELIVERY
    ========================= */

    public function reassignDelivery(
        $id,
        $new_agent
    )
    {
        mysqli_query(

            $this->db->conn,

            "UPDATE deliveries

            SET

            agent_id='$new_agent',

            delivery_status='assigned',

            failed_reason=NULL,

            updated_at=NOW()

            WHERE id='$id'"
        );

        mysqli_query(

            $this->db->conn,

            "INSERT INTO delivery_status_logs(

                delivery_id,
                status,
                changed_at

            )

            VALUES(

                '$id',
                'Reassigned',
                NOW()
            )"
        );
    }

    /* =========================
    DELIVERY SUMMARY
    ========================= */

    public function getSummary()
    {
        $data = [];

        $data['delivered'] =
        mysqli_num_rows(
            mysqli_query(
                $this->db->conn,

                "SELECT *

                FROM deliveries

                WHERE delivery_status='Delivered'"
            )
        );

        $data['failed'] =
        mysqli_num_rows(
            mysqli_query(
                $this->db->conn,

                "SELECT *

                FROM deliveries

                WHERE delivery_status='Failed'"
            )
        );

        $data['transit'] =
        mysqli_num_rows(
            mysqli_query(
                $this->db->conn,

                "SELECT *

                FROM deliveries

                WHERE delivery_status='In Transit'"
            )
        );

        $data['daily_delivered'] =
        mysqli_num_rows(
            mysqli_query(
                $this->db->conn,

                "SELECT *

                FROM deliveries

                WHERE delivery_status='Delivered'

                AND DATE(updated_at)=CURDATE()"
            )
        );

        $data['daily_failed'] =
        mysqli_num_rows(
            mysqli_query(
                $this->db->conn,

                "SELECT *

                FROM deliveries

                WHERE delivery_status='Failed'

                AND DATE(updated_at)=CURDATE()"
            )
        );

        $data['weekly_delivered'] =
        mysqli_num_rows(
            mysqli_query(
                $this->db->conn,

                "SELECT *

                FROM deliveries

                WHERE delivery_status='Delivered'

                AND updated_at >=
                DATE_SUB(
                    NOW(),
                    INTERVAL 7 DAY
                )"
            )
        );

        $data['weekly_failed'] =
        mysqli_num_rows(
            mysqli_query(
                $this->db->conn,

                "SELECT *

                FROM deliveries

                WHERE delivery_status='Failed'

                AND updated_at >=
                DATE_SUB(
                    NOW(),
                    INTERVAL 7 DAY
                )"
            )
        );

        return $data;
    }
}

?>