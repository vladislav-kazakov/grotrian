<div id="txt" class="container_12">
<div class="grid_12" id="loginform">
<br/>
<h3>{#$l10n.Login_hint#}</h3>
     <form action="/admin/" method="post" >
     {#$l10n.UserName#}<input name="login" value=""/>
     {#$l10n.Password#}<input type="password" name="passw" value=""/>
     <input type="hidden" name="enter" value="yes"/>  
     <input class=button type=submit value="{#$l10n.Login#}"/>
     </form>
	</div>
</div>