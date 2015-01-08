<form id="manager_form" class="form-inline">
    {foreach $managers as $manager}
    <label class="checkbox-inline" style="margin-right: 5px;">
        <input type="checkbox" name="manager[]" id="m_{$manager.id}" value="{$manager.id}" {if in_array($manager.id, $members)}checked="checked" {/if}> {$manager.username}
    </label>
    {/foreach}
    <input type="hidden" name="role_id" value="{$role.id}"/>
</form>