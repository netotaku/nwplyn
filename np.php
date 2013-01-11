<?php 

	class nowPlaying
	{

                public $feed;
                public $id;

		function __construct()
		{

                    empty($_POST) ? $this->get() : $this->create();
                    
		}

                function create()
                {

                    $this->id = trim($_POST['id']);

                    if($this->get_feed() && !empty($_POST['remember'])) setcookie("user", $this->id, 2592000+time());
                    
                    header('Location: /' . $this->id);
                   
                }

                function returning()
                {

                    return empty($_COOKIE['user']) ? false : $_COOKIE['user'];

                }

                function get()
                {

                    $o = file_get_contents('assets/templates/basis.html');

                    if(!$this->get_ID())
                    {

                        if($this->returning()) header('Location: /' . $this->returning());

                        $o = str_replace('{content}', file_get_contents('assets/templates/index.html'), $o);
                        $o = str_replace('{title}', '#nowPlaying, Tweet what you are listening to on last.fm and Spotify ♫', $o);
                    
                    } else {

                        if($this->id == 'forget')
                        {

                            setcookie("user", "", time()-3600);
                            header('Location: /');

                            return;

                        } else {
                            
                            if($this->get_feed())
                            {

                                $o = str_replace('{content}', $this->get_items(), $o);
                                $o = str_replace('{title}', '#nowPlaying for ' . $this->get_title(), $o);

                            } else {

                                $o = str_replace('{content}', file_get_contents('assets/templates/error.html'), $o);
                                $o = str_replace('{title}', 'Error', $o);

                            }

                        }

                    }

                    echo $o;

                }

                function get_ID()
                {

                    $params = explode("/", $_SERVER['REQUEST_URI']);

                    $this->id = $params[1];

                    return $this->id ? true : false;

                }

                function get_feed()
                {

                    $file = 'http://ws.audioscrobbler.com/1.0/user/' . $this->id . '/recenttracks.rss';

                    $this->feed = @simplexml_load_file($file);
                    
                    return $this->feed ? true : false;

                }

                function get_title()
                {

                    return $this->feed->channel->title;
                    
                }

                function get_items()
                {


                    $o = file_get_contents('assets/templates/tracks.html');

                    $o = str_replace('{title}', $this->get_title(), $o);

                    $o = $this->returning() ? str_replace('{forget}', '<li><a href="/forget" class="forget">Forget me</a></li>', $o) : str_replace('{forget}', '', $o);

                    $items = $this->feed->channel->item;

                    $lis = '';

                    foreach ($items as $item) {

                        $title = str_replace('–', ' - ', $item->title);
                        $title = str_replace('’', "'", $title);

                        $query = '?url=' . urlencode($item->link) . '&text=%23nowPlaying%20' . urlencode($title) . '&via=nwplyn';

                        $lis .= '
                            <li>
                                <span class="title"><h4>' . str_replace(' - ', '</h4> / ', $title) . '<br></span>
                                <input class="hide" value="' . $query . '">
                            </li>';

                    }

                    return str_replace('{tracks}', $lis, $o);

                }
	
	}

        ///////////////////////////////////////////////////////////////////////

        new nowPlaying();

?>


