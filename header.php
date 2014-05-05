<?php if ( !isset($this) ) die('Direct access to this file is not allowed') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-us">
	<head>
		<title><?php echo $this->siteName . ( $this->pageTitle ? ' - ' : '' ) . $this->t($this->pageTitle) ?></title>

		<link type="text/css"  rel="stylesheet"    href="<?php echo $this->viewPath ?>global.css"/>
		<link type="text/css"  rel="stylesheet"    href="<?php echo $this->viewPath ?>grid.css"  />

		<link type="image/png" rel="shortcut icon" href="<?php echo $this->rootPath ?>favicon.ico"/>

		<meta http-equiv="content-type"     content="text/html; charset=UTF-8"/>
		<meta http-equiv="content-language" content="en-US"/>

		<meta name="title"        content="<?php echo $this->siteName . ( $this->pageTitle ? ' - ' : '' ) . $this->t($this->pageTitle) ?>"/>
		<meta name="distribution" content="global"/>
		<meta name="generator"    content="Swiftlet - http://swiftlet.org"/>
		<meta name="copyright"    content="<?php echo $this->siteCopyright   ?>"/>
		<meta name="designer"     content="<?php echo $this->siteDesigner    ?>"/>
		<meta name="description"  content="<?php echo $this->pageDescription ?>"/>
		<meta name="keywords"     content="<?php echo $this->pageKeywords    ?>"/>

		<meta property="fb:admins" content="100002288502150"/>
		<meta property="fb:app_id" content="164217656966658">

		<script type="text/javascript" src="<?php echo $this->viewPath ?>scripts/gif.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo $this->viewPath ?>scripts/tipsy.js"></script>
	</head>
	<body class="<?php echo $controller->inAdmin ? 'in-admin' : '' ?> <?php echo str_replace('.', '_', $_SERVER['SERVER_NAME']) ?>">
		<div id="page">
			<div id="header">
				<h1 id="logo">
					<a href="<?php echo $this->rootPath ?>" title="<?php echo $_SERVER['SERVER_NAME'] == 'fapgif.com' ? $this->t('1000+ Hardcore porn GIFs') : $this->t('Upload your own animated GIFs') ?>"><?php echo $this->siteName . ( $this->pageTitle ? ' &mdash; ' : '' ) . $this->t($this->pageTitle) ?></a>
				</h1>

				<?php if ( $_SERVER['SERVER_NAME'] != 'fapgif.com' ): ?>
				<p id="share">
					<iframe src="http://www.facebook.com/plugins/like.php?href=http://reversegif.com/&amp;layout=button_count&amp;show_faces=false&amp;width=100&amp;height=21;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:100px; height:21px; text-align: center;"></iframe>

					<!-- Place this tag where you want the +1 button to render -->
					<g:plusone size="medium" href="http://reversegif.com"></g:plusone>
				</p>

				<ul id="settings">
					 <li><a class="<?php echo $this->app->gif->prefs['misc']     ? 'on' : 'off' ?>" href="<?php echo $this->route('toggle/misc?ref='     . rawurlencode($_SERVER['REQUEST_URI'])) ?>" title="<?php echo $this->app->gif->prefs['misc']     ? 'Hide' : 'Show' ?> misceleneous images">misc     <span><?php echo $this->app->gif->prefs['misc']     ? 'on' : 'off' ?></span></a></li
					><li><a class="<?php echo $this->app->gif->prefs['nudity']   ? 'on' : 'off' ?>" href="<?php echo $this->route('toggle/nudity?ref='   . rawurlencode($_SERVER['REQUEST_URI'])) ?>" title="<?php echo $this->app->gif->prefs['nudity']   ? 'Hide' : 'Show' ?> nudity"             >nudity   <span><?php echo $this->app->gif->prefs['nudity']   ? 'on' : 'off' ?></span></a></li
					><li><a class="<?php echo $this->app->gif->prefs['violence'] ? 'on' : 'off' ?>" href="<?php echo $this->route('toggle/violence?ref=' . rawurlencode($_SERVER['REQUEST_URI'])) ?>" title="<?php echo $this->app->gif->prefs['violence'] ? 'Hide' : 'Show' ?> violence"           >violence <span><?php echo $this->app->gif->prefs['violence'] ? 'on' : 'off' ?></span></a></li>
				</ul>
				<?php endif ?>

				<div style="clear: both;"></div>
			</div>

			<div id="featured" class="grid">
				<?php $featured = $this->app->gif->get_featured() ?>
				<?php for ( $i = 0; $i < ( $this->path ? 9 : 18 ); $i ++ ): ?>
				<div class="span-1">
					<?php if ( isset($featured[$i]) ): ?>
					<a class="<?php echo $featured[$i]['hot'] ? 'hot' : '' ?>" href="<?php echo $this->route($this->app->gif->id_to_url($featured[$i]['id']) . ( $_SERVER['SERVER_NAME'] == 'fapgif.com' ? '_o' : '' ) . $this->app->gif->title_to_url($featured[$i]['title'])) ?>" title="<?php echo $this->h($featured[$i]['title']) ?>">
						<?php if ( date('d-m') == '01-04' ): ?>
						<span class="thumb" style="background-image: url('http://reversegif.com/_views/images/april-fools.gif');">
							<span>
								<?php echo $this->h($featured[$i]['title']) ?>

								<img src="http://reversegif.com/_views/images/april-fools.gif" width="1" height="1"/>
							</span>
						</span>
						<?php else: ?>
						<span class="thumb" style="background-image: url('http://img.reversegif.com/<?php echo $featured[$i]['id'] ?>_t.gif');">
							<span>
								<?php echo $this->h($featured[$i]['title']) ?>

								<img src="http://img.reversegif.com/<?php echo $featured[$i]['id'] ?>_t.gif" width="1" height="1"/>
							</span>
						</span>
						<?php endif ?>
					</a>
					<?php endif ?>
				</div>
				<?php endfor ?>

				<script type="text/javascript">
					$('#featured .thumb').hide().css({ opacity: .8 });

					$('#featured img').load(function() {
						$(this).parent().parent().stop().fadeIn();
					});
				</script>
			</div>

			<?php if ( $this->request || $_SERVER['SERVER_NAME'] == 'fapgif.com' ): ?>
			<div id="ad">
				<?php if ( $this->app->gif->prefs['nudity'] || ( !empty($this->gif) && $this->gif['nudity'] ) ): ?>
				<!-- Begin: Black Label Ads, Generated: 2012-08-18 18:49:47  -->
				<iframe allowtransparency="1" frameborder="0" height="90" id="plwpr26878503e4f0dd481d8.17900077" scrolling="no" src="http://widget.plugrush.com/fapgif.com/zjf" width="728"></iframe>
				<!-- End: Black Label Ads -->
				<?php elseif ( !empty($this->gif) && !$this->gif['violence'] ): ?>
				
				<?php else: ?>
				<!--Copy and paste the code below into the location on your website where the ad will appear.-->
				<script type='text/javascript'>
				var adParams = {a: '7458281', size: '728x90'};
				</script>
				<script type='text/javascript' src='http://cdn.adk2.com/adstract/scripts/smart/smart.js'></script>
				<?php endif ?>
			</div>
			<?php endif ?>

			<div id="content">
