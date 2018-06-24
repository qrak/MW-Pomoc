<?PHP
///////////////////// TEMPLATE Default /////////////////////
$template_active = <<<HTML
<div align="left" style="background-color: #c09c67; border-style: ridge; padding-left: 10px; border-color: #c09c67;"><p><b>{title}</b></p></div>	
<div style="border-style: ridge; padding-left: 10px; border-color: #c09c67;"><p>{short-story}
<br><br>
autor: {author}<br> Dodano: {date}</p></div><p></p>

HTML;


$template_full = <<<HTML
<div style="width:420px; margin-bottom:15px;">
<div><strong>{title}</strong></div>

<div style="text-align:justify; padding:3px; margin-top:3px; margin-bottom:5px; border-top:1px solid #c09c67;">{full-story}</div>

<div style="float: right;">{comments-num} Comments</div>

<div><em>Posted on {date} by {author}</em></div>
</div>
HTML;


$template_comment = <<<HTML
<div style="width: 400px; margin-bottom:20px;">

<div style="border-bottom:1px solid black;"> by <strong>{author}</strong> @ {date}</div>

<div style="padding:2px; background-color:#c09c67">{comment}</div>

</div>
HTML;


$template_form = <<<HTML
  <table border="0" width="370" cellspacing="0" cellpadding="0">
    <tr>
      <td width="60">Name:</td>
      <td><input type="text" name="name"></td>
    </tr>
    <tr>
      <td>E-mail:</td>
      <td><input type="text" name="mail"> (optional)</td>
    </tr>
    <tr>
      <td>Smile:</td>
      <td>{smilies}</td>
    </tr>
    <tr>
      <td colspan="2">
      <textarea cols="40" rows="6" id=commentsbox name="comments"></textarea><br />
      <input type="submit" name="submit" value="Add My Comment">
      <input type=checkbox name=CNremember  id=CNremember value=1><label for=CNremember> Remember Me</label> |
  <a href="javascript:CNforget();">Forget Me</a>
      </td>
    </tr>
  </table>
HTML;


$template_prev_next = <<<HTML
<p align="center">[prev-link]<< Previous[/prev-link] {pages} [next-link]Next >>[/next-link]</p>
HTML;
$template_comments_prev_next = <<<HTML
<p align="center">[prev-link]<< Older[/prev-link] ({pages}) [next-link]Newest >>[/next-link]</p>
HTML;
?>
