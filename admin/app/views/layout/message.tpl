<!-- Call merged included template "layout/message.tpl" -->
{if Session::has('message_success')}
<div class="alert alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	{Session::get('message_success')}
</div>
{/if}
{if Session::has('message_info')}
<div class="alert alert-info alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	{Session::get('message_info')}
</div>
{/if}
{if Session::has('message_warning')}
<div class="alert alert-warning alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	{Session::get('message_warning')}
</div>
{/if}
{if Session::has('message_error')}
<div class="alert alert-danger alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	{Session::get('message_error')}
</div>
{/if}
<!-- End of included template "layout/message.tpl" -->