            <div class="footer" style="text-align:center">
                <small>
                    <p>
                        Built using <a href="http://www.smarty.net/">Smarty</a> and <a href="http://twitter.github.com/bootstrap/">Bootstrap</a> by <a href="https://twitter.com/rodoabad">@rodoabad</a>.
                        Icons from <a href="http://glyphicons.com/">Glypicons Free</a>. Backgrounds from <a href="http://subtlepatterns.com/">Subtle Patterns</a>.
                    </p>
                </small>
                <form class="form-inline" name="setlang" action="{$this}" method="POST">
                    <label>
                        {php} $total = CountBans(); {/php}
                        {"_TOTALBANS"|lang}: {php}echo $total{/php}
                    </label>
                    {assign var="lang" value=$true|getlanguage}
                    {assign var="select_lang" value=$true|selectlang:"session"}
                    {assign var="default_lang" value=$true|selectlang:"config"}
                    <select name="newlang" onchange="this.form.submit()">
                        {foreach from=$lang item="lang"}
                            <option value="{$lang|escape}" {if empty($select_lang) && $default_lang == $lang}selected{/if} {if $select_lang == $lang}selected{/if}>{$lang|escape}</option>
                        {/foreach}
                        </select>
                </form>
            </div>
        </div>
    </body>

</html>
