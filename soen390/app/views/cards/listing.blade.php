<!DOCTYPE HTML>
<html>
	<head>
    </head>
    <body>
        <header>
            <h1>Vous Déliberez</h1>
        </header>
        <div id="view_selection" class="buttons">
            <a href="#" id="lang_english" class="button" onclick="toggleLanguages('French')">English</a>
            <a href="#" id="lang_french" class="button" onclick="toggleLanguages('English')">French</a>
            <a href="#" id="position" class="button" onclick="filterByPosition()">Position</a>
            <a href="#" id="thumbs" class="button">Thumbs</a>
            <a href="#" id="popularity" class="button">Popularity</a>
        </div>
        
        <!--This is where the animations happen. Controlled by the JS file-->
        <div id="view">
        </div>

        <script src="{{ asset('js/animations.js') }}"></script>
        <script src="//d3js.org/d3.v3.min.js" charset="utf-8"></script>
        <script src="{{ asset('js/LanguageFilter.js') }}"></script>
        <script src="{{ asset('js/PositionFilter.js') }}"></script>
        <script>initiate();</script>
    </body>
</html>
