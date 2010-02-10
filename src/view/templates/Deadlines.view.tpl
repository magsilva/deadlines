<script type="text/javascript">
	{literal}
		$(document).ready(
			function() {
				var oTable = $('#deadlines').dataTable(
					{
						"aaSorting": [[1,'asc'], [ 2, "asc" ]],
						"aoColumns": [
							null,
							null,
							null,
							null
						],
						"bPaginate": true,
						"bLengthChange": true,
						"bFilter": true,
						"bSort": true,
						"bInfo": true,
						"bAutoWidth": true,
						"bStateSave": true,
						"sDom": '<"top"i>rt<"bottom"flp<"clear">',
						"fnRowCallback": function(nRow, aData, iDisplayIndex) {
							var startDate = Date.parseIso8601(aData[2]);
							if (startDate.compare(new Date(), "day") == -1) {
								$('td:eq(2)', nRow).html('<b>' + aData[2] + '</b>');
							}
							return nRow;
						}
					} 
				);
				
				$('#start-date').change(
					function() {
						oTable.fnDraw();
					}
				);
			}
		);
		
		/* Custom filtering function which will filter data in column four between two values */
		$.fn.dataTableExt.afnFiltering.push(
			function(oSettings, aData, iDataIndex) {
				var startDate = Date.parseIso8601(document.getElementById('start-date').value);
				if (aData[2] == null) {
					return false;
				}
				
				var deadlineDate = Date.parseIso8601(aData[2]);
				if (deadlineDate.compare(startDate) == -1) {
					return false;
				} else {
					return true;
				}
			}
		);
		
		$(function() {
  			$("#start-date").date_input();
		});
		
		$.extend(DateInput.DEFAULT_OPTS, {
			stringToDate: function(string) {
				var matches;
				if (matches = string.match(/^(\d{4,4})-(\d{2,2})-(\d{2,2})$/)) {
					return new Date(matches[1], matches[2] - 1, matches[3]);
				} else {
					return null;
				};
			},
	  		dateToString: function(date) {
    			var month = (date.getMonth() + 1).toString();
    			var dom = date.getDate().toString();
    			if (month.length == 1) month = "0" + month;
    			if (dom.length == 1) dom = "0" + dom;
    			return date.getFullYear() + "-" + month + "-" + dom;
  			}
		});
	{/literal}
</script>

<h1>Deadlines</h1>

Deadlines is a publication management application aimed at researchers with a strong
desire to publish their work results in a meaningful publication.

<p>Start date: <input id="start-date" type="text"></p>

<table class="rounded-table" id="deadlines">
<thead>
	<tr>
		<th scope="col" class="rounded-frame-top-left">Name</th>
		<th scope="col" class="rounded-frame-top-center">Abstract deadline</th>
		<th scope="col" class="rounded-frame-top-center">Deadline</th>
		<th scope="col" class="rounded-frame-top-right">Information URL</th>
	</tr>
</thead>
<tfoot>
	<tr>
		<th scope="col" class="rounded-frame-bottom-left">Name</th>
		<th scope="col" class="rounded-frame-bottom-center">Abstract deadline</th>
		<th scope="col" class="rounded-frame-bottom-center">Deadline</th>
		<th scope="col" class="rounded-frame-bottom-right">Information URL</th>
	</tr>
</tfoot>
<tbody>
{foreach from=$deadlines item=deadline}
	<tr>
		<td>{$deadline->publication->getName()}</td>
		<td>{$deadline->getAbstractSubmissionDeadline()}</td>
		{if $deadline->getExtendedSubmissionDeadline() != NULL}
			<td>{$deadline->getExtendedSubmissionDeadline()}</td>
		{else}
			<td>{$deadline->getSubmissionDeadline()}</td>
		{/if}
		<td>{$deadline->getInformationUrl()}</td>
	</tr>
{/foreach}
</tbody>
</table>

