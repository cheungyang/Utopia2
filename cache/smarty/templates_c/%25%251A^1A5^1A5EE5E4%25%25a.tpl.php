<?php /* Smarty version 2.6.25, created on 2009-06-01 17:22:59
         compiled from a.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Blueprint Forms Tests</title>

  <!-- Framework CSS -->
	<link rel="stylesheet" href="<?php echo $this->_tpl_vars['DIR_CSS_ROOT']; ?>
vendor/blueprint/screen.css" type="text/css" media="screen, projection">
	<link rel="stylesheet" href="<?php echo $this->_tpl_vars['DIR_CSS_ROOT']; ?>
vendor/blueprint/print.css" type="text/css" media="print">
  <!--[if lt IE 8]><link rel="stylesheet" href="<?php echo $this->_tpl_vars['DIR_CSS_ROOT']; ?>
vendor/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->

</head>
<body>

	<div class="container showgrid">
		<h1>Forms</h1>
		<hr>
    
    <div class="span-12">
    
      <form id="dummy" action="" method="post">

      	<fieldset>

      		<legend>Simple sample form</legend>

      		<p><label for="dummy0">Text input (title)</label><br>
      		  <input type="text" class="title" name="dummy0" id="dummy0" value="Field with class .title"></p>
        
          <p><label for="dummy1">Another field</label><br>
      		  <input type="text" class="text" id="dummy1" name="dummy1" value="Field with class .text"></p>

      	  <p><label for="dummy2">Textarea</label><br>

      	    <textarea name="dummy2" id="dummy2" rows="5" cols="20"></textarea></p>

      		<p><input type="submit" value="Submit">
      		  <input type="reset" value="Reset"></p>

      	</fieldset>
      </form>
    
    </div>
    <div class="span-12 last">

    
      <div class="error">
        This is a &lt;div&gt; with the class <strong>.error</strong>. <a href="#">Link</a>.
      </div>
      <div class="notice">
        This is a &lt;div&gt; with the class <strong>.notice</strong>. <a href="#">Link</a>.
      </div>		
      <div class="success">

        This is a &lt;div&gt; with the class <strong>.success</strong>. <a href="#">Link</a>.
      </div>    
      
      <fieldset>
        <legend>Select, checkboxes, lists</legend>

    		<p><label for="dummy3">Select field</label><br>

    		  <select id="dummy3" name="dummy3">
    			  <option value="1">Ottawa</option>
    			  <option value="2">Calgary</option>
    			  <option value="3">Moosejaw</option>
    		  </select></p>

    		<p><label for="dummy4">Select with groups</label><br>

    		  <select id="dummy4" name="dummy4">
    			  <option>Favorite pet</option>
    			  <optgroup label="mammals">
    			    <option>dog</option>
    			    <option>cat</option>
    			    <option>rabbit</option>
    			    <option>horse</option>

    			  </optgroup>
    			  <optgroup label="reptiles">
    			    <option>iguana</option>
    			    <option>snake</option>
    			  </optgroup>
    		  </select></p>
    		  
    		  <p><label>Radio buttons</label><br>

    		    <input type="radio" name="example"> Radio one<br>
    		    <input type="radio" name="example"> Radio two<br>
    		    <input type="radio" name="example"> Radio three<br></p>
          
    		  <p><label>Checkboxes</label><br>
    		    <input type="checkbox"> Check one<br>

    		    <input type="checkbox"> Check two<br>
    		    <input type="checkbox"> Check three<br></p>
        
      </fieldset>
    
    </div>

		<div class="span-24 last">
			
			<fieldset>

        		<legend>Alignment</legend>

    			<p>
					<label for="dummy5">Select field</label>
		    		  <select id="dummy5" name="dummy5">
    					  <option value="1">Ottawa</option>
    					  <option value="2">Calgary</option>

    					  <option value="3">Moosejaw</option>
    		 		 </select>
        		</p>

    		<p>
					<label for="dummy6">Text input (title)</label>
    		  <input type="text" class="title" name="dummy6" id="dummy6" value="Field with class .title">
				</p>

				
				<p>
					<label for="dummy7">Select field</label>
    		  <select id="dummy7" name="dummy7">
    			  <option value="1">Ottawa</option>
    			  <option value="2">Calgary</option>
    			  <option value="3">Moosejaw</option>
    		  </select>

					<label for="dummy8">Another field</label>
      		<input type="text" class="text" id="dummy8" name="dummy8" value="Field with class .text"></p>
        </p>
        
        	</fieldset>
        	
        </div>
        
        <div class="span-24 last">
        	
        	

			<form action="" method="post" class="inline">
					
				<fieldset>

					<legend>A form with class "inline"</legend>
					<div class="span-3">
						<label for="a">Label A:</label>
						<select id="a" name="a" >
							<option value="0">All</option>
						</select>
					</div>

					<div class="span-2">
						some text
					</div>
					<div class="span-3">
						<input type="checkbox" id="o" name="o" value="true"	checked="checked" class="checkbox">checkbox one
					</div>
					<div class="span-3">
						<label for="b">Label B:</label>
						<select id="b" name="b" >

							<option value="0">All</option>
						</select>
					</div>
					<div class="span-2">
						<a href="">A Hyperlink</a>
					</div>
					<div class="span-8">
						<input type="text" class="text" id="q" name="q" value="Field with class .text">

					</div>
					<div class="span-2 last">
						<input type="submit" value="submit" class="button">
					</div>
				</fieldset>
				
			</form>
      
		</div>
				
    <hr>

    <p><a href="http://validator.w3.org/check?uri=referer">
    <img src="valid.png" alt="Valid HTML 4.01 Strict" height="31" width="88" class="top"></a></p>
    
  </div>
</body>
</html>