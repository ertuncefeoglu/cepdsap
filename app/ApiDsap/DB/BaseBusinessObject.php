<?php namespace ApiDsap\DB;

 class BaseBusinessObject{
 	protected $db;

	public function __construct(){

		$this->db= new ADOModule();
	}

	protected function bulkInsert($tablename,$params) {
		throw new AppException("900", "Bu fonksiyon kullanım dışıdır!");
		if (count($params)>0) {
			foreach($params as $row){
				foreach($row as $key=>$value){
					$Fields[]=$key;
					$Params[]=$this->db->Param($key);
				}
				break;
			}
			$sql="insert into ".$tablename." (".implode(",",$Fields).") values(".implode(",",$Params).")";

			$this->db->StartTrans();
			try {
				$this->executePrepared($sql,$params);
				$this->db->CompleteTrans();
			} catch (Exception $e) {
				$this->db->CompleteTrans(false);
				throw $e;
			}
		}
	}

	protected function bulkUpdate($tablename,$whereFields,$params) {
		throw new AppException("900", "Bu fonksiyon kullanım dışıdır!");
		if (count($params)>0) {
			if (!is_array($whereFields)){
				$whereFields=array($whereFields);
			}

			foreach($params as $row){
				foreach($row as $key=>$value){
					if (!in_array($key,$whereFields)) {
						$Fields[]="$key = ".$this->db->Param($key);
					} else {
						$Where[]="$key = ".$this->db->Param($key);
					}
				}
				break;
			}
			$sql="update ".$tablename." SET ".implode(" , ",$Fields)." WHERE ".implode(" AND ",$Where);

			$this->db->StartTrans();
			try {
			$this->executePrepared($sql,$params);
				$this->db->CompleteTrans();
			} catch (Exception $e) {
				$this->db->CompleteTrans(false);
				throw $e;
			}
		}
	}

	public function setBind($array=null,$bindPrefix='BP'){
		throw new AppException("900", "Bu fonksiyon kullanım dışıdır!");
		$params=array();
		$values=array();
		$paramID="{$bindPrefix}0";

		if(!is_array($array)) {
			$params[]=$this->db->Param($paramID);
			$values[$paramID]=$array;
		} else {
			if (count($array)===0) {
				$params[]=$this->db->Param($paramID);
				$values[$paramID]=null;
			} else {
				foreach($array as $i=>$value){
					$paramID="{$bindPrefix}{$i}";
					$params[]=$this->db->Param($paramID);
					$values[$paramID]=$value;
				}
			}
		}

		return array('bind'=>$params,'value'=>$values);

	}

	public function insertData($entityName,$data,$debug=0){
		
		if(!is_array($data) || count($data)==0) return true;
		
		$myParam = BaseBusinessObject::getParamInstance();
		
		$row=$data[0]?$data[0]:$data;
		foreach($row as $key=>$value){
			$Fields[]=$key;
			//$Params[]=$this->db->Param($key);
			$Params[]=$this->Param($key,$myParam);
		}
	
		$sql="insert into ".TableEntity::name($entityName)."(".implode(",",$Fields).") values(".implode(",",$Params).")";
	
		if($debug==1){Tools::pre2($sql,10,"Inserted SQL");Tools::pre2($data,10,"Inserted DATA");}//die;//p2("X",1);
		//return $this->db->Execute($sql,$data);
		return $this->db->Execute($sql,$myParam->getParams($data));
	}

	public function updateData($tablename,$updateField,$whereField,$data,$debug=0){
		throw new AppException("900", "Bu fonksiyon kullanım dışıdır!");
		
		if(!is_array($updateField) || count($updateField)==0 || !is_array($data) || count($data)==0) return true;

		$time=time();

		//$sql="update  ".Entity::name($tablename)." set ";
		$sql="update  ".$tablename." set ";
		foreach($updateField as $key=>$value){
			$s=substr($value,0,1);
			$value=($s=="+" || $s=="-")?substr($value,1):$value;
			$c=($s=="+" || $s=="-")?$value.$s:"";

			$tmpArr[]=$value."=".$c.$this->db->Param("u_".$value);
		}
		$update=implode(",",$tmpArr);

		$sql.=$update;

		$where=" where ";
		foreach($whereField as $key=>$value){

			$tmpWhere[]=$value."=".$this->db->Param("w_".$value);
		}
		$where.=implode(" and ",$tmpWhere);

		$sql .=$where;

		if($debug==1){Tools::pre2($sql,10,"Updated SQL");Tools::pre2($data,10,"Updated DATA");}
		//return true;
		return $this->db->Execute($sql,$data);
	}
	
	public function LoadByWhere($tablename,$fields=null,$params=null) {
		$SQL = "select ".($fields===null ? '*' : $fields )." from ". $tablename." where ";
		$isFirst=true;
		$myParam = BaseBusinessObject::getParamInstance();
		foreach ($params as $key => $val) {
			$SQL.=($isFirst ? "" : " and ").$key." = ".$this->Param($key,$myParam);
			$isFirst=false;
		}
		return $this->db->getRow($SQL,$myParam->getParams($params));
	}
	
	public static function getParamInstance($params=null) {
		if ($params === null ) return new MyParam();
		else return new MyParam($params);
	}
	
	public function Param($field_name,$paramsObj) {
		$paramsObj->param($field_name);
		return $this->db->Param($field_name);
	}
	
	public function StartBoTransaction() {
		$this->db->BeginTrans();
	}
	
	public function RollbackBoTransaction() {
		$this->db->RollbackTrans();
	}
	
	public function CommitBoTransaction() {
		$this->db->CommitTrans();
	}

 }
?>