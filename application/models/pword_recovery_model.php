<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Pword_recovery_model
 *
 * table: password_recovery_status.
 *
 */

Class Pword_recovery_model extends CI_Model
{
    const TABLE = "password_recovery_status";

    /**
     * Insert item to
     *
     * @param $data
     * @return mixed
     */
    public function insertStatus($data)
    {
        if($data){
            $this->db->insert(self::TABLE, $data);
        }
    }

    /**
     * Select a recovery status based on uid
     *
     * @param $uid
     * @return null
     */
    public function selectRecoveryStatus($uid)
    {
        $this->db->where('user_id', $uid);
        $query = $this->db->get(self::TABLE);
        return $query->row();
    }

    public function updateStatus($uid, $data)
    {
        if($uid){
            $this->db->where('user_id', $uid);
            $this->db->update(self::TABLE, $data);
        }
    }

} // Class pword_recovery_model

/* EOF pword_recovery_model.php */
/* Location ./application/models/pword_recovery_model.php */