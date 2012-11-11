
{formtool_init src="/formtool.js"}

<table border=1>
	<form name='colors' method='post' action='{$this}'>
   <tr> 
   <td valign="top"> 
      <select name="colors5[]" multiple size="10"> 
      {html_options values=$colors output=$colors} 
      </select> 
      <input type="hidden" name="colors5_save"> 
   </td> 
   <td align="center"> 
      {formtool_moveall from="colors5[]" to="colors6[]" button_text=">>"  save_from="colors5_save" save_to="colors6_save"}<br /> 
      {formtool_move from="colors5[]" to="colors6[]" button_text=">" save_from="colors5_save" save_to="colors6_save"}<br /> 
      {formtool_move from="colors6[]" to="colors5[]" button_text="<" save_from="colors5_save" save_to="colors6_save"}<br /> 
      {formtool_moveall from="colors6[]" to="colors5[]" button_text="<<" save_from="colors5_save" save_to="colors6_save"} 
   </td> 
   <td valign="top"> 
      <select name="colors6[]" multiple size="10"> 
      </select> 
      <input type="hidden" name="colors6_save"> 
   </td> 
   </tr> 
   
</table>

<input type="submit" name="submit" value="submit">
</form>