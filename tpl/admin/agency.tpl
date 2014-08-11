{= title: "Agency" =}
{% layout %}
{{page
	{= path: "index.php?path=admin&page=agency" =}
		
		?$div.get.customer_not_found
		<div class="msg-error">Customer not found</div>
		$div.get.customer_not_found? 	
		
		?$msgerror
		<div class="msg-error">{$msgerror}</div>
		$msgerror?
		
		!$div.get.section
		<table width="100%">
		<tr><td valign="top" width="50%">

		<h1>Search for a customer</h1>
		<form action="index.php?path=admin&page=agency_search_customer" method="POST">
		Name: <br/><input class="text" name="edtSearchName"><br/>
		Email: <br/><input class="text" name="edtSearchEmail"><br/>
		Phone: <br/><input class="text" name="edtSearchPhone"><br/>
		<input type="submit" value="Search" class="submit" name="edtSearch">
		</form>
		
		?$searchresults
		{= pagewidth: 1024 =}
		</td><td valign="top" width="50%">
		&nbsp;
		<h1>Search results</h1>
		[$searchresults]
			?$_is_first
			<table class="tabla"><tr><th>Name</th><th>Email</th><th>Phone</th></tr>
			$_is_first?
			
			<tr><td><a href="index.php?path=admin&page=agency_customer&id={$id}">{$full_name}</a></td><td>{$email}</td><td>{$phone}</td></tr>
			
			?$_is_last
			</table>
			$_is_last?
		@empty@
		<!--{ Do nothing }-->
		[/$searchresults]
		@else@
		{= pagewidth: 500 =}
		$searchresults?
		
		</td></tr></table>
		<br/>
		<a class="button" href="{$path}&section=add_customer">Add a customer</a>
		
		@else@
		
		{?( "{$div.get.section}"=="add_customer" )?}
			{= pagewidth: 500 =}
			<h1>New customer</h1>
			<hr/>
		 	<form action="{$path}&page=agency_add_customer" method="POST">
		 	Full name: <br/>
			<input class="text" name ="edtName" ?$edtName value="{$edtName}" $edtName?><br/>
			Email:  <br/>
			<input class="text" name="edtEmail" ?$edtEmail value="{$edtEmail}" $edtEmail?><br/>
		 	Phone:  <br/>
			<input class="text" name="edtPhone" ?$edtPhone value="{$edtPhone}" $edtPhone?><br/>
		 	<hr/>
			<input class="submit" type="submit" name="btnAddCustomer" value="Add"> &nbsp; <a href="{$path}" class="submit">Cancel</a></td>
		 	</form>
		{/?}
		$div.get.section!
page}}