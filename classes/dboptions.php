<?php

class dboptions
{
	
	public function dbSelect($table, $fieldname = null, $id = null, $classname)
	{
		$db   = DB::getInstance();
		$sql  = "SELECT * FROM `$table` WHERE `$fieldname`=:id";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':id', $idd);
		//$id=$idd;
		$stmt->execute();
		
		return $stmt->fetchObject($classname);
	}
	
	public function rawSelect($sql)
	{
		$db = DB::getInstance();
		
		return $db->query($sql);
	}
	
	public function rawQuery($sql)
	{
		$db = DB::getInstance();
		$db->query($sql);
	}
	
	public function dbInsert($table, $values)
	{
		$db         = DB::getInstance();
		$fieldnames = array_keys($values[0]);
		$size       = sizeof($fieldnames);
		$i          = 1;
		$sql        = "INSERT INTO $table";
		$fields     = '( ' . implode(' ,', $fieldnames) . ' )';
		$bound      = '(:' . implode(', :', $fieldnames) . ' )';
		$sql        .= $fields . ' VALUES ' . $bound;
		$stmt       = $db->prepare($sql);
		foreach ($values as $vals) {
			$stmt->execute($vals);
		}
	}
	
	public function dbInsertArray($table, $array = array())
	{
		$fields = '';
		$bound  = '';
		foreach ($array as $key => $value) {
			$fields .= $key . ', ';
			$bound  .= '"' . $value . '"' . ', ';
		}
		$fields = substr($fields, 0, -2);
		$bound  = substr($bound, 0, -2);
		$db     = DB::getInstance();
		$sql    = "INSERT INTO $table ";
		
		$sql .= '(' . $fields . ')' . ' VALUES ' . '(' . $bound . ')';
		print_x($sql);
		$stmt = $db->prepare($sql);
		
		
		//$stmt->execute($sql);
		
	}
	
	public function dbUpdate($table, $fieldname, $value, $pk, $id)
	{
		$db   = DB::getInstance();
		$sql  = "UPDATE `$table` SET `$fieldname`='{$value}' WHERE `$pk` = :id";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$stmt->execute();
	}
	
	public function dbDelete($table, $fieldname, $id)
	{
		$db   = DB::getInstance();
		$sql  = "DELETE FROM `$table` WHERE `$fieldname` = :id";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$stmt->execute();
	}
	
	public function get_column_names($table)
	{
		
		$db = DB::getInstance();
		
		$rows = $db->query("SELECT * FROM `$table` LIMIT 1");
		for ($i = 0; $i < $rows->columnCount(); $i++) {
			$column    = $rows->getColumnMeta($i);
			$columns[] = $column['name'];
		}
		
		return $columns;
		
		
	}
	
	public function truncateTable($table)
	{
		$db   = DB::getInstance();
		$sql  = "TRUNCATE TABLE `$table`";
		$stmt = $db->prepare($sql);
		$stmt->execute();
	}
	
	public function selectAll($table)
	{
		$db   = DB::getInstance();
		$sql  = "SELECT * FROM `$table`";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
	
	public function selectAllByStartDate($table, $startDate)
	{
		$db  = DB::getInstance();
		$sql = "SELECT * FROM `$table` WHERE startdate = :startDate";
		
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
		
		$stmt->execute();
		
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
	
	
	
	
}
