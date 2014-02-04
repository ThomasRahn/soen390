<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>You Deliberate</title>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap/3.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdn.jsdelivr.net/fontawesome/4.0.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Crete+Round|Lato:300,400">
        <style>
            body {
                padding-bottom: 70px;
                font-family: "Lato", "Helvetica Neue", Helvetica, sans-serif;
                font-weight: 400;
            }
            header {
                border-bottom: 1px solid #ccc;
                margin-bottom: 20px;
            }
            h1.brand {
                font-family: "Crete Round", "Garamond", "Times New Roman", serif;
                font-weight: 400;
                text-transform: uppercase;
                letter-spacing: 5px;
                padding-bottom: 10px;
                color: #b5b5b5;
                -webkit-text-stroke: 0.2px;
                text-stroke: 0.2px;
            }
            #filter-nav button {
                text-transform: uppercase;
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
                        <button type="button" class="btn btn-default" data-lang="en"><img src="img/gb.png"></button>
                        <button type="button" class="btn btn-default" data-lang="fr"><img src="img/fr.png"></button>
                    </div>

                    <button type="button" class="btn btn-sm btn-default stance-btn"><i class="fa fa-thumbs-up"></i> <span class="stance">Stance</span> <i class="fa fa-thumbs-down"></i></button>

                    <button type="button" class="btn btn-sm btn-default popularity-btn"><i class="fa fa-signal"></i> <span class="popularity">Popularity</span></button>
                </div>
            </nav>
        </div>

        <section id="cards-container">
		<div id="stance-heading">
			<span id="yay-stance-heading" class="text-muted"><i class="fa fa-smile-o"></i></span>
			<span id="meh-stance-heading" class="text-muted"><i class="fa fa-meh-o"></i></span>
			<span id="nay-stance-heading" class="text-muted"><i class="fa fa-frown-o"></i></span>
		</div>
        </section>

        <div class="container">
            <footer class="navbar navbar-fixed-bottom">
                <p class="text-center text-muted" style="text-transform:uppercase"><small>&mdash; <a class="text-muted" href="mailto:support@youdeliberate.org" title="Email us for support."><i class="fa fa-envelope-o"></i></a> &mdash;</small></p><iframe id="konami" style="display:none"></iframe>
            </footer>
        </div>

        <!-- Guavascripts -->
        <script src="//cdn.jsdelivr.net/jquery/2.1.0/jquery.min.js"></script>
        <script src="//cdn.jsdelivr.net/d3js/3.3.9/d3.min.js"></script>
        <script src="//cdn.jsdelivr.net/konami.js/1.4.2/konami.min.js"></script>
        <script src="{{ asset('js/d3animate.js') }}"></script>
        <script src="{{ asset('js/dictionary.js') }}"></script>
        <script>
            var currentLanguage = '',
                narrativeSource = '/api/narrative',
                konamiMode      = false,
                stanceGravityCenters  = {
                    'yay': { x: (width / 4), y: (height / 2) },
                    'meh': { x: (width / 2), y: (height / 2) },
                    'nay': { x: (2.83 * (width / 4)), y: (height / 2) }
                };

            /**
             * Translate all text on page based on given language code.
             *
             * @param langCode string
             */
            function setTranslation(langCode) {
                // Set Current Language
                currentLanguage = langCode;

                // Set Branding
                $('.brand').html(dictionary[langCode].brand);
                document.title = dictionary[langCode].brandText;

                // Set Stance
                $('.stance').html(dictionary[langCode].stance);

                // Set Popularity
                $('.popularity').html(dictionary[langCode].popularity);

                // Set Spaghetti
                $('.spaghetti').html(dictionary[langCode].spaghetti);
            }

            /**
             * Filter narratives based on language depending on given language code.
             *
             * @param langCode string
             */
            function setLanguageFilter(langCode) {
                rectangles.transition()
                          .duration(750)
                          .style('opacity', function(node) {
                              return (langCode === null || langCode === node.lang) ? 1 : 0.2;
                          });
            }

            /**
             * Sort narratives on page based on narrative stance value.
             *
             * @param enableSort boolean
             */
            function setStanceSorting(enableSort) {
                force.gravity(layoutGravity)
                     .charge(charge)
                     .friction(0.9)
                     .on('tick', function(e) {
                        return rectangles.each(function(node) {
                                                var target = (enableSort ? stanceGravityCenters[node.stance] : center);
                                                node.x = node.x + (target.x - node.x) * (damper + 0.02) * e.alpha;
                                                node.y = node.y + (target.y - node.y) * (damper + 0.02) * e.alpha;
                                              })
                                         .attr('x', function(node){return node.x})
                                         .attr('y', function(node){return node.y});
                     });

                force.start();

                if (enableSort)
                    $('#stance-heading').css('display', 'block');
                else
                    $('#stance-heading').css('display', 'none');
            }

            /**
             * Set narrative thumbnail sizing based on number of views.
             *
             * @param enable boolean
             */
            function setSizeByViews(enable) {
                rectangles.transition()
                          .duration(750)
                          .attr('width', function(node) {
                            if (enable)
                                return parseInt(node.views) * 10 + 30;

                            return stdThumbW;
                          })
                          .attr('height', function(node) {
                            if (enable)
                                return parseInt(node.views) * 10 + 30;

                            return stdThumbH;
                          });

                force.gravity(layoutGravity)
                     .charge(function(node) {
                        if (enable)
                            return -Math.pow(parseInt(node.views) * 10 + 30, 2.0) / 8;

                        return -Math.pow(stdThumbW, 2.0) / 8;
                     })
                     .friction(0.9);

                force.start();
            }

            $(document).ready(function() {
                // Set default language to load.
                setTranslation('en');

                // Show cards
                initializeCards();

                $('input, button').focus(function() {
                    this.blur();
                });

                /**
                 * Handle button click for language filter.
                 */
                $('.lang-btn-group button').click(function(e) {
                    // Check if the user wants to deselect the language filter.
                    if ($(this).hasClass('active')) {
                        $(this).removeClass('active');
                        setLanguageFilter(null);
                    } else {
                        // Set translation
                        setTranslation( $(this).data('lang') );

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
                $('.stance-btn').click(function(e) {
                    if ($(this).hasClass('active')) {
                        $(this).removeClass('active');
                        setStanceSorting(false);
                    } else {
                        $(this).addClass('active');
                        setStanceSorting(true);
                    }
                });

                /**
                 * Handle button click for popularity transformation.
                 */
                $('.popularity-btn').click(function(e) {
                    if ($(this).hasClass('active')) {
                        $(this).removeClass('active');
                        setSizeByViews(false);
                    } else {
                        $(this).addClass('active');
                        setSizeByViews(true);
                    }
                });

                // Handle Konami code.
                var konami = new Konami(function() {
                    if (konamiMode) {
                        document.getElementById('konami').src = 'about:blank';
                        $('.spaghetti').html(dictionary[currentLanguage].spaghetti);
                        konamiMode = false;
                    } else {
                        document.getElementById('konami').src = 'http://momspaghetti.ytmnd.com/';
                        $('.spaghetti').html(dictionary[currentLanguage].momSpaghetti);
                        konamiMode = true;
                    }
                });

            });
        </script>
    </body>
</html>
