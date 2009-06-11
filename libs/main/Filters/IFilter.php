<?php
interface IFilter{
	public function __construct();
	public function execute($inputs, $opts);		
}
?>