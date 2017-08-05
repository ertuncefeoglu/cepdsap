<?php

class TestModel extends BaseModel {
	
	public function getUsers() {

		$sql = 'select * from saptmq.zdsap_auth_users';
		$rs = $this->db->Execute($sql);

		return $rs;
	}


	public function getParam() {

		$sql = 'select * from saptmq.zdsap_param_tip';
		$rs = $this->db->Execute($sql);

		return $rs;
	}

	public function getParamByTip($param) {
		
		$sql = 'select * from saptmq.zdsap_param_tip where param_tip_kodu ='.$this->db->param("PARAM_TIP_KODU");
		$rs = $this->db->GetAll($sql,$param);

		return $rs;
	}

	
}

?>