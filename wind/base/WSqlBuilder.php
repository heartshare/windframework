<?php
/**
 * @author Qian Su <aoxue.1988.su.qian@163.com> 2010-11-11
 * @link http://www.phpwind.com
 * @copyright Copyright &copy; 2003-2110 phpwind.com
 * @license 
 */

/**
 * the last known user to change this file in the repository  <$LastChangedBy$>
 * @author Qian Su <aoxue.1988.su.qian@163.com>
 * @version $Id$ 
 * @package 
 */
abstract class WSqlBuilder{
	
	public abstract function buildTable();
	public abstract function buildDistinct();
	public abstract function buildField();
	public abstract function buildUnion();
	public abstract function buildJoin();
	public abstract function buildWhere();
	public abstract function buildGroup();
	public abstract function buildOrder();
	public abstract function buildHaving();
	public abstract function buildLimit();
	public abstract function buildSet();
	public abstract function buildData();
	public abstract function escapeString();
	public  function getInsertSql($option){
		return sprintf("INSERT  %s %s VALUES %s",$this->buildTable($option['table']),$this->buildField($option['field']),$this->buildData($option['data']));
	}
	public  function getUpdateSql(){
		return sprintf("UPDATE  %s %s VALUES %s",$this->buildTable(),$this->buildField(),$this->buildValue());
	}
	public  function getDeleteSql(){
		return sprintf("DELETE  %s %s VALUES %s",$this->buildTable(),$this->buildField(),$this->buildValue());
	}
	public  function getSelectSql(){
		return sprintf("SELECT  %s %s VALUES %s",$this->buildTable(),$this->buildField(),$this->buildValue());
	}


	public function getDimension($array = array()){
		if(!is_array($array)) return 0;			
		static $dim = 0;
		foreach($array as $value){
			$dim++;
			$this->getDimension($value);
		}
		return $dim + 1;
    }

	public function buildSingleData($data){
		foreach($data as $key=>$value){
			$data[$key] = $this->escapeString($value);
		}
		return '('.implode(',',$data).')';
	}

	public function buildMultiData($multiData){
		$iValue = '';
		foreach($multiData as $data){
			$iValue .= $this->buildSingleData($data);
		}
		return $iValue;
	}
}