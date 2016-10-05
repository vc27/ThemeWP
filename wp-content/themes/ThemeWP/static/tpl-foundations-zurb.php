<?php
/**
 * Template Name: Foundations Zurb
 * @package WordPress
 * @subpackage ThemeWP
 *
 **/
#################################################################################################### */

get_template_part( 'header-head' );

?>
<!-- Start Body -->
<body <?php body_class(); echo apply_filters( 'tag_body_attr', '' ); ?>>
<?php do_action('after_body_tag'); ?>

<div class="row">
	<div class="large-3 columns">
		<h5>Medium</h5>
		<span class="secondary label">.text-medium</span>
		<p class="text-medium">Nunc tempus libero vel maximus ullamcorper. Ut consectetur ut nisi at rhoncus. Duis molestie neque et commodo venenatis. Donec et malesuada lectus. Morbi vitae rutrum arcu. Etiam sem eros, commodo nec ipsum quis, sagittis finibus odio. Donec vitae tellus et arcu fringilla rutrum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc aliquet ac elit vitae tempus. Proin ut nibh fermentum, interdum lacus sed, tristique nulla. Aliquam venenatis, lectus id gravida luctus, lectus velit placerat lacus, quis faucibus enim ipsum a mauris. Sed tempor sed lorem quis euismod. In malesuada scelerisque quam ornare facilisis.</p>
	</div>
	<div class="large-3 columns">
		<h5>Normal</h5>
		<span class="secondary label">no class</span>
		<p>Nunc tempus libero vel maximus ullamcorper. Ut consectetur ut nisi at rhoncus. Duis molestie neque et commodo venenatis. Donec et malesuada lectus. Morbi vitae rutrum arcu. Etiam sem eros, commodo nec ipsum quis, sagittis finibus odio. Donec vitae tellus et arcu fringilla rutrum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc aliquet ac elit vitae tempus. Proin ut nibh fermentum, interdum lacus sed, tristique nulla. Aliquam venenatis, lectus id gravida luctus, lectus velit placerat lacus, quis faucibus enim ipsum a mauris. Sed tempor sed lorem quis euismod. In malesuada scelerisque quam ornare facilisis.</p>
	</div>
	<div class="large-3 columns">
		<h5>Small</h5>
		<span class="secondary label">.text-small</span>
		<p class="text-small">Nunc tempus libero vel maximus ullamcorper. Ut consectetur ut nisi at rhoncus. Duis molestie neque et commodo venenatis. Donec et malesuada lectus. Morbi vitae rutrum arcu. Etiam sem eros, commodo nec ipsum quis, sagittis finibus odio. Donec vitae tellus et arcu fringilla rutrum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc aliquet ac elit vitae tempus. Proin ut nibh fermentum, interdum lacus sed, tristique nulla. Aliquam venenatis, lectus id gravida luctus, lectus velit placerat lacus, quis faucibus enim ipsum a mauris. Sed tempor sed lorem quis euismod. In malesuada scelerisque quam ornare facilisis.</p>
	</div>
	<div class="large-3 columns">
		<h5>Extra Small</h5>
		<span class="secondary label">.text-small-ex</span>
		<p class="text-small-ex">Nunc tempus libero vel maximus ullamcorper. Ut consectetur ut nisi at rhoncus. Duis molestie neque et commodo venenatis. Donec et malesuada lectus. Morbi vitae rutrum arcu. Etiam sem eros, commodo nec ipsum quis, sagittis finibus odio. Donec vitae tellus et arcu fringilla rutrum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc aliquet ac elit vitae tempus. Proin ut nibh fermentum, interdum lacus sed, tristique nulla. Aliquam venenatis, lectus id gravida luctus, lectus velit placerat lacus, quis faucibus enim ipsum a mauris. Sed tempor sed lorem quis euismod. In malesuada scelerisque quam ornare facilisis.</p>
	</div>
</div>

<hr />

<div class="row">
	<div class="large-12 columns">
		<h5>Grid</h5>
		<p>
			<a target="_blank" href="http://foundation.zurb.com/sites/docs/grid.html">http://foundation.zurb.com/sites/docs/grid.html</a>
		</p>
	</div>
</div>

<hr />

<div class="row">
	<div class="large-12 columns">
		<h5>Buttons</h5>
		<p>
			<button type="button" class="button">.button</button>
			<button type="button" class="success button">.success .button</button>
			<button type="button" class="alert button">.alert .button</button>
		</p>
		<p>
			<a class="tiny button" href="#">.tiny .button</a>
			<a class="small button" href="#">.small .button</a>
			<a class="button" href="#">.button</a>
			<a class="large button" href="#">.large .button</a>
			<a class="expanded button" href="#">.expanded .button</a>
			<a class="small expanded button" href="#">.small .expanded .button</a>
		</p>
		<p>
			<a class="secondary button" href="#">.secondary .button</a>
			<a class="success button" href="#">.success .button</a>
			<a class="alert button" href="#">.alert .button</a>
			<a class="warning button" href="#">.warning .button</a>
			<a class="disabled button" href="#">.disabled .button</a>
		</p>
		<p>
			<button class="hollow button" href="#">.hollow .button</button>
			<button class="secondary hollow button" href="#">.secondary .hollow .button</button>
			<button class="success hollow button" href="#">.success .hollow .button</button>
			<button class="alert hollow button" href="#">.alert .hollow .button</button>
			<button class="warning hollow button" href="#">.warning .hollow .button</button>
		</p>
		<h6>Other button references</h6>
		<p>
			<a href="http://foundation.zurb.com/sites/docs/button-group.html">Button Group</a>
		</p>
	</div>
</div>

<hr />

<div class="row">
	<div class="large-12 columns">
		<h5>Labels</h5>
		<p>Use these when you want the color block with out the button hover</p>
		<p>
			<span class="secondary label">Secondary Label</span>
			<span class="success label">Success Label</span>
			<span class="alert label">Alert Label</span>
			<span class="warning label">Warning Label</span>
		</p>
	</div>
</div>

<hr />

<div class="row">
	<div class="large-12 columns">
		<h5>Badge</h5>
		<span class="secondary badge">2</span>
		<span class="success badge">3</span>
		<span class="alert badge">A</span>
		<span class="warning badge">B</span>
	</div>
</div>

<hr />

<div class="row">
	<div class="large-6 columns">
		<h1>h1. This is a very large header.</h1>
		<h2>h2. This is a large header.</h2>
		<h3>h3. This is a medium header.</h3>
		<h4>h4. This is a moderate header.</h4>
		<h5>h5. This is a small header.</h5>
		<h6>h6. This is a tiny header.</h6>
	</div>
	<div class="large-6 columns">
		<h1 class="subheader">h1.subheader</h1>
		<h2 class="subheader">h2.subheader</h2>
		<h3 class="subheader">h3.subheader</h3>
		<h4 class="subheader">h4.subheader</h4>
		<h5 class="subheader">h5.subheader</h5>
		<h6 class="subheader">h6.subheader</h6>
	</div>
</div>

<hr />

<div class="row">
	<div class="large-6 columns">
		<h5>List</h5>
		<ul>
			<li>List item with a much longer description or more content.</li>
			<li>List item</li>
			<li>List item
				<ul>
					<li>Nested list item</li>
					<li>Nested list item</li>
					<li>Nested list item</li>
				</ul>
			</li>
			<li>List item</li>
			<li>List item</li>
			<li>List item</li>
		</ul>
	</div>
	<div class="large-6 columns">
		<h5>Definition Lists</h5>
		<dl>
			<dt>Time</dt>
			<dd>The indefinite continued progress of existence and events in the past, present, and future regarded as a whole.</dd>
			<dt>Space</dt>
			<dd>A continuous area or expanse that is free, available, or unoccupied.</dd>
			<dd>The dimensions of height, depth, and width within which all things exist and move.</dd>
		</dl>
	</div>
</div>

<hr />

<div class="row">
	<div class="large-12 columns">
		<h5>blockquote</h5>
		<blockquote>
			Those people who think they know everything are a great annoyance to those of us who do.
			<cite>Isaac Asimov</cite>
		</blockquote>
	</div>
</div>

<hr />

<div class="row">
	<div class="large-12 columns">
		<h5>forms</h5>
		<div class="row">
			<div class="large-6 columns end">
				<form>
					<div class="row">
						<div class="medium-6 columns">
							<label>Input Label
								<input type="text" placeholder=".medium-6.columns">
							</label>
						</div>
						<div class="medium-6 columns">
							<label>Input Label
								<input type="text" placeholder=".medium-6.columns">
							</label>
						</div>
					</div>
					<label>
						What books did you read over summer break?
						<textarea placeholder="None"></textarea>
					</label>
					<label>Select Menu
						<select>
							<option value="husker">Husker</option>
							<option value="starbuck">Starbuck</option>
							<option value="hotdog">Hot Dog</option>
							<option value="apollo">Apollo</option>
						</select>
					</label>
					<div class="row">
						<fieldset class="large-6 columns">
							<legend>Choose Your Favorite</legend>
							<input type="radio" name="pokemon" value="Red" id="pokemonRed" required><label for="pokemonRed">Red</label>
							<input type="radio" name="pokemon" value="Blue" id="pokemonBlue"><label for="pokemonBlue">Blue</label>
							<input type="radio" name="pokemon" value="Yellow" id="pokemonYellow"><label for="pokemonYellow">Yellow</label>
						</fieldset>
						<fieldset class="large-6 columns">
							<legend>Check these out</legend>
							<input id="checkbox1" type="checkbox"><label for="checkbox1">Checkbox 1</label>
							<input id="checkbox2" type="checkbox"><label for="checkbox2">Checkbox 2</label>
							<input id="checkbox3" type="checkbox"><label for="checkbox3">Checkbox 3</label>
						</fieldset>
					</div>
					<fieldset class="fieldset">
						<legend>Check these out</legend>
						<input id="checkbox12" type="checkbox"><label for="checkbox12">Checkbox 1</label>
						<input id="checkbox22" type="checkbox"><label for="checkbox22">Checkbox 2</label>
						<input id="checkbox32" type="checkbox"><label for="checkbox32">Checkbox 3</label>
					</fieldset>
					<label>Password
						<input type="password" aria-describedby="passwordHelpText">
					</label>
					<p class="help-text" id="passwordHelpText">Your password must have at least 10 characters, a number, and an Emoji.</p>
					<div class="input-group">
						<input class="input-group-field" type="text">
						<div class="input-group-button">
							<input type="submit" class="button" value="Submit">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<hr />

<div class="row">
	<div class="large-12 columns">
		<div class="callout" data-closable>
			<p>You can so totally close this!</p>
			<button class="close-button" aria-label="Dismiss alert" type="button" data-close>
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	</div>
</div>

<hr />

<div class="row">
	<div class="large-12 columns">
		<h5>Navigation</h5>
		<ul class="menu">
			<li><a href="#">Item One</a></li>
			<li><a href="#">Item Two</a></li>
			<li><a href="#">Item Three</a></li>
		</ul>
	</div>
</div>

<hr />

<div class="row">
	<div class="large-12 columns">
		<h5>Breadcrumbs</h5>
		<nav aria-label="You are here:" role="navigation">
			<ul class="breadcrumbs">
				<li><a href="#">Home</a></li>
				<li><a href="#">Features</a></li>
				<li class="disabled">Gene Splicing</li>
				<li>
					<span class="show-for-sr">Current: </span> Cloning
				</li>
			</ul>
		</nav>
	</div>
</div>

<hr />

<div class="row">
	<div class="large-12 columns">
		<h5>Callouts</h5>
		<div class="callout primary">
			<h5>.callout .primary</h5>
			<p>Nulla aliquet urna massa, non fermentum tortor semper non.</p>
		</div>
		<div class="callout secondary">
			<h5>.callout .secondary</h5>
			<p>Nulla aliquet urna massa, non fermentum tortor semper non.</p>
		</div>
		<div class="callout success">
			<h5>.callout .success</h5>
			<p>Nulla aliquet urna massa, non fermentum tortor semper non.</p>
		</div>
		<div class="callout warning">
			<h5>.callout .warning</h5>
			<p>Nulla aliquet urna massa, non fermentum tortor semper non.</p>
		</div>
		<div class="callout alert">
			<h5>.callout .alert</h5>
			<p>Nulla aliquet urna massa, non fermentum tortor semper non.</p>
		</div>
		<div class="callout primary large">
			<h5>.callout .primary .large</h5>
			<p>Nulla aliquet urna massa, non fermentum tortor semper non.</p>
		</div>
	</div>
</div>

<div class="row">
	<div class="large-12 columns"></div>
</div>

<?php wp_footer(); ?>
</body>
</html>
