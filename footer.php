				<?php if ( !isset($this) ) die('Direct access to this file is not allowed') ?>
			</div><!--/#content-->
		</div><!--/#page-->

		<script type="text/javascript">
			reverseGif.init();
		</script>

		<script type="text/javascript">
			var _gaq = _gaq || [];
			<?php if ( $_SERVER['SERVER_NAME'] == 'fapgif.com' ): ?>
			_gaq.push(['_setAccount', 'UA-34291519-1']);
			<?php else: ?>
			_gaq.push(['_setAccount', 'UA-34287042-1']);
			<?php endif ?>
			_gaq.push(['_trackPageview']);

			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>

		<!-- Quantcast Tag -->
		<script type="text/javascript">
			var _qevents = _qevents || [];

			(function() {
			var elem = document.createElement('script');
			elem.src = (document.location.protocol == "https:" ? "https://secure" : "http://edge") + ".quantserve.com/quant.js";
			elem.async = true;
			elem.type = "text/javascript";
			var scpt = document.getElementsByTagName('script')[0];
			scpt.parentNode.insertBefore(elem, scpt);
			})();

			_qevents.push({
			qacct:"p-5cNuY3zu-bTwU"
			});
		</script>

		<noscript>
			<div style="display:none;">
			<img src="//pixel.quantserve.com/pixel/p-5cNuY3zu-bTwU.gif" border="0" height="1" width="1" alt="Quantcast"/>
			</div>
		</noscript>
		<!-- End Quantcast tag -->

		<!-- Place this tag after the last plusone tag -->
		<script type="text/javascript">
		  (function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script>
	</body>
</html>
