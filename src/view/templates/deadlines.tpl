<table>
{foreach from=$deadlines item=deadline}
	<tr>
		<td>{$deadline->location}</td>
		<td>{$deadline->start_date}</td>
		<td>{$deadline->submission_deadline}</td>
	</tr>
{/foreach}
</table>

