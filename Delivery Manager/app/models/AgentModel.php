<?php

class AgentModel extends Model
{
    public function getAllAgents($filter = 'all')
    {
        $query = "

        SELECT 
        delivery_agents.*,
        users.name,

        (
        SELECT COUNT(*) 
        FROM (
            SELECT l1.delivery_id, l1.status
            FROM delivery_status_logs l1
            WHERE l1.changed_at = (
                SELECT MAX(l2.changed_at)
                FROM delivery_status_logs l2
                WHERE l2.delivery_id = l1.delivery_id
            )
        ) latest
        JOIN deliveries d
        ON d.id = latest.delivery_id

        WHERE d.agent_id = delivery_agents.id
        AND latest.status IN (
            'assigned',
            'picked',
            'on_the_way'
        )

        ) AS active_deliveries,

        (
        SELECT GROUP_CONCAT(DISTINCT latest.status)

        FROM (
            SELECT l1.delivery_id, l1.status

            FROM delivery_status_logs l1

            WHERE l1.changed_at = (
                SELECT MAX(l2.changed_at)
                FROM delivery_status_logs l2
                WHERE l2.delivery_id = l1.delivery_id
            )

        ) latest

        JOIN deliveries d
        ON d.id = latest.delivery_id

        WHERE d.agent_id = delivery_agents.id

        AND latest.status IN (
            'assigned',
            'picked',
            'on_the_way'
        )

        ) AS working_status

        FROM delivery_agents

        JOIN users
        ON delivery_agents.user_id = users.id
        ";

        if($filter == "active")
        {
            $query .= "
            WHERE delivery_agents.is_active = 1
            ";
        }

        elseif($filter == "inactive")
        {
            $query .= "
            WHERE delivery_agents.is_active = 0
            ";
        }

        return mysqli_query(
            $this->db->conn,
            $query
        );
    }

    public function addAgent(
        $name,
        $email,
        $phone,
        $vehicle,
        $password
    )
    {
        $checkEmail = mysqli_query(
            $this->db->conn,

            "SELECT id
            FROM users
            WHERE email='$email'"
        );

        if(mysqli_num_rows($checkEmail) > 0)
        {
            return "Email already exists";
        }

        $insertUser = "

        INSERT INTO users(
            name,
            email,
            password_hash,
            role
        )

        VALUES(
            '$name',
            '$email',
            '$password',
            'delivery_agent'
        )
        ";

        if(mysqli_query(
            $this->db->conn,
            $insertUser
        ))
        {
            $user_id =
                mysqli_insert_id($this->db->conn);

            mysqli_query(
                $this->db->conn,

                "INSERT INTO delivery_agents(
                    user_id,
                    vehicle_type,
                    phone
                )

                VALUES(
                    '$user_id',
                    '$vehicle',
                    '$phone'
                )"
            );

            return true;
        }

        return "Something went wrong";
    }

    public function getAgentById($id)
    {
        $query = "

        SELECT delivery_agents.*,
        users.name,
        users.email

        FROM delivery_agents

        JOIN users
        ON delivery_agents.user_id = users.id

        WHERE delivery_agents.id='$id'
        ";

        $result = mysqli_query(
            $this->db->conn,
            $query
        );

        return mysqli_fetch_assoc($result);
    }

    public function updateAgent(
        $id,
        $userId,
        $name,
        $email,
        $phone,
        $vehicle
    )
    {
        mysqli_query(
            $this->db->conn,

            "UPDATE users
            SET name='$name',
            email='$email'
            WHERE id='$userId'"
        );

        mysqli_query(
            $this->db->conn,

            "UPDATE delivery_agents
            SET phone='$phone',
            vehicle_type='$vehicle'
            WHERE id='$id'"
        );
    }

    public function deleteAgent($id)
    {
        $get = mysqli_query(
            $this->db->conn,

            "SELECT *
            FROM delivery_agents
            WHERE id='$id'"
        );

        $row = mysqli_fetch_assoc($get);

        mysqli_query(
            $this->db->conn,

            "DELETE FROM delivery_agents
            WHERE id='$id'"
        );

        mysqli_query(
            $this->db->conn,

            "DELETE FROM users
            WHERE id='".$row['user_id']."'"
        );
    }

    public function toggleAgent(
        $id,
        $status
    )
    {
        mysqli_query(
            $this->db->conn,

            "UPDATE delivery_agents
            SET is_active='$status'
            WHERE id='$id'"
        );
    }
}

?>