<div class="alert alert-info">
        <h4 class="alert-heading">{'_WHATISPRUNING'|lang}</h4>
        <p>
            {'_PRUNINGINFO'|lang}
            You currently have {if ($bans2prune == 0)}0{else}{$bans2prune}{/if} expired bans.
        </p>
            <form name="prunebans" method="get" action="{$this}">
                <input type="hidden" name="submitted" value="true">
                <button class="btn {if ($bans2prune == 0)}disabled{/if}" {if ($bans2prune == 0)}disabled{/if} type="submit">{'_PRUNEDB'|lang}</button>
            </form>
</div>
<!-- 
<table class="table">
          <tr>
            <td height='16' colspan='4' class='listtable_top'><b>{"_PRUNEDB"|lang}</b></td>
          </tr>
          <form name='prunebans' method='post' action='{$this}'>
          <tr>
          	<td>{"_NBEXPBANS"|lang}</td>
            <td>{if ($bans2prune == 0)}{"_NONE"|lang}{else}{$bans2prune}{/if}</td>
			<td><input type='hidden' name='submitted' value='true'><input type='submit' name='prune' value='{"_PRUNEDB"|lang}' {if ($bans2prune == 0)}disabled{/if}></td>
          </tr>
          </form>
          <tr>
          	<td height='16' width='100%' class='listtable_1' colspan='4'><br>

							<b>{"_WHATISPRUNING"|lang}</b><br>
							{"_PRUNINGINFO"|lang}
							<br><br>
          	</td>
          </tr>
</table>
-->