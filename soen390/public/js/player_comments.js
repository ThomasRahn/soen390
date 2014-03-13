var apiPath  = '',
    comments = new Array(),
    lastPost = 0;

function prepareComments(path) {
    // Set the appropriate API path
    apiPath = path;

    // Load all comments
    loadComments();

    // Register handlers
    registerCommentHandlers();
}

function loadComments() {
    // Fetch comments from the API.
    $.getJSON(apiPath, function(data) {
        comments = data.return;

        // Hide the empty comments message if necessary.
        if (comments.length === 0) {
            $(".placeholder-comment").empty().show();
            $("<p/>").html("This narrative does not have any comments yet.").appendTo(".placeholder-comment");
            return;
        } else {
            $(".placeholder-comment").hide();
        }

        var listItems = new Array();

        $.each(comments, function(index, c) {
            listItems.push(
                "<li class=\"media\">" +
                "<h4>" + c.name + " <small>" + c.created_at + "</small></h4>" +
                "<div class=\"media-body\">" +
                c.body +
                "</div></li>"
            );
        });

        var elements = $("<ul/>", { html: listItems.join("") }).addClass("media-list");

        $(".comment-frame").html(elements);
    });
}

function registerCommentHandlers() {
    // Bind the form submit event.
    $(".comment-form").bind("submit", function(e) {
        e.preventDefault();

        $("<i/>").addClass("fa fa-spin fa-spinner").appendTo(".comment-post-result");

        var secondsSinceLastPost = ((new Date()).valueOf() - lastPost) / 1000;

        if (secondsSinceLastPost < 60) {
            var secondsUntilNextPost = parseInt(60 - secondsSinceLastPost);
            $(".comment-post-result").addClass("text-warning").html("You may post another comment in " + secondsUntilNextPost + " seconds.");
            return;
        }

        $.post(
            apiPath,
            $(".comment-form").serialize()
        ).done(function(data, status, xhr) {
            $(".comment-post-result").addClass("text-success").html("Comment posted!");
            lastPost = new Date();
            loadComments();
        }).fail(function(xhr, status, error) {
            $(".comment-post-result").addClass("text-danger").html("An error occured while trying to post the comment.");  
            console.log(xhr.responseText);
        });
    });
}