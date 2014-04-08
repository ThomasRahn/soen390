<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>You Deliberate</title>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap/3.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdn.jsdelivr.net/fontawesome/4.0.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Cinzel|Roboto:300,300italic,400,400italic|Roboto+Condensed:300,400,700">
        <style>
            body {
                padding-bottom: 70px;
                font-family: Roboto, "Helvetica Neue", Helvetica, Arial, sans-serif;
                font-weight: 400;
            }
            header {
                border-bottom: 1px solid #e5e5e5;
                margin-bottom: 20px;
            }
            h1.brand {
                font-family: Cinzel, Garamond, "Times New Roman", serif;
                font-weight: 400;
                text-transform: uppercase;
                letter-spacing: 5px;
                padding-bottom: 10px;
                color: #ccc;
                -webkit-text-stroke: 0.2px;
                text-stroke: 0.2px;
            }
            #filter-nav button {
                text-transform: uppercase;
                font-family: "Roboto Condensed", "Helvetica Neue", Helvetica, "Arial Narrow", "Arial", sans-serif;
                font-weight: 300;
            }
            #stance-heading {
                display: none;
            }
            #stance-heading span {
                position: absolute;
                margin-top: 20px;
                font-size: 32px;
                -webkit-text-stroke: 0.2px;
                text-stroke: 0.2px;
            }
            #yay-stance-heading {
                left: 25%;
            }
            #meh-stance-heading {
                left: 50%;
            }
            #nay-stance-heading {
                left: 75%;
            }
            .meta-container {
                display: none;
                -webkit-transition-duration: 0.5s;
                transition-duration: 0.5s;
            }
            .ratio-bar-container {
                width: 100%;
                height: 5px;
                margin-top: 5px;
                background-color: #ccc;
                border-radius: 5px;
                box-shadow: 0 0 2px 0 #888 inset;
            }
            .ratio-bar {
                height: 100%;
                width: 25%;
                float: left;
            }
            .ratio-bar:first-of-type {
                -webkit-border-top-left-radius: 5px;
                -webkit-border-bottom-left-radius: 5px;
                   -moz-border-radius-topleft: 5px;
                   -moz-border-radius-bottomleft: 5px;
                        border-top-left-radius: 5px;
                        border-bottom-left-radius: 5px;
            }
            .ratio-bar.agrees {
                background-color: #0c8;
            }
            .ratio-bar.disagrees {
                background-color: #08d;
            }
            .narrative-ratios {
                text-align: center;
                font-family: "Roboto Condensed", Helvetica, "Arial Narrow", "Arial", sans-serif;
                font-weight: 400;
            }
            .narrative-ratios .agrees {
                color: #093;
            }
            .narrative-ratios .disagrees {
                color: #08d;
            }
            .narrative-radios .indifferent {
                color #333;
            }
            .current-topic {
                padding-left: 3px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <header class="row">
                <h1 class="brand text-center">You <i class="fa fa-comments"></i> Deliberate</h1>
            </header>

            <nav id="filter-nav" class="row">
                <div class="col-sm-6">
                    <div class="btn-group btn-group-sm lang-btn-group">
                        <button type="button" class="btn btn-default" data-lang="en" data-toggle="tooltip" data-placement="bottom" title="Highlight English Narratives"><img src="img/gb.png"> EN</button>
                        <button type="button" class="btn btn-default" data-lang="fr" data-toggle="tooltip" data-placement="bottom" title="Highlight French Narratives"><img src="img/fr.png"> FR</button>
                    </div>

                    <button type="button" class="btn btn-sm btn-default stance-btn" data-toggle="tooltip" data-placement="bottom" title="Separate Narratives by Opinion">
                        <i class="fa fa-thumbs-o-up fa-fw"></i>
                        <i class="fa fa-thumbs-o-down fa-fw"></i>
                        <span class="stance">Stance</span>
                    </button>

                    <button type="button" class="btn btn-sm btn-default popularity-btn" data-toggle="tooltip" data-placement="bottom" title="Organize Narratives by Number of Views">
                        <i class="fa fa-signal fa-fw"></i>
                        <span class="popularity">Popularity</span>
                    </button>

                    <button type="button" class="btn btn-sm btn-default agree-disagree-btn" data-toggle="tooltip" data-placement="bottom" title="Show Agree/Disagree Split">
                        <i class="fa fa-thumbs-up fa-fw"></i>
                        <i class="fa fa-thumbs-down fa-fw"></i>
                        <span class="agree-disagree">Agree/Disagree</span>
                    </button>
                </div>

                <div class="col-sm-6">
                    <div class="dropdown pull-right topic-dropdown en">
                        <button class="btn btn-sm btn-default dropdown-toggle" type="button" id="topic-dropdown" data-toggle="dropdown">
                            <i class="fa fa-level-down"></i>
                            <span class="current-topic">{{{ $selectedTopic->translations()->inLocale('en')->first()->translation }}}</span>
                        </button>

                        <ul class="dropdown-menu topic-list" role="menu">
                            @foreach ($topics as $t)
                            <li><a href="/?topic={{{ $t->TopicID }}}"><i class="fa fa-fw fa-caret-right"></i> {{{ $t->translations()->inLocale('en')->first()->translation }}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="dropdown pull-right topic-dropdown fr">
                        <button class="btn btn-sm btn-default dropdown-toggle" type="button" id="topic-dropdown" data-toggle="dropdown">
                            <i class="fa fa-level-down"></i>
                            <span class="current-topic">{{{ $selectedTopic->translations()->inLocale('fr')->first()->translation }}}</span>
                        </button>

                        <ul class="dropdown-menu topic-list" role="menu">
                            @foreach ($topics as $t)
                            <li><a href="/?topic={{{ $t->TopicID }}}"><i class="fa fa-fw fa-caret-right"></i> {{{ $t->translations()->inLocale('fr')->first()->translation }}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

        <section id="cards-container">
    		<div id="stance-heading">
    			<span id="yay-stance-heading" class="text-muted"><i class="fa fa-thumbs-o-up"></i></span>
    			<span id="meh-stance-heading" class="text-muted"><i class="fa fa-ellipsis-h"></i></span>
    			<span id="nay-stance-heading" class="text-muted"><i class="fa fa-thumbs-o-down"></i></span>
    		</div>
        </section>

        <div class="container">
            <div class="row">
                <div class="col-sm-5 meta-container" style="margin:0 auto; float:none;">
                    <div class="row-fluid">
                        <div class="ratio-bar-container">
                            <div class="ratio-bar agrees"></div>
                            <div class="ratio-bar disagrees"></div>
                        </div>
                    </div>
                    <div class="row-fluid narrative-ratios">
                        <div class="col-md-6"><span class="agrees">Agrees</span> <span class="agrees-percent">25</span></div>
                        <div class="col-md-6"><span class="disagrees">Disagrees</span> <span class="disagrees-percent">25</span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <footer class="navbar navbar-fixed-bottom">
                <p class="text-center text-muted" style="text-transform:uppercase"><small>&mdash; <a class="text-muted" href="mailto:{{ Configuration::get('supportEmail') }}" title="Email us for support."><i class="fa fa-envelope-o"></i></a> &mdash;</small></p><iframe id="konami" style="display:none"></iframe>
            </footer>
        </div>

        <!-- Guavascripts -->
        <script src="//cdn.jsdelivr.net/jquery/2.1.0/jquery.min.js"></script>
        <script src="//cdn.jsdelivr.net/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script src="//cdn.jsdelivr.net/d3js/3.3.9/d3.min.js"></script>
        <script src="//cdn.jsdelivr.net/konami.js/1.4.2/konami.min.js"></script>
        <script src="{{ asset('js/d3animate.js') }}"></script>
        <script src="{{ asset('js/dictionary.js') }}"></script>
        <script>
            var currentLanguage = 'fr',
                konamiMode      = false,
                stanceGravityCenters = 
                {
                    'For': 
                        { x: (width / 4),
                          y: (height / 2) 
                        },

                    'Indifferent':
                        { 
                          x: (width / 2),
                          y: (height / 2)
                        },
                    'Against': { x: (2.83 * (width / 4)), y: (height / 2) }
                };

            /**
             * Set narrative thumbnail sizing based on number of views.
             *
             * @param enable boolean
             */
            function setSizeByViews(enable) {
                var narrative_ids = [];
                viewFilter = enable;
                var debug = true;
                rectangles.selectAll(".child").transition()
                          .duration(750)
                          .attr('width', function(node) {

                            if (enable){
                                var width = 0;
                                if (!debug)
                                {
                                    var increment = (node.views / z) *1.5;
                                    width = getWidth(node.id) + increment;
                                 }
                                 else
                                 {
                                     var z = totalViews / numberOfNarr;
                                     var y = node.views / z;
                                     width = node.width + y;
                                 }
                                return width;
                            }

                            return stdThumbW;
                          })
                          .attr('height', function(node) {
                            if (enable){
                                var height = 0;
                                if (!debug)
                                {
                                    var increment = (node.views / z) *1.5;
                                    var increment = (node.views / z) *1.5;
                                    height = getHeight(node.id) + increment;
                                    narrative_ids[node.id] = height;
                                }
                                else
                                {
                                    var z = totalViews / numberOfNarr;
                                    var y = node.views / z;
                                    height = node.width + y;
                                }
                                narrative_ids[node.id] = height;
                                return height;
                            }
                            narrative_ids[node.id] = stdThumbH;
                            return stdThumbH;
                          });

                    rectangles.selectAll(".agree").transition()
                          .duration(300)
                          .attr('width', function(node) {
                            var likes = parseInt(node.yays);
                            var dislikes = parseInt(node.nays);
                            var numberOfVotes = (likes + dislikes == 0 ? 1 : likes + dislikes);
                            var dislikesRatio = dislikes / numberOfVotes;
                            if (enable){
                                //var tempW = getWidth(node.id);
                                var tempW = narrative_ids[node.id];
                                var dislikesRectangleWidth = (dislikesRatio * tempW) + (likes / numberOfVotes) * tempW;
                                return dislikesRectangleWidth;
                            }
                            var dislikesRectangleWidth = (dislikesRatio * stdThumbW) + (likes / numberOfVotes) * stdThumbW;
                            return dislikesRectangleWidth;
                          })
                          .attr('height', function(node) {
                            return  narrative_ids[node.id] * 0.1;
                            //return getHeight(node.id) * 0.10;
                          })
                          .attr("y", function(node){
                            return narrative_ids[node.id] * 0.9;
                          });

                   rectangles.selectAll(".disagree").transition()
                          .duration(300)
                          .attr('width', function(node) {
                            var likes = parseInt(node.yays);
                            var dislikes = parseInt(node.nays);
                            var numberOfVotes = (likes + dislikes == 0 ? 1 : likes + dislikes);
                            var likesRatio = likes / numberOfVotes;
                            if (enable){
                                //var tempW = getWidth(node.id);
                                var tempW = narrative_ids[node.id];
                                var dislikesRectangleWidth = likesRatio * tempW;
                                return dislikesRectangleWidth;
                            }
                            var likesRectangleWidth = likesRatio * stdThumbW;
                            return likesRectangleWidth;
                          })
                          .attr('height', function(node) {
                            return  narrative_ids[node.id] * 0.1;
                            //return getHeight(node.id) * 0.10;
                          })
                          .attr("y", function(node){
                            return narrative_ids[node.id] * 0.9;
                          });

                force.gravity(layoutGravity)
                     .charge(charge)
                     .friction(0.9);
                force.start();
            }

            /**
            * Translate all text on page based on given language code.
            *
            * @param langCode string
            */
            function setTranslation(langCode)
            {
                // Hide the opposite language.
                $('.' + currentLanguage).css('display', 'none');
                $('.' + langCode).css('display', '');
                
                // Set Current Language
                currentLanguage = langCode;

                // Set Branding
                $('.brand').html(dictionary[langCode].brand);
                document.title = dictionary[langCode].brandText;

                // Set Stance
                $('.stance').html(dictionary[langCode].stance);

                // Set Popularity
                $('.popularity').html(dictionary[langCode].popularity);

                $(".agree-disagree").html(dictionary[langCode].agreeDisagree)
                // Set Spaghetti
                $('.spaghetti').html(dictionary[langCode].spaghetti);

                // Agree/Disagree/Indifferent
                $('span.agrees').html(dictionary[langCode].agrees);
                $('span.disagrees').html(dictionary[langCode].disagrees);
                $('span.indifferent').html(dictionary[langCode].indifferent);

                // Language
                $('span.language').html(dictionary[langCode].language);
            }

            /**
            * Filter narratives based on language depending on given language code.
            *
            * @param langCode string
            */
            function setLanguageFilter(langCode)
            {
                var lang = null;

                if (langCode == "en") lang = "English";

                if (langCode == "fr") lang = "French";

                rectangles.transition()
                          .duration(500)
                          .style('opacity', function (node)
                          {
                              return (lang === null || lang === node.lang) ? 1 : 0.2;
                          });
            }
            /**
            * Sort narratives on page based on narrative stance value.
            *
            * @param enableSort boolean
            */
            function setStanceSorting(enableSort)
            {
                force.gravity(layoutGravity)
                     .charge(charge)
                //.charge(function(node) { return charge(node) - 250; })
                     .friction(0.9)
                     .on('tick', function (e)
                     {
                         var q = d3.geom.quadtree(nodes);
                         var i = 0;
                         var n = nodes.length;
                         while (++i < n) q.visit(collide(nodes[i]));

                         rectangles.attr("transform", function (d)
                         {
                             var target = (enableSort ? stanceGravityCenters[d.stance] : center);

                             d.x = d.x + (target.x - d.x) * (damper + 0.02) * e.alpha;
                             d.y = d.y + (target.y - d.y) * (damper + 0.02) * e.alpha;
                             
                             return "translate(" + d.x + "," + d.y + ")";
                         });

                         rectangles.selectAll("circle")
                                .attr("cx", function (d) { return d.centerX; })
                                .attr("cy", function (d) { return d.centerY; });
                     });

                force.start();

                if (enableSort)
                    $('#stance-heading').css('display', 'block');
                else
                    $('#stance-heading').css('display', 'none');
            }

            function showBar(enable)
            {
                if (enable)
                {
                    rectangles.selectAll(".rect")
                        .style("display", "block");
                }
                else
                {
                    rectangles.selectAll(".rect")
                        .style("display", "none");
                }
            }

            function printObject(o)
            {
                var out = '';
                for (var p in o)
                {
                    out += p + ': ' + o[p] + '\n';
                }
                alert(out);
            }

            $(document).ready(function ()
            {
                $('button').tooltip({ 'container': 'body' });

                // Set default language to load.
                setTranslation('en');

                // Show cards
                initializeCards();

                $('input, button').focus(function ()
                {
                    this.blur();
                });

                /**
                * Handle button click for language filter.
                */
                $('.lang-btn-group button').click(function (e)
                {
                    // Check if the user wants to deselect the language filter.
                    if ($(this).hasClass('active'))
                    {
                        $(this).removeClass('active');
                        setLanguageFilter(null);
                    } else
                    {
                        // Set translation
                        setTranslation($(this).data('lang'));

                        // Set filter
                        setLanguageFilter(currentLanguage);

                        // Set button active
                        $('.lang-btn-group button').removeClass('active');
                        $(this).addClass('active');
                    }
                });

                /**
                * Handle button click for stance filter.
                */
                $('.stance-btn').click(function (e)
                {
                    if ($(this).hasClass('active'))
                    {
                        $(this).removeClass('active');
                        setStanceSorting(false);
                    } else
                    {
                        $(this).addClass('active');
                        setStanceSorting(true);

                    }
                });

                /**
                * Handle button click for popularity transformation.
                */
                $('.popularity-btn').click(function (e)
                {
                    if ($(this).hasClass('active'))
                    {
                        $(this).removeClass('active');
                        setSizeByViews(false);
                    } else
                    {
                        $(this).addClass('active');
                        setSizeByViews(true);
                    }

                });
                $(".agree-disagree-btn").click(function (e)
                {
                    if ($(this).hasClass('active'))
                    {
                        $(this).removeClass('active');
                        showBar(false);
                    } else
                    {
                        $(this).addClass('active');
                        showBar(true);
                    }
                });

                // Handle Konami code.
                var konami = new Konami(function ()
                {
                    if (konamiMode)
                    {
                        document.getElementById('konami').src = 'about:blank';
                        $('.spaghetti').html(dictionary[currentLanguage].spaghetti);
                        konamiMode = false;
                    } else
                    {
                        document.getElementById('konami').src = 'http://momspaghetti.ytmnd.com/';
                        $('.spaghetti').html(dictionary[currentLanguage].momSpaghetti);
                        konamiMode = true;
                    }
                });

                $('.topic-dropdown').on('show.bs.dropdown', function(e){
                    $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
                });

                // ADD SLIDEUP ANIMATION TO DROPDOWN //
                $('.topic-dropdown').on('hide.bs.dropdown', function(e){
                    $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
                });

            });
        </script>

        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-48518812-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
    </body>
</html>
