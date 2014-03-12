var apiPath  = '',
    comments = new Array();

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
        if (comments.length === 0)
            $(".empty-comment").css("display", "");
        else
            $(".empty-comment").css("display", "none");

        var listItems

        $.each(comments, function(index, c) {
            listItems.push(
                "<li class=\"media\">" +
                "<h4>" + c.name + " <small>" + c.created_at + "</small></h4>" +
                "<div class=\"media-body\">" +
                c.body +
                "</div></li>"
            );
        });

        $("<ul/>", { html: listItems.join("") }).addClass("media-list").appendTo("body");
    });
}

function registerCommentHandlers() {
    // Bind the form submit event.
    $(".comment-form").submit(function(e) {
        e.preventDefaultAction();


    });
}