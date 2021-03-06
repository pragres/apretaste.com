{= title: Address list =}
{= path: "index.php?path=admin&page=address_list" =}
{% layout %}	
{{page
	{% address_list_panel %}
		<fieldset>	
		<legend>Download from</legend>
		<a href="{$path}&download=true">All ({$total_address})</a> | 
		<a href="{$path}&download=true&filter=*.cu">Domain .cu</a> |  
		<a href="{$path}&download=true&filter=apretaste.public.announcement">Internal ads</a> | 
		<a href="{$path}&download=true&filter=apretaste.public.external_ads">External ads</a> |
		<a href="{$path}&download=true&filter=apretaste.public.invitations">Invitations</a> | 
		<a href="{$path}&download=true&filter=apretaste.public.external_ads">Guests</a> |
		<a href="{$path}&download=true&filter=apretaste.public.authors">Authors</a> |
		<a href="{$path}&download=true&filter=apretaste.public.messages">Messages</a> |
		<a href="{$path}&download=true&filter=apretaste.public.admin">Admin (manual inserts)</a>
		</fieldset>
		Operations: <a href="{$path}&nourish=true">Nourish the list from all sources</a>
		<hr/>	
		<fieldset>
		<legend>Drop address</legend>
		<form action="{$path}" method="POST">
		<input class ="edit" name="edtDropAddress">
		<input onclick = "return confirm('Are you sure?');" type="submit" class="submit" value = "Drop" name="btnDropAddress">
		</form>
		</fieldset>
			
		?$addinserted
			<p>{$addinserted} already inserted: [$addinserted]{$value}, [/$addinserted]</p> 
		$addinserted?
		
		<!--{ download area }-->
		<hr/>
				
		<form action="{$path}" method="post">
			<fieldset><legend>New emails:</legend>
			Addresses: <br/>
			<textarea rows="20" cols="100" name="address"></textarea>&nbsp;
			<br/><input class="submit" type="submit" value="Add" name="btnAdd">
			</fieldset>
			
		</form>
page}}