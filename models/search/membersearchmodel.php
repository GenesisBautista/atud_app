<?php

class MemberSearchModel extends Model{
    function __construct($arr){
        $this->db = new Database();
    }

    public function GetSearchResults($page, $sort, $sorttype, $activeonly, $company, $name){
        $link = $this->db->OpenConnection();
        $return = $this->db->Query($this->SQLGenerator(
            $activeonly,
            $company,
            $name,
            $page,
            50,
            $sort,
            $sorttype
        ));
        $this->db->CloseConnection($link);
        return $return;
    }

    public function GetTotalResults($includeinactive, $company, $name){
        $link = $this->db->OpenConnection();
        $qry = "SELECT COUNT(*) as count
                FROM  `atud_members`
                INNER JOIN  `atud_companies` ON  `atud_companies`.id =  `atud_members`.company_fk
                WHERE (atud_members.active = ".($includeinactive == 0 ? "1" : "1 OR atud_members.active = 0 ").")";
        if( !empty($company) ){
            $qry .= " AND atud_members.company_fk = ".$company;
        }
        if( $name!='empty' ){
            $qry .= " AND CONCAT(atud_members.firstname, ' ', atud_members.lastname) LIKE '%".mysql_real_escape_string($name)."%'";
        }
        $return = $this->db->Query($qry);
        $this->db->CloseConnection($link);
        return $return[0]['count'];
    }

    private function SQLGenerator($includeinactive, $company, $name, $page, $rows, $sort, $sorttype){
        $start = ($page - 1) * $rows;
        $qry = "SELECT
                    atud_members.id,
                    atud_companies.name AS company,
                    CONCAT_WS(' ', firstname, lastname) as name,
                    title,
                    company_id,
                    atud_members.active as status
                FROM
                    atud_members
                INNER JOIN
                    atud_companies ON atud_companies.id = atud_members.company_fk
                WHERE
                    (atud_members.active = ".($includeinactive == 0 ? "1" : "1 OR atud_members.active = 0 ").")";
        if( $company ){
            $qry .= " AND atud_members.company_fk = ".$company;
        }
        if( $name!='empty' ){
            $qry .= " HAVING name LIKE '%".mysql_real_escape_string($name)."%'";
        }
        $qry .= " ORDER BY ".$sort." ".$sorttype;
        if( !empty($page) ){
            $qry .= " LIMIT ".$start.", ".$rows;
        }
        return $qry;
    }
}
