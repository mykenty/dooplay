<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title><?php wp_title('-', true, 'right'); ?> <?php bloginfo('name'); ?></title>
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600">
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() .'/assets/css/dt.style.css'; ?>">
	<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js?ver=2.2.0'></script>
	<script type='text/javascript' src='https://www.google.com/recaptcha/api.js' async defer></script>
	<script type="text/javascript">
	$.fn.passwordStrength = function(options) {
		return this.each(function() {
			var that = this;
			that.opts = {};
			that.opts = $.extend({}, $.fn.passwordStrength.defaults, options);
			that.div = $(that.opts.targetDiv);
			that.defaultClass = that.div.attr('class');
			that.percents = (that.opts.classes.length) ? 100 / that.opts.classes.length : 100;
			v = $(this)
				.keyup(function() {
					if (typeof el == "undefined")
						this.el = $(this);
					var s = getPasswordStrength(this.value);
					var p = this.percents;
					var t = Math.floor(s / p);

					if (100 <= s)
						t = this.opts.classes.length - 1;

					this.div
						.removeAttr('class')
						.addClass(this.defaultClass)
						.addClass(this.opts.classes[t]);

				})
				.next()
				.click(function() {
					$(this).prev().val(randomPassword()).trigger('keyup');
					return false;
				});
		});
		function getPasswordStrength(H) {
			var D = (H.length);
			if (D > 5) {
				D = 5
			}
			var F = H.replace(/[0-9]/g, "");
			var G = (H.length - F.length);
			if (G > 3) {
				G = 3
			}
			var A = H.replace(/\W/g, "");
			var C = (H.length - A.length);
			if (C > 3) {
				C = 3
			}
			var B = H.replace(/[A-Z]/g, "");
			var I = (H.length - B.length);
			if (I > 3) {
				I = 3
			}
			var E = ((D * 10) - 20) + (G * 10) + (C * 15) + (I * 10);
			if (E < 0) {
				E = 0
			}
			if (E > 100) {
				E = 100
			}
			return E
		}
		function randomPassword() {
			var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$_+";
			var size = 10;
			var i = 1;
			var ret = ""
			while (i <= size) {
				$max = chars.length - 1;
				$num = Math.floor(Math.random() * $max);
				$temp = chars.substr($num, 1);
				ret += $temp;
				i++;
			}
			return ret;
		}
	};
	$.fn.passwordStrength.defaults = {
		classes: Array('is10', 'is20', 'is30', 'is40', 'is50', 'is60', 'is70', 'is80', 'is90', 'is100'),
		targetDiv: '#passwordStrengthDiv',
		cache: {}
	}
	$(document)
		.ready(function() {
			$('input[name="dt_password"]').passwordStrength();
			$('input[name="dt_password"]').passwordStrength({
				targetDiv: '#passwordStrengthDiv',
				classes: Array('is10', 'is20', 'is30', 'is40', 'is50', 'is60', 'is70', 'is80', 'is90', 'is100')
			});
		});
	</script>

<?php 
	$color1 = get_option('color1');
	$color2 = get_option('color2');
?>
<style>
body{background:<?php echo $color2; ?>}
a{color: <?php echo $color1; ?>}
.form_dt_user fieldset input[type="submit"]{background:<?php echo $color1; ?>}
.text_ft{color: #fff;}
</style>

</head>
<body>
<div class="container">
	<div class="dt_box <?php if($_GET['action']=='log-in') { echo "login"; } ?>">
	<div class="logo">
		<a href="<?php echo esc_url( home_url() ); ?>/">
			<img src="<?php if($logo = get_option('dt_logo')) { echo $logo; } else { echo get_template_directory_uri(). '/assets/img/dooplay_.png'; } ?>">
		</a>
	</div>