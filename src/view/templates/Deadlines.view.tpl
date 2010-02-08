<table>
{foreach from=$deadlines item=deadline}
	<tr>
		<td>{$deadline->getId()}</td>
		<td>{$deadline->getAbstractSubmissionDeadline()}</td>
		<td>{$deadline->getSubmissionDeadline()}</td>
		<td>{$deadline->getInformationUrl()}</td>
	</tr>
{/foreach}
</table>

