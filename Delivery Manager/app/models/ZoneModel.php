<?php

class ZoneModel extends Model
{
    public function getAllZones()
    {
        return mysqli_query(
            $this->db->conn,

            "SELECT *
            FROM delivery_zones"
        );
    }

    public function addZone(
        $zone,
        $fee,
        $days
    )
    {
        $check = mysqli_query(
            $this->db->conn,

            "SELECT *
            FROM delivery_zones
            WHERE zone_name='$zone'"
        );

        if(mysqli_num_rows($check) > 0)
        {
            return "Zone already exists!";
        }

        elseif($fee < 0)
        {
            return "Fee cannot be negative!";
        }

        elseif($days <= 0)
        {
            return "Days must be greater than 0!";
        }

        else
        {
            mysqli_query(
                $this->db->conn,

                "INSERT INTO delivery_zones(
                    zone_name,
                    delivery_fee,
                    estimated_days
                )

                VALUES(
                    '$zone',
                    '$fee',
                    '$days'
                )"
            );

            return true;
        }
    }

    public function getZoneById($id)
    {
        $result = mysqli_query(
            $this->db->conn,

            "SELECT *
            FROM delivery_zones
            WHERE id='$id'"
        );

        return mysqli_fetch_assoc($result);
    }

    public function updateZone(
        $id,
        $zone,
        $fee,
        $days
    )
    {
        mysqli_query(
            $this->db->conn,

            "UPDATE delivery_zones

            SET
            zone_name='$zone',
            delivery_fee='$fee',
            estimated_days='$days'

            WHERE id='$id'"
        );
    }

    public function deleteZone($id)
    {
        mysqli_query(
            $this->db->conn,

            "DELETE FROM delivery_zones
            WHERE id='$id'"
        );
    }
}

?>