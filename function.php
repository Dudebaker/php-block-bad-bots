<?php 

function blockBadBots()
{
  $robotsTxt = explode(PHP_EOL, file_get_contents('robots.txt'));

  $disallowedRobots = [];

  foreach($robotsTxt as $line => $content)
  {
    $previousContent = str_replace('user-agent: ', 'user-agent:', strtolower($robotsTxt[$line - 1]));

    if(str_replace(' ', '',  trim(strtolower($content))) == 'disallow:/' && strpos(strtolower($previousContent), 'user-agent:') !== false)
    {
      $disallowedRobots[] = str_replace('user-agent:', '', $previousContent);
    }
  }

  foreach($disallowedRobots as $disallowedRobot)
  {
    if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), $disallowedRobot) !== false)
    {
      header("HTTP/1.0 403 FORBIDDEN");
      die();
    }
  }
}
