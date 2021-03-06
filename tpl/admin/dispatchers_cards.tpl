{= title: Cards of <i>{$dispatcher.email}</i> =}
{= path: "?q=dispatchers_cards&dispatcher={$dispatcher.email}&cards={$sale}" =}

{% layout %}

{{blocks
	{%% dispatcher_block: $dispatcher %%}
blocks}}

{{page
<a href="?q=dispatchers_card_sales&sales={$dispatcher.email}">&lt;&lt; Sales</a><br/>

{%% table: {
	data: $cards,
	hideColumns: {profit_percent: true, sale: true},
	headers: {
		recharge_date: "Recharge date"
	},
	wrappers: {
		code: '!$recharge_date <a onclick="return confirm(\'Are you sure?\');" href="{$path}&deactivate={$code}" title="Deactiviate"><span class="glyphicon glyphicon-trash"></span></a>&nbsp;$recharge_date!{$code:0,4}&nbsp;{$code:4,4}&nbsp;{$code:8,4}&nbsp;',
		amount: '${#amount:2.#}',
		email: '?$email <a href="?q=user_activity&user={$email}">{$email}</a> @else@ - still - $email?',
		recharge_date: '?$recharge_date {$recharge_date} @else@ - still - $recharge_date?'
	},
	footer: 'Total amount: <b>$(# {$sum:cards-amount} :2.#)</b>'
} %%}

page}}