<?php

class GruppaMap extends BaseMap
{
    public function arrGruppas()
    {
        $res = $this->db->query("SELECT gruppa.gruppa_id AS id, gruppa.name AS value, branch.id AS branch FROM gruppa
        INNER JOIN branch ON branch.id = gruppa.branch
        WHERE branch.id = {$_SESSION['branch']} and gruppa.deleted = 0
        ");
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT gruppa_id, name,  date_begin, date_end, branch FROM gruppa WHERE gruppa_id = $id and branch = {$_SESSION['branch']}");
            return $res->fetchObject("Gruppa");
        }
        return new Gruppa();
    }

    public function save($gruppa = Gruppa)
    {
        if ($gruppa->validate()) {
            if ($gruppa->gruppa_id == 0) {
                return $this->insert($gruppa);
            } else {
                return $this->update($gruppa);
            }
        }
        return false;
    }

    private function insert($gruppa = Gruppa)
    {
        $name = $this->db->quote($gruppa->name);
        $date_begin = $this->db->quote($gruppa->date_begin);
        $date_end = $this->db->quote($gruppa->date_end);
        if (
            $this->db->exec("INSERT INTO gruppa(name,
        date_begin, date_end, branch)"
                . " VALUES($name,  $date_begin, $date_end, {$_SESSION['branch']})") == 1
        ) {
            $gruppa->gruppa_id = $this->db->lastInsertId();
            return true;
        }
        return false;
    }

    private function update($gruppa = Gruppa)
    {
        $name = $this->db->quote($gruppa->name);
        $date_begin = $this->db->quote($gruppa->date_begin);
        $date_end = $this->db->quote($gruppa->date_end);
        if (
            $this->db->exec("UPDATE gruppa SET name = $name,
       "
                . " date_begin = $date_begin, date_end = $date_end WHERE gruppa_id = " . $gruppa->gruppa_id) == 1
        ) {
            return true;
        }
        return false;
    }

    public function findAll($ofset = 0, $limit = 30)
    {

        $res = $this->db->query("SELECT gruppa.gruppa_id, gruppa.name, 
            gruppa.date_begin, gruppa.date_end, branch.id, branch.branch FROM gruppa 
            
            INNER JOIN branch ON gruppa.branch=branch.id 
            WHERE gruppa.deleted = 0 and gruppa.branch = {$_SESSION['branch']}
            LIMIT $ofset, $limit");
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function count()
    {
        $res = $this->db->query("SELECT COUNT(*) AS cnt FROM gruppa WHERE gruppa.deleted = 0 AND gruppa.branch = {$_SESSION['branch']}");
        return $res->fetch(PDO::FETCH_OBJ)->cnt;
    }

    public function findViewById($id = null)
    {
        if ($id) {
            $res = $this->db->query("SELECT gruppa.gruppa_id, gruppa.name,  gruppa.date_begin, gruppa.date_end, branch.branch FROM gruppa 
            
            INNER JOIN branch ON branch.id=gruppa.branch WHERE gruppa_id = $id");
            return $res->fetch(PDO::FETCH_OBJ);
        }
        return false;
    }

    public function deleteGruppaById($id)
    {
        $query = "UPDATE gruppa SET deleted = 1 WHERE gruppa_id = :id";
        $res = $this->db->prepare($query);
        if (
            $res->execute([
                'id' => $id
            ])
        ) {
            return true;
        }
        return false;
    }
}