<?php 

function blockBadBots()
{
  $robotsTxt = explode(PHP_EOL, file_get_contents('robots.txt'));

  foreach($robotsTxt as $line => $content)
  {
    $previousContent = str_replace('user-agent: ', 'user-agent:', strtolower($robotsTxt[$line - 1]));

    if(str_replace(' ', '',  trim(strtolower($content))) == 'disallow:/' && strpos(strtolower($previousContent), 'user-agent:') === false)
    {
      continue;
    }

    if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), str_replace('user-agent:', '', $previousContent)) !== false)
    {
      header("HTTP/1.0 403 FORBIDDEN");
      die();
    }    
  }
}
