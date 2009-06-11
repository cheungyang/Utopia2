<?php
	function pr($data)
	{
		printf("<pre>%s</pre>", print_r($data, true));
	}
	
	function pc($command)
	{
		$cmd = $command;		
		if (isset($command['errors']))
		{		
			$errs = array();		
			foreach($command['errors'] as $err)
			{
				if ($err instanceof Exception)
				{
					$errs[] = '[error] '.$err->getMessage()."\n";
				}
				else
				{
					throw new Execption("variable is not an instance of Exception: ". print_r($err, true), ERROR_TYPE_MISMATCH);
				}
			}
			$cmd['errors'] = $errs;
		}
		
		if (isset($command['status']))
		{		
			$cmd['status'] = $command['status'] === SUCCESS ?
				'SUCCESS': 'FAIL';
		}		
		pr($cmd);		
	}
?>