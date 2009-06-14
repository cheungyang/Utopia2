<?php
interface IDataSource
{
	public function getMaxVersionCount($idx);
	public function getMaxSeqCount($idx);
	public function getDistinctLanguages($idx);
	
	public function create($params);
}
?>