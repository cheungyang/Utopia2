<?php
interface ICommand{
	public function __construct($params=array());	
	public function execute();
}
?>