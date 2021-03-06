{= title: <span class="glyphicon glyphicon-th"></span> List of recharges =}
{= path: ?q=agency_recharge_list =}

{% layout %}

{{headerdown

	{%% table: {
		data: $recharges,
		title: 'Recharges of {$date} ?$hour at {$hour}h $hour?',
		columns: ["date","customer_name","user_email","amount"],
		headers: {
			customer_name: "Customer",
			user_email: "User"			
		},
		wrappers: {
			customer_name: '<a href="index.php?q=agency_customer&id={$customer_id}">{$customer_name} ({$customer_email})</a>',
			amount: '${#amount:2.#}',
			user_email: '<a href="index.php?q=user_activity&user={$user_email}">{$user_email}</a>'
		},
		footer: "?$recharges Totals: <b>{$recharges-user_email}</b> user(s), <b>{$recharges-customer_id}</b> customer(s), <b>${#sum:recharges-amount:2.#}</b> $recharges? "
	} %%}
	
headerdown}}

{% agency_footer %}
